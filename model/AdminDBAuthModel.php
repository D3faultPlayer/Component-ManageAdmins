<?php

    /**
     * Пользовательская модель администратора
     *
     * @author Zmi and Guul
     */
    class AdminDbAuthModel extends AdminAuthModel
    {
        protected function Check($login, $pwdHash)
        {
            $adminModel = new AdminModel();
            $admin = $adminModel->GetAdminByLogin($login);

            return $admin && $admin->IsExists() && $admin->pwd_hash == $pwdHash;
        }
    };
?>