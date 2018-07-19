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
            <div class="col-md-7 content_box info_box">
                <div class="col-md-6"><i class="glyphicon glyphicon-king"></i>V.I.P.
                </div>


                <div class="col-md-6">
                   Был(а): <?=gmdate('H:i d.m.Y',$userdata->last_login); ?>
                </div>
                <div class="col-md-12"> <i class="glyphicon glyphicon-user"></i><?=$userdata->first_name.' '.$userdata->last_name ;?></div>

                <div class="col-md-12">
                    <?php //Если страничка юзера то он может менять статус?>
                    <?php if($userdata->id == $this->user->id) : ?>
                        <?php if($userdata->text_status == '') : //если статус пустой, то выводить Изменить статус  ?>
                            <span class="status_string">Изменить статус</span>
                        <?php else : ?>
                            <span class="status_string"><?=$userdata->text_status; //Иначе статус?></span>
                        <?php endif; ?>
                    <?php else : ?>
                        <span class="status_string_disabled"><?=$userdata->text_status; ?></span>
                    <?php endif; ?>
                </div>
                <div class="col-md-12">Страна: <?=$userdata->country;?></div>

            </div>
            <div class="col-md-12 thumb-container content_box">
                <?php if(count($userdata->photos) != 0): ?>
                <div class="col-md-2" style="text-align:center;">Мои фотографии <?=count($userdata->photos);?></div>
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
                    <div class="form-group" id="preview_avatar">
                        <img id="image" />
                    </div>
                    <div class="docs-buttons" style="display:none;">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="">
                                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="$().cropper(&quot;rotate&quot;, -45)">
                                    <span class="fa fa-rotate-left">Повернуть влево</span>
                                </span>
                            </button>
                            <button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right">
                                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="$().cropper(&quot;rotate&quot;, 45)">
                                    <span class="fa fa-rotate-right">Повернуть вправо</span>
                                </span>
                            </button>
                            <!--Увеличить/уменьшить-->
                            <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
                                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="$().cropper(&quot;zoom&quot;, 0.1)">
                                  <span class="glyphicon glyphicon-zoom-in"></span>
                                </span>
                            </button>
                            <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
                                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="$().cropper(&quot;zoom&quot;, -0.1)">
                                  <span class="glyphicon glyphicon-zoom-out"></span>
                                </span>
                            </button>
                            <!--Отразить горизонталь/вертикаль -->
                            <button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1" title="Flip Horizontal">
                                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="$().cropper(&quot;scaleX&quot;, -1)">
                                    <span class="glyphicon glyphicon-resize-horizontal"></span>
                                </span>
                            </button>
                            <button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1" title="Flip Vertical">
                                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="$().cropper(&quot;scaleY&quot;, -1)">
                                    <span class="glyphicon glyphicon-resize-vertical"></span>
                                </span>
                            </button>

                        </div>
                    </div>

                    <div class="form-group">
                        <label>Выберите аватар:</label>
                        <input type="file" name="photo" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Подпись:</label>
                        <textarea name="description" class="form-control"></textarea>
                        <input type="hidden" name="dataX" id="dataX" />
                        <input type="hidden" name="dataY" id="dataY" />
                        <input type="hidden" name="dataHeight" id="dataHeight" />
                        <input type="hidden" name="dataWidth" id="dataWidth" />
                        <input type="hidden" name="dataRotate" id="dataRotate" />
                        <input type="hidden" name="dataScaleX" id="dataScaleX" />
                        <input type="hidden" name="dataScaleY" id="dataScaleY" />
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
            <!--<script src="/js/socket.js"></script> -->