<div class="row">
    <p class="col-md-12 h3">
        <a href="/group/<?=$group->id?>" title="Назад на страницу группы">
            <span class="glyphicon glyphicon-arrow-left"></span>
        </a>
        &emsp;
        Управление группой "<?=$group->name?>"</p>

</div>
<ul class="nav nav-tabs">
    <li class="active"><a href="#general" data-toggle="tab">Основные настройки</a></li>
    <li><a href="#rules" data-toggle="tab">Привелегии</a></li>
    <li><a href="#users" data-toggle="tab">Участники</a></li>
    <li><a href="#remove" data-toggle="tab">Удалить группу</a></li>
</ul>
<div class="tab-content">
    <div class="tab-pane fade in active" id="general">
        <form class="row form-horizontal" id="group-info" enctype="multipart/form-data">
            <div class="form-group">
                <label for="slogan" class="col-sm-3 control-label">Слоган</label>
                <div class="col-sm-9">
                    <input type="text" name="slogan" value="<?=
                        (empty(set_value('slogan')))?$group->slogan:set_value('slogan');
                        ?>" class="form-control"
                           id="slogan" aria-describedby="sloganHelp" minlength="25" maxlength="512" required>
                    <span class="text-danger" id="slogan_err" ></span>
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-sm-3 control-label">Описание</label>
                <div class="col-sm-9">
                    <textarea name="description" class="form-control" id="description"
                              aria-describedby="descriptionHelp" minlength="100" required><?=
                        (empty(set_value('description')))?$group->description:set_value('description');
                        ?></textarea>
                    <span class="text-danger" id="description_err" ></span>
                </div>
            </div>
            <div class="form-group">
                <label for="label" class="col-sm-3 control-label">Аватар группы</label>
                <div class="col-sm-9">
                    <input type="file" name="label" class="form-control-file" id="label"
                           accept="image/jpeg,image/png, image/gif" data-toggle="tooltip" data-placement="right"
                           title="Максимальный размер файла: 100кБ, 1024х768px">
                    <span class="text-danger" id="label_err" ></span>
                </div>
            </div>
            <div class="form-group">
                <label for="type" class="col-sm-3 control-label">Тип группы</label>
                <div class="col-sm-9">
                    <select id="type" class="form-control">
                        <option value="open" <?php
                            echo  set_select('type', 'open', ($group->type === 'open')?true:false);
                            ?>>Открытая</option>
                        <option value="close" <?php
                            echo  set_select('type', 'close', ($group->type === 'close')?true:false);
                            ?>>Закрытая</option>
                    </select>
                    <span class="text-danger" id="type_err" ></span>
                </div>
            </div>
            <div id="status" class="text-center" ></div>
            <button type="button" class="center-block btn btn-success btn-md"
                    onclick="saveGroupInfo('<?=$group->id?>');" >
                Сохранить
            </button>
        </form>

        <form class="row form-horizontal" id="group-setting" enctype="multipart/form-data">
            <div class="form-group">
                <label for="wall" class="col-sm-3 control-label">Стена</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <select id="wall" class="form-control">
                            <option value="open" <?php
                            echo  set_select('wall', 'open', ($group->setting->wall === 'open')?true:false);
                            ?>>Открытая</option>
                            <option value="limited" <?php
                            echo  set_select('wall', 'limited', ($group->setting->wall === 'limited')?true:false);
                            ?>>Ограниченная</option>
                            <option value="close" <?php
                            echo  set_select('wall', 'close', ($group->setting->wall === 'close')?true:false);
                            ?>>Закрытая</option>
                        </select>
                        <span class="input-group-addon">?</span>
                    </div>
                    <span class="text-danger" id="wall_err" ></span>
                </div>
            </div>
            <div class="form-group">
                <label for="albums" class="col-sm-3 control-label">Альбомы</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <select id="albums" class="form-control">
                            <option value="open" <?php
                            echo  set_select('albums', 'open', ($group->setting->albums === 'open')?true:false);
                            ?>>Открытые</option>
                            <option value="close" <?php
                            echo  set_select('albums', 'close', ($group->setting->albums === 'close')?true:false);
                            ?>>Закрытые</option>
                        </select>
                        <span class="input-group-addon">?</span>
                    </div>
                    <span class="text-danger" id="albums_err" ></span>
                </div>
            </div>
            <div class="form-group">
                <label for="event" class="col-sm-3 control-label">Мероприятия</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <select id="event" class="form-control">
                            <option value="open" <?php
                            echo  set_select('event', 'open', ($group->setting->event === 'open')?true:false);
                            ?>>Открытые</option>
                            <option value="limited" <?php
                            echo  set_select('event', 'limited', ($group->setting->event === 'limited')?true:false);
                            ?>>Ограниченные</option>
                            <option value="close" <?php
                            echo  set_select('event', 'close', ($group->setting->event === 'close')?true:false);
                            ?>>Закрытые</option>
                        </select>
                        <span class="input-group-addon">?</span>
                    </div>
                    <span class="text-danger" id="event_err" ></span>
                </div>
            </div>
            <div id="status" class="text-center"></div>
            <button type="button" class="center-block btn btn-success btn-md"
                    onclick="saveGroupSetting('<?=$group->id?>');" >
                Сохранить
            </button>
        </form>
    </div>

    <div class="tab-pane fade" id="rules">
        <p>Владелец группы обладает всеми правами. Права участников настраиваются в основных настройках</p>
        <form class="row form-horizontal" id="group-rules">
            <table class="table">
                <thead>
                    <tr>
                        <th>Разрешение</th>
                        <th>Администратор</th>
                        <th>Редактор</th>
                        <th>Модератор</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($group->rules as $key => $row) : ?>
                    <tr>
                        <td><?=$row->title?>
                            <input type="hidden" name="<?=$key?>_title" value="<?=$row->title?>"/>
                            <input type="hidden" name="<?=$key?>_type" value="<?=$row->type?>"/>
                            <input type="hidden" name="<?=$key?>_o" value="<?=$row->o?>"/>
                            <input type="hidden" name="<?=$key?>_u" value="<?=$row->u?>"/>
                        </td>
                        <td>
                            <input type="checkbox" name="<?=$key?>_a"<?=($row->a)?' checked':''?>/>
                        </td>
                        <td>
                            <input type="checkbox" name="<?=$key?>_e"<?=($row->e)?' checked':''?>/>
                        </td>
                        <td>
                            <input type="checkbox" name="<?=$key?>_m"<?=($row->m)?' checked':''?>/>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div id="status" class="text-center"></div>
            <button type="button" class="center-block btn btn-success btn-md"
                    onclick="saveGroupRules('<?=$group->id?>');" >
                Сохранить
            </button>
        </form>
    </div>

    <div class="tab-pane fade" id="users">
        <div class="row">
            <div class="col-md-9">
                <?php foreach ($users as $row) : ?>
                <div class="row userCard<?=($row->community_group_id < 10)?' hidden':''?>"
                     data-type-user="<?=$row->community_group_id?>">
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
                            <a href="#" class="btn btn-info"
                               title="test">
                                Действие
                            </a>
                        </p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="col-md-3">
                <div class="radio">
                    <input type="radio" class="radio-hidden" id="changeUserAll" name="changeUser" value="all"/>
                    <label for="changeUserAll">Все участники</label>
                </div>
                <div class="radio">
                    <input type="radio" class="radio-hidden" id="changeUserAdmin" name="changeUser" value="admin"/>
                    <label for="changeUserAdmin">Администрация</label>
                </div>
                <div class="radio">
                    <input type="radio" class="radio-hidden" id="changeUserRequest" name="changeUser" value="request"/>
                    <label for="changeUserRequest">Заявки</label>
                </div>
                <div class="radio">
                    <input type="radio" class="radio-hidden" id="changeUserBan" name="changeUser" value="ban"/>
                    <label for="changeUserBan">Заблокированные</label>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="remove">
        <div class="row">
            <p class="col-md-9">
                Вы можете удалить группу нажав на кнопку справа, либо передать
                права участнику группы являющемуся администратором
            </p>
            <div class="col-md-3">
                <button type="button" class="btn btn-block btn-success btn-md"
                        onclick="removeGroup('<?=$group->id?>');" >
                    Удалить группу
                </button>
            </div>
        </div>

        <?php
        $admins = array();
        foreach ($users as $row) {
            if ($row->community_group_id == 50) {
                $admins[] = $row;
            }
        }
        if (count($admins) === 0) : ?>
        <p>Для передачи прав в группе должен быть хотя бы один администратор</p>
        <?php else : ?>
        <form class="form-horizontal" id="group-transfer" enctype="multipart/form-data">
            <div class="form-group">
                <div class="col-sm-9">
                    <select id="transfer" name="transfer" class="form-control">
                        <option value="null">
                            Выберите администратора которому передаете группу
                        </option>
                        <?php foreach ($admins as $row) : ?>
                        <option value="<?=$row->user_id?>" ><?=$row->full_name_user?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="text-danger" id="type_err" ></span>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-block btn-success btn-md"
                            onclick="transferGroup('<?=$group->id?>');" disabled="disabled">
                        Передать группу
                    </button>
                </div>
            </div>
            <div id="status" class="text-center"></div>
        </form>
        <?php endif; ?>
    </div>
