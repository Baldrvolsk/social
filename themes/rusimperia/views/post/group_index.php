<?php
/**
 * Created by PhpStorm.
 * User: Baldr
 * Date: 11.06.2018
 * Time: 5:52
 */

foreach ($posts as $post):
    if ($post->delta <= -25) continue;?>
    <div class="row row-border">
        <div class="col-sm-2">
            <img src="<?=$post->photo?>"
                 width="50" class="center-block img-circle">
            <p class="text-center"><?= $post->full_name_user ?></p>
        </div>
        <div class="col-sm-10">
            <div class="postHeader clearfix">
                <ul class="list-inline pull-right">
                    <li><?= $post->date_add ?></li>
                    <li>
                        <?php if ($this->user->id === $post->user_create_id) : ?>
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="post<?=$post->id?>" data-toggle="dropdown">
                                Меню
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="post<?=$post->id?>">
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="/post/edit/<?=$post->id?>">Редактировать</a>
                                </li>
                                <li role="presentation" class="divider"></li>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="/post/delete/<?=$post->id?>">Удалить</a>
                                </li>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </li>
                </ul>

            </div>
            <div class="postContent" style="margin:15px 0">
                <?= $post->content ?>
            </div>
            <div class="postFooter">
                <span<?=($post->u_like === 1)?' class="bg-success"':''?>>
                    <span id="like" class="glyphicon glyphicon-thumbs-up" onclick="add_like(<?=$post->id?>)"></span>
                    <span id="countLike<?=$post->id?>" class="badge"><?=($post->like > 0)?$post->like:''?></span>
                </span>
                <span<?=($post->u_like === 0)?' class="bg-danger"':''?>>
                    <span id="dislike" class="glyphicon glyphicon-thumbs-down" onclick="add_dislike(<?=$post->id?>)"></span>
                    <span id="countDislike<?=$post->id?>" class="badge"><?=($post->dislike > 0)?$post->dislike:''?></span>
                </span>

                <span>&Delta; <span id="countDelta<?=$post->id?>" class="badge"><?php
                    if ($post->delta !== 0) {
                        echo $post->delta;
                    }?></span></span>
                <span class="glyphicon glyphicon-comment" onclick="open_modal(<?=$post->id?>)"></span>
                <span class="glyphicon glyphicon-share-alt"></span>
            </div>
        </div>
    </div>

<?php endforeach; ?>

<script>
    function add_like(id) {
        $.ajax({
            type: "GET",
            url: "/group/post/add_like/<?=$this->user->id?>/" + id,
            dataType: 'json',
            success: function(data){
                $('#countLike'+id).text(data.like);
                $('#countDislike'+id).text(data.dislike);
                $('#countDelta'+id).text(data.delta);
            }
        });
    }
    function add_dislike(id) {
        $.ajax({
            type: "GET",
            url: "/group/post/add_dislike/<?=$this->user->id?>/" + id,
            dataType: 'json',
            success: function(data){
                $('#countLike'+id).text(data.like);
                $('#countDislike'+id).text(data.dislike);
                $('#countDelta'+id).text(data.delta);
            }
        });
    }

    function open_modal(id) {
        $.ajax({
            type: "GET",
            url: '/post/comment/'+id,
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
        <?php
        $show_modal = $this->session->flashdata('show_post');
        if (!empty($show_modal)) { ?>
        $.ajax({
            type: "GET",
            url: '/group/post/comment/<?=$show_modal?>',
            success: function(data){
                $('#Modal .modal-content').html(data);
                $('#Modal').modal('show');
            }
        });
        <?php } ?>
    }, false);
</script>
