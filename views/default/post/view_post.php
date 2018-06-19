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
        <div class="col-sm-1">
            <img src="/uploads/profile/<?= $this->user->id; ?>/active.jpg"
                 width="50" class="img-circle">
        </div>
        <div class="col-sm-11">
            <div class="postHeader">
                <span class="lead"><?= $post->first_name . ' ' . $post->last_name ?></span>
                <span><?= $post->date_add ?></span>
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
                <span class="glyphicon glyphicon-share-alt"></span>
                <span class="glyphicon glyphicon-eye-open"></span>
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
