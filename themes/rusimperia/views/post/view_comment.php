<?php
foreach ($comments as $comment): ?>
    <hr>
    <div class="row" style="margin-top: 15px;margin-bottom: 15px">
        <div class="col-sm-2">
            <img src="<?=$comment->photo?>"
                 width="50" class="center-block img-circle">
            <p class="text-center"><?= $comment->full_name_user ?></p>
        </div>
        <div class="col-sm-10">
            <div class="postContent" style="margin:15px 0">
                <?= $comment->content ?>
            </div>
            <div class="postFooter">
                <span class="glyphicon glyphicon-comment" onclick="open_modal('data')"></span>

            </div>
        </div>
    </div>
<?php endforeach; ?>