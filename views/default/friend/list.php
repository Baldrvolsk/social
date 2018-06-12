<div class="col-md-10">
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <h4 class="col-md-12">Список друзей</h4>
            </div>
            <div class="row">
                <?php foreach ($friends as $friend): ?>
                <div class="col-md-12">
                    <a class="row" href="/profile/<?=$friend['id']?>">
                        <div class="col-md-2">
                            <img src="<?=@$friend['avatar']?>" width="50" class="img-circle">
                        </div>
                        <div class="col-md-10">
                            <span class="lead"><?=$friend['first_name'].' '.$friend['last_name']?></span>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="row">
                <h4 class="col-md-12">Временное поле списка пользователей</h4>
            </div>
            <div class="row">
                <?php foreach ($users as $user): ?>
                <div class="col-md-12" style="margin:.3em">
                    <div class="row">
                        <a class="col-md-2" href="/profile/<?=$user->id?>" title="Посмотреть профиль">
                            <img src="<?=@$user->avatar?>" width="50" class="img-circle">
                        </a>
                        <a class="col-md-8" href="/profile/<?=$user->id?>" title="Посмотреть профиль">
                            <span class="lead"><?=$user->first_name.' '.$user->last_name?></span>
                        </a>
                        <a href="/friends/add/<?=$user->id?>" class="col-md-2" title="Добавить в друзья">
                            <span class="glyphicon glyphicon-plus"></span>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
