<?php
require_once 'bin/CustomerEntity.php'; //เพิ่มไฟล์ customer
require_once 'bin/MyDatabase.php';

session_start();
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
if (isset($_POST["idOrder"])) {
    error_log("OrderPost:" . $_POST["idOrder"]);
    $db = new MyDatabase();
    $sql = "UPDATE CAKE_ORDER SET ORC_STATUS=1 WHERE ORC_ID =" . $_POST["idOrder"];
    error_log($sql);
    $db->Query($sql);

    $sql = "INSERT INTO receipt(ORC_RECEIPT, TOTAL_PRICE, RECEIPT_DATE) ";
    $sql.= "SELECT ORC_ID,ORC_NUMBER * ORC_PRICE ,NOW() FROM cake_order WHERE orc_id =" . $_POST["idOrder"];
    error_log($sql);
    $db->Query($sql);
}
?>

<html>
    <head>
        <title>My Bakery</title>
        <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="js/jquery-1.11.2.min.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <!-- Custom Theme files -->
        <link href="css/jquery.dataTables.css" rel='stylesheet' type='text/css' />
        <!-- Custom Theme files -->
        <meta name="viewport" charset="UTF-8" content="width = device-width, initial-scale = 1">
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    </script>
    <!----webfonts--->
    <!---//webfonts--->
