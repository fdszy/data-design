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
        <!--[if lt IE 9]>
        <script src="./static/js/html5shiv.js"></script>
        <script src="./static/js/respond.min.js"></script>
      <style> body {
                font-family: "Microsoft YaHei UI", "Droid Sans Mono", serif;
            }
        </style>
            <style>
    /* Custom Styles */
        ul.nav-tabs{
            width: 140px;
            margin-top: 20px;
            border-radius: 4px;
            border: 1px solid #ddd;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.067);
        }
        ul.nav-tabs li{
            margin: 0;
            border-top: 1px solid #ddd;
        }
        ul.nav-tabs li:first-child{
            border-top: none;
        }
        ul.nav-tabs li a{
            margin: 0;
            padding: 8px 16px;
            border-radius: 0;
        }
        ul.nav-tabs li.active a, ul.nav-tabs li.active a:hover{
            color: #fff;
            background: #000000;
            border: 1px solid #000000;
        }
        ul.nav-tabs li:first-child a{
            border-radius: 4px 4px 0 0;
        }
        ul.nav-tabs li:last-child a{
            border-radius: 0 0 4px 4px;
        }
        ul.nav-tabs.affix{
            top: 30px; /* Set the top position of pinned element */
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
        </style>


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
                    <li><a href="./admin_plane.php">航班管理</a></li>
                    <li class="active"><a href="javascript:void(0)">客户信息管理</a></li>
                    <li><a href="./analysis.php">流量统计</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="./login.html">欢迎, <?php session_start();echo $_SESSION['user']['name'];?></a></li>
                </ul>
            </div><!-- /.nav-collapse -->
        </div><!-- /.container -->
    </nav><!-- /.navbar -->
    <div class = container">
        <div class="jumbotron">
            <h1 class="text-center">客户信息管理</h1>
        </div>
        <div class="container">
            <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
                <div class="list-group">
                    <a href="#" @click="changeAccountInfo()" class="list-group-item"
                       :class="{active: !isAccountInfoHidden}" >用户信息查询</a>
                    <a href="#" @click="changeChgPsw()" class="list-group-item"
                       :class="{active: !isChgPwdHidden}">不良用户踢除</a>
                </div>
            </div><!--/.sidebar-offcanvas-->
            <div class="col-xs-12 col-sm-9">
                <div class="row">
                    <div :class="{hidden: isAccountInfoHidden}">
                        <h1 class="text-center" >客户信息查询</h1>
                            <div class = "panel-default">
                            <div class="panel-heading"> 账号查询 </div>
                            <div class="panel-body">
                                <form role="form" method="post" action="admin_manage_user.php">
                                    <input type="hidden" name="op" value="query">
                                    <div class="form-group">
                                        <label for="name">用户名</label>
                                        <input type="text" class="form-control" name="username" maxlength=5 placeholder="请输入需要查询的账户名">
                                        <label for="name"></label>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary form-control">查询</button>
                                        </div>
                                        </div>
                                </form>

                                    </div>
                            </div>
                            <div class="panel-default">
                                <div class="panel-heading"> 查询结果 </div>
                                <div class="panel-body">
                                    <table class="table table-striped">
                                        <caption></caption>
                                        <?php

                                        if(isset($_SESSION['admin_query_user'])){
                                            echo '<thead>
                                        <tr>
                                            <th>用户名</th>
                                            <th>身份证号</th>
                                            <th>用户账户余额</th>
                                        </tr>' ;
                                            echo "<tbody>  
                                            <tr>
                                              <td>".$_SESSION['admin_query_user']['name']."</td>
                                              <td>".$_SESSION['admin_query_user']['id']."</td>
                                              <td>".$_SESSION['admin_query_user']['balance']."</td>
                                            </tr>
                                        </tbody>";
                                            unset($_SESSION['admin_query_user']);
                                        }
                                        
                                        ?>
                                    </table>
                                </div>
                            </div>
                    </div>

                    <div :class="{hidden: isChgPwdHidden}">
                        <h1 class = "text-center">黑名单</h1>
                        <div class="row" style="margin-top: 20px;margin-left: 30px">
                            <div class = "panel-default">
                                <div class="panel-heading"> 拉入黑名单 </div>
                                <div class="panel-body">
                                    <form role="form" method="post" action="admin_manage_user.php">
                                        <div class="form-group">
                                            <input type="hidden" name="op" value="black">
                                            <label for="name">账号名</label>
                                            <input type="text" class="form-control" name="username" placeholder="请输入需要拉入黑名单的账户名">
                                            <label for="name"></label>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary form-control">拉入黑名单</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                            <div class="panel-default">
                                <div class="panel-heading"> 历史黑名单 </div>
                                <div class="panel-body">
                                    <table class="table table-striped">
                                        <caption></caption>
                                        <thead>
                                        <tr>
                                            <th>用户名</th>
                                            <th>身份证号</th>
                                            <th>用户账户余额</th> 
                                        </tr>
                                        </thead>
                                        <?php
                                        include 'functions.php';
                                        $results = get_blacklist();
                                        foreach($results as $result){
                                            echo "<tbody>
                                            <tr>
                                              <td>".$result['name']."</td>
                                              <td>".$result['id']."</td>
                                              <td>".$result['balance']."</td>
                                            </tr>
                                        </tbody>";
                                        }
                                        ?>

                                    </table>
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
</body>
</html>