</div>
<?php if (DEBUG) : ?>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <?php
            ob_start();
            var_dump($users);
            $s= ob_get_contents();
            ob_end_clean();
            echo '<pre>'.$s.'</pre>';
            ?>
        </div>
    </div>
</div>
<?php endif; ?>
<style>
    .radio-hidden {
        display: none;
    }
</style>
<script>
    function saveGroupInfo(id) {
        var formData = new FormData();
        formData.append('slogan', $("#group-info [name='slogan']").val());
        formData.append('description', $("#group-info [name='description']").val());
        if ($("#group-info [name='label']")[0].files[0]) {
            formData.append('label', $("#group-info [name='label']")[0].files[0]);
        }
        formData.append('type', $("#group-info #type option:selected").val());

        //Begin the ajax call
        $.ajax({
            url: "/group/save_group/"+id,
            type: "POST",
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,

            beforeSend: function() {
                $('#group-info #status').addClass("bg-info")
                            .removeClass("bg-danger bg-success bg-warning")
                            .html('<span class="glyphicon glyphicon-refresh"></span>')
                            .css({'margin-bottom':'10px','padding':'10px 0'});
            },

            success: function (json) {
                if (json.status == "OK") { //ошибок не было
                    $('#group-info #status').addClass("bg-success")
                                .removeClass("bg-danger bg-info bg-warning")
                                .html(json.message)
                                .css({'margin-bottom':'10px','padding':'10px 0'});
                    setTimeout(function() {
                        $('#group-info #status').html('').css({'margin-bottom':'0','padding':'0'});
                    }, 2000);
                } else { //ошибки были, показываем их описание
                    $('#group-info #status').addClass("bg-danger")
                                .removeClass("bg-success bg-info bg-warning")
                                .html(json.message)
                                .css({'margin-bottom':'10px','padding':'10px 0'});

                    $('#slogan_err').html(json.slogan_err);
                    $('#description_err').html(json.description_err);
                    $('#label_err').html(json.label_err);
                }
            },

            error: function () {
                $('#group-info #status').addClass("bg-warning")
                            .removeClass("bg-danger bg-info bg-success")
                            .html('<span class="text-danger">Что-то пошло не так. Попробуйте позже.</span>')
                            .css({'margin-bottom':'10px','padding':'10px 0'});
            }
        });
    }

    function saveGroupSetting(id) {
        var formData = new FormData();
        formData.append('wall', $("#wall option:selected").val());
        formData.append('albums', $("#albums option:selected").val());
        formData.append('event', $("#event option:selected").val());
        //Begin the ajax call
        $.ajax({
            url: "/group/save_setting/"+id,
            type: "POST",
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,

            beforeSend: function() {
                $('#group-setting #status').addClass("bg-info")
                    .removeClass("bg-danger bg-success bg-warning")
                    .html('<span class="glyphicon glyphicon-refresh"></span>')
                    .css({'margin-bottom':'10px','padding':'10px 0'});
            },

            success: function (json) {
                if (json.status == "OK") { //ошибок не было
                    $('#group-setting #status').addClass("bg-success")
                        .removeClass("bg-danger bg-info bg-warning")
                        .html(json.message)
                        .css({'margin-bottom':'10px','padding':'10px 0'});
                    setTimeout(function() {
                        $('#group-setting #status').html('').css({'margin-bottom':'0','padding':'0'});
                    }, 2000);
                } else { //ошибки были, показываем их описание
                    $('#group-setting #status').addClass("bg-danger")
                        .removeClass("bg-success bg-info bg-warning")
                        .html(json.message)
                        .css({'margin-bottom':'10px','padding':'10px 0'});

                    $('#wall_err').html(json.wall_err);
                    $('#albums_err').html(json.albums_err);
                    $('#event_err').html(json.event_err);
                }
            },

            error: function () {
                $('#group-setting #status').addClass("bg-warning")
                    .removeClass("bg-danger bg-info bg-success")
                    .html('<span class="text-danger">Что-то пошло не так. Попробуйте позже.</span>')
                    .css({'margin-bottom':'10px','padding':'10px 0'});
            }
        });
    }

    function saveGroupRules(id) {
        var formData = $('#group-rules').serialize();

        //Begin the ajax call
        $.ajax({
            url: "/group/save_rules/"+id,
            type: "POST",
            data: formData,
            dataType: "json",

            beforeSend: function() {
                $('#group-rules #status').addClass("bg-info")
                    .removeClass("bg-danger bg-success bg-warning")
                    .html('<span class="glyphicon glyphicon-refresh"></span>')
                    .css({'margin-bottom':'10px','padding':'10px 0'});
            },

            success: function (json) {
                if (json.status == "OK") { //ошибок не было
                    $('#group-rules #status').addClass("bg-success")
                        .removeClass("bg-danger bg-info bg-warning")
                        .html(json.message)
                        .css({'margin-bottom':'10px','padding':'10px 0'});
                    setTimeout(function() {
                        $('#group-rules #status').html('').css({'margin-bottom':'0','padding':'0'});
                    }, 2000);
                } else { //ошибки были, показываем их описание
                    $('#group-rules #status').addClass("bg-danger")
                        .removeClass("bg-success bg-info bg-warning")
                        .html(json.message)
                        .css({'margin-bottom':'10px','padding':'10px 0'});
                }
            },

            error: function () {
                $('#group-rules #status').addClass("bg-warning")
                    .removeClass("bg-danger bg-info bg-success")
                    .html('<span class="text-danger">Что-то пошло не так. Попробуйте позже.</span>')
                    .css({'margin-bottom':'10px','padding':'10px 0'});
            }
        });
    }

    let currSelect = null;
    $(function() {
        let defaultRadio = $('#users input:radio[value="all"]');
        currSelect = initSelectRadio(defaultRadio);
        $('#users').on('click', 'input:radio[name="changeUser"]', function() {
            if ($(this).val() === currSelect.val()) {
                return false;
            } else {

                currSelect = initSelectRadio($(this));
                filterUser($(this).val());
            }
        });
        $('#transfer option[value="null"]').prop({checked:true, disabled:true});
        $('#group-transfer').on('change', '#transfer', function(){checkTransfer()});
    });

    function initSelectRadio(elem) {
        elem.prop('checked', true);
        elem.siblings().css("font-weight", "bolder");
        $("#users input:radio:not(:checked)").siblings().css("font-weight", "normal");
        return elem;
    }

    function filterUser(type) {
        let users = document.getElementById('users');
        let usersCard = users.getElementsByClassName('userCard');
        for(let i=0; i<usersCard.length; i++) {
            switch (type) {
                case 'all':
                    if (usersCard[i].dataset.typeUser >= 10) {
                        usersCard[i].classList.remove("hidden")
                    } else {
                        usersCard[i].classList.add("hidden")
                    }
                    break;
                case 'admin':
                    if (usersCard[i].dataset.typeUser >= 20) {
                        usersCard[i].classList.remove("hidden")
                    } else {
                        usersCard[i].classList.add("hidden")
                    }
                    break;
                case 'request':
                    if (usersCard[i].dataset.typeUser == 5) {
                        usersCard[i].classList.remove("hidden")
                    } else {
                        usersCard[i].classList.add("hidden")
                    }
                    break;
                case 'ban':
                    if (usersCard[i].dataset.typeUser == 1) {
                        usersCard[i].classList.remove("hidden")
                    } else {
                        usersCard[i].classList.add("hidden")
                    }
                    break;
            }
        }
    }

    function removeGroup(id) {
        $.ajax({
            url: "/group/remove_group/"+id,
            type: "POST",
            dataType: "json",
            success: function (json) {
                if (json.status == "OK") { //ошибок не было
                    $('#Modal .modal-content').html(json.message);
                    $('#Modal').modal('show');
                    setTimeout(function() {
                        $('#Modal').modal('hide');
                        $('#Modal .modal-content').html('');
                    }, 3000);
                } else { //ошибки были, показываем их описание
                    $('#Modal .modal-content').html(json.message);
                    $('#Modal').modal('show');
                }
            }
        });
    }

    function checkTransfer() {
        let trId = $("#transfer option:selected").val();
        $.ajax({
            url: "/group/check_transfer/"+trId,
            type: "POST",
            dataType: "json",
            success: function (json) {
                if (json.status == "OK") { //ошибок не было
                    $('#group-transfer button').removeProp('disabled');
                } else { //ошибки были, показываем их описание
                    $('#group-transfer #status').addClass("bg-danger")
                        .removeClass("bg-success bg-info bg-warning")
                        .html(json.message)
                        .css({'margin-bottom':'10px','padding':'10px 0'});
                }
            }
        });
    }

    function transferGroup(id) {
        let formData = new FormData();
        formData.append('transfer', $("#transfer option:selected").val());
        $.ajax({
            url: "/group/group_transfer/"+id,
            type: "POST",
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            success: function (json) {
                if (json.status == "OK") { //ошибок не было
                    $('#Modal .modal-content').html(json.message);
                    $('#Modal').modal('show');
                    setTimeout(function() {
                        $('#Modal').modal('hide');
                        $('#Modal .modal-content').html('');
                    }, 3000);
                } else { //ошибки были, показываем их описание
                    $('#Modal .modal-content').html(json.message);
                    $('#Modal').modal('show');
                }
            }
        });
    }
</script>