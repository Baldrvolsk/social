<div class="row">
    <p class="col-md-11 h3">Управление группой "<?=$group->name?>"</p>
    <a class="col-md-1" href="/group/<?=$group->id?>" title="Назад на страницу группы">
        <span class="glyphicon glyphicon-arrow-left"></span>
    </a>
</div>
<ul class="nav nav-tabs">
    <li class="active"><a href="#general" data-toggle="tab">Основные</a></li>
    <li><a href="#setting" data-toggle="tab">Настройки</a></li>
    <li><a href="#rules" data-toggle="tab">Привелегии</a></li>
    <li><a href="#admin" data-toggle="tab">Администрация</a></li>
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
    <div class="tab-pane fade" id="setting">
        <div class="row">

        </div>
    </div>
    <div class="tab-pane fade" id="rules">
        <div class="row">

        </div>
    </div>
    <div class="tab-pane fade" id="admin">
        <div class="row">

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="row">
            <?php
            ob_start();
            var_dump($group);
            $s= ob_get_contents();
            ob_end_clean();
            echo '<pre>'.$s.'</pre>';
            ?>
        </div>
    </div>
</div>

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
</script>