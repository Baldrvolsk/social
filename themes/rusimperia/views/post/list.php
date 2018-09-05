<?php defined('BASEPATH') OR exit('No direct script access allowed');

foreach ($posts as $post):
    if ($post->delta <= -25) continue;?>
<div class="content-box post">
    <div class="post-user">
        <img src="/media/user/avatar/<?=$post->avatar;?>" class="avatar">
        <p class="text-center"><?= $post->full_name_user ?></p>
        <p><?php if ($post->user_group > 40) $post->user_group = 40;
            switch ((int)$post->user_group) {
            case 10:
            $rangIcon = 'far fa-smile';
            break;
            case 20:
            $rangIcon = 'far fa-user';
            break;
            case 30:
            $rangIcon = 'fas fa-university';
            break;
            case 40:
            $rangIcon = 'fas fa-crown';
            break;
            }
        ?><i class="<?=$rangIcon?> rang-icon"></i></p>
    </div>
    <ul class="post-header">
        <li><?=date_to_str('%R %e %bf %Y', $this->router->user_lang, strtotime($post->date_add))?></li>
        <li class="dd-anchor"><i class="fas fa-ellipsis-v"></i>
        <?php if ($this->user->id === $post->user_id) : ?>
            <ul class="dropdown">
                <li><button type="button" class="btn btn-text" onclick="edit_post(<?=$post->id?>)
                            ">Редактировать</button></li>
                <li><button type="button" class="btn btn-text" onclick="delete_post(<?=$post->id?>)">Удалить</button></li>
            </ul>
        <?php endif; ?>
        </li>
    </ul>
    <div class="post-content">
        <?=(empty($post->content)?$post->post_content:$post->content)?>
    </div>
    <div class="post-footer">
        <span<?=($post->u_like === 1)?' class="bg-success"':''?> onclick="add_like(<?=$post->id?>)">
            <i class="far fa-thumbs-up" ></i>
            <span id="countLike<?=$post->id?>"><?=($post->c_like > 0)?$post->c_like:''?></span>
        </span>
        <span<?=($post->u_like === 0)?' class="bg-danger"':''?> onclick="add_dislike(<?=$post->id?>)">
            <i class="far fa-thumbs-down"></i>
            <span id="countDislike<?=$post->id?>"><?=($post->c_dislike > 0)?$post->c_dislike:''?></span>
        </span>
        <span><span class="post-delta">&Delta;</span> <span id="countDelta<?=$post->id?>"><?php
                if ($post->delta != 0) {
                    echo $post->delta;
                }?></span></span>
        <span onclick="add_comment(<?=$post->id?>)">
            <i class="far fa-comment-alt"></i>
            <span id="countComment<?=$post->id?>"><?=($post->c_comment > 0)?$post->c_comment:''?></span>
        </span>
        <span onclick="share_post(<?=$post->id?>)">
            <i class="fas fa-share-alt"></i>
            <span id="countShare<?=$post->id?>"><?=($post->c_shared > 0)?$post->c_shared:''?></span>
        </span>
    </div>
</div>

<?php endforeach; ?>