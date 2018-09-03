<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="profile-grid">
    <div class="content-box profile-photo">
        <img class="profile-img" src="/media/user/profile/<?=$userData->avatar;?>" alt="photo profile" />
        <?php if($userData->id === $this->user->id) : ?>
            <span class="upload-new">
                <i class="fas fa-upload"></i>
                <span>Изменить фото профиля</span>
            </span>
        <?php endif; ?>
    </div>

    <div class="content-box info-box">
        <div class="rang">
            <?php
                $rangName = $this->lang->line('profile_rang_name_'.$userData->group[0]->name);
                if ($userData->group[0]->id > 40) $userData->group[0]->id = 40;
                switch ((int)$userData->group[0]->id) {
                    case 10:
                        $rangIcon = 'far fa-smile';
                        break;
                    case 20:
                        $rangIcon = 'far fa-user';
                        break;
                    case 30:
                        $rangIcon = 'fas fa-university';
                        break;
                    case 40:
                        $rangIcon = 'fas fa-crown';
                        break;
                }
            ?>
            <i class="<?=$rangIcon?> rang-icon"></i> <?=$rangName?>
        </div>
        <div class="last-online" id="last-online">
            <?php if ($userData->meta->online) : ?>
            В сети
            <?php else :
                echo (($userData->gender === 'female')?'Была':'Был').': '.date_format(date_create($userData->last_login),'H:i d.m.Y');
            endif; ?>
        </div>
        <div class="user-name">
            <?php switch ($userData->gender) {
                case 'ns':
                    $genderIcon = 'fas fa-genderless';
                    break;
                case 'male':
                    $genderIcon = 'fas fa-mars';
                    break;
                case 'female':
                    $genderIcon = 'fas fa-venus';
                    break;
            } ?>
            <i class="<?=$genderIcon?> user-gender"></i> <?=$userData->first_name.' '.$userData->last_name ;?>
        </div>
        <div class="user-status">
            <?php if($userData->id === $this->user->id) : //Если страничка юзера то он может менять статус ?>
                <?php if($userData->meta->text_status == '') : //если статус пустой, то выводить Изменить статус  ?>
                    <span class="status_string">Изменить статус</span>
                <?php else : ?>
                    <span class="status_string"><?=$userData->meta->text_status; //Иначе статус?></span>
                <?php endif; ?>
            <?php else : ?>
                <span class="status_string status_string_disabled"><?=$userData->meta->text_status; ?></span>
            <?php endif; ?>
        </div>
        <div class="user-country-title">Страна:</div>
        <div class="user-country-content">
            <?=(empty($userData->geo->country_name)?'Не указана':$userData->geo->country_name)?>
        </div>
        <div class="user-city-title">Город:</div>
        <div class="user-city-content">
            <?=(empty($userData->geo->city_name)?'Не указан':$userData->geo->city_name)?>
        </div>
        <div class="user-birthday-title">День рождения:</div>
        <div class="user-birthday-content">
            <?=(empty($userData->birthDayString)?'Не указан':$userData->birthDayString)?>
        </div>
        <div class="more-info">Показать больше информации</div>
        <div class="more"></div>
        <div class="user-counter" id="user-counter">
            <span>
                <span id="user-friend"><?=$userData->count->friend?></span>
                <span><?=decl_a_num($userData->count->friend, '%друг%друга%друзей')?></span>
            </span>
            <span>
                <span id="user-follower"><?=$userData->count->follower?></span>
                <span><?=decl_a_num($userData->count->follower, 'подписчик%а%ов')?></span>
            </span>
            <span>
                <span id="user-photo"><?=$photoData['count']?></span>
                <span><?=decl_a_num($photoData['count'], 'фотографи%я%и%й')?></span>
            </span>
            <span>
                <span id="user-group"><?=$userData->count->group?></span>
                <span><?=decl_a_num($userData->count->group, 'групп%а%ы%')?></span>
            </span>
            <span>
                <span id="user-delta"><?=$userData->delta?></span>
                <span>&Delta;</span>
            </span>
        </div>
    </div>

    <div class="user-button">
    <?php //if($userData->id != $this->user->id) : ?>
        <button class="btn btn-user"><i class="far fa-comments"></i></button>
        <button class="btn btn-user"><i class="fas fa-user-plus"></i></button>
    <?php //endif;?>
    </div>

    <div class="content-box photo-list">
    <?php if ($userData->id === $this->user->id) : ?>
        <div class="photo-list-title">Мои фотографии <?=($photoData['count']>0?$photoData['count']:'')?></div>
    <?php else :?>
        <div class="photo-list-title">Фотографии пользователя <?=($photoData['count']>0?$photoData['count']:'')?></div>
    <?php endif; ?>
        <?php if ($photoData['count'] > 0) :
            foreach($photoData['photo'] as $p) : ?>
                <div class="photo-list-thumb">
                    <img src="/media/photo/thumb/<?=$p->media;?>" alt="photo-<?=$p->media;?>"/>
                </div>
            <?php endforeach;
        endif; ?>

    </div>
    <div class="content-box post-add">
        <?=$postAdd?>
    </div>
    <div id="post-list" class="post-list">
        <?=$postList?>
    </div>
</div>
