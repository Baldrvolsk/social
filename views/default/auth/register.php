<form action="/auth/register" method="POST">
    <div class="form-group">
        <label for="InputEmail1">Email(обязательно)</label>
        <input type="email" name="email" value="<?php echo set_value('email'); ?>" class="form-control" id="InputEmail1" aria-describedby="emailHelp" placeholder="Ваш email" required>
        <?php if(form_error('email')) {echo form_error('email','<span class="error">','</span>');} ?>
    </div>
    <div class="form-group">
        <label for="InputLogin">Логин(обязательно)</label>
        <input type="text" name="login" value="<?php echo set_value('login'); ?>" class="form-control" id="InputLogin" aria-describedby="loginHelp" placeholder="Ваш логин" required>
        <?php if(form_error('login')) {echo form_error('login','<span class="error">','</span>');} ?>
    </div>
    <div class="form-group">
        <label for="InputName">Ваше имя(обязательно)</label>
        <input type="text" name="first_name" value="<?php echo set_value('first_name'); ?>" class="form-control" id="InputName" aria-describedby="nameHelp" placeholder="Ваше имя" required>
        <?php if(form_error('first_name')) {echo form_error('first_name','<span class="error">','</span>');} ?>
    </div>
    <div class="form-group">
        <label for="InputLogin">Ваша фамилия</label>
        <input type="text" name="last_name" value="<?php echo set_value('last_name'); ?>" class="form-control" id="InputLastName" aria-describedby="lastNameHelp" placeholder="Ваша фамилия">
        <?php if(form_error('last_name')) {echo form_error('last_name','<span class="error">','</span>');} ?>
    </div>
    <div class="form-group">
        <label for="InputPassword1">Пароль</label>
        <input type="password" name="password" value="<?php echo set_value('password'); ?>" class="form-control" id="InputPassword1" placeholder="Пароль" required>
        <?php if(form_error('password')) {echo form_error('password','<span class="error">','</span>');} ?>
    </div>
    <div class="form-group">
        <label for="InputPassword1">Подтверждение пароля</label>
        <input type="password" name="password_confirm" value="<?php echo set_value('password_confirm'); ?>" class="form-control" id="InputPassword2" placeholder="Подтверждение пароля" required>
        <?php if(form_error('password_confirm')) {echo form_error('password_confirm','<span class="error">','</span>');} ?>
    </div>
    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
</form>
<style>
    .error {
        color:red;
    }
</style>