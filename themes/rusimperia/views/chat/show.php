<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="messages_container">

    <?php if(count($chat) > 0) : ?>
            <?php foreach($chat as $c): ?>
                <?php
                $tmp = explode(' ',$c->date_add);
                $date = explode('-',$tmp[0]);
                $time= explode(':',$tmp[1]);
                ?>
                <?php if($c->user_id == $this->user->id) : ?>
                <div class="chat_message right">
                   Я <?=$time[0].':'.$time[1] ?><br />
                    <?=$c->content; ?>                    <img src="<?=$c->company;?>" width="50"/>
                    <br />
                    <?=$date[2].'-'.$date[1].'-'.$date[0]; ?>

                </div>

        <?php else : ?>
                <div class="chat_message">
                    <a href="/profile/<?=$c->user_id; ?>"><?=$c->first_name.' '.$c->last_name; ?></a> <?=$time[0].':'.$time[1] ?><br />
                    <img src="<?=$c->company;?>" width="50"/>
                    <?=$c->content; ?><br />
                    <?=$date[2].'-'.$date[1].'-'.$date[0]; ?>
                </div>
        <?php endif; ?>
            <?php endforeach; ?>
    <?php else : ?>
        <h1>У Вас нет начатых чатов</h1>
    <?php endif; ?>
</div>
    <form action="/chat/send" method="POST">
        <input type="hidden" name="chat_id" value="<?=$chat_id; ?>" />
        <textarea class="form-control" placeholder="Ваше сообщение" name="content"></textarea>
        <button type="submit" class="btn btn-success">Отправить</button>
    </form>

<style>
    .messages_container {
        min-height: 400px;
        max-height: 400px;
        overflow-x: scroll;
    }
    .chat_message {
        border: 2px solid #dedede;
        background-color: #f1f1f1;
        border-radius: 5px;
        padding: 10px;
        margin: 10px 0;
    }
    .chat_message .chat_image {

        margin-right:10px;
    }
    .right {
        text-align:right;
    }
</style>
