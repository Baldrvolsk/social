<div class="row">
    <div class="col-md-2">
        <img src="<?=$post->photo?>" width="50" class="center-block img-circle">
    </div>
    <div class="col-md-10">
        <ul class="list-inline">
            <li>
                <p class="lead"><?= $post->full_name_user ?></p>
            </li>
            <li><?= $post->date_add ?></li>

            <li class="pull-right">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </li>
            <li class="pull-right">
                <?php if ($this->user->id === $post->user_id) : ?>
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
</div>
<div class="row">
    <div class="col-md-12">
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
<div class="row">
    <div class="col-md-12">
        <?= $comment ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?= $add_comment_form ?>
    </div>
</div>
