<div class="row">
    <div class="col-md-12">
        <ul class="list-inline">
            <li>
                <p class="lead">Create group</p>
            </li>
            <li class="pull-right">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </li>
        </ul>
    </div>
</div>
<form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name" class="col-sm-3 control-label">Название группы</label>
        <div class="col-sm-9">
            <input type="text" name="name" value="<?php echo set_value('name'); ?>" class="form-control"
                   id="name" aria-describedby="nameHelp" minlength="5" maxlength="128" required>
            <span class="text-danger" id="name_err" ></span>
        </div>
    </div>
    <div class="form-group">
        <label for="slogan" class="col-sm-3 control-label">Слоган</label>
        <div class="col-sm-9">
            <input type="text" name="slogan" value="<?php echo set_value('slogan'); ?>" class="form-control"
                   id="slogan" aria-describedby="sloganHelp" minlength="25" maxlength="512" required>
            <span class="text-danger" id="slogan_err" ></span>
        </div>
    </div>
    <div class="form-group">
        <label for="description" class="col-sm-3 control-label">Описание</label>
        <div class="col-sm-9">
            <textarea name="description" class="form-control" id="description"
                      aria-describedby="descriptionHelp" minlength="100" required><?php
                echo set_value('description');
            ?></textarea>
            <span class="text-danger" id="description_err" ></span>
        </div>
    </div>
    <div class="form-group">
        <label for="label" class="col-sm-3 control-label">Аватар группы</label>
        <div class="col-sm-9">
            <input type="file" name="label" class="form-control-file" id="label"
                   accept="image/jpeg,image/png, image/gif" required data-toggle="tooltip" data-placement="right"
                   title="Максимальный размер файла: 100кБ, 1024х768px">
            <span class="text-danger" id="label_err" ></span>
        </div>
    </div>
    <div class="form-group">
        <label for="type" class="col-sm-3 control-label">Тип группы</label>
        <div class="col-sm-9">
            <select id="type" name="type" class="form-control">
                <option value="open" <?php echo  set_select('type', 'open', TRUE); ?>>Открытая</option>
                <option value="close" <?php echo  set_select('type', 'close'); ?>>Закрытая</option>
            </select>
            <span class="text-danger" id="type_err" ></span>
        </div>
    </div>
    <div id="status" class="text-center" ></div>
        <button type="submit" class="btn btn-success btn-lg btn-block" id="contactModalsubmit" >Создать
            группу</button>
    </div>
</form>

<script>
    $(document).ready(function(){
        //Listen for the form submit
        $('#Modal').submit(sendContact);
        $('#label').tooltip();
    });
</script>