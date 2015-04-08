<?php
require_once 'bin/CustomerEntity.php';
require_once 'bin/MyDatabase.php';
require_once 'bin/basepage.php';

header("Cache-Control: no-cache, must-revalidate");
if (session_id() == '') {
    session_start();
}
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

    echo AlertandRedirect("กรุณาเข้าระบบก่อนใช้งาน", "index.php");
}

//$customer = 1 ;
?>
<html>
    <head>
        <title>My Bakery</title>
        <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

        <!-- Custom Theme files -->
        <link href="css/style.css" rel='stylesheet' type='text/css' />
        <!-- Custom Theme files -->
        <meta name="viewport" charset="UTF-8" content="width=device-width, initial-scale=1">
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>


        <script src="js/jquery.min.js"></script>
<!--        <script type="text/javascript" src="js/move-top.js"></script>
        <script type="text/javascript" src="js/easing.js"></script>-->
        <link rel="stylesheet" href="css/etalage.css">
        <link href="css/form.css" rel="stylesheet" type="text/css" media="all" />

        <script src="js/jquery.easydropdown.js"></script>
        <script src="js/jquery.etalage.min.js"></script>
        <script>
            jQuery(document).ready(function ($) {
                $('#etalage').etalage({
                    thumb_image_width: 300,
                    thumb_image_height: 400,
                    source_image_width: 800,
                    source_image_height: 1000,
                    show_hint: true,
                    click_callback: function (image_anchor, instance_id) {
                        alert('Callback example:\nYou clicked on an image with the anchor: "' + image_anchor + '"\n(in Etalage instance: "' + instance_id + '")');
                    }
                });

            });
        </script>

        <style type="text/css">
            .divCheckbox{
                display: inline-block;
                width: 100%;
            }
            label.checkbox{
                //left:40%;
            }
        </style>
        <!----webfonts--->
        <!---//webfonts--->
    </head>
    <body  onLoad="window.history.forward()">
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
                        <li ><a href="index.php">หน้าหลัก</a></li>
                        <li class="active"><a href="cakeorder.php">ใบสั่งทำเค้ก</a></li>
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
        <div class="details">
            <div class="container">
                <div class="row single">
                    <div class="col-md-9">
                        <div class="single_left">
                            <div class="span_3_of_2" style="width: 100%">
                                <form name="cakeOrder" action="confirmOrder.php" method="POST" class="contact-form">
                                    <h3>เลือกรูปแบบตามที่ต้องการได้เล้ยยยยย</h3>
                                    <div class="det_nav" >
                                        <h4>รูปทรงเค้ก</h4>
                                        <ul>
                                            <?php
                                            $db = new MyDatabase();
                                            $sql = "SELECT * FROM piece_cake";
                                            $db->Query($sql);
                                            if ($db->Num_rows() > 0) {
                                                while ($result = $db->FetchQuery()) {
                                                    ?>
                                                    <li><a href="#">
                                                            <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($result['ORC_PIC']) . '" class="img-responsive" alt=""/>'; ?></a>
                                                        <div class="divCheckbox">
                                                            <label class="checkbox">
                                                                <input type="checkbox" name="checkPiece" value="<?php echo $result["PIECE_ID"] . "," . $result["PIECE"]; ?>" ><i></i> <?php echo $result["PIECE"]; ?>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>

                                    <div class="det_nav" id="flavorGroup">
                                        <h4>รสชาติเค้ก</h4>
                                        <ul>
                                            <?php
                                            $sql = "SELECT * FROM FLAVOR_CAKE";
                                            $db->Query($sql);
                                            if ($db->Num_rows() > 0) {
                                                while ($result = $db->FetchQuery()) {
                                                    ?>
                                                    <li><a href="#">
                                                            <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($result['ORC_PIC']) . '" class="img-responsive" alt=""/>'; ?></a>
                                                        <div class="divCheckbox">
                                                            <label class="checkbox">
                                                                <input type="checkbox" name="checkFlavor" value="<?php echo $result["FLAVOR_ID"] . "," . $result["FLAVOR"]; ?>"><i></i> <?php echo $result["FLAVOR"]; ?>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                    <div class="det_nav" id="creamGroup">
                                        <h4>ครีมหน้าเค้ก</h4>
                                        <ul>
                                            <?php
                                            $sql = "SELECT * FROM CREAM_CAKE";
                                            $db->Query($sql);
                                            if ($db->Num_rows() > 0) {
                                                while ($result = $db->FetchQuery()) {
                                                    ?>
                                                    <li><a href="#">
                                                            <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($result['CREAM_PIC']) . '" class="img-responsive" alt=""/>'; ?></a>
                                                        <div class="divCheckbox">
                                                            <label class="checkbox">
                                                                <input type="checkbox" name="checkCream" value="<?php echo $result["CREAM_ID"] . "," . $result["CREAM_NAME"]; ?>"><i></i> <?php echo $result["CREAM_NAME"]; ?>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                    <div class="det_nav" id="ToppingGroup">
                                        <h4>ท็อปปิ้ง</h4>
                                        <select name="selectTopping">
                                            <?php
                                            $sql = "SELECT * FROM TOPPINGS";
                                            $db->Query($sql);
                                            if ($db->Num_rows() > 0) {
                                                while ($result = $db->FetchQuery()) {
                                                    echo "<option value='" . $result["TOPPINGS_ID"] . "," . $result["TOP_NAME"] . "'>" . $result["TOP_NAME"] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                        <h4>ตำแหน่ง</h4>
                                        <select name="selectPosition">
                                            <?php
                                            $sql = "SELECT * FROM CAKE_POSITION";
                                            $db->Query($sql);
                                            if ($db->Num_rows() > 0) {
                                                while ($result = $db->FetchQuery()) {
                                                    echo "<option value='" . $result["POSITION_ID"] . "," . $result["POSITION"] . "," . $result["PRICE"] . "'>" . $result["POSITION"] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                        <h4>ข้อความบนเค้ก</h4>
                                        <input type="text" name="cakeMessage" style="width: 20%" />
                                        <h4>รูปแบบการส่ง</h4>
                                        <select name="selectDeliver">
                                            <?php
                                            $sql = "SELECT * FROM DELIVERy_TYPE";
                                            $db->Query($sql);
                                            if ($db->Num_rows() > 0) {
                                                while ($result = $db->FetchQuery()) {
                                                    echo "<option value='" . $result["DELIVER_ID"] . "," . $result["DELIVER_NAME"] . "'>" . $result["DELIVER_NAME"] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                        <h4>จำนวนที่ต้องการ</h4>
                                        <select name="selectAmount">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>

                                    </div>
                                    <div class="btn_form">
                                        <input id="btnOrder" type="submit" name="btnOrder" value="ถัดไป" class="submitButton">
                                        <input type="button" value="ป้อนข้อมูลใหม่" class="submitButton" style="background: #DBDADA">
                                    </div>
                                </form>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>   
                    <div class="clearfix"></div>	
                </div>
            </div>
        </div>
        <!-- /container -->

        <script>
            $(document).ready(function () {
                var btnOrder = $("#btnOrder");
                var flavorGroup = $("#flavorGroup");
                var creamGroup = $("#creamGroup");
                var ToppingGroup = $("#ToppingGroup");
                var checkPiece = $("input[name$=checkPiece]");
                var checkFlavor = $("input[name$=checkFlavor]");
                var checkCream = $("input[name$=checkCream]");
                checkPiece.each(function () {
                    $(this).change(function () {
                        checkPiece.each(function () {
                            $(this).prop('checked', false);
                        });
                        $(this).prop('checked', true);
                        flavorGroup.fadeIn("slow");
                        scrollDown(flavorGroup);
                    });
                });

                checkFlavor.each(function () {
                    $(this).change(function () {
                        checkFlavor.each(function () {
                            $(this).prop('checked', false);
                        });
                        $(this).prop('checked', true);
                        creamGroup.fadeIn("slow");
                        scrollDown(creamGroup);
                    });
                });

                checkCream.each(function () {
                    $(this).change(function () {
                        checkCream.each(function () {
                            $(this).prop('checked', false);
                        });
                        $(this).prop('checked', true);
                        ToppingGroup.fadeIn("slow");
                        scrollDown(ToppingGroup);
                        $(".btn_form").show();

                    });
                });

                flavorGroup.hide();
                creamGroup.hide();
                ToppingGroup.hide();

                $(".btn_form").hide();
            });

            function scrollDown(ele) {
                $('html,body').animate({
                    scrollTop: ele.offset().top
                }, 1000);
            }
        </script>
    </body>
</html>

