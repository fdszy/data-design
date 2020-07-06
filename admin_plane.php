<?php
header ( "Content-type:text/html;charset=utf-8" ); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
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
</head>
<body data-spy="scroll" data-target="#myScrollspy">
<meta charset="utf-8">
<div id="app">
<img src="image/航班管理.jpg"  width="1600px" height="400px">
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
            <li class="active"><a href="javascript:void(0)">航班管理</a></li>
            <li><a href="./admin_user.php">客户信息管理</a></li>
              <li><a href="./analysis.php">流量统计</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="./login.html">欢迎, <?php session_start();echo $_SESSION['user']['name'];?></a></li>
          </ul>
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </nav><!-- /.navbar -->
<hr />
        <div class="container">
            <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
                <div class="list-group">
                    <a href="#" @click="changeAccountInfo()" class="list-group-item"
                       :class="{active: !isAccountInfoHidden}" >票务信息</a>
                    <a href="#" @click="changePsgMgr()" class="list-group-item" :class="{active: !isUserMgrHidden}">注册航线</a>
                    <a href="#" @click="changeline()" class="list-group-item" :class="{active: !isline}">添加航班</a>
                    <a href="#" @click="changeflight()" class="list-group-item" :class="{active: !isflight}">修改航班</a>
                    <a href="#" @click="changeprice()" class="list-group-item" :class="{active: !isprice}">修改票价信息</a>
                    <a href="#" @click="changedelete()" class="list-group-item" :class="{active: !isdelete}">删除航班</a>
                    <a href="#" @click="changeChgPsw()" class="list-group-item"
                       :class="{active: !isChgPwdHidden}">发送消息</a>
                </div>
            </div><!--/.sidebar-offcanvas-->
            <div class="col-xs-12 col-sm-9">
                <div class="row">
                    <div :class="{hidden: isAccountInfoHidden}">
                        <h1 class="text-center" >查询信息</h1>
                        <div style="margin-top: 20px">
                            <div class="panel panel-default">
                                <style>
                                    .form-group {
                                        height: 200px;
                                        width: 300px;
                                    }
                                    .bin{
                                        height: 200px;
                                        width: 500px;
                                    }
                                </style>
                                <div class="panel-heading"> 航班查询 </div>
                                <div class="panel-body">
                                    <form role="form" method="post" action="admin_manage_flight.php">
                                        <input type="hidden" name="op" value="query">
                                        <label for="name">航班号</label>
                                        <input type="text" class="form-control" name="fNo" placeholder="请输入航班号">
                                        <br>
                                        <label for="name">航班日期</label>
                                        <div class="form-group">
                                            <div class="input-group date form_date col-md-12" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                <input class="form-control" size="10" type="text" name="date" value="" readonly>
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                            </div>
                                            <input type="hidden" id="dtp_input2" value="" />
                                            <br>
                                        </div>

                                        <button type="submit" class="btn btn-primary">查询</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading"> 查询结果 </div>
                            <div class="panel-body">
                                <table class="table table-striped">
                                    <caption></caption>
                                    <?php 
                                    if(isset($_SESSION['admin_query_flight'])){
                                        echo "<thead>
                                    <tr>
                                        <th>航班号</th>
                                        <th>出发时间</th>
                                        <th>到达时间</th>
                                        <th>头等舱总仓位</th>
                                        <th>头等舱剩余仓位</th>
                                        <th>经济舱总仓位</th>
                                        <th>经济舱剩余仓位</th>
                                    </tr>
                                    </thead>";
                                        foreach($_SESSION['admin_query_flight'] as $result){
                                            echo "<tbody>
                                            <tr>
                                              <td>".$result['fNo']."</td>
                                              <td>".$result['de-time']."</td>
                                              <td>".$result['ar-time']."</td>
                                              <td>".$result['t-1']."</td>
                                              <td>".$result['l-1']."</td>
                                              <td>".$result['t-2']."</td>
                                              <td>".$result['l-2']."</td>
                                            </tr>
                                          </tbody>";
                                        }
                                        unset($_SESSION['admin_query_flight']);
                                    }
                                    ?>
                                </table>
                            </div>
                            </div>
                        </div>
                    <div :class="{hidden: isUserMgrHidden}">
                        <h1 class="text-center" >注册航线</h1>
                        <div style="margin-top: 20px">
                            <div class="panel panel-default">

                                <div class="panel-heading"> 注册航线 </div>
                                <div class="panel-body">
                                <form role="form" method="post" action="admin_manage_flight.php">
                                        <input type="hidden" name="op" value="create_flight">
                                        <label for="name">航班号</label>
                                        <input type="text" class="form-control" name = "fNo" placeholder="请输入航班号">
                                        <label for="name">飞机型号</label>
                                        <input type="text" class="form-control" name = "model" placeholder="请输入飞机型号">
                                        <label for="name">航空公司</label>
                                        <input type="text" class="form-control" name = "airline" placeholder="请输入航空公司">
                                        <label for="name">出发机场</label>
                                        <input type="text" class="form-control" name = "departure" placeholder="请输入出发机场（输入格式为包括航站楼的机场ID，如：PEKT1）">
                                        <label for="name">到达机场</label>
                                        <input type="text" class="form-control" name = "arrival" placeholder="请输入到达机场">
                                        <label for="name">中转机场1</label>
                                        <input type="text" class="form-control" name="tran-1" value="NULL" placeholder="请输入中转机场1（如果没有可不输入）">
                                        <label for="name">中转机场2</label>
                                        <input type="text" class="form-control" name="tran-2" value="NULL" placeholder="请输入中转机场2（如果没有可不输入）">
                                        <label for="name">头等舱数量</label>
                                        <input type="text" class="form-control" name = "seat1-total" placeholder="请输入头等舱数量">
                                        <label for="name">经济舱数量</label>
                                        <input type="text" class="form-control" name = "seat2-total" placeholder="请输入经济舱数量">
                                        <br>
                                        <button type="submit" class="btn btn-primary">注册</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div :class="{hidden: isline}">
                        <h1 class="text-center" >添加航班</h1>
                        <div style="margin-top: 20px">
                            <div class="panel panel-default">
                                <div class="panel-heading"> 添加航班 </div>
                                <div class="panel-body">
                                    <form role="form" method="post" action="admin_manage_flight.php">
                                        <input type="hidden" name="op" value="create_inventory">
                                        <label for="name">航班号</label>
                                        <input type="text" class="form-control" name="fNo" placeholder="请输入航班号">
                                        <label for="name">出发时间</label>
                                        <input type="text" class="form-control" name="de-time" placeholder="请输入出发时间（按照正确的时间格式，如2020-1-1 12:00:00）">
                                        <label for="name">出发机场</label>
                                        <input type="text" class="form-control" name="departure" placeholder="请输入出发机场">
                                        <label for="name">到达时间</label>
                                        <input type="text" class="form-control" name="ar-time" placeholder="请输入到达时间">
                                        <label for="name">头等舱价格</label>
                                        <input type="text" class="form-control" name="price1" placeholder="请输入头等舱价格">
                                        <label for="name">经济舱价格</label>
                                        <input type="text" class="form-control" name="price2" placeholder="请输入经济舱价格">
                                        <br>
                                        <button type="submit" class="btn btn-primary">添加</button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div :class="{hidden: isflight}">
                        <h1 class="text-center" >修改航线</h1>
                        <div style="margin-top: 20px">
                            <div class="panel panel-default">

                                <div class="panel-heading"> 修改航线 </div>
                                <div class="panel-body">
                                    <form role="form" method="post" action="admin_manage_flight.php">    <!- 这里改一下 ->
                                        <input type="hidden" name="op" value="modify_flight">
                                        <label for="name">航班号</label>
                                        <input type="text" class="form-control" name="fNo" placeholder="请输入航班号">
                                        <label for="name">飞机型号</label>
                                        <input type="text" class="form-control" name="model" placeholder="请输入飞机型号">
                                        <label for="name">航空公司</label>
                                        <input type="text" class="form-control" name="airline" placeholder="请输入航空公司">
                                        <label for="name">出发机场</label>
                                        <input type="text" class="form-control" name="departure" placeholder="请输入出发机场">
                                        <label for="name">到达机场</label>
                                        <input type="text" class="form-control" name="arrival" placeholder="请输入到达机场">
                                        <label for="name">中转机场1</label>
                                        <input type="text" class="form-control" name="tran-1" placeholder="请输入中转机场1（如果没有请输入无">
                                        <label for="name">中转机场2</label>
                                        <input type="text" class="form-control" name="tran-2" placeholder="请输入中转机场2（如果没有请输入无">

                                        <label for="name">头等舱数量</label>
                                        <input type="text" class="form-control" name="seat1-total" placeholder="请输入头等舱数量">
                                        <label for="name">经济舱数量</label>
                                        <input type="text" class="form-control" name="seat2-total" placeholder="请输入经济舱数量">
                                        <br>
                                        <button type="submit" class="btn btn-primary">修改</button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div :class="{hidden: isprice}">
                        <h1 class="text-center" >修改票价</h1>
                        <div style="margin-top: 20px">
                            <div class="panel panel-default">

                                <div class="panel-heading"> 修改票价 </div>
                                <div class="panel-body">
                                    <form role="form" method="post" action="admin_manage_flight.php">    <!- 这里改一下 ->
                                        <input type="hidden" name="op" value="modify_price">
                                        <label for="name">航班号</label>
                                        <input type="text" class="form-control" name="fNo" placeholder="请输入航班号">
                                        <label for="name">出发时间</label>
                                        <input type="text" class="form-control" name="de-time" placeholder="请输入出发时间（按照正确的时间格式）">

                                        <label for="name">头等舱价格</label>
                                        <input type="text" class="form-control" name="price1" placeholder="请输入头等舱价格">
                                        <label for="name">经济舱价格</label>
                                        <input type="text" class="form-control" name="price2" placeholder="请输入经济舱价格">
                                        <br>
                                        <button type="submit" class="btn btn-primary">修改</button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div :class="{hidden: isdelete}">
                        <h1 class="text-center" >删除航线</h1>
                        <div style="margin-top: 20px">
                            <div class="panel panel-default">

                                <div class="panel-heading"> 删除航线 </div>
                                <div class="panel-body">
                                    <form role="form" method="post" action="admin_manage_flight.php">
                                        <input type="hidden" name="op" value="delete_flight">
                                        <label for="name">航班号</label>
                                        <input type="text" name="fNo" class="form-control" placeholder="请输入航班号">
                                        <br>
                                        <button type="submit" class="btn btn-primary">删除</button>
                                    </form>
                                </div>
                                <div class="panel-heading"> 删除航班 </div>
                                <div class="panel-body">
                                    <form role="form" method="post" action="admin_manage_flight.php">
                                        <input type="hidden" name="op" value="delete_inventory">
                                        <label for="name">航班号</label>
                                        <input type="text" name="fNo" class="form-control" placeholder="请输入航班号">
                                        <label for="name">出发时间</label>
                                        <input type="text" name="de-time" class="form-control" placeholder="请输入出发时间(正确格式，如2020-06-06 13:00:00)">
                                        <br>
                                        <button type="submit" class="btn btn-primary">删除</button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div :class="{hidden: isChgPwdHidden}">
                    <h1 class = "text-center">留言板</h1>
                            <form role="form" method="post" action="messageboard.php">
                            <input type="hidden" name="user" value="<?php echo $_SESSION['user']['id']?>">
                            <div class="form-group">
                                <label for="content">请输入留言内容</label>
                                <textarea name="content" class="form-control" rows="3"></textarea>
                                <label for="content">如果是回复消息，请在下方输入回复的楼层，不是的话输入NULL即可</label>
                                <input type="text" class="form-control" name="reply" value="NULL" placeholder="请输入想要回复的楼层">
                            </div>
                            <button type="submit" class="btn btn-primary" id="sub_btn">发送</button>
                            </form>
                            <br>
                            <hr style="filter: alpha(opacity=100,finishopacity=0,style=2)" width="80%" color="#6f5499" size="10"/>
                            <div id="messDivId" style="margin-left:25%;">
                                <?php 
                                include 'functions.php';
                                $results = refresh_message();
                                foreach($results as $key=>$value){
                                   echo '<div class="story">
                                    <div class="opbtn"></div>
                                    <div class="m_top">
                                       <div class = "aut_na">
                                           <h4><strong>#'.$key.' '.$value['user'].'</strong>&nbsp&nbsp;</h4>
                                       </div>
                                    </div>
                                    <p class="story_time">'.$value['time'].'</p>
                                    <p class="story_m">'.htmlspecialchars($value['content']).'</p>';
                                    if($value['reply']!=NULL){
                                        echo '<p class="story_hf"><strong>@'.$results[$value['reply']]['user']
                                        .'</strong><small>('.$results[$value['reply']]['time']
                                        .')</small>:'.htmlspecialchars($results[$value['reply']]['content']).'</p>';
                                    }
                                    echo '</div>
                                    <br>'; 
                                }
                                ?>
                                <!--
                                <div class="story">
                                    <div class="opbtn"></div>
                                    <div class="m_top">
                                        <div class = "aut_na">
                                            <h4><strong>sss</strong>&nbsp&nbsp;</h4>
                                        </div>
                                    </div>
                                    <p class="story_time">2020/06/5 10:00</p>
                                    <p class="story_m">航班啥时候飞</p>
                                </div>
                                <br>
                                <div class="story">
                                    <div class="opbtn"></div>
                                    <div class="m_top">
                                        <div class = "aut_na">
                                            <h4><strong>管理员</strong>&nbsp;&nbsp;&nbsp;</h4>
                                        </div>
                                    </div>
                                    <p class="story_time">2022/01/12 8:12</p>
                                    <p class="story_m">延误了，不飞了</p>
                                    <p class="story_hf"><strong>@sss</strong><small>(2020/06/05 10:00)</small>:航班啥时候飞</p>
                                </div>
                                <br>
                                <div class="story">
                                    <div class="opbtn"></div>
                                    <div class="m_top">
                                        <div class = "aut_na">
                                            <h4><strong>毛哥</strong>&nbsp;&nbsp;&nbsp;</h4>
                                        </div>
                                    </div>
                                    <p class="story_time">2026/02/10 13:23</p>
                                    <p class="story_m">别飞了，爬吧</p>
                                    <p class="story_hf"><strong>@管理员</strong><small>(2022/01/12
                                        8:12)</small>:延误了，飞不了</p>
                                </div> -->
                        </div>

                    </div>
                    
                </div>


            </div>
        </div>
    </div>
