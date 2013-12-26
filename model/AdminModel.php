<?php

    /**
     * Модель для работы администратора
     */
    class AdminModel extends Model
    {
        const REMEMBER_PERIOD = 604800; // Время хранения авторизации (в секундах)

        public function __construct($admin_id = NULL, $onlyShow = false)
        {
            global $g_databases;
            parent::__construct($g_databases->db, 'admin', 'admin_id', $admin_id, $onlyShow);
        }

        public function CreateTable()
        {
            $this->db->query("CREATE TABLE IF NOT EXISTS ?#
                             (
                                `admin_id` INT  NOT NULL AUTO_INCREMENT,
                                `login` VARCHAR(128)  CHARACTER SET utf8 COLLATE utf8_general_ci,
                                `pwd_hash` VARCHAR(32)  CHARACTER SET utf8 COLLATE utf8_general_ci,
                                `name` VARCHAR(128)  CHARACTER SET utf8 COLLATE utf8_general_ci,
                                `desc` VARCHAR(512)  CHARACTER SET utf8 COLLATE utf8_general_ci,
                                `email` VARCHAR(128)  CHARACTER SET utf8 COLLATE utf8_general_ci,
                                `phone` VARCHAR(128)  CHARACTER SET utf8 COLLATE utf8_general_ci,
                                `reg_time` INT,
                                UNIQUE (`login`),
                                PRIMARY KEY (`admin_id`)
                             ) ENGINE = MyISAM",
                             $this->table);
            // Если админов ещё нет то регаем первого
            if (!$this->CountAdmins())
            {
                global $g_config;
                $this->db->query("INSERT INTO ?# SET `login` = ?, `pwd_hash` = ?, `reg_time` = ?d", $this->table, 
                                 $g_config['admin_sector']['def_login'], 
                                 $this->MakeHash($g_config['admin_sector']['def_pwd']), 
                                 time());
            }
        }

        public function CountAdmins()
        {
            return $this->db->selectCell("SELECT COUNT(*) FROM ?# WHERE 1", $this->table);
        }

        public function MakeHash($pwd)
        {
            global $g_config;
            return md5($pwd . $g_config['admin_sector']['salt']);
        }

        public function GetAdminIdByLogin($login)
        {
            return empty($login) ?
                        false :
                        $this->db->selectCell("SELECT `admin_id` FROM ?# WHERE `login` = ?", $this->table, $login);
        }

        public function CurAdminId()
        {
            global $g_config;

            $login    = isset($_COOKIE['auto_admin_auth_login'])    ? $_COOKIE['auto_admin_auth_login']    : '';
            $pwd_hash = isset($_COOKIE['auto_admin_auth_pwd_hash']) ? $_COOKIE['auto_admin_auth_pwd_hash'] : '';
            $ret      = false;
            $aid      = $this->GetAdminIdByLogin($login);
            if ($aid)
            {
                $a   = new self($aid, true);
                $ret = $a->login == $login && $a->pwd_hash == $pwd_hash ? $aid : false;
            }
            return $ret;
        }

        // Проверка занятости логина
        public function IsLoginBusy($login)
        {
            return $this->db->selectCell("SELECT COUNT(`admin_id`) FROM ?# WHERE `login` = ?", $this->table, $login);
        }

        // Авторизован ли текущей юзер
        public function IsAuth()
        {
            return (bool)($this->CurAdminId());
        }

        // Авторизует пользователя, что бы при будущих обращениях он проходил как авторизованный при успехе вернёт true и запомнит что авторизован, иначе false
        public function Login($login, $pwd_hash)
        {
            if (empty($login) || empty($pwd_hash))
            {
                trigger_error("Can not login: login or pwd_hash are empty!", E_USER_ERROR);
            }

            $ret = false;
            $aid = $this->GetAdminIdByLogin($login);
            if ($aid)
            {
                $a = new self($aid, true);
                if ($a->login == $login && $a->pwd_hash == $pwd_hash)
                {
                    setcookie('auto_admin_auth_login',    $login,     time() + self::REMEMBER_PERIOD, '/', DOMAIN_COOKIE);
                    setcookie('auto_admin_auth_pwd_hash', $pwd_hash,  time() + self::REMEMBER_PERIOD, '/', DOMAIN_COOKIE);
                    $ret = true;
                }
            }
            return $ret;
        }

        // Проверяет авторизацию, и если человек не авторизован то проверят на допустимой ли он странице
        public function ChkLogin()
        {
            global $g_config;
            $query = strtolower(GetQuery());

            // Если юзер не залогинен
            if (!$this->IsAuth())
            {
                if (SiteRoot($query) !== SiteRoot($g_config['admin_sector']['after_logout_page']))
                {
                    header("Location: " . SiteRoot($g_config['admin_sector']['after_logout_page']));
                    exit();
                }
            }
        }

        public function Logout()
        {
            setcookie('auto_admin_auth_login',    '', -1, '/', DOMAIN_COOKIE);
            setcookie('auto_admin_auth_pwd_hash', '', -1, '/', DOMAIN_COOKIE);
        }

        public function GetList()
        {
            return $this->db->selectCol("SELECT `admin_id` FROM ?# WHERE 1", $this->table);
        }
    };
?>
