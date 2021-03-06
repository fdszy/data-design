<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>航空机票管理系统</title>
        <!-- Bootstrap -->
        <script src="./Chart.js"></script>

    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="./static/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    <link href="./static/css/bootstrap.min.css" rel="stylesheet">

    <!-- Css -->
    <link rel="stylesheet" href="./static/css/offcanvas.css">
    <link rel="stylesheet" href="./static/css/bootstrap-datetimepicker.min.css">
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
</head>
<body>
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
                <li><a href="./admin_user.php">客户信息管理</a></li>
                <li class="active"><a href="javascript:void(0)">流量分析</a></li>

            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="./login.html">欢迎,<?php session_start();echo $_SESSION['user']['name'];?></a></li>
            </ul>
        </div><!-- /.nav-collapse -->
    </div><!-- /.container -->
</nav><!-- /.navbar -->
<img src="image/流量.jpg"  width="1600px" height="400px">
<hr/>


<div style="width:25%;margin-left:18%;margin-top:100px;">

    <canvas id="canvas" height="450" width="1000"></canvas>
</div>

<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<script>
    window.onload=function()
    {
        getdatafromDB();
    }

    var getdatafromDB = function(){
        $.ajax({
            url: "./pro_ana.php",
            type: "POST",
            dataType:"json",
            error: function(){
                alert('Error loading XML document');
            },
            success:function(data){
                console.info(data);
                bar(data);
            }
        });
    }

    function bar(data) {
        if(data.length==null || data.length == 0) {
            return;
        }
        var barData={};
        barData.labels=[];
        barData.datasets=[];
        var temData={};
        temData.data=[];
        temData.fillColor= "rgba(151,187,205,0.5)";
        temData.strokeColor = "rgba(151,187,205,0.8)";
        temData.highlightFill="rgba(151,187,205,0.75)",
            temData.highlightStroke= "rgba(151,187,205,1)";

        for(var i=0;i<data.length;i++)
        {
            barData.labels.push(data[i].day)
            temData.data.push(data[i].flight_count);
        }
        barData.datasets.push(temData); //封装一个规定格式的barData。
        console.info(barData);
        //// 动画效果
        var options = {
            scaleOverlay: false,
            scaleOverride: false,
            scaleSteps: null,
            scaleStepWidth: null,
            scaleStartValue: null,
            scaleLineColor: "rgba(0,0,0,.1)",
            scaleLineWidth: 1,
            scaleShowLabels: true,
            scaleLabel: "<%=value%>",
            scaleFontFamily: "'Arial'",
            scaleFontSize: 12,
            scaleFontStyle: "normal",
            scaleFontColor: "#666",
            scaleShowGridLines: true,
            scaleGridLineColor: "rgba(0,0,0,.05)",
            scaleGridLineWidth: 1,
            bezierCurve: true,
            pointDot: true,
            pointDotRadius: 3,
            pointDotStrokeWidth: 1,
            datasetStroke: true,
            datasetStrokeWidth: 2,
            datasetFill: true,
            animation: true,
            animationSteps: 60,
            animationEasing: "easeOutQuart",
            onAnimationComplete: null
        }
        var ctx  = document.getElementById("canvas").getContext('2d');
        myChart = new Chart(ctx).Bar(barData,options, { //重点在这里
            responsive : true
        });

    }




</script>

</body>
</html>