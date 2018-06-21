        <div class="col-md-10">
            <div class="col-md-5">
                <img class="avatar" src="<?=$userdata->company;?>" style="width: 100%"/>
                <?php if($userdata->id != $this->user->id) : ?>
                    <button class="btn btn-info send_message"  data-toggle="modal" data-target="#exampleModal" style="width: 100%">Отправить сообщение</button>
                <?php endif;?>
            </div>
            <div class="col-md-7">
                <div class="col-md-6"><i class="glyphicon glyphicon-user"></i>V.I.P.</div>
                <?php if($userdata->id == $this->user->id) : ?>
                    <div class="col-md-6"><a href="/profile/edit">Редактировать профиль</a>
                <?php endif;?>
                <br />Last vizit: <?=gmdate('H:i d.m.Y',$userdata->last_login); ?></div>
                <div class="col-md-12"><?=$userdata->first_name.' '.$userdata->last_name ;?></div>
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
<div class="modal" tabindex="-1" role="dialog" id="exampleModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Отправка сообщения пользователю <?=$this->user->first_name.' '.$this->user->last_name ;?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/chat/send" method="post">
                <input type="hidden" name="user_id" value="<?=$userdata->id; ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Текст сообщения:</label>
                        <textarea name="content" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Отправить</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- модалка для постов -->

<div class="modal fade" id="postModal" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content"></div>
    </div>
</div>