<?php

    $adminModel = new AdminModel();

    $flashParam = new FlashParam();
    $msg = $flashParam->Get('msg');

    if (Post("remove_id"))
    {
        $admin = new AdminModel(intval(Post("remove_id")));
        
        if (!$admin->IsExists())
        {
            trigger_error("Internal error. Invalid admin id.", E_USER_ERROR);
        }
        $isDel = $admin->Delete();

        $msg   = $isDel ? MsgOk('Администратор успешно удален') : MsgErr('Ошибка удаления администратора');
        $_POST = array();
    }

    $list   = $adminModel->GetAdmins();
    $admins = array();
    foreach ($list as $l)
    {
        $admins[] = new AdminModel($l, true);
    }
?>