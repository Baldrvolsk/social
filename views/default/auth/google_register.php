<form action="/auth/register" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="InputEmail1">Email(обязательно)</label>
        <input type="email" name="email" value="<?=$google_info['email']; ?>" class="form-control" id="InputEmail1" aria-describedby="emailHelp" placeholder="Ваш email" readonly required>
    </div>
    <div class="form-group">
        <label for="InputLogin">Логин(обязательно)</label>
        <input type="text" name="login" value="<?=$google_info['login'];?>"  readonly class="form-control" id="InputLogin" aria-describedby="loginHelp" placeholder="Ваш логин" required>
    </div>
    <div class="form-group">
        <label for="InputName">Ваше имя(обязательно)</label>
        <input type="text" name="first_name" value="<?=$google_info['given_name']; ?>" class="form-control" id="InputName" aria-describedby="nameHelp" placeholder="Ваше имя" required>
    </div>
    <div class="form-group">
        <label for="InputLogin">Ваша фамилия</label>
        <input type="text" name="last_name" value="<?=$google_info['family_name']; ?>" class="form-control" id="InputLastName" aria-describedby="lastNameHelp" placeholder="Ваша фамилия">
    </div>
    <div class="form-group">
        <label for="exampleFormControlFile1">Ваше фото</label>
        <input type="hidden" name="google_photo" value="<?=$google_info['picture']; ?>" />
        <img src="<?=$google_info['picture'];?>" width="300"/>
    </div>
    <div class="form-group" style="display:none;">
        <label for="InputPassword1">Пароль</label>
        <input type="hidden" name="password" value="123456" class="form-control" id="InputPassword1" placeholder="Пароль" required>
    </div>
    <div class="form-group" style="display:none;">
        <label for="InputPassword1">Подтверждение пароля</label>
        <input type="hidden" name="password_confirm" value="123456" class="form-control" id="InputPassword2" placeholder="Подтверждение пароля" required>
    </div>
    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
</form>
<style>
    .error {
        color:red;
    }
</style>