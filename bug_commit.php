
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>航空机票管理系统</title>
    <!-- Bootstrap -->
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="./static/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    <link href="./static/css/bootstrap.min.css" rel="stylesheet">
    <!-- Css -->
    <link rel="stylesheet" href="./static/css/offcanvas.css">
    <link rel="stylesheet" href="./static/css/bootstrap-datetimepicker.min.css">
    <script src="./static/js/jquery.min.js"></script>

    <!--[if lt IE 9]>
    <script src="./static/js/html5shiv.js"></script>
    <script src="./static/js/respond.min.js"></script>
  <style> body {
            font-family: "Microsoft YaHei UI", "Droid Sans Mono", serif;
        }
    </style>
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body >
<div id="app">
    <div class="jumbotron">
        <h1 class="text-center">bug提交</h1>
    </div>
    <nav class="navbar navbar-fixed-top navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">航空机票管理系统</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="./index.php">首页</a></li>
                    <li><a href="./user.php">账号管理</a></li>
                    <li><a href="./ticket.php">订单信息</a></li>
                    <li><a href="./buy_ticket.php">购票</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="./login.html">欢迎,
                        <?php session_start();echo $_SESSION['user'];?></a></li>
                </ul>
            </div><!-- /.nav-collapse -->
        </div><!-- /.container -->
    </nav><!-- /.navbar -->
</div>
<div class="py-3 text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>提交bug</h1>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4 p-4"> <i class="d-block fa fa-circle fa-3x mb-2 text-muted"></i>
                <h4><b>关于奖励</b></h4>
                <p>任何提交bug的成员账号都会被设置为信用满级</p>
            </div>
            <div class="col-md-4 col-6 p-4"> <i class="d-block fa fa-stop-circle-o fa-3x mb-2 text-muted"></i>
                <h4> <b>关于描述</b></h4>
                <p>请详细描述bug的位置和您的执行情况</p>
            </div>
            <div class="col-md-4 col-6 p-4"> <i class="d-block fa fa-circle-o fa-3x mb-2 text-muted"></i>
                <h4> <b>关于道歉</b></h4>
                <p>我们在此对任何可能出现的Bug表示抱歉</p>
            </div>
        </div>
    </div>
</div>
<div>
    <form action="pro_bug.php" method="post">
    <form role="form">
        <div class="form-group" style ="margin-left:20%;width: 60%">
            <label for="name">bug描述</label>
            <textarea class="form-control" rows="8" id="bug" name="bug"></textarea>
        </div>
    </form>
    <button type="button" class="btn btn-primary" style="width: 20% ;margin-left: 40%">提交</button>
    </form>
</div>
</body>

</html>