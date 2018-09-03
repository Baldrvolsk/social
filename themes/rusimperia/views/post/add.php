<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<form id="add_post" enctype="multipart/form-data">
    <input type="hidden" name="type" value="<?=$this->router->class?>">
    <input type="hidden" name="owner_id" value="<?=$data->id?>">
    <input type="hidden" name="add_id" value="<?=$this->user->id?>">
    <textarea name="content" class="form-control" id="postEditor" placeholder="Что у вас нового" required><?=set_value
        ('content')?></textarea>
    <span id="status"></span>
    <button type="button" onclick="add_post()" class="btn btn-primary">Поделиться</button>
</form>
