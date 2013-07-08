
    <head>
        <link rel="stylesheet" type="text/css" href="<?= Root('i/css/admin/manage_admins.css')?>" />
    </head>

    <h1>Администраторы сайта:</h1>

    <?= $msg?>
    <form action="<?= GetCurUrl()?>" method="post">
        <table class="manage-admins-table">
            <thead>
                <tr>
                    <th>
                        ID
                    </th>
                    <th class="login">
                        Логин
                    </th>
                    <th>
                    </th>
                    <th>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($admins as $a):?>
                    <tr>
                        <td>
                            <?= $a->admin_id?>
                        </td>
                        <td>
                            <?= $a->login?>
                        </td>
                        <td>
                            <a href="<?= SiteRoot("admin/manage_admins_entity&id=" . $a->admin_id)?>">
                                Редактировать
                            </a>
                        </td>
                        <td>
                            <button onclick="return confirm('Хотите удалить этого администратора?')" name="remove_id" value="<?= $a->admin_id?>">
                                Удалить
                            </button>
                        </td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
       
        <a href="<?= SiteRoot("admin/manage_admins_entity")?>">
            Добавить
        </a>
    </form>
