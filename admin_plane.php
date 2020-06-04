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
<div id="app">
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
              <li><a href="./buy_ticket.html">流量统计</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="./login.html">欢迎,<?php session_start();echo $_SESSION['user']['name'];?></a></li>
          </ul>
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </nav><!-- /.navbar -->
    <div class = container">
        <div class="jumbotron">
        <h1 class="text-center">航班管理</h1>
    </div>
        <div class="container">
            <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
                <div class="list-group">
                    <a href="#" @click="changeAccountInfo()" class="list-group-item"
                       :class="{active: !isAccountInfoHidden}" >票务信息</a>
                    <a href="#" @click="changePsgMgr()" class="list-group-item" :class="{active: !isUserMgrHidden}">修改航班</a>
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
                                                <input class="form-control" size="10" type="text" name ="date" value="" readonly>
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
                                        <th>经济舱总仓位</th>
                                        <th>头等舱剩余仓位</th>
                                        <th>经济舱剩余仓位</th>
                                    </tr>
                                    </thead>";
                                        foreach($_SESSION['admin_query_flight'] as $result){
                                            echo "<tbody>
                                            <tr>
                                              <td>'.$result['fNo'].'</td>
                                              <td>'.$result['de_time'].'</td>
                                              <td>'.$result['ar-time'].'</td>
                                              <td>'.$result['de_time'].'</td>
                                              <td>'.$result['t-1'].'</td>
                                              <td>'.$result['l-1'].'</td>
                                              <td>'.$result['t-2'].'</td>
                                              <td>'.$result['l-2'].'</td>
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
                        <h1 class="text-center" >修改航班</h1>
                        <div style="margin-top: 20px">
                            <div class="panel panel-default">

                                <div class="panel-heading"> 添加/修改航班 </div>
                                <div class="panel-body">
                                    <form role="form" method="post" action="search.php">    <!- 这里改一下 ->
                                        <label for="name">航班号</label>
                                        <input type="text" class="form-control" placeholder="请输入航班号">
                                        <label for="name">飞机型号</label>
                                        <input type="text" class="form-control" placeholder="请输入飞机型号">
                                        <label for="name">出发机场</label>
                                        <input type="text" class="form-control" placeholder="请输入出发机场">
                                        <label for="name">中转机场1</label>
                                        <input type="text" class="form-control" placeholder="请输入中转机场1（如果没有请输入无">
                                        <label for="name">中转机场2</label>
                                        <input type="text" class="form-control" placeholder="请输入中转机场2（如果没有请输入无">
                                        <label for="datetime">出发时间</label>
                                        <input type="text" class="form-control" placeholder="请输入出发时间">
                                        <label for="name">头等舱数量</label>
                                        <input type="text" class="form-control" placeholder="请输入头等舱数量">
                                        <label for="name">头等舱价格</label>
                                        <input type="text" class="form-control" placeholder="请输入头等舱价格">
                                        <label for="name">经济舱数量</label>
                                        <input type="text" class="form-control" placeholder="请输入经济舱数量">
                                        <label for="name">经济舱价格</label>
                                        <input type="text" class="form-control" placeholder="请输入经济舱价格">
                                        <br>
                                        <button type="submit" class="btn btn-primary">修改</button>
                                    </form>
                                </div>
                            </div>
                            <div class="panel panel-default">

                                <div class="panel-heading"> 删除航班 </div>
                                <div class="panel-body">
                                    <form role="form" method="post" action="search.php">    <!- 这里改一下 ->
                                        <label for="name">航班号</label>
                                        <input type="text" class="form-control" placeholder="请输入航班号">

                                        <br>
                                        <button type="submit" class="btn btn-primary">删除</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="changepwd.php" method="post">
                        <div :class="{hidden: isChgPwdHidden}">
                            <h1 class = "text-center">修改密码</h1>
                            <div class="row" style="margin-top: 20px;margin-left: 30px">
                            <div class="col-lg-8">
                                <div class="input-group">
                                    <span class="input-group-addon">旧密码</span>
                                    <input type="text" v-model="passwordForm.oldPassword" class="form-control"
                                           placeholder="Old Password" name="oldpwd">
                                </div>
                            </div>
                            <div class="col-lg-8" style="margin-top: 3px">
                                <div class="input-group">
                                    <span class="input-group-addon">新密码</span>
                                    <input type="text" v-model="passwordForm.newPassword" class="form-control"
                                           placeholder="New Password" name="newpwd">
                                </div>
                            </div>
                            <div class="col-lg-8" style="margin-top: 3px">
                                <div class="input-group">
                                    <span class="input-group-addon">重复密码</span>
                                    <input type="text" v-model="passwordForm.newPassword2" class="form-control"
                                           placeholder="Repeat Password" name="confirm">
                                </div>
                            </div>
                            <div class="col-lg-12" style="font-size: 1.2em; margin-top: 3px">
                                <span class="label label-danger">{{ passwordForm.errorLabel }}</span>
                            </div>
                            <div class="col-lg-8" style="margin-top: 5px">
                                <button type="submit" class="btn btn-primary" style="float: right">修改密码
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
                    userInfo: {},
                    passengers: [],
                    passengerForm: {
                        pName: '',
                        pId: ''
                    },
                    passwordForm: {
                        oldPassword: '',
                        newPassword: '',
                        newPassword2: '',
                        errorLabel: '',
                    }
                },
                created: function () {
                    this.userId = getCookie('userId');
                    this.loadUserInfo();
                    this.loadPassengers();
                },
                methods: {
                    changeAccountInfo: function () {
                        this.isAccountInfoHidden = false;
                        this.isUserMgrHidden = true;
                        this.isChgPwdHidden = true;
                    },
                    changePsgMgr: function () {
                        this.isAccountInfoHidden = true;
                        this.isUserMgrHidden = false;
                        this.isChgPwdHidden = true;
                    },
                    changeChgPsw: function () {
                        this.isAccountInfoHidden = true;
                        this.isUserMgrHidden = true;
                        this.isChgPwdHidden = false;
                    },
                    loadUserInfo: function () {
                        api.save({action: 'user_info'}, {
                            uid: this.userId
                        }).then(resp => {
                            this.userInfo = resp.body;
                        });
                    },
                    loadPassengers: function () {
                        api.save({action: 'get_my_psg'}, {
                            uid: this.userId
                        }).then(resp => {
                            this.passengers = resp.body;
                        });
                    },
                    delPassenger: function (psgId) {
                        api.save({action: 'del_psg'}, {
                            pId: psgId,
                            uid: this.userId
                        }).then(resp => {
                            checkResp(resp, () => {
                                this.loadPassengers()
                            });
                        });
                    },
                    addPassenger: function () {
                        api.save({action: 'add_psg'}, {
                            pName: this.passengerForm.pName,
                            pId: this.passengerForm.pId,
                            uid: this.userId
                        }).then(resp => {
                            checkResp(resp, () => {
                                this.loadPassengers()
                            });
                        });
                    },
                    changePassword: function () {
                        if (this.passwordForm.newPassword !== this.passwordForm.newPassword2) {
                            this.passwordForm.errorLabel = "两次输入的密码不一致";
                            return;
                        }
                        this.passwordForm.errorLabel = '';

                        api.save({action: 'change_password'}, {
                            uid: this.userId,
                            old_pwd: this.passwordForm.oldPassword,
                            new_pwd: this.passwordForm.newPassword,
                        }).then(resp => {
                            checkResp(resp, () => {
                                setCookie("userId", 0);
                                alert("修改密码成功，请重新登录");
                                location.href = './index.html';
                            });
                        });


                    }
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