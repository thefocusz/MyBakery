<?php
require_once 'bin/CustomerEntity.php';
require_once 'bin/MyDatabase.php';
require_once 'bin/basepage.php';
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
    RedirectClient("index.php");
}

//$customer = 1 ;

if (isset($_POST["btnOrder"])) {
    $piece = explode(",", $_POST["checkPiece"]);
    $flavor = explode(",", $_POST["checkFlavor"]);
    $cream = explode(",", $_POST["checkCream"]);
    $topping = explode(",", $_POST["selectTopping"]);
    $position = explode(",", $_POST["selectPosition"]);
    $cakeMSG = $_POST["cakeMessage"];
    $position = explode(",", $_POST["selectPosition"]);
    $deliver = explode(",", $_POST["selectDeliver"]);
    $amount = $_POST["selectAmount"];

    SetCakePieceID($piece[0]);
    SetCakePieceName($piece[1]);

    SetCakeFlavorID($flavor[0]);
    SetCakeFlavorName($flavor[1]);

    SetCakeCreamID($cream[0]);
    SetCakeCreamName($cream[1]);

    SetCakeToppingID($topping[0]);
    SetCakeToppingName($topping[1]);

    SetCakePositionID($position[0]);
    SetCakePositionName($position[1]);
    SetCakePrice($position[2]);

    SetCakeMSG($cakeMSG);

    SetCakeDeliveryID($deliver[0]);
    SetCakeDeliveryName($deliver[1]);

    SetCakeAmount($amount);

    error_log("PieceID:" . GetCakePieceID());
    error_log("PieceName:" . GetCakePieceName());
    error_log("FlavorID:" . GetCakeFlavorID());
    error_log("FlavorName:" . GetCakeFlavorName());
    error_log("CreamID:" . GetCakeCreamID());
    error_log("CreamName:" . GetCakeCreamName());
    error_log("ToppingID:" . GetCakeToppingID());
    error_log("ToppingName:" . GetCakeToppingName());
    error_log("PositionID:" . GetCakePositionID());
    error_log("PostionName:" . GetCakePositionName());
    error_log("CakeMSG:" . GetCakeMSG());
    error_log("DeliveryID:" . GetCakeDeliveryID());
    error_log("DeliveryName:" . GetCakeDeliveryName());
    error_log("CakeAmount:" . GetCakeAmount());
} else if (isset($_POST["btnConfirmOrder"])) {
    $db = new MyDatabase();
    $sql = "INSERT INTO style_cake(CAKE_NAME,PIECE_ID,FLAVOR_ID,TOPPINGS_ID,POSITION_ID,CREAM_ID) ";
    $sql.= "VALUES ('" . GetCakeMSG() . "'," . GetCakePieceID() . "," . GetCakeFlavorID() . "," . GetCakeToppingID() . "," . GetCakePositionID() . "," . GetCakeCreamID() . ") ";
    error_log($sql);
    $db->Query($sql);
    error_log("result:" . $db->result);
    $insert_id = $db->Insert_ID();
    error_log($insert_id);
    $cus_id = $_SESSION["CUSTOMER"]->customerID;
    $orc_date = "CURDATE()";
    $orc_shipping = "";
    if (GetCakeDeliveryID() == 1)
        $orc_shipping = "มารับของเองที่ร้าน";
    else {
        $sql = "SELECT ORC_ADD FROM CUSTOMER WHERE CUS_ID ='" . $cus_id . "'";
        error_log($sql);
        $db->Query($sql);
        $result = $db->FetchQuery();
        $orc_shipping = $result["ORC_ADD"];
    }
    $orc_number = GetCakeAmount();
    $orc_text = GetCakeMSG();
    $orc_price = GetCakePrice();
    $style_ID = $insert_id;
    $orc_deliver = GetCakeDeliveryID();
    $orc_status = 2;

    $sql = "INSERT INTO CAKE_ORDER(ORC_DATE,ORC_SHIPPING,ORC_NUMBER,ORC_TEXT,ORC_PRICE,CUS_ID,STYLE_ID,DELIVERY_ID,ORC_STATUS) ";
    $sql .="VALUES(NOW(),'" . $orc_shipping . "'," . $orc_number . ",'" . $orc_text . "'," . $orc_price . ",'" . $cus_id . "'," . $style_ID . "," . $orc_deliver . "," . $orc_status . ")";
    error_log($sql);
    $db->Query($sql);
    echo AlertandRedirect("สั่งทำเค้กเรียบร้อย", "index.php");
} else {
    header("location:index.php");
    //echo RedirectClient("index.php");    
}
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
        <!-- no cache headers -->
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
    <body >
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
        <div class="top-grids" style="margin-top: 70px">
            <div class="container">
                <div class="col-md-4 top-grid">
                </div>
                <div class="col-md-4 top-grid"> 
                    <?php
                    $db = new MyDatabase();
                    $sql = "SELECT PIC_ID FROM CAKE_PICTURE ";
                    $sql .="WHERE PIECE_ID = 1 ";
                    $sql .="AND FLAVOR_ID = 1 ";
                    $sql .="AND CREAM_ID = 1 ";
                    $sql .="AND TOPPING_ID = 4 ";
                    $sql .="AND POSITION_ID = 1 ";

                    error_log($sql);
                    $db->Query($sql);
                    $result = $db->FetchQuery();
                    ?>
                    <div class="top-grid-info">
                        <?php
                        $db = new MyDatabase();
                        $sql = "SELECT PIC_ID FROM cake_picture ";
                        $sql .=" WHERE PIECE_ID =" . GetCakePieceID();
                        $sql .=" AND FLAVOR_ID =" . GetCakeFlavorID();
                        $sql .=" AND CREAM_ID =" . GetCakeCreamID();
                        $sql .=" AND TOPPING_ID =" . GetCakeToppingID();
                        $sql .=" AND POSITION_ID =" . GetCakePositionID();
                        error_log($sql);
                        $db->Query($sql);
                        if ($db->Num_rows() > 0) {
                            $result = $db->FetchQuery();
                            echo '<img src="data:image/jpeg;base64,' . base64_encode($result['PIC_ID']) . '" class="img-responsive" alt=""/>';
                        } else
                            echo '<img src="images/No_Image.png" class="img-responsive" alt=""/>';
                        ?>
                        <span>รายละเอียดการสั่งเค้ก</span>
                        <p>รูปร่างเค้ก : <?php echo GetCakePieceName(); ?></p>
                        <p>รสชาติเค้ก : <?php echo GetCakeFlavorName(); ?></p>
                        <p>ครีมเค้ก : <?php echo GetCakeCreamName(); ?></p>
                        <p>ท็อปปิ้ง : <?php echo GetCakeToppingName(); ?></p>
                        <p>ตำแหน่งท็อปปิ้ง : <?php echo GetCakePositionName(); ?></p>    
                        <p>ข้อความเค้ก : <?php echo GetCakeMSG(); ?></p> 
                        <p>วิธีรับเค้ก : <?php echo GetCakeDeliveryName(); ?></p> 
                        <p>จำนวน : <?php echo GetCakeAmount(); ?></p> 
                        <p>ราคารวม : <?php echo GetCakeAmount() * GetCakePrice(); ?></p> 

                        <div class="clearfix"> </div>
                        <form method="POST" action="confirmOrder.php">
                            <input id="btnConfirmOrder" type="submit" name="btnConfirmOrder" value="ยืนยัน" class="submitButton">
                            <a href="cakeorder.php?isEdit=10">
                                <input type="button" value="แก้ไข" class="submitButton" style="background: #DBDADA">
                            </a>
                        </form>
                    </div>
                </div>
                <div class="col-md-4 top-grid">

                </div>
            </div>
        </div>
        <!-- /container -->
    </body>
</html>

