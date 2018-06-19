<?php
/**
 * Created by PhpStorm.
 * User: Baldr
 * Date: 11.06.2018
 * Time: 5:52
 */

foreach ($posts as $post):
    if ($post->delta <= -25) continue;?>
    <hr>
    <div class="row" style="margin-top: 15px;margin-bottom: 15px">
        <div class="col-sm-2">
            <img src="/uploads/profile/<?= $this->user->id; ?>/active.jpg"
                 width="50" class="img-circle">
            <p><?= $post->first_name . ' ' . $post->last_name ?></p>
        </div>
        <div class="col-sm-10">
            <div class="postHeader clearfix">
                <ul class="list-inline pull-right">
                    <li><?= $post->date_add ?></li>
                    <li>
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
                <span class="glyphicon glyphicon-comment"></span>
                <span class="glyphicon glyphicon-share-alt"></span>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    function add_like(id) {
        $.ajax({
            type: "GET",
            url: "/post/add_like/<?=$this->user->id?>/" + id,
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
            url: "/post/add_dislike/<?=$this->user->id?>/" + id,
            dataType: 'json',
            success: function(data){
                $('#countLike'+id).text(data.like);
                $('#countDislike'+id).text(data.dislike);
                $('#countDelta'+id).text(data.delta);
            }
        });
    }
</script>
