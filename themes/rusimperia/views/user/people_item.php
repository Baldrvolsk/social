<?php if ($full) : ?>
<li class="content-item people-item" id="people-<?=$row->id?>" data-online="<?=$row->online?>">
    <?php endif; ?>
    <div class="item-photo">
        <img src="/media/user/avatar/<?=$row->avatar?>" class="item-img">
    </div>
    <a class="item-link" href="/profile/<?=$row->id?>">
        <?php if ($row->online) : ?>
            <i class="fas fa-circle fa-xs item-online"></i>
        <?php endif; ?>
        <span class="tooltip">
                    <?=$row->full_name_user?>
            <span class="tooltip-content">
                        <span class="tooltip-text">
                            <span class="tooltip-inner">Посмотреть профиль</span>
                        </span>
                    </span>
                </span>
    </a>
    <div class="item-rang">
        <?php
        if ($row->group_id > 40) $row->group_id = 40;
        $rangName = $this->lang->line('profile_rang_name_'.$row->group_id);
        switch ((int)$row->group_id) {
            case 10:
                $rangIcon = 'far fa-smile';
                break;
            case 20:
                $rangIcon = 'fas fa-user';
                break;
            case 30:
                $rangIcon = 'fas fa-university';
                break;
            case 40:
                $rangIcon = 'fas fa-crown';
                break;
        }
        ?>
        <i class="<?=$rangIcon?> item-rang-icon"></i> <?=$rangName?>
    </div>
    <div class="item-button">
        <?php if (!empty($row->u_f_status)) : // если просматривающий страницу добавлял в друзья
            switch ($row->u_f_status) {
                case 'request': ?>
                    <button type="button" class="btn tooltip" onclick="deleteRequest(this, <?=$row->id?>)">
                        <i class="fas fa-user-minus"></i>
                        <span class="tooltip-content">
                                <span class="tooltip-text">
                                    <span class="tooltip-inner">Удалить запрос</span>
                                </span>
                            </span>
                    </button>
                    <button type="button" class="btn tooltip" onclick="addBlackList(this, <?=$row->id?>)">
                        <i class="fas fa-user-shield"></i>
                        <span class="tooltip-content">
                                <span class="tooltip-text">
                                    <span class="tooltip-inner">Добавить в черный список</span>
                                </span>
                            </span>
                    </button>
                    <button type="button" class="btn tooltip" onclick="sendMessage(this, <?=$row->id?>)">
                        <i class="fas fa-comments"></i>
                        <span class="tooltip-content">
                                <span class="tooltip-text">
                                    <span class="tooltip-inner">Написать сообщение</span>
                                </span>
                            </span>
                    </button>
                    <?php break;
                case 'confirmed': ?>
                    <button type="button" class="btn tooltip" onclick="deleteFriends(this, <?=$row->id?>)">
                        <i class="fas fa-user-times"></i>
                        <span class="tooltip-content">
                                <span class="tooltip-text">
                                    <span class="tooltip-inner">Удалить себя из друзей</span>
                                </span>
                            </span>
                    </button>
                    <button type="button" class="btn tooltip" onclick="addBlackList(this, <?=$row->id?>)">
                        <i class="fas fa-user-shield"></i>
                        <span class="tooltip-content">
                                <span class="tooltip-text">
                                    <span class="tooltip-inner">Добавить в черный список</span>
                                </span>
                            </span>
                    </button>
                    <button type="button" class="btn tooltip" onclick="sendMessage(this, <?=$row->id?>)">
                        <i class="fas fa-comments"></i>
                        <span class="tooltip-content">
                                <span class="tooltip-text">
                                    <span class="tooltip-inner">Написать сообщение</span>
                                </span>
                            </span>
                    </button>
                    <?php break;
                case 'subscriber': ?>
                    <button type="button" class="btn tooltip" onclick="addFriends(this, <?=$row->id?>)">
                        <i class="fas fa-user-plus"></i>
                        <span class="tooltip-content">
                                <span class="tooltip-text">
                                    <span class="tooltip-inner">Добавить в друзья</span>
                                </span>
                            </span>
                    </button>
                    <button type="button" class="btn tooltip" onclick="deleteSubscriber(this, <?=$row->id?>)">
                            <span class="fa-stack fa-sm">
                                <i class="fas fa-user-edit fa-stack-1x"></i>
                                <i class="fas fa-ban fa-stack-2x"></i>
                            </span>
                        <span class="tooltip-content">
                                <span class="tooltip-text">
                                    <span class="tooltip-inner">Удалить себя из подписчиков</span>
                                </span>
                            </span>
                    </button>
                    <button type="button" class="btn tooltip" onclick="addBlackList(this, <?=$row->id?>)">
                        <i class="fas fa-user-shield"></i>
                        <span class="tooltip-content">
                                <span class="tooltip-text">
                                    <span class="tooltip-inner">Добавить в черный список</span>
                                </span>
                            </span>
                    </button>
                    <button type="button" class="btn tooltip" onclick="sendMessage(this, <?=$row->id?>)">
                        <i class="fas fa-comments"></i>
                        <span class="tooltip-content">
                                <span class="tooltip-text">
                                    <span class="tooltip-inner">Написать сообщение</span>
                                </span>
                            </span>
                    </button>
                    <?php break;
                case 'blacklist': ?>
                    <button type="button" class="btn tooltip" onclick="addFriends(this, <?=$row->id?>)">
                        <i class="fas fa-user-plus"></i>
                        <span class="tooltip-content">
                                <span class="tooltip-text">
                                    <span class="tooltip-inner">Добавить в друзья</span>
                                </span>
                            </span>
                    </button>
                    <button type="button" class="btn tooltip" onclick="deleteBlackList(this, <?=$row->id?>)">
                            <span class="fa-stack fa-sm">
                                <i class="fas fa-user-shield fa-stack-1x"></i>
                                <i class="fas fa-ban fa-stack-2x"></i>
                            </span>
                        <span class="tooltip-content">
                                <span class="tooltip-text">
                                    <span class="tooltip-inner">Удалить из черного списка</span>
                                </span>
                            </span>
                    </button>
                <?php }
        elseif (!empty($row->f_u_status)) : // если выводимый пользователь добавлял в друзья
            switch ($row->f_u_status) {
                case 'request': ?>
                    <button type="button" class="btn tooltip" onclick="confirmFriends(this, <?=$row->id?>)">
                        <i class="fas fa-user-check"></i>
                        <span class="tooltip-content">
                                <span class="tooltip-text">
                                    <span class="tooltip-inner">Подтвердить запрос в друзья</span>
                                </span>
                            </span>
                    </button>
                    <button type="button" class="btn tooltip" onclick="addSubscriber(this, <?=$row->id?>)">
                        <i class="fas fa-user-edit"></i>
                        <span class="tooltip-content">
                                <span class="tooltip-text">
                                    <span class="tooltip-inner">Оставить в подписчиках</span>
                                </span>
                            </span>
                    </button>
                    <button type="button" class="btn tooltip" onclick="addBlackList(this, <?=$row->id?>)">
                        <i class="fas fa-user-shield"></i>
                        <span class="tooltip-content">
                                <span class="tooltip-text">
                                    <span class="tooltip-inner">Добавить в черный список</span>
                                </span>
                            </span>
                    </button>
                    <button type="button" class="btn tooltip" onclick="sendMessage(this, <?=$row->id?>)">
                        <i class="fas fa-comments"></i>
                        <span class="tooltip-content">
                                <span class="tooltip-text">
                                    <span class="tooltip-inner">Написать сообщение</span>
                                </span>
                            </span>
                    </button>
                    <?php break;
                case 'confirmed': ?>
                    <button type="button" class="btn tooltip" onclick="deleteFriends(this, <?=$row->id?>)">
                        <i class="fas fa-user-times"></i>
                        <span class="tooltip-content">
                                <span class="tooltip-text">
                                    <span class="tooltip-inner">Удалить из друзей</span>
                                </span>
                            </span>
                    </button>
                    <button type="button" class="btn tooltip" onclick="addSubscriber(this, <?=$row->id?>)">
                        <i class="fas fa-user-edit"></i>
                        <span class="tooltip-content">
                                <span class="tooltip-text">
                                    <span class="tooltip-inner">Удалить из друзей, оставив подписчиком</span>
                                </span>
                            </span>
                    </button>
                    <button type="button" class="btn tooltip" onclick="addBlackList(this, <?=$row->id?>)">
                        <i class="fas fa-user-shield"></i>
                        <span class="tooltip-content">
                                <span class="tooltip-text">
                                    <span class="tooltip-inner">Добавить в черный список</span>
                                </span>
                            </span>
                    </button>
                    <button type="button" class="btn tooltip" onclick="sendMessage(this, <?=$row->id?>)">
                        <i class="fas fa-comments"></i>
                        <span class="tooltip-content">
                                <span class="tooltip-text">
                                    <span class="tooltip-inner">Написать сообщение</span>
                                </span>
                            </span>
                    </button>
                    <?php break;
                case 'subscriber': ?>
                    <button type="button" class="btn tooltip" onclick="addFriends(this, <?=$row->id?>)">
                        <i class="fas fa-user-plus"></i>
                        <span class="tooltip-content">
                                <span class="tooltip-text">
                                    <span class="tooltip-inner">Добавить в друзья</span>
                                </span>
                            </span>
                    </button>
                    <button type="button" class="btn tooltip" onclick="deleteSubscriber(this, <?=$row->id?>)">
                            <span class="fa-stack fa-sm">
                                <i class="fas fa-user-edit fa-stack-1x"></i>
                                <i class="fas fa-ban fa-stack-2x"></i>
                            </span>
                        <span class="tooltip-content">
                                <span class="tooltip-text">
                                    <span class="tooltip-inner">Удалить из подписчиков</span>
                                </span>
                            </span>
                    </button>
                    <button type="button" class="btn tooltip" onclick="addBlackList(this, <?=$row->id?>)">
                        <i class="fas fa-user-shield"></i>
                        <span class="tooltip-content">
                                <span class="tooltip-text">
                                    <span class="tooltip-inner">Добавить в черный список</span>
                                </span>
                            </span>
                    </button>
                    <button type="button" class="btn tooltip" onclick="sendMessage(this, <?=$row->id?>)">
                        <i class="fas fa-comments"></i>
                        <span class="tooltip-content">
                                <span class="tooltip-text">
                                    <span class="tooltip-inner">Написать сообщение</span>
                                </span>
                            </span>
                    </button>
                    <?php break;
                case 'blacklist': ?>
                    <button type="button" class="btn tooltip">
                        <i class="fas fa-user-shield user-bl"></i>
                        <span class="tooltip-content">
                                <span class="tooltip-text">
                                    <span class="tooltip-inner">Пользователь заблокировал Вас</span>
                                </span>
                            </span>
                    </button>
                <?php }
        else : ?>
            <button type="button" class="btn tooltip" onclick="addFriends(this, <?=$row->id?>)">
                <i class="fas fa-user-plus"></i>
                <span class="tooltip-content">
                        <span class="tooltip-text">
                            <span class="tooltip-inner">Добавить в друзья</span>
                        </span>
					</span>
            </button>
            <button type="button" class="btn tooltip" onclick="addBlackList(this, <?=$row->id?>)">
                <i class="fas fa-user-shield"></i>
                <span class="tooltip-content">
                        <span class="tooltip-text">
                            <span class="tooltip-inner">Добавить в черный список</span>
                        </span>
                    </span>
            </button>
            <button type="button" class="btn tooltip" onclick="sendMessage(this, <?=$row->id?>)">
                <i class="fas fa-comments"></i>
                <span class="tooltip-content">
                        <span class="tooltip-text">
                            <span class="tooltip-inner">Написать сообщение</span>
                        </span>
					</span>
            </button>
        <?php endif; ?>
    </div>
    <?php if ($full) : ?>
</li>
<?php endif; ?>