<div class="col-md-10">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#all_people" data-toggle="tab">All people</a></li>
        <li><a href="#people_online" data-toggle="tab">People online</a></li>
    </ul>
    <!-- Search -->
    <div class="row">
        <div class="col-md-12">
            <div class="input-group">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                </span>
                <input type="text" class="form-control">
            </div><!-- /input-group -->
        </div>
    </div>
    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active" id="all_people">
            <div class="row">
                <?php foreach ($people as $row):
                    if (!file_exists(WEBROOT . $row->photo)) {
                        $row->photo = '/img/blank.jpeg';
                    }?>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="<?=$row->photo?>" width="50" class="center-block img-circle">
                            </div>
                            <div class="col-md-10">
                                <p>
                                    <a href="/profile/<?=$row->id?>" title="Посмотреть профиль">
                                        <?= $row->full_name_user ?>
                                    </a>
                                </p>
                                <p>Ранг</p>
                                <p>
                                    <?php if (!empty($row->u_f_status)) : // если просматривающий страницу добавлял в
                                        // друзья
                                        switch ($row->u_f_status) {
                                            case 'request': ?>
                                    <a href="/friends/delete/<?=$row->id?>" class="btn btn-info" title="Вы уже
                                    отправили запрос на добавление в друзья">
                                        Удалить запрос
                                    </a>
                                            <?php break;
                                            case 'confirmed': ?>
                                    <a href="/friends/delete/<?=$row->id?>" class="btn btn-info">
                                        Удалить из друзей
                                    </a>
                                            <?php break;
                                            case 'blacklist': ?>
                                    <a href="/friends/delete/<?=$row->id?>" class="btn btn-info">
                                        Удалить из черного списка
                                    </a>
                                        <?php }
                                     elseif (!empty($row->f_u_status)) : // если выводимый пользователь добавлял в друзья
                                        switch ($row->f_u_status) {
                                            case 'request': ?>
                                        <a href="/friends/confirm_friend/<?=$row->id?>" class="btn btn-info">
                                            Подтвердить запрос в друзья
                                        </a>
                                        <?php break;
                                        case 'confirmed': ?>
                                        <a href="/friends/delete/<?=$row->id?>" class="btn btn-info">
                                            Удалить из друзей
                                        </a>
                                        <?php break;
                                        case 'blacklist': ?>
                                        <a href="/friends/add/<?=$row->id?>" class="btn btn-info">
                                            Добавить в друзья
                                        </a>
                                        <?php }
                                    else : ?>
                                    <a href="/friends/add/<?=$row->id?>" class="btn btn-info">
                                        Добавить в друзья
                                    </a>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="tab-pane" id="people_online">
            <div class="row">
                <?php foreach ($on_people as $row):
                    if (!file_exists(WEBROOT . $row->photo)) {
                        $row->photo = '/img/blank.jpeg';
                    }?>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="<?=$row->photo?>" width="50" class="center-block img-circle">
                            </div>
                            <div class="col-md-10">
                                <p>
                                    <a href="/profile/<?=$row->id?>" title="Посмотреть профиль">
                                        <?= $row->full_name_user ?>
                                    </a>
                                </p>
                                <p>Ранг</p>
                                <p>
                                    <?php if (!empty($row->u_f_status)) : // если просматривающий страницу добавлял в
                                        // друзья
                                        switch ($row->u_f_status) {
                                            case 'request': ?>
                                                <a href="/friends/delete/<?=$row->id?>" class="btn btn-info" title="Вы уже
                                    отправили запрос на добавление в друзья">
                                                    Удалить запрос
                                                </a>
                                                <?php break;
                                            case 'confirmed': ?>
                                                <a href="/friends/delete/<?=$row->id?>" class="btn btn-info">
                                                    Удалить из друзей
                                                </a>
                                                <?php break;
                                            case 'blacklist': ?>
                                                <a href="/friends/delete/<?=$row->id?>" class="btn btn-info">
                                                    Удалить из черного списка
                                                </a>
                                            <?php }
                                    elseif (!empty($row->f_u_status)) : // если выводимый пользователь добавлял в друзья
                                        switch ($row->f_u_status) {
                                            case 'request': ?>
                                                <a href="/friends/confirm_friend/<?=$row->id?>" class="btn btn-info">
                                                    Подтвердить запрос в друзья
                                                </a>
                                                <?php break;
                                            case 'confirmed': ?>
                                                <a href="/friends/delete/<?=$row->id?>" class="btn btn-info">
                                                    Удалить из друзей
                                                </a>
                                                <?php break;
                                            case 'blacklist': ?>
                                                <a href="/friends/add/<?=$row->id?>" class="btn btn-info">
                                                    Добавить в друзья
                                                </a>
                                            <?php }
                                    else : ?>
                                        <a href="/friends/add/<?=$row->id?>" class="btn btn-info">
                                            Добавить в друзья
                                        </a>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
</div>
