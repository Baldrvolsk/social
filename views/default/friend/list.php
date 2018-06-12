<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <h4 class="col-md-12">Список друзей</h4>
            </div>
            <?php foreach ($friends as $friend): ?>
                <a class="row" href="/profile/<?=$friend['id']?>">
                    <div class="col-md-2">
                        <img src="<?=@$friend['avatar']?>" width="50" class="img-circle">
                    </div>
                    <div class="col-md-10">
                        <span class="lead"><?=$friend['first_name'].' '.$friend['last_name']?></span>
                    </div>
                </>
            <?php endforeach; ?>
        </div>
        <div class="col-md-4">
            <div class="row">
                <h4 class="col-md-12">Временное поле списка пользователей</h4>
            </div>
            <?php foreach ($users as $user): ?>
            <a class="row" href="/profile/<?=$user->id?>">
                <div class="col-md-2">
                    <img src="<?=@$user->avatar?>" width="50" class="img-circle">
                </div>
                <div class="col-md-10">
                    <span class="lead"><?=$user->first_name.' '.$user->last_name?></span>
                </div>
            </>
            <?php endforeach; ?>
        </div>
    </div>
</div>
