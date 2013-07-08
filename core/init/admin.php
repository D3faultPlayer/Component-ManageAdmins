<?php

    require_once BASEPATH . 'core/init/db.php';
    $g_adminAuth = new AdminDBAuthModel();

    // Часть для админки
    if (strpos(strtolower(GetQuery()), 'admin/') === 0 || GetQuery() === 'admin')
    {
        // Меняем папку куда будут складироваться css/js админки
        $g_config['extrapacker']['dir'] = 'extrapacker_admin';
        $g_config['mainTpl']            = 'admin/main_template';

        if (GetQuery() !== 'admin')
        {
            $g_adminAuth->AutoLogin();
        }
    }

    define('IS_ADMIN_AUTH', $g_adminAuth->IsAuth());
?>