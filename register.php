<?php
require 'bin/CustomerEntity.php';
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
    $isOwner = FALSE;
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
                        <li><a href="listOrder.php">รายการสั่ง</a></li>
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
                    <form id="form1" name="form1" action="register.php" method="POST"> 
                        <div class="register-top-grid">
                            <h3>กรุณากรอกข้อมูลตามที่กำหนด</h3>
                            <div class="wow fadeInLeft" data-wow-delay="0.4s">
                                <span>ชื่อ<label>*</label></span>
                                <input type="text" id="txtName" name="txtName" MaxLength="30"> 
                            </div>
                            <div class="wow fadeInRight" data-wow-delay="0.4s">
                                <span>นามสกุล<label>*</label></span>
                                <input type="text" name="txtLastName" MaxLength="30"> 
                            </div>
                            <div class="clearfix"> </div>
                            <div class="clearfix"> </div>
                            <div class="wow fadeInRight" data-wow-delay="0.4s">
                                <span>เบอร์โทรศัพท์<label>*</label></span>
                                <input type="text" name="txtTelNo" MaxLength="10"> 
                            </div>
                            <div class="wow fadeInRight" data-wow-delay="0.4s">
                                <span>ที่อยู่ในการจัดส่ง<label>*</label></span>
                                <textarea class="textAddress" MaxLength="150" type="text" name="txtAddress" style="resize: none;
                                          height: 120px"></textarea> 
                            </div>                            
                        </div>
                        <div class="clearfix"> </div>
                        <div class="clearfix"> </div>
                        <div class="register-bottom-grid login-right">
                            <h3>ข้อมูลการเข้าใช้ระบบ</h3>
                            <div class="wow fadeInLeft" data-wow-delay="0.4s">
                                <span>ชื่อผู้ใช้<label>*</label></span>
                                <input type="text" name="txtUserName" MaxLength="16">
                            </div>
                            <div  style="height: 84px">
                            </div>
                            <div style="display: inline-block;width: 100%">
                                <div class="wow fadeInLeft" data-wow-delay="0.4s">
                                    <span>รหัสผ่าน<label>*</label></span>
                                    <input type="password" id="txtPassword" name="txtPassword" MaxLength="16">
                                </div>
                                <div class="wow fadeInRight" data-wow-delay="0.4s">
                                    <span>ยืนยันรหัสผ่าน<label>*</label></span>
                                    <input type="password" name="txtConfirmPassword" MaxLength="16">
                                </div>
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

        $("#form1").validate({
            rules: {
                txtName: {required: true, minlength: 2, maxlength: 30, checkName: true},
                txtLastName: {required: true, minlength: 2, maxlength: 30, checkLastName: true},
                txtTelNo: {required: true, checkTelNo: true, minlength: 7, maxlength: 10},
                txtAddress: {required: true, minlength: 5, maxlength: 150, checkAddress: true},
                txtUserName: {required: true, minlength: 5, maxlength: 16, checkUserName: true},
                txtPassword: {required: true, minlength: 5, maxlength: 16, checkPassword: true},
                txtConfirmPassword: {required: true, minlength: 5, maxlength: 16, equalTo: "#txtPassword", checkPassword: true}
            },
            messages: {
                txtName: {required: "กรุณาระบุชื่อ", minlength: "กรุณาระบุไม่น้อยกว่า 2 ตัวอักษร", maxlength: "กรุณาระบุไม่เกิน 30 อักษร"},
                txtLastName: {required: "กรุณาระบุรหัสนามสกุล", minlength: "กรุณาระบุไม่น้อยกว่า 2 ตัวอักษร", maxlength: "กรุณาระบุไม่เกิน 30 อักษร"},
                txtTelNo: {required: "กรุณาระบุเบอร์โทร", minlength: "กรุณาระบุไม่น้อยกว่า 7 ตัวอักษร", maxlength: "กรุณาระบุไม่เกิน 10 อักษร"},
                txtAddress: {required: "กรุณาระบุที่อยู่ที่อยู่", minlength: "กรุณาระบุไม่น้อยกว่า 5 ตัวอักษร", maxlength: "กรุณาระบุไม่เกิน 150 อักษร"},
                txtUserName: {required: "กรุณาระบุชื่อผู้ใช้", minlength: "กรุณาระบุไม่น้อยกว่า 5 ตัวอักษร", maxlength: "กรุณาระบุไม่เกิน 16 อักษร"},
                txtPassword: {required: "กรุณาระบุรหัสผ่าน", minlength: "กรุณาระบุไม่น้อยกว่า 5 ตัวอักษร", maxlength: "กรุณาระบุไม่เกิน 16 อักษร"},
                txtConfirmPassword: {required: "กรุณาระบุยืนยันรหัส", minlength: "กรุณาระบุไม่น้อยกว่า 5 ตัวอักษร", maxlength: "กรุณาระบุไม่เกิน 16 อักษร", equalTo: "ระบุรหัสผ่านให้ตรงกัน"},
            }
        });

        $.validator.addMethod("checkName", function (value, element) {
            //No idea what to call here
            var _pattern = 'กขฃคฅฆงจฉชซฌญฎฏฐฑฒณดตถทธนบปผฝพฟภมยรฤลฦวศษสหฬอฮฯะัาำิีึืุู฿ฺเแโใไๅๆ็่้๋๊์ํ๎๏';
            var _value = value;
            var _result = true;

            for (var i = 0; i < _value.length; i++) {
                if (_pattern.indexOf(_value.charAt(i)) < 0)
                    _result = false;
            }
            return _result;
        }, 'กรุณาระบุชื่อให้ถูกต้อง');

        $.validator.addMethod("checkLastName", function (value, element) {
            //No idea what to call here
            var _pattern = 'กขฃคฅฆงจฉชซฌญฎฏฐฑฒณดตถทธนบปผฝพฟภมยรฤลฦวศษสหฬอฮฯะัาำิีึืุู฿ฺเแโใไๅๆ็่้๋๊์ํ๎๏';
            var _value = value;
            var _result = true;

            for (var i = 0; i < _value.length; i++) {
                if (_pattern.indexOf(_value.charAt(i)) < 0)
                    _result = false;
            }
            return _result;
        }, 'กรุณาระบุนามสกุลให้ถูกต้อง');

        $.validator.addMethod("checkTelNo", function (value, element) {
            //No idea what to call here
            return /^\d+$/.test(value);
        }, 'กรุณาระบุเบอร์โทรศัพท์ให้ถูกต้อง');


        $.validator.addMethod("checkAddress", function (value, element) {
            //No idea what to call here
            var _pattern = ' 1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZกขฃคฅฆงจฉชซฌญฎฏฐฑฒณดตถทธนบปผฝพฟภมยรฤลฦวศษสหฬอฮฯะัาำิีึืฺุูเแโใไๅๆ็่้๋๊์ํ๎๏';
            var _value = value;
            var _result = true;

            for (var i = 0; i < _value.length; i++) {
                if (_pattern.indexOf(_value.charAt(i)) < 0)
                    _result = false;
            }
            return _result;
        }, 'กรุณาระบุที่อยู่ให้ถูกต้อง');

        $.validator.addMethod("checkUserName", function (value, element) {
            //No idea what to call here
            return /^[A-Za-z0-9_-]{5,16}$/.test(value);
        }, 'กรุณาระบุชื่อผู้ใช้ให้ถูกต้อง');
        $.validator.addMethod("checkPassword", function (value, element) {
            //No idea what to call here
            return /^[A-Za-z0-9_-]{5,16}$/.test(value);
        }, 'กรุณาระบุรหัสผ่านให้ถูกต้อง');
    });



