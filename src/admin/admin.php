<?php

    $admin = new AdminModel(NULL, true);

    $admin_id = intval(Get('id'));
    $admin    = new AdminModel($admin_id);

    if ($admin_id && !$admin->IsExists())
    {
        trigger_error("Invalid admin id.", E_USER_ERROR);
    }

    $login = trim(Post('login', $admin_id ? $admin->login : NULL));
    $pwd   = Post('pwd');
    $pwd2  = Post('pwd2');
    $name  = trim(Post('name',  $admin_id ? $admin->name  : NULL));
    $desc  = trim(Post('desc',  $admin_id ? $admin->desc  : NULL));
    $email = trim(Post('email', $admin_id ? $admin->email : NULL));
    $phone = trim(Post('phone', $admin_id ? $admin->phone : NULL));

    $msg = '';
    if (Post('is_apply'))
    {
        $errs = array();
        if (empty($login))
        {
            $errs[] = "Логин не может быть пустым";
        }
        if (!$admin_id && empty($pwd))
        {
            $errs[] = "Пароль не может быть пустым";
        }
        if ($pwd != $pwd2)
        {
            $errs[] = "Ошибка подтверждения пароля";
        }
        if (!$admin_id && $admin->IsLoginBusy($login))
        {
            $errs[] = "Данный логин уже используется";
        }
        if ($admin_id && $admin->login != $login && $admin->IsLoginBusy($login))
        {
            $errs[] = "Данный логин уже используется";
        }

        if (empty($errs))
        {
            $admin->login       = $login;
            if (!empty($pwd))
            {
                $admin->pwd_hash    = $admin->MakeHash($pwd);
            }
            $admin->name        = $name;
            $admin->desc        = $desc;
            $admin->email       = $email;
            $admin->phone       = $phone;
            $admin->reg_time    = time();
            $id                 = $admin->Flush();

            if ($id)
            {
                $msg = "<div class='alert alert-success'>Операция успешно выполнена</div>";
                $_POST = array();
            }
            else
            {
                $errs[] = "Ошибка регистрации";
            }
        }

        if (!empty($errs))
        {
            $msg = "<div class='alert alert-danger'>" . implode('<br>', $errs) . "</div>";
        }
    }
?>