<form action="/profile/edit" method="POST">
    <div class="form-group">
        <label for="InputEmail1">Email(обязательно)</label>
        <input type="email" name="email" value="<?=$user->email; ?>" class="form-control" id="InputEmail1" aria-describedby="emailHelp" placeholder="Ваш email" readonly required>
    </div>
    <div class="form-group">
        <label for="InputLogin">Логин(обязательно)</label>
        <input type="text" name="login" value="<?=$user->username;?>"  readonly class="form-control" id="InputLogin" aria-describedby="loginHelp" placeholder="Ваш логин" required>
    </div>
    <div class="form-group">
        <label for="InputName">Ваше имя(обязательно)</label>
        <input type="text" name="first_name" value="<?=$user->first_name; ?>" class="form-control" id="InputName" aria-describedby="nameHelp" placeholder="Ваше имя" required>
        <?php if(form_error('first_name')) {echo form_error('first_name','<span class="error">','</span>');} ?>
    </div>
    <div class="form-group">
        <label for="InputLogin">Ваша фамилия</label>
        <input type="text" name="last_name" value="<?=$user->last_name; ?>" class="form-control" id="InputLastName" aria-describedby="lastNameHelp" placeholder="Ваша фамилия">
    </div>
    <button type="submit" class="btn btn-primary">Сохранить</button>
</form>

<style>
    .error {
        color:red;
    }
</style>