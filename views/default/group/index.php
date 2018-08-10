
<!-- Nav tabs -->
<ul class="nav nav-tabs">
    <li class="active"><a href="#all_groups" data-toggle="tab">All groups</a></li>
    <li><a href="#popular_groups" data-toggle="tab">Popular groups</a></li>
    <li><a href="#new_groups" data-toggle="tab">New groups</a></li>
    <li class="pull-right">
        <?php if ($this->user->create_group->status): ?>
            <span class="btn btn-info" onclick="add_group()">Create group</span>
        <?php else: ?>
            <span class="btn btn-info disabled" rel="tooltip" data-placement="bottom" data-html="true"
                  data-title="Доступно через <?=$this->user->create_group->time?>">
                Create group
            </span>
        <?php endif; ?>
    </li>
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
    <div class="tab-pane active" id="all_groups">
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
    <div class="tab-pane" id="popular_groups">
        <div class="row">

        </div>
    </div>
    <div class="tab-pane" id="new_groups">
        <div class="row">

        </div>
    </div>
</div>

<script>
    function follow_group(id) {
        $.ajax({
            type: "POST",
            url: '/group/follow_group/<?=$this->user->id?>/' + id,
            success: function(data){
                $('#Modal .modal-content').html(data);
                $('#Modal').modal('show');
                setTimeout(function(){$('#Modal').modal('hide');}, 2000);
            }
        });
    }

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

        $('body').tooltip({
            selector: '[rel="tooltip"]'
        });

        $(".btn").click(function(e) {
            if (! $(this).hasClass("disabled"))
            {
                $(".disabled").removeClass("disabled").attr("rel", null);
                $(this).addClass("disabled").attr("rel", "tooltip");

                $(this).mouseenter();
            }
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
        formData.append('type', $("[name='type'] :selected").val());

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
                $('#status').addClass("bg-info")
                            .removeClass("bg-danger bg-success bg-warning")
                            .html('<span class="glyphicon glyphicon-refresh"></span>)
                            .css({'margin-bottom':'10px','padding':'10px 0'});
            },

            success: function (json) {
                //ошибок не было
                if (json.status == "OK") {
                    $('#status').addClass("bg-success")
                                .removeClass("bg-danger bg-info bg-warning").html(json.message)
                                .css({'margin-bottom':'10px','padding':'10px 0'});

                }
                //ошибки были, показываем их описание
                else {
                    $('#status').addClass("bg-danger")
                                .removeClass("bg-success bg-info bg-warning")
                                .html(json.message+'<s'+'cript>' +
                                    'setTimeout(function(){location.reload()}, 2e3)' +
                                    '</s'+'cript>')
                                .css({'margin-bottom':'10px','padding':'10px 0'});

                    $('#name_err').html(json.name_err);
                    $('#slogan_err').html(json.slogan_err);
                    $('#description_err').html(json.description_err);
                    $('#label_err').html(json.label_err);
                    $('#type_err').html(json.type_err);
                }
            },

            error: function (r) {
                $('#status').addClass("bg-warning")
                            .removeClass("bg-danger bg-info bg-success")
                            .html('<span class="text-danger">Что-то пошло не так. Попробуйте позже.</span>')
                            .css({'margin-bottom':'10px','padding':'10px 0'});
            }
        });
    }
</script>
