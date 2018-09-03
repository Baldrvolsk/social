<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Nav tabs -->
<ul class="nav nav-tabs">
    <li class="active"><a href="#all_friends" data-toggle="tab">All Friends</a></li>
    <li><a href="#friends_online" data-toggle="tab">Friends online</a></li>
    <li><a href="#friends_request" data-toggle="tab">Friend requests</a></li>
    <li><a href="#user_request" data-toggle="tab">Your request</a></li>
    <li><a href="#blacklist" data-toggle="tab">Blacklist</a></li>
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
    <!-- все друзья -->
    <div class="tab-pane active" id="all_friends">
        <div class="row">
            <?php foreach ($friends as $row):
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
                                <a class="btn btn-info send_message"  data-toggle="modal" data-target="#exampleModal">Отправить сообщение</a>
                                <a href="/friends/delete/<?=$row->id?>" class="btn btn-info" title="Удалить из друзей">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </a>
                                <a href="/friends/add_blacklist/<?=$row->id?>" class="btn btn-info"
                                   title="Добавить в черный список">
                                    <span class="glyphicon glyphicon-ban-circle"></span>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- друзья онлайн -->
    <div class="tab-pane" id="friends_online">
        <div class="row">
            <?php foreach ($on_friends as $row):
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
                                <a class="btn btn-info send_message"  data-toggle="modal" data-target="#exampleModal">Отправить сообщение</a>
                                <a href="/friends/delete/<?=$row->id?>" class="btn btn-info" title="Удалить из друзей">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </a>
                                <a href="/friends/add_blacklist/<?=$row->id?>" class="btn btn-info"
                                   title="Добавить в черный список">
                                    <span class="glyphicon glyphicon-ban-circle"></span>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- входящие запросы в друзья -->
    <div class="tab-pane" id="friends_request">
        <div class="row">
            <?php foreach ($req_friends as $row):
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
                                <a class="btn btn-info send_message"  data-toggle="modal" data-target="#exampleModal">Отправить сообщение</a>
                                <a href="/friends/confirm_friend/<?=$row->id?>" class="btn btn-info"
                                   title="Подтвердить запрос">
                                    <span class="glyphicon glyphicon-ok"></span>
                                </a>
                                <a href="/friends/add_blacklist/<?=$row->id?>" class="btn btn-info"
                                   title="Добавить в черный список">
                                    <span class="glyphicon glyphicon-ban-circle"></span>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- исходящие запросы в друзья -->
    <div class="tab-pane" id="user_request">
        <div class="row">
            <?php foreach ($user_request as $row):
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
                                <a class="btn btn-info send_message"  data-toggle="modal" data-target="#exampleModal">Отправить сообщение</a>
                                <a href="/friends/delete/<?=$row->id?>" class="btn btn-info" title="Удалить запрос">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- черный список -->
    <div class="tab-pane" id="blacklist">
        <div class="row">
            <?php foreach ($blacklist as $row):
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
                                <a class="btn btn-info send_message"  data-toggle="modal" data-target="#exampleModal">Отправить сообщение</a>
                                <a href="/friends/delete/<?=$row->id?>" class="btn btn-info"
                                   title="Удалить из черного списка">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
