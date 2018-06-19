<div class="col-md-10">
    <div id="albums">
        <h3>Albums</h3>
        <?php foreach($albums as $a) : ?>
            <div class="col-md-4">Тут обложка</div>
            <div class="col-md-8"><a href="/photos/album/<?=$a->id; ?>"><?=$a->name;?></a><br /><?=$a->description; ?></div>
        <?php endforeach; ?>
        <button class="btn btn-info" data-toggle="modal" data-target="#create_album">Create album</button>
    </div>
    <div id="Photos">
        <h3>Photos</h3>
        <div class="row">
        <?php foreach($photos as $p) : ?>
            <div class="col-md-3"><img src="<?=$p->file;?>" style="width:100%"/></div>
        <?php endforeach; ?>
        </div>
    </div>
    <?php if(count($albums) > 0) : ?>
        <button class="btn btn-info"  data-toggle="modal" data-target="#upload">Add photo</button>
    <?php endif; ?>

</div>
</div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="create_album">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/photos/create_album" method="POST">
                <div class="modal-header">
                    <span class="modal-title">Create album</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="name" class="form-control" placeholder="it's me" required/>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="upload">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/photos/add_photo" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <span class="modal-title">Upload photo</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Album</label>
                        <select name="album_id" class="form-control">
                            <?php foreach($albums as $a) : ?>
                                <option value="<?=$a->id;?>"><?=$a->name;?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Photo</label>
                        <input type="file" name="photo" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>