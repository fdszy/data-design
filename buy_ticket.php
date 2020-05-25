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

<body>
  <div id="app">
    <div class="jumbotron">
        <h1 class="text-center">购票中心</h1>
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
            <li><a href="./user.html">账号管理</a></li>
            <li><a href="./ticket.html">订单信息</a></li>
              <li class="active"><a href="javascript:void(0)">购票</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="./login.html">欢迎,<?php session_start();echo $_SESSION['user']['name'];?></a></li>
          </ul>
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </nav><!-- /.navbar -->
    <h5>账户余额：0 </h5>
      <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
    <div class="panel panel-default">
      <style>
        .form-group {
          height: 200px;
          width: 300px;
      </style>
      <div class="panel-heading"> 机票搜索 </div>
      <div class="panel-body">
        <form role="form" method="post" action="search_ticket.php">
          <div class="form-group">
            <label for="name">出发地</label>
            <select class="form-control" name="departure">
              <option value="0">北京</option>
              <option value="1">上海</option>
            </select>
            <label for="name">到达地</label>
            <select class="form-control" name="arrival">
              <option value="0">北京</option>
              <option value="1">上海</option>
            </select>
            <label for="name">日期</label>
            <div class="form-group">
                <div class="input-group date form_date col-md-12" data-date="" data-date-format="yyyy-MM-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="10" type="text" name="date" value="" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
				<input type="hidden" id="dtp_input2" value="" />
              <label for="name"></label>
              <div class="form-group">
                <button type="submit" class="btn btn-primary form-control">查询</button>
            </div>
            </div>
          </div>
        </form>
      </div>
    </div>
      </div>
    <p><img src="image/ticket_plane.jpg"class = "img-round" width="1000"height="300" class="img-responsive center-block"/> </p>
        <div class="panel panel-default">
      <div class="panel-heading"> 查询结果 </div>
      <div class="panel-body">
          <div class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="table-responsive">
            <table class="table table-bordered ">
            <?php 
            session_start();
            if(isset($_SESSION['result_inv'])){
              echo '<thead class="thead-dark">
                <tr>
                  <th>航班号</th>
                  <th>出发机场</th>
                  <th>到达机场</th>
                  <th>出发时间</th>
                  <th>到达时间</th>
                  <th>头等舱价格</th>
                  <th>经济舱价格</th>
                  <th>订票</th>
                </tr>
              </thead>';
              foreach($_SESSION['result_inv'] as $result){
              echo "<tbody>
                <tr>
                  <th>".$result['flight']."</th>
                  <td>".$result['departure']."</td>
                  <td>".$result['arrival']."</td>
                  <td>".$result['de-time']."</td>
                  <td>".$result['ar-time']."</td>
                  <td>".$result['price1']."</td>
                  <td>".$result['price2']."</td>";
              echo '<td><a class="btn btn-primary" href="#"><i class="fa fa-download fa-fw"></i>购买机票</a></td>
                </tr>
                <tr></tr>
                <tr></tr>
              </tbody>';
                }
              }
            ?>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
      </div>
      </di</div>
  </div>

<script type="text/javascript" src="./jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="./bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="./static/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="./static/js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
	$('.form_date').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
	$('.form_time').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 1,
		minView: 0,
		maxView: 1,
		forceParse: 0
    });
</script>

</body>

</html>