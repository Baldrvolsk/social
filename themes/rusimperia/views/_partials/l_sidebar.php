<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php if ($this->ion_auth->logged_in()) : ?>
    <div class="content-box">
        <ul class="">
            <li role="presentation"><a href="/friends">Contacts +2</a></li>
            <li role="presentation"><a href="/chat">Messages +15</a></li>
            <li role="presentation"><a href="/photos">Photos</a></li>
            <li role="presentation"><a href="#">News +257</a></li>
            <li role="presentation"><a href="/my_groups">My groups +3</a></li>
            <li role="presentation"><a href="#">&Delta; +16</a></li>
            <li role="presentation">Leptas: 10.000</li>
        </ul>
        <ul class="">
            <li><a href="/gpoup/#1">Группа #1</a></li>
            <li><a href="/gpoup/#2">Группа #2</a></li>
            <li><a href="/gpoup/#3">Группа #3</a></li>
            <li><a href="/gpoup/#4">Группа #4</a></li>
            <li><a href="/gpoup/#5">Группа #5</a></li>
        </ul>
        <ul class="">
            <li><a href="/event/#1">Встреча #1<br>26 июня в 18:00</a></li>
            <li><a href="/gpoup/#2">Встреча #2<br>26 июня в 18:00</a></li>
            <li><a href="/gpoup/#3">Встреча #3<br>26 июня в 18:00</a></li>
        </ul>
    </div>
<?php endif; ?>
<div class="advertising"><?=img_alt(170, 200, "advertising")?></div>
<div class="advertising"><?=img_alt(170, 200, "advertising")?></div>
<div class="advertising"><?=img_alt(170, 200, "advertising")?></div>