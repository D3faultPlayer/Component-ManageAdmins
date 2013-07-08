<?php

    /**
     * Пользовательская модель администратора
     *
     * @author Guul
     */
    class AdminModel extends Model
    {
        public function __construct($admin_id = NULL, $onlyShow = false)
        {
            global $g_databases;
            parent::__construct($g_databases->db, 'admin', 'admin_id', $admin_id, $onlyShow);
        }

        public function CreateTable()
        {
            static $arrCreates = array();

            if (!isset($arrCreates[$this->table]))
            {

                $this->db->query("CREATE TABLE IF NOT EXISTS ?# (
                                                                  `admin_id` int(11) NOT NULL AUTO_INCREMENT,

                                                                  `login`    varchar(512) CHARACTER SET utf8,
                                                                  `pwd_hash` varchar(32)  CHARACTER SET utf8,

                                                                  PRIMARY KEY (`admin_id`)
                                                                ) AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;",
                                  $this->table);

                $arrCreates[$this->table] = true;

                if ($this->GetAdminsCount() == 0)
                {
                    global $g_config;

                    foreach($g_config['admin']['admins'] as $a)
                    {
                        $authModel = new AdminDbAuthModel();

                        $admin = new AdminModel();
                        $admin->login     = $a["login"];
                        $admin->pwd_hash  = $authModel->CreateHash($a["login"], $a["pwd"]);
                        $admin->Flush();
                        unset($admin);
                    }
                }
            }
        }

        public function GetAdmins()
        {
            return $this->db->selectCol("SELECT admin_id FROM ?#", $this->table);
        }

        public function GetAdminsCount()
        {
            return $this->db->selectCell("SELECT COUNT(*) FROM ?#", $this->table);
        }

        public function GetAdminByLogin($login)
        {
            $id = $this->db->selectCell("SELECT admin_id FROM ?# WHERE login = ?", $this->table, $login);
            if ($id)
            {
                return new self($id);
            }
            return NULL;
        }
    };
?>