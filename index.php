<?php 
session_start(); 
if(!isset($_SESSION['user'])){
    header("Location:./login.html");
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>航空机票购买系统</title>
	<link rel="stylesheet" href="./static/css/index_bootstrap.min.css">
	<script src="./static/js/jquery.min.js"></script>
	<script src="./static/js/bootstrap.min.js"></script>
    <link href="./static/css/bootstrap.min.css" rel="stylesheet">
    <link href="./static/css/font-awesome.min.css" rel="stylesheet">
    <link href="./static/css/animate.min.css" rel="stylesheet">
    <link href="./static/css/prettyPhoto.css" rel="stylesheet">
    <link href="./static/css/main.css" rel="stylesheet">
    <link href="./static/css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="./static/js/html5shiv.js"></script>
    <script src="./static/js/respond.min.js"></script>
    <![endif]-->
</head>

<body>
	<div id="myCarousel" class="carousel slide">
	<!-- 点容器 -->
	<ol class="carousel-indicators">
		<li class="active"></li>
		<li></li>
		<li></li>
	</ol>
	<!-- 轮播（Carousel）项目 -->
	<div class="carousel-inner">
		<div class="item active">
            <a href="./buy_ticket.php"><img src="image/机票选购.jpg"/></a>
			<div class="carousel-caption">机票选购</div>
		</div>
		<div class="item">
            <a href="./ticket.php"><img src="image/订单信息.jpg" /></a>
			<div class="carousel-caption">订单信息</div>
		</div>
		<div class="item">
            <a href="./user.php"><img src="image/个人中心.jpg" class="img-responsive center-block"/></a>
			<div class="carousel-caption">个人中心</div>
		</div>
	</div>
	<!-- 左右箭头 -->
	<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
	    <span class="glyphicon glyphicon-chevron-left"></span>
	</a>
	<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
	    <span class="glyphicon glyphicon-chevron-right"></span>
	</a>
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
             <li class="active"><a href="javascript:void(0)">首页</a></li>
             <?php
             if($_SESSION['user']['name']==='admin'){
                echo '<li><a href="./admin_plane.php">航班管理</a></li>
                <li><a href="./admin_user.php">客户信息管理</a></li>
                <li><a href="./analysis.php">流量统计</a></li>';
             }
             else{
                echo '<li><a href="./user.php">个人中心</a></li>
                <li><a href="./ticket.php">订单信息</a></li>
                  <li><a href="./buy_ticket.php">购票</a></li>';
             }

             ?>

          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="./login.html">欢迎, <?php echo $_SESSION['user']['name'];?></a></li>
          </ul>
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </nav><!-- /.navbar -->
    <section id="feature" >
        <div class="container">
           <div class="center wow fadeInDown">
                <h2>数据分析</h2>
                <p class="lead">我们提供了以下数据分析服务以帮助您更好的理解我们的工作</p>
            </div>

            <div class="row">
                <div class="features">
                    <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                        <div class="feature-wrap">
                            <i class="fa fa-bullhorn"></i>
                            <a href="ana1.html"><h2>航线分析</h2></a>
                        </div>
                    </div><!--/.col-md-4-->

                    <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                        <div class="feature-wrap">
                            <i class="fa fa-comments"></i>
                            <a href="ana2.html"><h2>折扣率分析</h2></a>
                        </div>
                    </div><!--/.col-md-4-->

                    <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                        <div class="feature-wrap">
                            <i class="fa fa-comments"></i>
                            <a href="ana3.html"><h2>城市连通率分析</h2></a>
                        </div>
                    </div><!--/.col-md-4-->

                    <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                        <div class="feature-wrap">
                            <i class="fa fa-leaf"></i>
                             <h2>更多内容，敬请期待</h2>
                        </div>
                    </div><!--/.col-md-4-->

                    <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                        <div class="feature-wrap">
                            <i class="fa fa-cogs"></i>
                            <h2>更多内容，敬请期待</h2>
                        </div>
                    </div><!--/.col-md-4-->

                    <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                        <div class="feature-wrap">
                            <i class="fa fa-heart"></i>
                             <h2>更多内容，敬请期待</h2>
                        </div>
                    </div><!--/.col-md-4-->
                </div><!--/.services-->
            </div><!--/.row-->
        </div><!--/.container-->
    </section><!--/#feature-->
<section id="services" class="service-item" style="background:url(./image/game/bg_services.jpg)">
	   <div class="container">
            <div class="center wow fadeInDown">
                <h2>愉快玩耍吧</h2>
                <p class="lead">我们写了一些游戏以防您在候机时无聊 <br> 当然也有一些游戏是抄的传统游戏</p>
            </div>

            <div class="row">

                <div class="col-sm-6 col-md-4">
                    <div class="media services-wrap wow fadeInDown">
                        <div class="pull-left">
                            <a href="./tanchishe/index.html"><img src="image/game/snake.jpg" width="300" height="200"></a>
                        </div>
                        <div class="media-body">
                            <h3 class="media-heading">贪吃蛇</h3>
                            <p>小朋友,我已经在此恭候多时</p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4">
                    <div class="media services-wrap wow fadeInDown">
                        <div class="pull-left">
                            <a href="./chrome/game/index.html"><img src="image/game/dino.jpg" width="300" height="200"></a>
                        </div>
                        <div class="media-body">
                            <h3 class="media-heading">小恐龙</h3>
                            <p>不会吧不会吧？不会真有人会撞仙人掌吧</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="media services-wrap wow fadeInDown">
                        <div class="pull-left">
                            <a href="edge://surf/"><img src="image/game/surf.jpg" width="300" height="200"></a>
                        </div>
                        <div class="media-body">
                            <h3 class="media-heading">冲浪</h3>
                            <p>冲浪人我冲浪魂(仅限edge浏览器)</p>
                        </div>
                    </div>
                </div>

            </div><!--/.row-->
        </div><!--/.container-->
    </section><!--/#services-->
<section id="recent-works">
        <div class="container">
            <div class="center wow fadeInDown">
                <h2>近期新闻</h2>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-3">
                                    <div class="recent-work-wrap">
                                        <img class="img-responsive" src="image/国航.jpg" alt="">
                                        <div class="overlay">
                                            <div class="recent-work-inner">
                                                <h3><a href="#">国航</a> </h3>
                                                <a class="preview" href="http://www.airchina.com.cn" rel="prettyPhoto"><i class="fa fa-eye"></i> View</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-4 col-md-3">
                                    <div class="recent-work-wrap">
                                        <img class="img-responsive" src="image/南航.jpg" alt="">
                                        <div class="overlay">
                                            <div class="recent-work-inner">
                                                <h3><a href="#">南航</a></h3>
                                                <a class="preview" href="http://www.csair.com/cn" rel="prettyPhoto"><i class="fa fa-eye"></i> View</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-4 col-md-3">
                                    <div class="recent-work-wrap">
                                        <img class="img-responsive" src="image/东航.jpg" alt="">
                                        <div class="overlay">
                                            <div class="recent-work-inner">
                                                <h3><a href="#">东航</a></h3>

                                                <a class="preview" href="http://www.ceair.com" rel="prettyPhoto"><i class="fa fa-eye"></i> View</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-4 col-md-3">
                                    <div class="recent-work-wrap">
                                        <img class="img-responsive" src="image/海南.jpg" alt="">
                                        <div class="overlay">
                                            <div class="recent-work-inner">
                                                <h3><a href="#">海南航空 </a></h3>
                                                <a class="preview" href="http://www.hnair.com" rel="prettyPhoto"><i class="fa fa-eye"></i> View</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-4 col-md-3">
                                    <div class="recent-work-wrap">
                                        <img class="img-responsive" src="image/深航.jpg" alt="">
                                        <div class="overlay">
                                            <div class="recent-work-inner">
                                                <h3><a href="#">深圳航空</a></h3>
                                                <a class="preview" href="http://www.shenzhenair.com" rel="prettyPhoto"><i class="fa fa-eye"></i> View</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-4 col-md-3">
                                    <div class="recent-work-wrap">
                                        <img class="img-responsive" src="image/国泰.jpg" alt="">
                                        <div class="overlay">
                                            <div class="recent-work-inner">
                                                <h3><a href="#">国泰航空 </a></h3>
                                                <a class="preview" href="http://www.cathaypacific.com" rel="prettyPhoto"><i class="fa fa-eye"></i> View</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-4 col-md-3">
                                    <div class="recent-work-wrap">
                                        <img class="img-responsive" src="image/吉祥.jpg" alt="">
                                        <div class="overlay">
                                            <div class="recent-work-inner">
                                                <h3><a href="#">吉祥航空 </a></h3>
                                                <a class="preview" href="http://www.juneyaoair.com" rel="prettyPhoto"><i class="fa fa-eye"></i> View</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-4 col-md-3">
                                    <div class="recent-work-wrap">
                                        <img class="img-responsive" src="image/春秋.jpg" alt="">
                                        <div class="overlay">
                                            <div class="recent-work-inner">
                                                <h3><a href="#">Business theme </a></h3>
                                                <p>There are many variations of passages of Lorem Ipsum available, but the majority</p>
                                                <a class="preview" href="http://www.ch.com" rel="prettyPhoto"><i class="fa fa-eye"></i> View</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            </div><!--/.row-->
        </div><!--/.container-->
    </section><!--/#recent-works-->

<section id="bottom">
        <div class="container wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="widget">
                        <h3>about us</h3>
                        <ul>
                            <li><a href="#">we are</a></li>
                            <li><a href="#">students</a></li>
                            <li><a href="#">from</a></li>
                            <li><a href="#">fudan computer and science</a></li>
                            <li><a href="#">school</a></li>

                        </ul>
                    </div>
                </div><!--/.col-md-3-->

                <div class="col-md-3 col-sm-6">
                    <div class="widget">
                        <h3>Support</h3>
                        <ul>
                            <li><a href="#">github</a></li>
                            <li><a href="#">csdn</a></li>
                            <li><a href="#">菜鸟教程</a></li>
                            <li><a href="#">各大网站页面参考</a></li>
                        </ul>
                    </div>
                </div><!--/.col-md-3-->

                <div class="col-md-3 col-sm-6">
                    <div class="widget">
                        <h3>Developers</h3>
                        <ul>
                            <li><a href="#">sha zeyang</a></li>
                            <li><a href="#">mao xiangyu</a></li>
                            <li><a href="#">ma zuolin</a></li>
                        </ul>
                    </div>
                </div><!--/.col-md-3-->

                <div class="col-md-3 col-sm-6">
                                    <div class="widget">
                                        <h3>提交bug</h3>
                                        <ul>
                                            <li><a href="./bug_commit.php">若发现bug在这里提交</a></li>

                                        </ul>
                                    </div>
                                </div><!--/.col-md-3-->

            </div>
        </div>
    </section><!--/#bottom-->

</body>

</html>

