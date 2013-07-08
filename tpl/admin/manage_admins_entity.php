
    <head>
        <link rel="stylesheet" type="text/css" href="<?= Root('i/css/admin/manage_admins.css')?>" />
    </head>

    <h1>Данные администратора</h1>
    <?php if ($admin_id):?>
        <p>Если хотите поменять имя, то обязательно введите пароль.</p>
    <?php endif;?>
    
    <?= $msg?>
    <form action="<?= GetCurUrl()?>" method="post" class="manage-admins-item">
                           
        <input type="hidden" name="is_apply" value="1">
        <label>
            <span>Логин:</span>
            <input type="text" name="login" value="<?= $login?>">
        </label>
        <label>
            <span>Пароль:</span>
            <input type="password" name="pwd" value="">
        </label>
        <label>
            <span>Повторите пароль:</span>
            <input type="password" name="pwd_again" value="">
        </label>

        <button>
            <?= $btnText?>
        </button>
        <a href="<?= SiteRoot("admin/manage_admins")?>">
            Отмена
        </a>
    </form>

