<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if(count($chats) > 0) : ?>
    <table class="table table-hover">
        <thead>
        <th>От</th>
        <th>Кому</th>
        <th>Дата</th>
        </thead>
        <tbody>
        <?php foreach($chats as $c): ?>
            <tr style="cursor:pointer;" onclick="location.href = '/chat/index/<?=$c->id;?>'">
                <td><?=$c->from_user;?></td>
                <td><?=$c->to_user;?></td>
                <td><?=$c->date_create;?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <h1>У Вас нет начатых чатов</h1>
<?php endif; ?>
