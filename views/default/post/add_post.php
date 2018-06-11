<form id="add_post" action="/post/add" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="userId" value="<?=$userId?>">
    <div class="form-group">
        <label for="PostContent"></label>
        <textarea name="content" class="form-control" id="PostContent" placeholder="Что у вас нового" required>
            <?=trim(set_value('content'))?>
        </textarea>
        <?php if(form_error('content')) {echo form_error('content','<span class="error">','</span>');} ?>
    </div>
    <button type="submit" class="btn btn-primary">Поделиться</button>
</form>
<style>
    .error {
        color:red;
    }
</style>