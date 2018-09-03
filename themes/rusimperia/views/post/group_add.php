<form id="add_post" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="group_id" value="<?=$group_id?>">
    <input type="hidden" name="user_id" value="<?=$this->user->id?>">

    <div class="form-group">
        <textarea name="content" class="form-control" id="PostContent" placeholder="Предложить новость"
                  rows="1" required><?=set_value('content')?></textarea>
        <span class="glyphicon glyphicon-ok form-control-feedback" onclick="add_post()"></span>
        <?php if(form_error('content')) {echo form_error('content','<span class="error">','</span>');} ?>
    </div>
</form>
<style>
    textarea {
        resize: none;
    }
    .form-control-feedback {
        pointer-events: auto;
    }
    .error {
        color:red;
    }
</style>
<script>

</script>