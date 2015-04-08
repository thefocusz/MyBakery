<?php
require_once 'bin/CustomerEntity.php'; //เพิ่มไฟล์ customer
require_once 'bin/MyDatabase.php';
require_once 'bin/basepage.php';

//session_start();
//
//$cusEntity = new CustomerEntity();
//$cusEntity->customerID = "Admin" ;
//$_SESSION["CUSTOMER"] = $cusEntity ;


if (isset($_SESSION["CUSTOMER"])) {
    $customer = $_SESSION["CUSTOMER"]; //Cast('CustomerEntity',$_SESSION["CUSTOMER"]) ;
    $isOwner = $customer->customerID == "Admin" ? TRUE : FALSE;
} else {
    unset($customer);
    unset($_SESSION["CUSTOMER"]);
    $isOwner = FALSE;
}

//$customer = 1 ;
?>

<html>
    <head>
        <title>My Bakery</title>
        <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="js/jquery.min.js"></script>
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
                <ul style="font-size: 90%;">
                    <li ><a href="index.php">หน้าหลัก</a></li>
                    <li><a href="cakeorder.php">ใบสั่งทำเค้ก</a></li>
                    <?php if ($isOwner) { ?>
                        <li><a href="listOrder.php">รายการสั่ง</a></li>
                        <li class="active"><a href="report.php">รายงาน</a></li>
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
                    //$("#log").append("<div>Handler for .resize() called.</div>");
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
    <div class="about">
        <div class="container">
            <h1>กรุณเลือกเดือนที่ต้องการออกรายงาน</h1>
            <form action="export.php" method="POST" target="_blank" >
                <?php
                $db = new MyDatabase();
                $sql = "SELECT DISTINCT MONTH(RECEIPT_DATE) MONTHNO,YEAR(RECEIPT_DATE) YEAR FROM RECEIPT";
                error_log($sql);
                $db->Query($sql);
                if ($db->Num_rows() > 0) {
                    echo "<select name='selectReport' style='margin-right:20px'>";
                    while ($result = $db->FetchQuery()) {
                        echo "<option value='" . $result["MONTHNO"] . "," . $result["YEAR"] . "'>" . MonthNameThai($result["MONTHNO"]) . " " . $result["YEAR"] . "</option>";
                    }
                    echo "</select>";
                    echo "<input type='submit' name='report' value='ตกลง' /> ";
                } else {
                    echo "<H2>ไม่มีรายการ</H2>";
                }
                ?>
            </form>
        </div>
    </div>
    <!-- /container -->
</body>
</html>