</div>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="./static/js/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="./static/js/bootstrap.min.js"></script>
        <script src="./static/js/vue.js"></script>
        <script src="./static/js/vue-resource.min.js"></script>
        <script src="./static/js/common.js"></script>
        <script>
            new Vue({
                el: '#app',
                data: {
                    userId: 0,
                    isAccountInfoHidden: false,
                    isUserMgrHidden: true,
                    isChgPwdHidden: true,
                    isline: true,
                    isflight: true,
                    isprice: true,
                    isdelete: true,

                },
                created: function () {

                },
                methods: {
                    changeAccountInfo: function () {
                        this.isAccountInfoHidden = false;
                        this.isUserMgrHidden = true;
                        this.isChgPwdHidden = true;
                        this.isline = true;
                        this.isflight = true;
                        this.isprice = true;
                        this.isdelete = true;
                    },
                    changePsgMgr: function () {
                        this.isAccountInfoHidden = true;
                        this.isUserMgrHidden = false;
                        this.isChgPwdHidden = true;
                        this.isline = true;
                        this.isflight = true;
                        this.isprice = true;
                        this.isdelete = true;
                    },
                    changeChgPsw: function () {
                        this.isAccountInfoHidden = true;
                        this.isUserMgrHidden = true;
                        this.isChgPwdHidden = false;
                        this.isline = true;
                        this.isflight = true;
                        this.isprice = true;
                        this.isdelete = true;
                    },
                    changeline: function(){
                        this.isAccountInfoHidden = true;
                        this.isUserMgrHidden = true;
                        this.isChgPwdHidden = true;
                        this.isline = false;
                        this.isflight = true;
                        this.isprice = true;
                        this.isdelete = true;
                    },
                    changeflight: function(){
                        this.isAccountInfoHidden = true;
                        this.isUserMgrHidden = true;
                        this.isChgPwdHidden = true;
                        this.isline = true;
                        this.isflight = false;
                        this.isprice = true;
                        this.isdelete = true;
                    },
                    changeprice: function(){
                        this.isAccountInfoHidden = true;
                        this.isUserMgrHidden = true;
                        this.isChgPwdHidden = true;
                        this.isline = true;
                        this.isflight = true;
                        this.isprice = false;
                        this.isdelete = true;
                    },
                    changedelete: function(){
                        this.isAccountInfoHidden = true;
                        this.isUserMgrHidden = true;
                        this.isChgPwdHidden = true;
                        this.isline = true;
                        this.isflight = true;
                        this.isprice = true;
                        this.isdelete = false;
                    },


                }
            })
        </script>
<script type="text/javascript" src="./jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="./bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="./static/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="./static/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        //language:  'zh-CN',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });
    $('.form_date').datetimepicker({
        language:  'zh-CN',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('.form_time').datetimepicker({
        language:  'zh-CN',
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

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

</body>
</html>