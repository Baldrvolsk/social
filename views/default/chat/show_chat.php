<div class="col-md-10">
<div class="messages_container">

    <?php if(count($chat) > 0) : ?>
            <?php foreach($chat as $c): ?>
        <div <?php if($c->user_id == $this->user->id) : ?> style="text-align:right;" <?php endif;?>>
            От: <a href="/profile/<?=$c->user_id; ?>"><?=$c->first_name.' '.$c->last_name; ?></a> <?=$c->date_add; ?><br />
        Текст: <?=$c->content; ?>
        </div>
            <br />
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
</div>

</div>
</div>
<style>
    .messages_container {
        min-height: 400px;
    }
</style>