<div id="Photos">
    <h3>Photos</h3>
    <div class="row">
        <?php foreach($photos as $p) : ?>
            <div class="col-md-3">
                <a href="<?=$p->file;?>" class="gal" rel="gal"> <img src="<?=$p->file;?>" style="width:100%"/></a>
                <span><?=$p->description;?></span></div>
        <?php endforeach; ?>
    </div>
</div>
<link href="/css/colorbox.css" rel="stylesheet">
<script type="text/javascript" src="/js/jquery.colorbox-min.js"></script>
<script type="text/javascript" src="/js/photos.js"></script>