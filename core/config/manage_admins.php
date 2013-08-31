<?php

    require_once BASEPATH . 'core/config/admin_menu.php';

    GetQuery(); // Чтобы фунция SiteRoot корректно заработала нужно проинициализировать LANG в функции GetQuery
    $g_config['admin_menu'][]   = array
                        (
                            'link'  => 'javascript:void(0)',
                            'name'  => 'Администраторы',
                            'label' => 'Управление администраторами',
                            'css'   => '',
                            'list'  => array(
                                                array('link' => SiteRoot('admin/admin'),  'name' => 'Новый администратор',    'label' => 'Зарегистрировать нового администратора'),
                                                array('link' => SiteRoot('admin/admins'), 'name' => 'Список администраторов', 'label' => 'Показать список администраторов')
                                            )
                        );
?>