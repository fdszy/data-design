<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location:login.html");
  }
if($_SESSION['user']['name'] === "admin"){
    header("Location:admin_user.php");
    exit;
}
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
</head>
</head>
<body data-spy="scroll" data-target="#myScrollspy">
<div id="app">
    <img src="image/个人中心2.jpg"  width="1600px" height="400px">
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
            <li class="active"><a href="javascript:void(0)">个人中心</a></li>
            <li><a href="./ticket.php">订单信息</a></li>
              <li><a href="./buy_ticket.php">购票</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="./login.html">欢迎, <?php echo $_SESSION['user']['name'];?></a></li>
          </ul>
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </nav><!-- /.navbar -->

        <div class="container">
            <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
                <div class="list-group">
                    <a href="#" @click="changeAccountInfo()" class="list-group-item"
                       :class="{active: !isAccountInfoHidden}">帐号信息</a>
                    <a href="#" @click="changePsgMgr()" class="list-group-item" :class="{active: !isUserMgrHidden}">消息中心</a>
                    <a href="#" @click="changeChgPsw()" class="list-group-item"
                       :class="{active: !isChgPwdHidden}">修改密码</a>
                    <a href="#" @click="changemoney()" class="list-group-item"
                       :class="{active: !ismoney}">账户充值</a>
                </div>
            </div><!--/.sidebar-offcanvas-->
                <div class="col-xs-12 col-sm-9">
                    <div class="row">
                        <div :class="{hidden: isAccountInfoHidden}">
                            <h1 class="text-center">帐号信息</h1>
                            <div style="margin-top: 20px">
                            <p class = "col-md-offset-3">用户ID：<?php echo $_SESSION['user']['id'];?></p>
                            <p class = "col-md-offset-3">用户名：<?php echo $_SESSION['user']['name'];?></p>
                            <p class = "col-md-offset-3">账户余额：<?php echo round($_SESSION['user']['balance'],2);?></p>
                             <p class = "col-md-offset-3">信用积分：<?php echo round($_SESSION['user']['credit'],2);?></p>
                        </div>
                        </div>

                        <div :class="{hidden: isUserMgrHidden}">
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

                        <div :class="{hidden: ismoney}">
                            <div class="paying" style="margin-left:20%">

                                <form action="money.php" method="post" class="validator" name="f" onsubmit="return chongzhi();" >
                                    <div class="payamont">
                                        <input type="text" id="money" name="money" value="" />
                                        <span>元 （输入充值金额，不支持小数。最低 500元）</span>
                                    </div>
                                    <div class="clr"></div>
                                    <ul class="ui-list-icons clrfix">
                                        <li>
                                            <input type="radio" name="bank" id="ABC" value="" checked="checked">
                                            <label class="icon-box current" for="ABC">
                                                <span class="icon-box-sparkling" bbd="false"> </span>
                                                <span class="false icon ABC" title="中国农业银行"></span>
                                                <span class="bank-name">中国农业银行</span>
                                            </label>
                                        </li>
                                        <li>
                                            <input type="radio" name="bank" id="ICBC" value="">
                                            <label class="icon-box" for="ICBC">
                                                <span class="icon-box-sparkling" bbd="false"> </span>
                                                <span class="false icon ICBC" title="中国工商银行"></span>
                                                <span class="bank-name">中国工商银行</span>
                                            </label>
                                        </li>
                                        <li>
                                            <input type="radio" name="bank" id="CCB" value="">
                                            <label class="icon-box" for="CCB">
                                                <span class="icon-box-sparkling" bbd="false"> </span>
                                                <span class="false icon CCB" title="中国建设银行"></span>
                                                <span class="bank-name">中国建设银行</span>
                                            </label>
                                        </li>
                                        <li>
                                            <input type="radio" name="bank" id="CCB" value="">
                                            <label class="icon-box" for="CCB">
                                                <span class="icon-box-sparkling" bbd="false"> </span>
                                                <span class="false icon CCB" title="中国建设银行"></span>
                                                <span class="bank-name">中国建设银行</span>
                                            </label>
                                        </li>
                                        <li>
                                            <input type="radio" name="bank" id="PSBC" value="">
                                            <label class="icon-box" for="PSBC">
                                                <span class="icon-box-sparkling" bbd="false"> </span>
                                                <span class="false icon PSBC" title="中国邮政储蓄银行"></span>
                                                <span class="bank-name">中国邮政储蓄银行</span>
                                            </label>
                                        </li>
                                        <li>
                                            <input type="radio" name="bank" id="BOC" value="">
                                            <label class="icon-box" for="BOC">
                                                <span class="icon-box-sparkling" bbd="false"> </span>
                                                <span class="false icon BOC" title="中国银行"></span>
                                                <span class="bank-name">中国银行</span>
                                            </label>
                                        </li>
                                        <li>
                                            <input type="radio" name="bank" id="CMB" value="">
                                            <label class="icon-box" for="CMB">
                                                <span class="icon-box-sparkling" bbd="false"> </span>
                                                <span class="false icon CMB" title="招商银行"></span>
                                                <span class="bank-name">招商银行</span>
                                            </label>
                                        </li>
                                        <li>
                                            <input type="radio" name="bank" id="COMM" value="">
                                            <label class="icon-box" for="COMM">
                                                <span class="icon-box-sparkling" bbd="false"> </span>
                                                <span class="false icon COMM" title="交通银行"></span>
                                                <span class="bank-name">交通银行</span>
                                            </label>
                                        </li>
                                        <li>
                                            <input type="radio" name="bank" id="SPDB" value="">
                                            <label class="icon-box" for="SPDB">
                                                <span class="icon-box-sparkling" bbd="false"> </span>
                                                <span class="false icon SPDB" title="浦发银行"></span>
                                                <span class="bank-name">浦发银行</span>
                                            </label>
                                        </li>
                                        <li>
                                            <input type="radio" name="bank" id="CEB" value="">
                                            <label class="icon-box" for="CEB">
                                                <span class="icon-box-sparkling" bbd="false"> </span>
                                                <span class="false icon CEB" title="中国光大银行"></span>
                                                <span class="bank-name">中国光大银行</span>
                                            </label>
                                        </li>
                                    </ul>
                                    <div class="paybok"><input class="csbtx" type="button" value="确认充值" onclick="this.form.submit();" /></div>
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
                    ismoney: true,
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

                },
                methods: {
                    changeAccountInfo: function () {
                        this.isAccountInfoHidden = false;
                        this.isUserMgrHidden = true;
                        this.isChgPwdHidden = true;
                        this.ismoney = true;
                    },
                    changePsgMgr: function () {
                        this.isAccountInfoHidden = true;
                        this.isUserMgrHidden = false;
                        this.isChgPwdHidden = true;
                        this.ismoney = true;
                    },
                    changeChgPsw: function () {
                        this.isAccountInfoHidden = true;
                        this.isUserMgrHidden = true;
                        this.isChgPwdHidden = false;
                        this.ismoney = true;
                    },
                    changemoney: function () {
                        this.isAccountInfoHidden = true;
                        this.isUserMgrHidden = true;
                        this.isChgPwdHidden = true;
                        this.ismoney = false;
                    }

                }
            })
        </script>
</body>
</html>