<?php
/**
 * Created by PhpStorm.
 * User: Baldr
 * Date: 11.06.2018
 * Time: 5:52
 */

    foreach ($posts as $key => $post): ?>
        <?= ($key !== 0) ? '<hr>' : '' ?>
        <div class="row" style="margin-top: 15px;margin-bottom: 15px">
            <div class="col-sm-1">
                <img src="/uploads/profile/<?= $this->user->id; ?>/active.jpg"
                     width="50" class="img-circle">
            </div>
            <div class="col-sm-11">
                <div class="postHeader">
                    <span class="lead"><?= $post['first_name'] . ' ' . $post['last_name'] ?></span>
                    <span><?= $post['date_add'] ?></span>
                </div>
                <div class="postContent" style="margin:15px 0">
                    <?= $post['content'] ?>
                </div>
                <div class="postFooter">
                    <span class="glyphicon glyphicon-thumbs-up"></span>
                    <span class="glyphicon glyphicon-thumbs-down"></span>
                    <span class="glyphicon glyphicon-comment"></span>
                    <span class="glyphicon glyphicon-share-alt"></span>
                    <span class="glyphicon glyphicon-eye-open"></span>
                </div>
            </div>
        </div>
    <?php endforeach;
