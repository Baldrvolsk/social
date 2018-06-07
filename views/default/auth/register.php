<form>
    <div class="form-group">
        <label for="InputEmail1">Email(обязательно)</label>
        <input type="email" name="email" class="form-control" id="InputEmail1" aria-describedby="emailHelp" placeholder="Ваш email" required>
        <small id="emailHelp" class="form-text text-muted">Только почта на gmail</small>
    </div>
    <div class="form-group">
        <label for="InputLogin">Логин(обязательно)</label>
        <input type="text" name="login" class="form-control" id="InputLogin" aria-describedby="loginHelp" placeholder="Ваш логин" required>
    </div>
    <div class="form-group">
        <label for="InputLogin">Ваше имя(обязательно)</label>
        <input type="text" name="login" class="form-control" id="InputLogin" aria-describedby="loginHelp" placeholder="Ваше имя" required>
    </div>
    <div class="form-group">
        <label for="InputPassword1">Пароль</label>
        <input type="password" name="password" class="form-control" id="InputPassword1" placeholder="Пароль" required>
    </div>
    <div class="form-group">
        <label for="InputPassword1">Подтверждение пароля</label>
        <input type="password" name="password_confirm" class="form-control" id="InputPassword2" placeholder="Подтверждение пароля" required>
    </div>
    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
</form>