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
    document.addEventListener('DOMContentLoaded', function() {
        $("[name='content']")
            .focus(function() {
                $(this).attr('rows', "3");
            })
            .blur(function() {
                $(this).attr('rows', "1");
            });
    }, false);

    function add_post() {
        //Collect our form data.
        var formData = new FormData();
        formData.append('group_id', $("[name='group_id']").val());
        formData.append('user_id', $("[name='user_id']").val());
        formData.append('content', $("[name='content']").val());

        $.ajax({
            type: "POST",
            url: '/group/post_add',
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            success: function(data){
                $('#Modal .modal-content').html(data.message);
                $('#Modal').modal('show');
            }
        });
    }
</script>