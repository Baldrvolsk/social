            <div class="col-md-5">
                <div class="box-crew">
                <a href="<?=$userdata->company;?>" class="gallery" rel="avatar_gal">
                    <img class="avatar" src="<?=$userdata->company;?>" style="width: 100%"/>
                    <?php if($userdata->id == $this->user->id) : ?>

                        <a href="#" data-toggle="modal" data-target="#upload_modal"><span>- Загрузить новую</span></a>
                    <?php endif; ?>

                </a>
                </div>
                <?php foreach($userdata->avatars as $a) : ?>
                <a href="<?=$a->file;?>" class="gallery" rel="avatar_gal"></a>
                <?php endforeach; ?>

                <?php if($userdata->id != $this->user->id) : ?>
                    <button class="btn btn-info send_message"  data-toggle="modal" data-target="#exampleModal" style="width: 100%">Отправить сообщение</button>
                <?php endif;?>
            </div>
            <div class="col-md-7">
                <div class="col-md-6"><i class="glyphicon glyphicon-user"></i>V.I.P.</div>
                <div class="col-md-6">
                    <?php if($userdata->id == $this->user->id) : ?>
                    <a href="/profile/edit">Редактировать профиль</a><br />
                    <?php endif;?>
                    Last vizit: <?=gmdate('H:i d.m.Y',$userdata->last_login); ?>
                </div>
                <div class="col-md-12"><?=$userdata->first_name.' '.$userdata->last_name ;?></div>
                <div class="col-md-12">Тут статус</div>
                <div class="col-md-12">Тут еще что-то</div>

            </div>
            <div class="col-md-12 thumb-container">
                <?php if(count($userdata->photos) != 0): ?>

                    <?php foreach($userdata->photos as $p) : ?>
                        <div class="col-md-2 thumb">
                            <a href="<?=$p->file;?>" class="gallery_profie" rel="profile_gal"><img src="<?=$p->file;?>" style="width:100%" /></a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="col-md-12">
                <div class="row" style="margin-bottom:50px">
                    <?=$addPostForm?>
                </div>
                <?=$posts?>
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
<div class="modal" tabindex="-1" role="dialog" id="upload_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Загрузка нового аватара</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/photos/add_avatar" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group" id="preview_avatar"></div>
                    <div class="form-group">
                        <label>Выберите аватар:</label>
                        <input type="file" name="photo" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Подпись:</label>
                        <textarea name="description" class="form-control"></textarea>
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
            <link href="/css/colorbox.css" rel="stylesheet">
            <script type="text/javascript" src="/js/jquery.colorbox-min.js"></script>
            <script type="text/javascript" src="/js/profile.js"></script>
            <style>
                .box-crew{
                    position:relative;
                    overflow:hidden;
                }

                .box-crew span{
                    background-color:rgba(0, 0, 0, 0.4);
                    bottom:-120px;
                    transition-duration:0.6s;
                    padding:52px 0;
                    position:absolute;
                    text-align:center;
                    color:#fff;
                    font-size:12px;
                    font-weight:bold;
                    line-height:16px;
                    margin:0;
                    display:block;
                    width:100%;
                }

                div.box-crew:hover span{
                    bottom:0px;
                }
                .thumb {
                    overflow:hidden;
                    height:120px;

                }
                .thumb img {
                    border-radius: 20px;
                }
                .thumb-container {
                    margin-top:20px;
                    margin-bottom:20px;

                }
                .avatar {
                    border-radius: 20px;
                }
            </style>