<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content-box">
    <form class="form form-inline" action="/auth/register" method="POST" enctype="multipart/form-data">
        <label class="form-label" for="inputEmail">Email</label>
        <div class="form-group">
            <input type="email" name="email" id="inputEmail"  class="form-control"
                   value="<?=$google_info['email']?>" placeholder="Ваш email" readonly required
            />
        </div>
        <label class="form-label" for="inputLogin">Логин</label>
        <div class="form-group">
            <input type="text" name="login" id="inputLogin" class="form-control"
                   value="<?=$google_info['login']?>" minlength="3" maxlength="100"
                   placeholder="Ваш логин" required
            />
        </div>
        <label class="form-label" for="inputFName">Ваше имя</label>
        <div class="form-group">
            <input type="text" name="first_name" id="inputName" class="form-control"
                   value="<?=$google_info['given_name']?>" minlength="2" maxlength="50"
                   placeholder="Ваше имя" required
            />
        </div>
        <label class="form-label" for="inputLName">Ваша фамилия</label>
        <div class="form-group">
            <input type="text" name="last_name" id="inputLName" class="form-control"
                   value="<?=$google_info['family_name']?>" minlength="2" maxlength="50"
                   placeholder="Ваша фамилия"
            />
        </div>
        <label class="form-label" for="avatar">Ваше фото</label>
        <div class="form-group">
            <img src="<?=$google_info['picture'];?>" class="img-circle" width="50" />
            <input type="hidden" name="google_photo" value="<?=$google_info['picture']; ?>" />
        </div>
        <label class="form-label" for="inputGender">Пол</label>
        <div class="form-group">
            <select name="gender" id="gender" class="chosen-select form-control" data-placeholder="Выберите пол"
                    >
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
        <label class="form-label" for="inputCountry">Страна</label>
        <div class="form-group">
            <input type="text" name="country" value="<?= $google_info['locale']; ?>" class="form-control"
                   id="inputCountry" placeholder="" required>
        </div>
        <div class="form-wide form-right">
            <button type="submit" class="btn btn-success">Зарегистрироваться</button>
        </div>
    </form>
</div>