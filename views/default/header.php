<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Выше 3 Мета-теги ** должны прийти в первую очередь в голове; любой другой руководитель контент *после* эти теги -->
    <title></title>

    <!-- Bootstrap -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">

    <!-- на jQuery (необходим для Bootstrap - х JavaScript плагины) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- HTML5 Shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- Предупреждение: Respond.js не работает при просмотре страницы через файл:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script >
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<?php if ($this->ion_auth->logged_in()) : ?>
<div class="container-fluid main_logo"></div>

<div class="container">
<nav class="navbar navbar-default">

        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Brand</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="/profile">Main</a></li>
                <li class=""><a href="/people">People</a></li>
                <li class=""><a href="/groups">Groups</a></li>

            </ul>
            <form class="navbar-form navbar-left">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">About us</a></li>
                <li><a href="#">For investors</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Contact us <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                    </ul>
                </li>
                <li><a href="/auth/logout">Logout</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->

</nav>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-2">
            <ul class="nav nav-pills nav-stacked">
                <li role="presentation"><a href="/friends">Contacts +2</a></li>
                <li role="presentation"><a href="/chat">Messages +15</a></li>
                <li role="presentation"><a href="/photos">Photos</a></li>
                <li role="presentation"><a href="#">News +257</a></li>
                <li role="presentation"><a href="/my_groups">My groups +3</a></li>
                <li role="presentation"><a href="#">D +16</a></li>
                <li role="presentation">Leptas: 10.000</li>
            </ul>
        </div>
        <div class="col-md-8">
<?php else: ?>
            <div class="main_logo_big">
                <img src="/img/main_logo_big.png" />
            </div>

            <div class="container">

            <nav class="navbar">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="main_menu">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Правила</a></li>
                <li><a href="#">Для инвесторов</a></li>
                <li><a href="/auth/login">Войти</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
</nav>
            </div><!-- /.container -->

            <div class="container">
            <div class="row">
                <div class="col-md-12">
<?php endif; ?>
