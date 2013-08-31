
    <h1>Управление администраторами</h1>
    <br>
    <?= $msg?>
    <form action="<?= GetCurUrl()?>" method="post">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <tr>
                    <th>#</th>
                    <th>Логин</th>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Телефон</th>
                    <th>Описание</th>
                    <th>Действия</th>
                </tr>
                <?php foreach ($admins as $aid => $a):?>
                    <tr>
                        <td><?= $aid?></td>
                        <td><?= $a->login?></td>
                        <td><?= $a->name?></td>
                        <td><?= $a->email?></td>
                        <td><?= $a->phone?></td>
                        <td><?= $a->desc?></td>
                        <td>
                            <div class="btn-group">
                                <a href="<?= SiteRoot("admin/admin&id=" . $aid)?>" class="btn btn-sm btn-info" title="Изменить данные"><span class="glyphicon glyphicon-wrench"></span></a>
                                <button href="#" class="btn btn-sm btn-danger" name="remove_id" value="<?= $a->admin_id?>" onclick="return confirm('Удалить данного администратора?')" title="Удалить администратора"><span class="glyphicon glyphicon-trash"></span></a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach?>
            </table>
        </div>
    </form>
