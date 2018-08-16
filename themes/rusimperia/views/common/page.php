<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content-box">
    <form class="form-inline" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="InputEmail1">Email(обязательно)</label>
            <input type="email" name="email" value="<?=$google_info['email']; ?>"
                   class="form-control" id="InputEmail1" aria-describedby="emailHelp"
                   placeholder="Ваш email" readonly required />
        </div>
        <div class="form-group">
            <label for="InputLogin">Логин(обязательно)</label>
            <input type="text" name="login" value="<?=$google_info['login'];?>"
                   class="form-control" id="InputLogin" aria-describedby="loginHelp"
                   placeholder="Ваш логин" required />
        </div>
        <div class="form-group">
            <label for="InputName">Ваше имя(обязательно)</label>
            <input type="text" name="first_name" value="<?=$google_info['given_name']; ?>"
                   class="form-control" id="InputName" aria-describedby="nameHelp"
                   placeholder="Ваше имя" required>
        </div>
        <div class="form-group">
            <label for="InputLogin">Ваша фамилия</label>
            <input type="text" name="last_name" value="<?=$google_info['family_name']; ?>"
                   class="form-control" id="InputLastName" aria-describedby="lastNameHelp"
                   placeholder="Ваша фамилия">
        </div>
        <div class="form-group">
            <label for="exampleFormControlFile1">Ваше фото</label>
            <input type="hidden" name="google_photo" value="<?=$google_info['picture']; ?>" />
            <img src="<?=$google_info['picture'];?>" width="100"/>
        </div>
        <div class="form-group">
            <label for="Inputgender">Пол</label>
            <select id="gender" name="gender" class="form-control" required>
                <option value="null" <?php
                echo  set_select('gender', 'null', ($google_info['gender'] === 'null')?true:false);
                ?>>Не указан</option>
                <option value="male" <?php
                echo  set_select('gender', 'male', ($google_info['gender'] === 'male')?true:false);
                ?>>М</option>
                <option value="female" <?php
                echo  set_select('gender', 'female', ($google_info['gender'] === 'female')?true:false);
                ?>>Ж</option>
            </select>
        </div>
        <div class="form-group" style="display:none;">
            <label for="InputPassword1">Страна</label>
            <input type="hidden" name="country" value="<?= $google_info['locale']; ?>" class="form-control" id="Inputcountry" placeholder="" required>
        </div>
        <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
    </form>
</div>