<div class="row row-border">
    <div class="col-md-12 head-img" style="background-image:url(<?=$group->head_img?>)">
        <button class="btn btn-default upl-head-img" onclick="load_form('change_head_img', <?=$group->id?>);">
            <span class="glyphicon glyphicon-upload"></span>
        </button>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-1">
                <img src="<?=$group->label?>" width="50" class="center-block img-circle">
            </div>
            <div class="col-md-8">
                <p><span class="lead"><?=$group->name?></span><br>
                <?=$group->slogan?></p>
            </div>
            <div class="col-md-3">
                <?php if ($this->user->com_gr_id === 50) : ?>
                    <div class="btn-group">
                        <a class="btn btn-info" href="/group/manage/<?=$group->id?>">
                            Управление
                        </a>
                    </div>
                <?php elseif($this->user->com_gr_id !== null && $this->user->com_gr_id <= 10) : ?>
                <div class="btn-group">
                    <button type="button" class="btn btn-info" onclick="follow_group(<?=$group->id?>);">
                        Отписаться
                    </button>
                </div>
                <?php else : ?>
                <div class="btn-group">
                    <button type="button" class="btn btn-info" onclick="follow_group(<?=$group->id?>);">
                        Подписаться
                    </button>
                </div>
                <?php endif; ?>
                <div class="btn-group">
                    <button type="button" class="btn btn-default" onclick="share_group(<?=$group->id?>);">
                        <span class="glyphicon glyphicon-share"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row row-border">
    <p class="col-md-12 h3">Contacts <?=(!empty($contacts) && count($contacts) > 0)?count($contacts):''?></p>
    <?php if (!empty($contacts)) :
    foreach ($contacts as $row) :
    if (!file_exists(WEBROOT . $row->photo)) {
        $row->photo = '/img/blank.jpeg';
    }?>
    <div class="col-md-4">
        <div class="row">
            <div class="row">
                <div class="col-md-3">
                    <img src="<?=$row->photo?>" width="50" class="center-block img-circle">
                </div>
                <div class="col-md-9">
                    <p>
                        <a href="/profile/<?=$row->id?>" title="Посмотреть профиль">
                            <?= $row->full_name_user ?>
                        </a>
                        <br><?=$row->name_ru?>
                        <br>contacts
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach;
    endif; ?>
</div>
<div class="row row-border">
   <div class="col-md-12">
       <div class="row">
           <div class="col-md-2">About</div>
           <div class="col-md-10"><p><?=$group->description?></p></div>
       </div>
       <div class="row">
           <div class="col-md-2">Members</div>
           <div class="col-md-10"><?=$group->count_users?></div>
       </div>
       <?php if (!empty($group->website)) : ?>
       <div class="row">
           <div class="col-md-2">Website</div>
           <div class="col-md-10"><?=$group->website?></div>
       </div>
       <?php endif; ?>
   </div>
</div>
<div class="row row-border">
    <div class="col-md-2">Events</div>
    <div class="col-md-10"></div>
</div>
<div class="row row-border">
    <div class="col-md-2">Photos</div>
    <div class="col-md-10"></div>
</div>

<div class="row row-border">
    <div class="col-md-12">
        <div class="row">
            <?=$addPostForm?>
        </div>
    </div>
</div>

<?=$posts?>
<?php if (DEBUG) : ?>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <?php
            ob_start();
            var_dump($this->user);
            $s= ob_get_contents();
            ob_end_clean();
            echo '<pre>'.$s.'</pre>';
            ?>
        </div>
    </div>
</div>
<?php endif; ?>
<style>
    .row-border {
        border-radius: 20px;
        border: #a3a3a3 1px solid;
        margin-bottom: 20px;
        background-color: #fff;
        overflow: hidden;
    }
    .head-img {
        width: 100%;
        min-height: 250px;
    }
    .upl-head-img {
        position: absolute;
        bottom: 15px;
    }
    p {
        text-align: justify;
    }
</style>
<script>
    function load_form(type, group_id) {
        $.ajax({
            type: "POST",
            url: '/group/load_form/'+type+'/'+group_id,
            dataType: "html",
            success: function(data){
                if (type === 'setting') {
                    $('#Modal .modal-dialog').removeClass('modal-md').addClass('modal-lg');
                } else {
                    $('#Modal .modal-dialog').removeClass('modal-lg').addClass('modal-md');
                }
                $('#Modal .modal-content').html(data);
                $('#Modal').modal('show');
            }
        });
    }
</script>