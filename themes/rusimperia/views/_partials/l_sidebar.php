<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php if ($this->ion_auth->logged_in()) : ?>
    <div class="content-box l-sidebar">
        <ul class="page-list">
            <li class="page-list-item">
                <a class="page-list-link" href="/profile">
                    Мой профиль
                </a>
            </li>
            <li class="page-list-item">
                <a class="page-list-link" href="/friend">
                    Друзья
                    <span class="page-list-count" id="countFriend">
                        <?=((!empty($count->friend) && $count->friend > 0)?$count->friend:'')?>
                    </span>
                </a>
            </li>
            <li class="page-list-item">
                <a class="page-list-link" href="/chat">
                    Сообщения
                    <span class="page-list-count" id="countMessage">
                        <?=((!empty($count->message) && $count->message > 0)?$count->message:'')?>
                    </span>
                </a>
            </li>
            <li class="page-list-item">
                <a class="page-list-link" href="/photo">Фотографии</a>
            </li>
            <li class="page-list-item">
                <a class="page-list-link" href="/feed">
                    Новости
                    <span class="page-list-count" id="countNews">
                        <?=((!empty($count->news) && $count->news > 0)?$count->news:'')?>
                    </span>
                </a>
            </li>
            <li class="page-list-item">
                <a class="page-list-link" href="/my_group">
                    Мои группы
                    <span class="page-list-count" id="countGroup">
                        <?=((!empty($count->group) && $count->group > 0)?$count->group:'')?>
                    </span>
                </a>
            </li>
            <li class="page-list-item">
                <a class="page-list-link" href="/rating">
                    &Delta;
                    <span class="page-list-count" id="countDelta">
                        <?=((!empty($count->delta) && $count->delta > 0)?$count->delta:'')?>
                    </span>
                </a>
            </li>
            <li class="page-list-item">
                <a class="page-list-link" href="/balance">
                    Лепта:
                    <span class="page-list-count" id="countLeptas">
                        <?=((!empty($count->leptas) && $count->leptas > 0)?$count->leptas:'')?>
                    </span>
                </a>
            </li>
        </ul>
        <ul class="group-list">
        <?php if (empty($groups)) : ?>
            <li class="group-list-item">
                <a class="group-list-link" href="/my_group">
                    Можете добавить до 5 групп в этот список
                </a>
            </li>
        <?php else :
        foreach ($groups as $row) : ?>
            <li class="group-list-item">
                <a class="group-list-link" href="/gpoup/<?=$row->id?>">
                    <?=$row->name?>
                </a>
            </li>
        <?php endforeach;
        endif; ?>
        </ul>
        <ul class="event-list">
            <?php if (empty($events)) : ?>
                <li class="event-list-item">
                    <a class="event-list-link" href="/my_event">
                        Можете добавить до 3 мероприятий в этот список
                    </a>
                </li>
            <?php else :
                foreach ($events as $row) : ?>
                    <li class="event-list-item">
                        <a class="event-list-link" href="/event/<?=$row->id?>">
                            <span class="event-title"><?=$row->name?></span>
                            <span class="event-time"><?=$row->time?></span>
                        </a>
                    </li>
                <?php endforeach;
            endif; ?>
        </ul>
    </div>
<?php endif; ?>
<div class="advertising"><?=img_alt(180, 200, "advertising")?></div>
<div class="advertising"><?=img_alt(180, 200, "advertising")?></div>
<div class="advertising"><?=img_alt(180, 200, "advertising")?></div>