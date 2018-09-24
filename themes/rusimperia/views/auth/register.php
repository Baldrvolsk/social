<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content-box">
    <form class="form form-inline" name="registration" action="/auth/register" method="POST"
          enctype="multipart/form-data">
        <label class="form-label" for="inputEmail">Email</label>
        <div class="form-group">
            <input type="email" name="email" id="inputEmail"  class="form-control"
                   value="<?=$google_info['email']?>" placeholder="Ваш email" readonly required
            />
            <span class="text-danger" id="email_err" ></span>
        </div>
        <label class="form-label" for="inputLogin">Логин</label>
        <div class="form-group">
            <input type="text" name="login" id="inputLogin" class="form-control"
                   value="<?=$google_info['login']?>" minlength="3" maxlength="100"
                   placeholder="Ваш логин" required
            />
            <span class="text-danger" id="login_err" ></span>
        </div>
        <label class="form-label" for="inputFName">Ваше имя</label>
        <div class="form-group">
            <input type="text" name="first_name" id="inputFName" class="form-control"
                   value="<?=$google_info['given_name']?>" minlength="2" maxlength="50"
                   placeholder="Ваше имя" required
            />
            <span class="text-danger" id="f_name_err" ></span>
        </div>
        <label class="form-label" for="inputLName">Ваша фамилия</label>
        <div class="form-group">
            <input type="text" name="last_name" id="inputLName" class="form-control"
                   value="<?=$google_info['family_name']?>" minlength="2" maxlength="50"
                   placeholder="Ваша фамилия"
            />
            <span class="text-danger" id="l_name_err" ></span>
        </div>
        <label class="form-label" for="avatar">Ваше фото</label>
        <div class="form-group">
            <img src="<?=$google_info['picture'];?>" class="img-circle" width="50" />
            <span class="help fas fa-info tooltip"></span>
            <input type="hidden" name="google_photo" id="avatar" value="<?=$google_info['picture']; ?>" />
            <span class="text-danger" id="photo_err" ></span>
        </div>
        <label class="form-label" for="inputGender">Пол</label>
        <div class="form-group">
            <select name="gender" id="gender" class="chosen-select form-control" data-placeholder="Выберите пол"
                    >
                <option value="ns" <?php
                echo  set_select('gender', 'ns', ($google_info['gender'] === 'ns')?true:false);
                ?>>Не указан</option>
                <option value="male" <?php
                echo  set_select('gender', 'male', ($google_info['gender'] === 'male')?true:false);
                ?>>М</option>
                <option value="female" <?php
                echo  set_select('gender', 'female', ($google_info['gender'] === 'female')?true:false);
                ?>>Ж</option>
            </select>
            <span class="text-danger" id="gender_err" ></span>
        </div>
        <label class="form-label" for="inputCountry" style="display: none">Страна</label>
        <div class="form-group" style="display: none">
            <input type="text" name="country" value="2017370" class="form-control"
                   id="inputCountry" placeholder="" required>
            <span class="text-danger" id="country_err" ></span>
        </div>
        <div></div>
        <div class="form-group">
            <input type="checkbox" name="rules" id="rules" class="checkbox-input" required />
            <label for="rules" class="checkbox-label">
                <span class="far checkbox-icon"></span>
                Согласен с <a href="/rules" title="Правила проекта" target="_blank">правилами</a>
            </label>
            <span class="text-danger" id="rules_err" ></span>
        </div>
        <div class="form-wide form-right">
            <div id="status" class="text-center" ></div>
            <button type="button" class="btn btn-success" onclick="regUser(this);">
                Зарегистрироваться
            </button>
        </div>
    </form>
</div>