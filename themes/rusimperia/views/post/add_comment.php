<form id="add_comment" action="/post/add_comment/<?=$postId?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="userAddId" value="<?=$this->user->id?>">
    <div class="form-group">
        <textarea name="content" class="form-control" id="commContent" required><?=set_value('content')?></textarea>
        <?php
        $form_error = $this->session->tempdata('form_error');
        if(is_string($form_error)) echo '<div class="error">'.$form_error.'</div>' ?>
    </div>
    <button type="submit" class="btn btn-primary">Добавить комментарий</button>
</form>
<style>
    .error {
        color:red;
    }
</style>
