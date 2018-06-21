<div class="col-md-10">
    <div id="Photos">
        <h3>Photos</h3>
        <div class="row">
            <?php foreach($photos as $p) : ?>
                <div class="col-md-3"><img src="<?=$p->file;?>" style="width:100%"/><span><?=$p->description;?></span></div>
            <?php endforeach; ?>
        </div>
    </div>

</div>
</div>
</div>
