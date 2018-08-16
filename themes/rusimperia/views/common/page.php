<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content-box">
    <h1 class="page-title"><?=$h?></h1>
    <div class="page-content"><?=$content?></div>
</div>
<div class="social">
    <span><?=$this->lang->line('site_social_text')?></span>
    <?php foreach ($this->config->item('site_social') as $row) : ?>
    <a href="<?=$row['link']?>" title="<?=$this->lang->line('site_social_title_'.$row['name'])?>" target="_blank">
        <i class="fab <?=$row['faIcon']?> fa-3x"></i>
    </a>
    <?php endforeach; ?>
</div>