<form id="add_post" action="/post/add/<?=$userId?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="userAddId" value="<?=$this->user->id?>">
    <div class="form-group">
        <textarea name="content" class="form-control" id="PostContent" placeholder="Что у вас нового" required><?=set_value('content')?></textarea>
        <?php if(form_error('content')) {echo form_error('content','<span class="error">','</span>');} ?>
    </div>
    <button type="submit" class="btn btn-primary">Поделиться</button>
</form>
<style>
    .error {
        color:red;
    }
</style>