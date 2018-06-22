<div class="col-md-10">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#all_friends" data-toggle="tab">All Friends</a></li>
        <li><a href="#friends_online" data-toggle="tab">Friends online</a></li>
        <li><a href="#friends_request" data-toggle="tab">Friend request</a></li>
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
        <div class="tab-pane active" id="all_friends">
            <div class="row">
            <?php foreach ($friends as $friend): ?>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-2">
                            <img src="<?=$friend->photo?>" width="50" class="center-block img-circle">
                        </div>
                        <div class="col-md-10">
                            <p>
                                <a href="/profile/<?=$friend->friend_id?>" title="Посмотреть профиль">
                                    <?= $friend->full_name_user ?>
                                </a>
                            </p>
                            <p>Ранг</p>
                            <p>
                                <a class="btn btn-info send_message"  data-toggle="modal" data-target="#exampleModal">Отправить сообщение</a>
                                <a href="/friends/delete/<?=$friend->friend_id?>" class="btn btn-info" title="Удалить из друзей">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
        <div class="tab-pane" id="friends_online">
            <div class="row">
                <?php foreach ($friends as $friend): ?>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-2">
                            <img src="<?=$friend->photo?>" width="50" class="center-block img-circle">
                        </div>
                        <div class="col-md-10">
                            <p>
                                <a href="/profile/<?=$friend->friend_id?>" title="Посмотреть профиль">
                                    <?= $friend->full_name_user ?>
                                </a>
                            </p>
                            <p>Ранг</p>
                            <p>
                                <a class="btn btn-info send_message"  data-toggle="modal" data-target="#exampleModal">Отправить сообщение</a>
                                <a href="/friends/delete/<?=$friend->friend_id?>" class="btn btn-info" title="Удалить из друзей">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="tab-pane" id="friends_request">
            <div class="row">
                <?php foreach ($req_friends as $friend): ?>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-2">
                            <img src="<?=$friend->photo?>" width="50" class="center-block img-circle">
                        </div>
                        <div class="col-md-10">
                            <p>
                                <a href="/profile/<?=$friend->friend_id?>" title="Посмотреть профиль">
                                    <?= $friend->full_name_user ?>
                                </a>
                            </p>
                            <p>Ранг</p>
                            <p>
                                <a class="btn btn-info" href="/friends/confirm_friend/<?=$friend->friend_id?>"
                                   title="Подтвердить">
                                    <span class="glyphicon glyphicon-ok"></span>
                                </a>
                                <a href="/friends/black_list/<?=$friend->friend_id?>" class="btn btn-info"
                                   title="Добавить в черный список">
                                    <span class="glyphicon glyphicon-remove-circle"></span>
                                </a>
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
