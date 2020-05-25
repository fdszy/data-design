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
      <h1 class="text-center">订单信息</h1>
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
            <li class="active"><a href="javascript:void(0)">订单信息</a></li>
            <li><a href="./buy_ticket.php">购票</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="./login.html">欢迎,
                <?php session_start();echo $_SESSION['user']['name'];?></a></li>
          </ul>
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </nav><!-- /.navbar -->
    <h5>账户余额：0 </h5>
  </div>
  <div class="py-3 text-center">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <h1>温馨提示</h1>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-4 p-4"> <i class="d-block fa fa-circle fa-3x mb-2 text-muted"></i>
          <h4><b>关于退票</b></h4>
          <p>已购买的机票出发前24小时前可以全额退款，<br>出发前24小时内不再允许退款</p>
        </div>
        <div class="col-md-4 col-6 p-4"> <i class="d-block fa fa-stop-circle-o fa-3x mb-2 text-muted"></i>
          <h4> <b>关于登机</b></h4>
          <p>请您在出发时间一小时前办理完登机手续<br>并在起飞前十五分钟前登机</p>
        </div>
        <div class="col-md-4 col-6 p-4"> <i class="d-block fa fa-circle-o fa-3x mb-2 text-muted"></i>
          <h4> <b>关于安全</b></h4>
          <p>请有序配合机场的安保工作<br>并有序登机</p>
        </div>
      </div>
    </div>
  </div>
  <div class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-12"></div>
      </div>
    </div>
  </div>
  <div class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1 class="text-center">&nbsp;下面是您的订单信息</h1>
        </div>
      </div>
    </div>
  </div>
  <div class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="table-responsive">
            <table class="table table-striped table-borderless">
              <thead>
                <tr>
                  <th scope="col">出发机场</th>
                  <th scope="col">出发地点</th>
                  <th scope="col">到达机场</th>
                  <th scope="col">到达地点</th>
                  <th scope="col">出发时间</th>
                  <th scope="col">到达时间</th>
                  <th scope="col">票价</th>
                  <th scope="col">座位号</th>
                  <th scope="col">操作</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">null</th>
                  <td>null</td>
                  <td>null</td>
                  <td>null</td>
                  <td>null</td>
                  <td>null</td>
                  <td>null</td>
                  <td>null</td><a class="btn btn-primary" href="./process_order.php?option=cancel&fNo=">退票</a>
                  <td><br></td>
                </tr>
                <tr></tr>
                <tr></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>