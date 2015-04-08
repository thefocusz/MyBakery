<?php

require_once 'bin/MyDatabase.php';
require_once 'bin/basepage.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
echo "<script> window.print(); </script>";
if (isset($_GET["order"])) {
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $db = new MyDatabase();
    $sql = "SELECT * FROM STYLE_CAKE,PIECE_CAKE,FLAVOR_CAKE,CREAM_CAKE,TOPPINGS,CAKE_POSITION,CAKE_ORDER,customer ";
    $sql .= "WHERE STYLE_CAKE.PIECE_ID = PIECE_CAKE.PIECE_ID ";
    $sql .= "AND STYLE_CAKE.FLAVOR_ID = FLAVOR_CAKE.FLAVOR_ID ";
    $sql .= "AND STYLE_CAKE.CREAM_ID = CREAM_CAKE.CREAM_ID ";
    $sql .= "AND STYLE_CAKE.TOPPINGS_ID = TOPPINGS.TOPPINGS_ID ";
    $sql .= "AND STYLE_CAKE.POSITION_ID = CAKE_POSITION.POSITION_ID ";
    $sql .= "AND STYLE_CAKE.STYLE_ID = CAKE_ORDER.STYLE_ID ";
    $sql .= "AND CAKE_ORDER.CUS_ID = customer.CUS_ID ";
    $sql .="AND ORC_ID =" . $_GET["order"] . " ";
    $sql .="ORDER BY ORC_DATE DESC ";
    error_log("Export Order " . $sql);
    $db->Query($sql);
    $result = $db->FetchQuery();

    $sql = " SELECT * FROM CAKE_PICTURE ";
    $sql .= "WHERE PIECE_ID = " . $result["PIECE_ID"] . " ";
    $sql .= "AND FLAVOR_ID = " . $result["FLAVOR_ID"] . " ";
    $sql .= "AND CREAM_ID = " . $result["CREAM_ID"] . " ";
    $sql .= "AND TOPPING_ID = " . $result["TOPPINGS_ID"] . " ";
    $sql .= "AND POSITION_ID = " . $result["POSITION_ID"] . " ";
    $db->Query($sql);
    $result2 = $db->FetchQuery();
    $imgStr = "";
    if ($db->Num_rows() > 0)
        $imgStr .= '<img src="data:image/jpeg;base64,' . base64_encode($result2['PIC_ID']) . '" style="width:100%" class="img-responsive" alt=""/>';
    else
        $imgStr .= "<img style='width:30%' src='images/No_Image.png' class='img-responsive' alt=''/>";
    $html = <<<EOD
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Cake Order</title>
    <link rel="stylesheet" href="report/style.css" media="all" />
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="images/bakerylogo.png">
      </div>
      <h1>ใบสั่งทำเค้ก</h1>
      <div id="company" class="clearfix">
        <div>MyBakery</div>
        <div>ที่อยู่</div>
        <div>0841234568</div>
        <div><a href="mailto:mybakery@gmail.com">mybakery@gmail.com</a></div>
      </div>
      <div id="project">
EOD;
    $html.="
        <div><span>ชื่อลูกค้า</span>" . $result["NAME_LAST"] . "</div>
        <div><span>ที่อยู่</span>" . $result["ORC_ADD"] . "</div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class='service'>วันที่สั่ง</th>
            <th class='desc'>รายละเอียดเค้ก</th>
            <th class='desc'>จำนวนที่สั่ง</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class='service'>" . $result["ORC_DATE"] . "</td>
            <td class='desc'>" . "รูปร่าง:" . $result["PIECE"] . " รส:" . $result["FLAVOR"] . " ครีม: " . $result["CREAM_NAME"] . " ท็อปปิ้ง: " . $result["TOP_NAME"] . " " . $result["POSITION"] . "</td>
            <td class='unit'>" . $result["ORC_NUMBER"] . "</td>
          </tr>
        </tbody>
      </table>
      <div id='notices' style='margin-left:auto;margin-right:auto;width:60%;'>"
            . $imgStr .
            "</div>
    </main>
        <input type='button' value='พิมพ์' onclick='window.print()'/>
        <input type='button' value='ปิดหน้า' onclick='window.close()'/>
  </body>
</html>";

    echo $html;
}
else if (isset($_GET["receipt"])) {
    $db = new MyDatabase();
    $sql = "SELECT * FROM STYLE_CAKE,PIECE_CAKE,FLAVOR_CAKE,CREAM_CAKE,TOPPINGS,CAKE_POSITION,CAKE_ORDER,customer,RECEIPT ";
    $sql .= "WHERE STYLE_CAKE.PIECE_ID = PIECE_CAKE.PIECE_ID ";
    $sql .= "AND STYLE_CAKE.FLAVOR_ID = FLAVOR_CAKE.FLAVOR_ID ";
    $sql .= "AND STYLE_CAKE.CREAM_ID = CREAM_CAKE.CREAM_ID ";
    $sql .= "AND STYLE_CAKE.TOPPINGS_ID = TOPPINGS.TOPPINGS_ID ";
    $sql .= "AND STYLE_CAKE.POSITION_ID = CAKE_POSITION.POSITION_ID ";
    $sql .= "AND STYLE_CAKE.STYLE_ID = CAKE_ORDER.STYLE_ID ";
    $sql .= "AND CAKE_ORDER.CUS_ID = customer.CUS_ID ";
    $sql.="AND CAKE_ORDER.ORC_ID = receipt.ORC_RECEIPT ";
    $sql .="AND ORC_ID =" . $_GET["receipt"] . " ";
    $sql .="ORDER BY ORC_DATE DESC ";
    error_log("Export Order " . $sql);
    $db->Query($sql);
    $result = $db->FetchQuery();

    $sql = " SELECT * FROM CAKE_PICTURE ";
    $sql .= "WHERE PIECE_ID = " . $result["PIECE_ID"] . " ";
    $sql .= "AND FLAVOR_ID = " . $result["FLAVOR_ID"] . " ";
    $sql .= "AND CREAM_ID = " . $result["CREAM_ID"] . " ";
    $sql .= "AND TOPPING_ID = " . $result["TOPPINGS_ID"] . " ";
    $sql .= "AND POSITION_ID = " . $result["POSITION_ID"] . " ";
    $db->Query($sql);
    $result2 = $db->FetchQuery();
    $imgStr = "";
    if ($db->Num_rows() > 0)
        $imgStr .= '<img src="data:image/jpeg;base64,' . base64_encode($result2['PIC_ID']) . '" style="width:100%" class="img-responsive" alt=""/>';
    else
        $imgStr .= "<img style='width:30%' src='images/No_Image.png' class='img-responsive' alt=''/>";
    $html = <<<EOD
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Cake Invoice</title>
    <link rel="stylesheet" href="report/style.css" media="all" />
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="images/bakerylogo.png">
      </div>
      <h1>ใบเสร็จรับเงิน</h1>
      <div id="company" class="clearfix">
        <div>MyBakery</div>
        <div>ที่อยู่</div>
        <div>0841234568</div>
        <div><a href="mailto:mybakery@gmail.com">mybakery@gmail.com</a></div>
      </div>
      <div id="project">
EOD;
    $html.="
        <div><span>ชื่อลูกค้า</span>" . $result["NAME_LAST"] . "</div>
        <div><span>ที่อยู่</span>" . $result["ORC_ADD"] . "</div>
            <div><span>วันที่สั่ง</span>" . $result["ORC_DATE"] . "</div>
                <div><span>รหัสใบเสร็จ</span>" . "Ref" . str_pad($result["ORC_RECEIPT"], 7, "0", STR_PAD_LEFT) . "</div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class='desc'>รายละเอียดเค้ก</th>
            <th class='desc'>จำนวนที่สั่ง</th>
            <th class='desc'>ราคา(ต่อชิ้น)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class='desc'>" . "รูปร่าง:" . $result["PIECE"] . " รส:" . $result["FLAVOR"] . " ครีม: " . $result["CREAM_NAME"] . " ท็อปปิ้ง: " . $result["TOP_NAME"] . " " . $result["POSITION"] . "</td>
            <td class='unit'>" . $result["ORC_NUMBER"] . "</td>
                <td class='unit'>" . $result["ORC_PRICE"] . "</td>
          </tr>
          <tr>
            <td colspan='2' class='grand total'>ราคารวมทั้งหมด</td>
            <td class='grand total'>" . $result["TOTAL_PRICE"] . "</td>
          </tr>
        </tbody>
      </table>
      <div id='notices' >"
            . // $imgStr .
            "</div>
    </main>
    <input type='button' value='พิมพ์' onclick='window.print()'/>
    <input type='button' value='ปิดหน้า' onclick='window.close()'/>
  </body>
</html>";

    echo $html;
}
else if (isset($_POST["report"])) {
//echo $_POST["selectReport"];
    $key = explode(",", $_POST["selectReport"]);
    $db = new MyDatabase();
    $sql = "SELECT * FROM STYLE_CAKE,PIECE_CAKE,FLAVOR_CAKE,CREAM_CAKE,TOPPINGS,CAKE_POSITION,CAKE_ORDER,customer,receipt ";
    $sql .= "WHERE STYLE_CAKE.PIECE_ID = PIECE_CAKE.PIECE_ID  ";
    $sql .= "AND STYLE_CAKE.FLAVOR_ID = FLAVOR_CAKE.FLAVOR_ID   ";
    $sql .= "AND STYLE_CAKE.CREAM_ID = CREAM_CAKE.CREAM_ID   ";
    $sql .= "AND STYLE_CAKE.TOPPINGS_ID = TOPPINGS.TOPPINGS_ID   ";
    $sql .= "AND STYLE_CAKE.POSITION_ID = CAKE_POSITION.POSITION_ID   ";
    $sql .= "AND STYLE_CAKE.STYLE_ID = CAKE_ORDER.STYLE_ID   ";
    $sql .= "AND CAKE_ORDER.CUS_ID = customer.CUS_ID   ";
    $sql .= "AND CAKE_ORDER.ORC_ID = receipt.ORC_RECEIPT  ";
    $sql .= "AND MONTH(RECEIPT_DATE) =" . $key[0] . " ";
    $sql .= "AND YEAR(RECEIPT_DATE) = " . $key[1] . "  ";
    error_log($sql);
    $db->Query($sql);

    $html = <<<EOD
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Cake Order</title>
    <link rel="stylesheet" href="report/style.css" media="all" />
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="images/bakerylogo.png">
      </div>
      <h1>รายงานประจำเดือน</h1>
      <div id="company" class="clearfix">
        <div>MyBakery</div>
        <div>ที่อยู่</div>
        <div>0841234568</div>
        <div><a href="mailto:mybakery@gmail.com">mybakery@gmail.com</a></div>
      </div>
      <div id="project">
EOD;
    $html.="
        <div><span>เดือน</span>" . MonthNameThai($key[0]) . "</div>
        <div><span>ปี</span>" . $key[1] . "</div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class='desc'>รายละเอียดเค้ก</th>
            <th class='desc'>จำนวนที่สั่ง</th>
            <th class='desc'>ราคาต่อชิ้น</th>
            <th class='desc'>ราคารวม</th>
          </tr>
        </thead>
        <tbody>";

    while ($result = $db->FetchQuery()) {
        $html.="<tr>";
        $html.="<td class = 'desc'>" . "รูปร่าง:" . $result["PIECE"] . " รส:" . $result["FLAVOR"] . " ครีม: " . $result["CREAM_NAME"] . " ท็อปปิ้ง: " . $result["TOP_NAME"] . " " . $result["POSITION"] . "</td>";
        $html.="<td class = 'unit'>" . $result["ORC_NUMBER"] . "</td>";
        $html.="<td class = 'unit'>" . $result["ORC_PRICE"] . "</td>";
        $html.="<td class = 'unit'>" . $result["TOTAL_PRICE"] . "</td>";
        $html.="</tr>";
    }
    $sql = "SELECT SUM(total_price)TotalPrice FROM receipt ";
    $sql .= "WHERE MONTH(receipt_date) = 4 ";
    $sql .= "AND YEAR(receipt_date) = 2015 ";
    $db->Query($sql);
    $result = $db->FetchQuery();
    $html.= "<tr>";
    $html.= "<td colspan = '3' class = 'grand total'>ยอดรวม เดือน" . MonthNameThai($key[0]) . " ปี " . $key[1] . "</td>";
    $html.= "<td class = 'grand total'><span>" . $result["TotalPrice"] . "</span></td>";
    $html.= "</tr >";
    $html .="</tbody>
</table>
<div id = 'notices' style = 'text-align:center;'>"
            .
            "</div>
</main>
<input type='button' value='พิมพ์' onclick='window.print()'/>
<input type='button' value='ปิดหน้า' onclick='window.close()'/>
</body>
</html>";

    echo $html;
}