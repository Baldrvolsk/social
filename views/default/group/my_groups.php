<!-- Nav tabs -->
<ul class="nav nav-tabs">
    <li class="active"><a href="#all_group" data-toggle="tab">All groups <?php
        if (count($groups) > 0) echo count($groups); ?></a></li>
    <li><a href="#new_groups" data-toggle="tab">New groups</a></li>
    <li><a href="#managed_groups" data-toggle="tab">Managed groups</a></li>
    <li class="pull-right"><span class="btn btn-info" onclick="add_group()">Create group</span></li>
</ul>
<!-- Search -->
<div class="row">
    <div class="col-md-12">
        <div class="input-group">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
            </span>
            <input type="text" class="form-control">
        </div><!-- /input-group -->
    </div>
</div>
<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane active" id="all_group">
        <div class="row">
            <?php foreach ($groups as $row) : ?>
                <div class="row">
                    <div class="col-md-2">
                        <img src="<?=$row->label?>" width="50" class="center-block img-circle">
                    </div>
                    <div class="col-md-10">
                        <p class="lead" ><a href="/group/<?=$row->id?>"><?=$row->name?></a></p>
                        <p><?=$row->slogan?></p>
                        <p><?=$row->count_users?> подписчиков</p>
                        <button type="button" class="btn btn-primary"
                                onclick="follow_group(<?=$row->id?>);">Вступить</button>
                    </div>
                </div>
                <hr>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="tab-pane" id="new_groups">
        <div class="row">

        </div>
    </div>
    <div class="tab-pane" id="managed_groups">
        <div class="row">

        </div>
    </div>
</div>

<script>
    function add_group() {
        $.ajax({
            type: "POST",
            url: '/group/form_new_group',
            success: function(data){
                $('#Modal .modal-content').html(data);
                $('#Modal').modal('show');
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        $('#Modal').on('hidden.bs.modal', function (e) {
            $('#Modal .modal-content').html('');
        });

    }, false);

    //The function that handles the process
    function sendContact(event) {
        //Stop the form from submitting
        event.preventDefault();

        //Collect our form data.
        var formData = new FormData();
        formData.append('name', $("[name='name']").val());
        formData.append('slogan', $("[name='slogan']").val());
        formData.append('description', $("[name='description']").val());
        formData.append('label', $("[name='label']")[0].files[0]);

        //Begin the ajax call
        $.ajax({
            url: "/group/create_group",
            type: "POST",
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,

            beforeSend: function() {
                $('#status').addClass("bg-info").removeClass("bg-danger bg-success bg-warning").html('<span class="glyphicon glyphicon-refresh"' +
                    '></span>').css({'margin-bottom':'10px','padding':'10px 0'});
            },

            success: function (json) {
                //ошибок не было
                if (json.status == "OK") {
                    $('#status').addClass("bg-success").removeClass("bg-danger bg-info bg-warning").html(json.message).css({'margin-bottom':'10px','padding':'10px 0'});

                }
                //ошибки были, показываем их описание
                else {
                    $('#status').addClass("bg-danger").removeClass("bg-success bg-info bg-warning").html(json.message).css({'margin-bottom':'10px','padding':'10px 0'});

                    $('#name_err').html(json.name_err);
                    $('#slogan_err').html(json.slogan_err);
                    $('#description_err').html(json.description_err);
                    $('#label_err').html(json.label_err);
                }
            },

            error: function (r) {
                $('#status').addClass("bg-warning").removeClass("bg-danger bg-info bg-success").html('<span class="text-danger">Что-то пошло не так. Попробуйте позже.</span>').css({'margin-bottom':'10px','padding':'10px 0'});
            }
        });
    }
</script>