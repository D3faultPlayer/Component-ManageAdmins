<?php

    global $g_config;
    global $g_adminAuth;

    $adminModel = new AdminModel(NULL, true);
              
    $admin_id = intval(Get('id'));
    $admin    = new AdminModel($admin_id);

    if ($admin_id && !$admin->IsExists())
    {
        trigger_error("Invalid admin id.", E_USER_ERROR);
    }
    $login = trim(Post('login', $admin_id ? $admin->login : NULL));

    $msg = '';
    $errs = array();
    if (Post('is_apply'))
    {
        $pwd       = Post('pwd');
        $pwdAgain  = Post('pwd_again');

        $existing = $adminModel->GetByLogin($login);
         
        if (empty($login))
        {
            $errs[] = "Пустой логин";
        }
        else if ($existing && $existing->admin_id != $admin_id)
        {
            $errs[] = "Пользователь с таким логином уже существует";
        }

        if ($pwd != $pwdAgain)
        {
            $errs[] = "Ошибка подтверждения пароля";
        }
        if (!$admin_id && empty($pwd))
        {
            $errs[] = "Пустой пароль";
        }

        if ($admin_id && $admin->login != $login && empty($pwd)) // так как хеш пароля строится в том числе и по логину, то при изменении логина, нам нужен и пароль
        {
            $errs[] = "Пустой пароль при смене логина";
        }

        if (!empty($errs))
        {
            $msg = MsgErr(implode("<br>", $errs));
        }
        else
        {
            $admin->login = $login;
            if (!empty($pwd))
            {
                $admin->pwd_hash = $g_adminAuth->CreateHash($login, $pwd);
            }
            $ret = $admin->Flush();
        
            if ($ret)
            {
                $flashParam = new FlashParam();
                $flashParam->Set('msg', $msg);
                Header("Location: " . SiteRoot("admin/manage_admins"));
                exit(0);
            }
            else
            {
                $msg = MsgErr("Неизвестная ошибка");
            }
        }
    }
    $btnText = $admin_id ? "Сохранить" : "Добавить";
?>