<div class="col-md-10">


    <?php if(count($chat) > 0) : ?>
            <?php foreach($chat as $c): ?>
        От: <?=$c->first_name.' '.$c->last_name; ?> <?=$c->date_add; ?><br />
        Текст: <?=$c->content; ?>
            <br />
            <br />
            <?php endforeach; ?>
    <?php else : ?>
        <h1>У Вас нет начатых чатов</h1>
    <?php endif; ?>
    <form action="/chat/send" method="POST">
        <input type="hidden" name="chat_id" value="<?=$chat_id; ?>" />
        <textarea class="form-control" placeholder="Ваше сообщение" name="content"></textarea>
        <button type="submit" class="btn btn-success">Отправить</button>
    </form>
</div>

</div>
</div>