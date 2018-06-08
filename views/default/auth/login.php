<h1>Авторизация</h1>

<div id="infoMessage"><?php echo $message;?></div>

<form action="/auth/login" method="POST">

  <p>
    <label>Ваш email</label>
    <?php echo form_input($identity);?>
  </p>

  <p>
      <label>Ваш пароль</label>
    <?php echo form_input($password);?>
  </p>

  <p>
    <label>Запомнить меня</label>
    <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
  </p>


  <p><?php echo form_submit('submit', 'Войти');?></p>

</form>

<p><a href="forgot_password">Забыли пароль?</a></p>