</script>

<?php
try {
    if (isset($_POST["btnSubmit"])) {
//    $db = new MyDatabase() ;
//    $sql = "INSERT INTO customer(CUS_ID,NAME_LAST,ORC_ADD,ORC_TEL,PWD)";
//    $sql .= "VALUES('ADMIN','FIRST LASTNAME','1234','0841234455','PASSWORD')";
//    $db->ExcuteNonQuery($sql) ;
        $custEnt = new CustomerEntity();
        $custEnt->customerID = !empty($_POST["txtUserName"]) ? $_POST["txtUserName"] : NULL;
        $custEnt->customerName = (!empty($_POST["txtName"]) && !empty($_POST["txtLastName"]) ) ? ($_POST["txtName"] . " " . $_POST["txtLastName"]) : NULL;
        $custEnt->ORC_Address = !empty($_POST["txtAddress"]) ? $_POST["txtAddress"] : NULL;
        $custEnt->ORC_Tel = !empty($_POST["txtTelNo"]) ? $_POST["txtTelNo"] : NULL;
        if (!empty($_POST["txtPassword"]) && !empty($_POST["txtConfirmPassword"])) {
            $custEnt->custPasword = $_POST["txtPassword"];
            $custEnt->custConfirmPassword = $_POST["txtConfirmPassword"];
        } else {
            $custEnt->custPasword = NULL;
            $custEnt->custConfirmPassword = NULL;
        }
        $result = $custEnt->RegisCustomer();
    } else {
        
    }
} catch (Exception $e) {
    echo "<script> alert('" . $e->getMessage() . "') </script>";
}
?>

<?php
if (isset($result) && $result != "success") {
    ?>
    <script>
        $(document).ready(function () {
            $("[name$=txtName]").val('<?php echo $_POST["txtName"]; ?>');
            $("[name$=txtLastName]").val('<?php echo $_POST["txtLastName"]; ?>');
            $("[name$=txtUserName]").val('<?php echo $_POST["txtUserName"]; ?>');
            $("[name$=txtAddress]").val('<?php echo $_POST["txtAddress"]; ?>');
            $("[name$=txtTelNo]").val('<?php echo $_POST["txtTelNo"]; ?>');
            alert("<?php echo $result; ?>")
        });

    </script>
<?php } else if (isset($result)) { ?>
    <script>
        alert('สมัครสมาชิกเรียบร้อย');
        window.location.href = "index.php";
    </script>
<?php } ?>

