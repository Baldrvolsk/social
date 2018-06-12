        <div class="col-md-10">
            <div class="col-md-5">
                <img class="avatar" src="/uploads/profile/<?=$this->user->id;?>/<?=$this->user->photo;?>" style="width: 100%"/>
            </div>
            <div class="col-md-7">
                <div class="col-md-6"><i class="glyphicon glyphicon-user"></i>V.I.P.</div>
                <div class="col-md-6">Last vizit: <?=gmdate('H:i d.m.Y',$this->user->last_login); ?></div>
                <div class="col-md-12"><?=$this->user->first_name.' '.$this->user->last_name ;?></div>
                <div class="col-md-12">Тут статус</div>
                <div class="col-md-12">Тут еще что-то</div>
            </div>
            <div class="col-md-12">
                <div class="row" style="margin-bottom:50px">
                    <?=$addPostForm?>
                </div>

                <?=$posts?>
            </div>
        </div>

    </div>
</div>