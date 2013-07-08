<?php

    if (is_file(BASEPATH . 'core/config/admin_menu.php'))
    {
        require_once BASEPATH . 'core/config/admin_menu.php';
        $g_config['admin_menu'][] = array
        (
            "name" => "Администраторы",
            "page" => "admin/manage_admins",
        );
    }
?>