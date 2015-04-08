<?php
require 'bin/CustomerEntity.php';
session_start();
//
//$cusEntity = new CustomerEntity();
//$cusEntity->customerID = "Admin" ;
//$_SESSION["CUSTOMER"] = $cusEntity ;

$customer;
if (isset($_SESSION["CUSTOMER"])) {
    $customer = $_SESSION["CUSTOMER"]; //Cast('CustomerEntity',$_SESSION["CUSTOMER"]) ;
    $isOwner = $customer->customerID == "Admin" ? TRUE : FALSE;
} else {
    unset($customer);
    unset($_SESSION["CUSTOMER"]);
    $isOwner = FALSE;
    header("Location:index.php");
}
?>
<?php
try {
    if (isset($_POST["btnSubmit"])) {
        $isSuccess = true;
        $active = isset($_POST['active']) ? "TRUE" : "FALSE";
        $active = $active === "TRUE";
        error_log("isChangePassword:" . $active);
        $customerEntity = new CustomerEntity();
        $ssCustomer = $_SESSION["CUSTOMER"];
        $customerEntity->customerID = $ssCustomer->customerID;
        $customerEntity->customerName = $_POST["txtName"];
        $customerEntity->ORC_Tel = $_POST["txtTelNo"];
        $customerEntity->ORC_Address = $_POST["txtAddress"];
        if ($active) {
            $customerEntity->custOldPassword = $_POST["txtOldPassword"];
            $customerEntity->custPasword = $_POST["txtPassword"];
            $customerEntity->custConfirmPassword = $_POST["txtConfirmPassword"];
            if ($customerEntity->custPasword != $customerEntity->custConfirmPassword) {
                echo "<script> alert('กรุณากรอก รหัสผ่าน และ ยืนยันรหัสผ่านให้ตรงกัน') </script>";
                $isSuccess = FALSE;
            }
        }
        if ($isSuccess) {
            $isSuccess = $customerEntity->ChangeUserProfile($active);
            if ($isSuccess) {
                $_SESSION["CUSTOMER"] = $customerEntity;
                header("Location:index.php");
            } else {
                echo "<script> alert('ไม่สามารถเปลี่ยนข้อมูลได้เนื่องจากข้อมูลไม่ถูกต้อง') </script>";
            }
        }
    }
} catch (Exception $e) {
    echo "<script> alert('" . $e->getMessage() . "') </script>";
}
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
                <ul style="font-size: 90%">
                    <li><a href="index.php">หน้าหลัก</a></li>
                    <li><a href="cakeorder.php">ใบสั่งทำเค้ก</a></li>
                    <?php if ($isOwner) { ?>
                        <li><a href="listOrder.php">รายการสั่ง</a></li>
                        <li><a href="report.php">รายงาน</a></li>
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
        <div class="main">
            <div class="container">
                <div class="register">
                    <form id="form1" name="form1" action="myaccount.php" method="POST"> 
                        <div class="register-top-grid">
                            <h3>กรุณากรอกข้อมูลตามที่กำหนด</h3>
                            <div class="wow fadeInLeft" data-wow-delay="0.4s">
                                <span>ชื่อ นามสกุล<label>*</label></span>
                                <input type="text" name="txtName" value='<?php echo $customer->customerName; ?>'> 
                            </div>
                            <div class="wow fadeInRight" data-wow-delay="0.4s" style="height: 68px">
                            </div>
                            <div class="wow fadeInRight" data-wow-delay="0.4s">
                                <span>เบอร์โทรศัพท์<label>*</label></span>
                                <input type="text" name="txtTelNo" value='<?php echo $customer->ORC_Tel; ?>'> 
                            </div>
                            <div class="wow fadeInRight" data-wow-delay="0.4s">
                                <span>ที่อยู่ในการจัดส่ง<label>*</label></span>
                                <textarea class="textAddress" type="text" name="txtAddress" style="resize: none;
                                          height: 120px" ><?php echo $customer->ORC_Address; ?></textarea> 
                            </div>
                            <div class="clearfix"> </div>
                            <div class="clearfix"> </div>
                        </div>
                        <div class="register-bottom-grid login-right">
                            <h3>ข้อมูลการเข้าใช้ระบบ</h3>
                            <div class="wow fadeInLeft" data-wow-delay="0.4s">
                                <span>ชื่อผู้ใช้</span>
                                <input type="text" name="txtUserName" readonly value='<?php echo $customer->customerID; ?>'>
                            </div>
                            <div  style="height: 68px">
                            </div>
                            <div class="clearfix"> </div>
                            <a class="news-letter" href="#">
                                <label class="checkbox"><input id="changePassword" type="checkbox" name="active"><i> </i>ต้องการเปลี่ยนรหัสผ่านหรือไม่</label>
                            </a>
                            <div class="clearfix"></div>
                            <div class="clearfix"></div>
                            <div class="wow fadeInLeft" data-wow-delay="0.4s" name="divPassword">
                                <span>รหัสผ่านเดิม<label>*</label></span>
                                <input type="password" name="txtOldPassword">
                            </div>
                            <div class="clearfix"></div>
                            <div class="clearfix"></div>
                            <div class="clearfix"></div>
                            <div class="clearfix"></div>
                            <div class="wow fadeInLeft" data-wow-delay="0.4s" name="divPassword">
                                <span>รหัสผ่านใหม่<label>*</label></span>
                                <input type="password" name="txtPassword">
                            </div>
                            <div class="wow fadeInRight" data-wow-delay="0.4s" name="divPassword">
                                <span>ยืนยันรหัสผ่านใหม่<label>*</label></span>
                                <input type="password" name="txtConfirmPassword">
                            </div>
                        </div>

                        <input id="btnSubmit" type="submit" name="btnSubmit" style="display: none" />
                    </form>
                    <div class="clearfix"> </div>
                    <div class="register-but">
                        <form>
                            <input class="submitButton" id="btnRegister" type="button" value="ยืนยัน" name = "submit">
                            <div class = "clearfix"> </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/container -->
</body>
</html>
<script>
    $(document).ready(function () {
        $("#btnRegister").click(function () {
            //validate
            $("#btnSubmit").click();
        });
        
        if(!$("#changePassword").prop("checked"))
            $("div[name$='divPassword']").hide();
        
        $("#changePassword").change(function () {
            var isChecked = $(this).prop("checked");
            if (isChecked) {
                $("div[name$='divPassword']").show();
            }
            else {
                $("div[name$='divPassword']").hide();
            }
        });
    });

</script>

