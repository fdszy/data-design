<?php
if (!isset($_SERVER['HTTP_REFERER'])) {
    header("Location:buy_ticket.php");
    exit;
}
?>
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
    <style>
        .panel{
            height:500px;
            width:600px;
        }
        .btn{
            height:40px;
            width: 250px;
        }
    </style>
</head>

<body>
<div id="app">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="./index.php">首页</a></li>
        <li class="breadcrumb-item"><a href="./buy_ticket.php">购票</a></li>
        <li class="breadcrumb-item active">确认购票信息</li>
    </ol>

    <div class="jumbotron">
        <h1 class="text-center">确认订单信息信息</h1>
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
                    <li><a href="./user.php">帐号管理</a></li>
                    <li><a href="./ticket.php">账户信息</a></li>
                    <li class="active"><a href="javascript:void(0)">购票</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="./login.html">欢迎,<?php session_start();echo $_SESSION['user']['name'];?></a></li>
                </ul>
            </div><!-- /.nav-collapse -->
        </div><!-- /.container -->
    </nav><!-- /.navbar -->
    <h5>账户余额：0 </h5>
    <div class = "col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading"> 订单基础信息 </div>
            <div class="panel-body">
                <div class = "col-md-offset-1">
                <form role="form" method="post" action="./process_order.php">
                    <div class="form-group">
                        <input type="hidden" name="option" value="buy">
                        <h4>航班号:<?php echo '<input type="text" name="fNo" value="'.$_GET['fNo'].'" readonly="true">';?></h4>
                        <h4>出发机场:<?php echo $_GET['de'];?></h4>
                        <h4>到达机场:<?php echo $_GET['ar'];?></h4>
                        <h4>出发时间:<?php echo '<input type="text" name="time" value="'.$_GET['de-time'].'" readonly="true">';?></h4>
                        <h4>到达时间:<?php echo $_GET['ar-time'];?></h4>
                        <label for="name">购票人姓名</label>
                        <input type="text" class="form-control" id="name" name="passenger" placeholder="请输入姓名">
                        <br>
                        <label for="name">购票人身份证号</label>
                        <input type="text" class="form-control" id="name" name="passenger_id" placeholder="请输入身份证号">
                        <br>
                        <label class="btn btn-primary">
                            <input type="radio" name="seat" id="option1" value="1"> 经济舱 ￥<?php echo $_GET['price1'];?>
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="seat" id="option2" value="2"> 头等舱 ￥<?php echo $_GET['price2'];?>
                        </label>
                        <br>
                        <div class = "col-md-offset-3">
                        <div class="btn-group btn-group-lg">
                        <button class="btn" type="submit"> 购买
                        </button>
                            </div>
                        </div>

                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>

</div>


</body>

</html>