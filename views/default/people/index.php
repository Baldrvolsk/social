<div class="col-md-10">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#all_people" data-toggle="tab">All people</a></li>
        <li><a href="#people_online" data-toggle="tab">People online</a></li>
    </ul>
    <!-- Search -->
    <div class="row">
        <div class="col-md-12">
            <div class="input-group">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                </span>
                <input type="text" class="form-control">
            </div><!-- /input-group -->
        </div>
    </div>
    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active" id="all_people">
            <div class="row">
                <?php foreach ($people as $row): ?>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="<?=$row->photo?>" width="50" class="center-block img-circle">
                            </div>
                            <div class="col-md-10">
                                <p>
                                    <a href="/profile/<?=$row->id?>" title="Посмотреть профиль">
                                        <?= $row->full_name_user ?>
                                    </a>
                                </p>
                                <p>Ранг</p>
                                <p>
                                    <a href="/friends/add/<?=$row->id?>" class="btn btn-info">
                                        Добавить в друзья
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="tab-pane" id="people_online">
            <div class="row">
                <?php foreach ($on_people as $row): ?>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="<?=$row->photo?>" width="50" class="center-block img-circle">
                            </div>
                            <div class="col-md-10">
                                <p>
                                    <a href="/profile/<?=$row->id?>" title="Посмотреть профиль">
                                        <?= $row->full_name_user ?>
                                    </a>
                                </p>
                                <p>Ранг</p>
                                <p>
                                    <a href="/friends/add/<?=$row->id?>" class="btn btn-info">
                                        Добавить в друзья
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
</div>
