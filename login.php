<?php
require 'bin/CustomerEntity.php';
//
//$cusEntity = new CustomerEntity();
//$cusEntity->customerID = "Admin" ;
//$_SESSION["CUSTOMER"] = $cusEntity ;


if (isset($_SESSION["CUSTOMER"])) {
    $customer = $_SESSION["CUSTOMER"]; //Cast('CustomerEntity',$_SESSION["CUSTOMER"]) ;
    $isOwner = $customer->customerID == "Admin" ? TRUE : FALSE;
} else {
    unset($customer);
    $isOwner = FALSE;
}
//$customer = 1 ;
?>
<?php
if (isset($_POST["btnLogin"])) {
    $custEnt = new CustomerEntity();
    $result = $custEnt->CustomerLogin($_POST["username"], $_POST["password"]);
    if ($result instanceof CustomerEntity) {
        session_start();
        $_SESSION["CUSTOMER"] = $result;
        header("Location:index.php");
        //die();
    } else {
        echo "<script> alert('กรุณาระบุชื่อผู้ใช้และรหัสผ่านให้ถูกต้อง'); </script>";
    }
}
else
    session_unset();

if (session_id() == PHP_SESSION_NONE) {
    session_start();
} else {
    //session_destroy(); 
}
?>
<html>
    <head>
        <title>My Bakery</title>
        <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.validate.js"></script>
        <!-- Custom Theme files -->
        <link href="css/style.css" rel='stylesheet' type='text/css' />
        <!-- Custom Theme files -->
        <meta name="viewport" charset="UTF-8" content="width=device-width, initial-scale=1">
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    </script>
    <!----webfonts--->
    <!---//webfonts--->
</head>
<body>
    <!-- container -->
    <!-- top-header -->
    <div class="top-header">
        <div class="container">
            <div class="top-header-left" style="width: 50%">
                <ul>
                    <li><a href="myaccount.php">
                        </a></li>
                    <div class="clearfix"> </div>
                </ul>
            </div>
            <div class="top-header-center">
                <p></p>
            </div>
            <div class="top-header-right">
                <?php if (!isset($customer)) { ?>				
                    <ul style="left: 30%">
                        <li><a href="login.php">เข้าสู่ระบบ</a></li>
                        <li><a href="register.php">สมัครสมาชิก</a></li>
                    </ul>
                <?php } else { ?>
                    <ul style="left: 30%">
                        <li><a href="myaccount.php">ข้อมูลสมาชิก</a></li>
                        <li><a href="logout.php">ออกจากระบบ</a></li>
                    </ul>
                <?php } ?>
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>
    <!-- /top-header -->
    <!-- main-menu -->
    <div class="main-menu">
        <div class="container">
            <div class="head-nav">
                <span class="menu"> </span>
                <ul style="font-size: 90%">
                    <li><a href="index.php">หน้าหลัก</a></li>
                    <li><a href="cakeorder.php">ใบสั่งทำเค้ก</a></li>
                    <?php if ($isOwner) { ?>
                        <li><a href="index.php">รายงาน</a></li>
                    <?php } ?>
                    <li><a href="about.php">เกี่ยวกับผู้จัดทำ</a></li>
                    <div class="clearfix"> </div>
                </ul>
            </div>	
            <!-- script-for-nav -->
            <script>
                $("span.menu").click(function () {
                    $(".head-nav ul").slideToggle(300, function () {
                        // Animation complete.
                    });
                });
                $(window).resize(function () {
                    if ($(window).width() > 768)
                        $(".head-nav ul").css("display", "block");
                    else
                        $(".head-nav ul").css("display", "none");

                });
            </script>
            <!-- script-for-nav -->
            <!-- logo -->
            <div class="logo" style="left: 42%">
                <a href="index.php"><img src="images/bakerylogo.png" title="Sweetcake" /></a>
            </div>
            <!-- logo -->
        </div>
    </div>
    <!-- /main-menu -->
    <div class="content">
        <div class="container">
            <div class="login-page">
                <div class="account_grid">
                    <div style="margin-right: auto;margin-left: auto;width: 50%" class=" login-right wow fadeInRight" data-wow-delay="0.4s" >
                        <h3>สำหรับลูกค้าที่ลงทะเบียนแล้ว</h3>
                        <form action="login.php" method="POST" id="loginForm" autocomplete="off">
                            <div>
                                <span style="font-size: 14px;">ชื่อผู้ใช้งาน<label>*</label></span>
                                <input type="text" name="username" id="username"> 
                            </div>
                            <div>
                                <span style="font-size: 14px;">รหัสผ่าน<label>*</label></span>
                                <input type="password" name="password" id="password"> 
                            </div>
                            <input type="submit" name="btnLogin" value="Login">
                        </form>
                    </div>	
                    <div class="clearfix"> </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /container -->

    <script>
        $(document).ready(function () {
            $("#loginForm").validate({
                rules: {
                    username: {minlength: 5, required: true, checkUserName: true},
                    password: {minlength: 5, required: true, checkPassword: true}
                },
                messages: {
                    username: {minlength: "กรุณาระบุชื่อผู้ใช้ให้ถูกต้อง", required: "กรุณาระบุชื่อผู้ใช้"},
                    password: {minlength: "กรุณาระบุรหัสผ่านให้ถูกต้อง", required: "กรุณาระบุรหัสผ่าน"}
                }
            });
        });

        $.validator.addMethod("checkUserName", function (value, element) {
            //No idea what to call here
            return /^[A-Za-z0-9_-]{5,16}$/.test(value);
        }, 'กรุณาระบุชื่อผู้ใช้ให้ถูกต้อง');
        $.validator.addMethod("checkPassword", function (value, element) {
            //No idea what to call here
            return /^[A-Za-z0-9_-]{5,16}$/.test(value);
        }, 'กรุณาระบุรหัสผ่านให้ถูกต้อง');
    </script>
</body>
</html>


