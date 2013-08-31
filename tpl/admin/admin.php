                                              
    <?php if ($admin_id):?>
        <h1>Редактирование администратора</h1>
    <?php else:?>
        <h1>Регистрация нового администратора</h1>
    <?php endif;?>
    <br>
    <form action="<?= GetCurUrl()?>" method="post" class="form-horizontal" role="form">
        <?= $msg?>
        <input type="hidden" name="is_apply" value="1">
              
        <div class="form-group">
            <label for="inputLogin" class="col-lg-2 control-label">Логин *</label>
            <div class="col-lg-6">
                <input type="text" class="form-control" id="inputLogin" autocomplete="on" name="login" value="<?= $login?>">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword" class="col-lg-2 control-label">Пароль *</label>
            <div class="col-lg-6">
                <input type="password" class="form-control" id="inputPassword" autocomplete="on" name="pwd" placeholder="<?= $admin_id ? 'Не вводите пароль если не собираетесь его менять' : ''?>">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword2" class="col-lg-2 control-label">Повторите пароль *</label>
            <div class="col-lg-6">
                <input type="password" class="form-control" id="inputPassword2" autocomplete="on" name="pwd2">
            </div>
        </div>

        <div class="form-group">
            <label for="input" class="col-lg-2 control-label">Имя администратора</label>
            <div class="col-lg-6">
                <input type="text" class="form-control" id="inputName" autocomplete="on" name="name" value="<?= $name?>">
            </div>
        </div>
        <div class="form-group">
            <label for="input" class="col-lg-2 control-label">Описание учётной записи</label>
            <div class="col-lg-6">
                <textarea name="desc" id="inputDesc" class="form-control" rows="3"><?= $desc?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail" class="col-lg-2 control-label">E-mail</label>
            <div class="col-lg-6">
                <input type="text" class="form-control" id="inputEmail" autocomplete="on" name="email" value="<?= $email?>">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPhone" class="col-lg-2 control-label">Телефон</label>
            <div class="col-lg-6">
                <input type="text" class="form-control" id="inputPhone" autocomplete="on" name="phone" value="<?= $phone?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-6">
                <button type="submit" class="btn btn-primary"><?= $admin_id ? "Сохранить" : "Зарегистрировать"?></button>
            </div>
        </div>
    </form>