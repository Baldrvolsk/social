<div class="content">
    <div class="container-fluid">


        <div class="row">
            <div class="col-md-12">
                <div class="card strpied-tabled-with-hover">
                    <div class="card-header ">
                        <h4 class="card-title">Список зарегистрированных пользователей</h4>
                        <p class="card-category">Строки кликабельны</p>
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Ip адрес</th>
                            <th>Страна</th>
                            <th>Город</th>
                            <th>Email</th>
                            <th>Посл.активность</th>
                            </thead>
                            <tbody>
                            <?php foreach($users as $u) : ?>
                            <tr>
                                <td><?= $u->id; ?></td>
                                <td><?= $u->first_name.' '.$u->last_name; ?></td>
                                <td><?= $u->ip_address; ?></td>
                                <td><?= $u->country; ?></td>
                                <td><?= $u->city; ?></td>
                                <td><?= $u->email; ?></td>
                                <td><?=gmdate('H:i d.m.Y',$u->last_login); ?></td>
                            </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

