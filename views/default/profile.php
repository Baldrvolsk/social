<nav class="navbar navbar-default">
    <div class="container-fluid">
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
                <li class=""><a href="/friends">Friends</a></li>
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
    </div><!-- /.container-fluid -->
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-2">
            <ul class="nav nav-pills nav-stacked">
                <li role="presentation"><a href="#">Contacts +2</a></li>
                <li role="presentation"><a href="#">Messages +15</a></li>
                <li role="presentation"><a href="#">News +257</a></li>
                <li role="presentation"><a href="#">My groups +3</a></li>
                <li role="presentation"><a href="#">D +16</a></li>
                <li role="presentation">Leptas: 10.000</li>
            </ul>
        </div>
        <div class="col-md-10">
            <div class="col-md-5">
                <img class="avatar" src="https://media.forgecdn.net/avatars/124/768/636424778749237239.jpeg" style="width: 100%"/>
            </div>
            <div class="col-md-7">
                <div class="col-md-6"><i class="glyphicon glyphicon-user"></i>V.I.P.</div>
                <div class="col-md-6">Last vizit: <?=gmdate('H:i d.m.Y',$this->user->last_login); ?></div>
                <div class="col-md-12"><?=$this->user->first_name.' '.$this->user->last_name ;?></div>
                <div class="col-md-12">Тут статус</div>
                <div class="col-md-12">Тут еще что-то</div>
            </div>
            <div class="col-md-12">
                Тут лента
            </div>
        </div>

    </div>
</div>