</head>
<body>
    <style type="text/css">
        th{
            text-align: center;
        }
    </style>
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
                <ul style="font-size: 90%;
                    ">
                    <li ><a href="index.php">หน้าหลัก</a></li>
                    <li><a href="cakeorder.php">ใบสั่งทำเค้ก</a></li>
                    <?php if ($isOwner) { ?>
                        <li class="active"><a href="listOrder.php">รายการสั่ง</a></li>
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
                    //$("#log").append("<div>Handler for .resize() called.</div>");
                    if ($(window).width() > 768)
                        $(".head-nav ul").css("display", "block");
                    else
                        $(".head-nav ul").css("display", "none");
                });</script>
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
            <H1>รายการที่ยังไม่สั่งทำ</h1>
            <?php
            $db = new MyDatabase();
            $sql = "SELECT * FROM STYLE_CAKE,PIECE_CAKE,FLAVOR_CAKE,CREAM_CAKE,TOPPINGS,CAKE_POSITION,CAKE_ORDER,customer ";
            $sql .= "WHERE STYLE_CAKE.PIECE_ID = PIECE_CAKE.PIECE_ID ";
            $sql .= "AND STYLE_CAKE.FLAVOR_ID = FLAVOR_CAKE.FLAVOR_ID ";
            $sql .= "AND STYLE_CAKE.CREAM_ID = CREAM_CAKE.CREAM_ID ";
            $sql .= "AND STYLE_CAKE.TOPPINGS_ID = TOPPINGS.TOPPINGS_ID ";
            $sql .= "AND STYLE_CAKE.POSITION_ID = CAKE_POSITION.POSITION_ID ";
            $sql .= "AND STYLE_CAKE.STYLE_ID = CAKE_ORDER.STYLE_ID ";
            $sql .= "AND CAKE_ORDER.CUS_ID = customer.CUS_ID ";
            $sql .="AND CAKE_ORDER.ORC_STATUS = 2 ";
            $sql .="ORDER BY ORC_DATE DESC ";
            error_log("List order " . $sql);
            $db->Query($sql);
            ?>
            <table id="listorder_table" class="display">
                <thead>
                    <tr>
                        <th>วันที่สั่ง</th>
                        <th>ชื่อผู้สั่ง</th>
                        <th>รายละเอียดเค้ก</th>
                        <th>ที่จัดส่ง</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($db->Num_rows() > 0) {
                        while ($result = $db->FetchQuery()) {
                            echo "<tr>";
                            echo "<td>" . $result["ORC_DATE"] . "</td>";
                            echo "<td>" . $result["NAME_LAST"] . "</td>";
                            echo "<td>" . "รูปร่าง:" . $result["PIECE"] . " รส:" . $result["FLAVOR"] . " ครีม: " . $result["CREAM_NAME"] . " ท็อปปิ้ง: " . $result["TOP_NAME"] . " " . $result["POSITION"] . "</td>";
                            echo "<td>" . $result["ORC_SHIPPING"] . "</td>";
                            echo "<td>"
                            . "<form action='listOrder.php' method='POST'>"
                            . "<input type='button' name='btnConfirm' value='สั่งทำเค้ก' onclick='clickforsubmit($(this));'/>"
                            . "<input type='hidden' name='idOrder' value='" . $result["ORC_ID"] . "' />"
                            . "</form>"
                            . "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>

            <H1>รายการสั่งทำแล้ว</h1>
            <?php
            $db = new MyDatabase();
            $sql = "SELECT * FROM STYLE_CAKE,PIECE_CAKE,FLAVOR_CAKE,CREAM_CAKE,TOPPINGS,CAKE_POSITION,CAKE_ORDER,customer ";
            $sql .= "WHERE STYLE_CAKE.PIECE_ID = PIECE_CAKE.PIECE_ID ";
            $sql .= "AND STYLE_CAKE.FLAVOR_ID = FLAVOR_CAKE.FLAVOR_ID ";
            $sql .= "AND STYLE_CAKE.CREAM_ID = CREAM_CAKE.CREAM_ID ";
            $sql .= "AND STYLE_CAKE.TOPPINGS_ID = TOPPINGS.TOPPINGS_ID ";
            $sql .= "AND STYLE_CAKE.POSITION_ID = CAKE_POSITION.POSITION_ID ";
            $sql .= "AND STYLE_CAKE.STYLE_ID = CAKE_ORDER.STYLE_ID ";
            $sql .= "AND CAKE_ORDER.CUS_ID = customer.CUS_ID ";
            $sql .="AND CAKE_ORDER.ORC_STATUS = 1 ";
            $sql .="ORDER BY ORC_DATE DESC ";
            error_log("List order " . $sql);
            $db->Query($sql);
            ?>
            <table id="listOrdered_table" class="display">
                <thead>
                    <tr>
                        <th>วันที่สั่ง</th>
                        <th>ชื่อผู้สั่ง</th>
                        <th>รายละเอียดเค้ก</th>
                        <th>ที่จัดส่ง</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($db->Num_rows() > 0) {
                        while ($result = $db->FetchQuery()) {
                            echo "<tr>";
                            echo "<td>" . $result["ORC_DATE"] . "</td>";
                            echo "<td>" . $result["NAME_LAST"] . "</td>";
                            echo "<td>" . "รูปร่าง:" . $result["PIECE"] . " รส:" . $result["FLAVOR"] . " ครีม: " . $result["CREAM_NAME"] . " ท็อปปิ้ง: " . $result["TOP_NAME"] . " " . $result["POSITION"] . "</td>";
                            echo "<td>" . $result["ORC_SHIPPING"] . "</td>";
                            echo "<td style='width:12%;text-align:center'>"
                            . "<a href='export.php?order=" . $result["ORC_ID"] . "' target='_blank' style='font-size:0.9em;padding: 5px 7px;'>ใบสั่ง</a> "
                            . "<a href='export.php?receipt=" . $result["ORC_ID"] . "' target='_blank' style='font-size:0.9em;padding: 5px 7px;'>ใบเสร็จ</a> "
                            . "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#listorder_table').DataTable({"oLanguage": {"sEmptyTable": "ไม่มีข้อมูลการสั่งซื้อ"}, "bSort": false});
            $('#listOrdered_table').DataTable({"oLanguage": {"sEmptyTable": "ไม่มีข้อมูลการสั่งซื้อ"}, "bSort": false});

            //$('#listorder_table').DataTable();
        });

        function clickforsubmit(ele) {
            ele.closest("form").submit();
        }
    </script>
    <!-- /container -->
</body>
</html>

