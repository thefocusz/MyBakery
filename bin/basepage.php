<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();

define("CAKEPIECEID", "CAKEPIECEID");
define("CAKEPIECENAME", "CAKEPIECENAME");
define("CAKEFLAVORID", "CAKEFLAVORID");
define("CAKEFLAVORNAME", "CAKEFLAVORNAME");
define("CAKECREAMID", "CAKECREAMID");
define("CAKECREAMNAME", "CAKECREAMNAME");
define("TOPPINGID", "TOPPINGID");
define("TOPPINGNAME", "TOPPINGNAME");
define("POSITIONID", "POSITIONID");
define("POSITIONNAME", "POSITIONNAME");
define("CAKEMSG", "CAKEMSG");
define("DELIVERYID", "DELIVERYID");
define("DELIVERYNAME", "DELIVERYNAME");
define("CAKEAMOUNTID", "CAKEAMOUNTID");
define("CAKEPRICE", "CAKEPRICE");

function GetCakePieceID() {
    if (isset($_SESSION[CAKEPIECEID]))
        return $_SESSION[CAKEPIECEID];
    return "";
}

function SetCakePieceID($value) {
    $_SESSION[CAKEPIECEID] = $value;
}

function GetCakePieceName() {
    if (isset($_SESSION[CAKEPIECENAME]))
        return $_SESSION[CAKEPIECENAME];
    return "";
}

function SetCakePieceName($value) {
    $_SESSION[CAKEPIECENAME] = $value;
}

function GetCakeFlavorID() {
    if (isset($_SESSION[CAKEFLAVORID]))
        return $_SESSION[CAKEFLAVORID];
    return "";
}

function SetCakeFlavorID($value) {
    $_SESSION[CAKEFLAVORID] = $value;
}

function GetCakeFlavorName() {
    if (isset($_SESSION[CAKEFLAVORNAME]))
        return $_SESSION[CAKEFLAVORNAME];
    return "";
}

function SetCakeFlavorName($value) {
    $_SESSION[CAKEFLAVORNAME] = $value;
}

function GetCakeCreamID() {
    if (isset($_SESSION[CAKECREAMID]))
        return $_SESSION[CAKECREAMID];
    return "";
}

function SetCakeCreamID($value) {
    $_SESSION[CAKECREAMID] = $value;
}

function GetCakeCreamName() {
    if (isset($_SESSION[CAKECREAMNAME]))
        return $_SESSION[CAKECREAMNAME];
    return "";
}

function SetCakeCreamName($value) {
    $_SESSION[CAKECREAMNAME] = $value;
}

function GetCakeToppingID() {
    if (isset($_SESSION[TOPPINGID]))
        return $_SESSION[TOPPINGID];
    return "";
}

function SetCakeToppingID($value) {
    $_SESSION[TOPPINGID] = $value;
}

function GetCakeToppingName() {
    if (isset($_SESSION[TOPPINGNAME]))
        return $_SESSION[TOPPINGNAME];
    return "";
}

function SetCakeToppingName($value) {
    $_SESSION[TOPPINGNAME] = $value;
}

function GetCakePositionID() {
    if (isset($_SESSION[POSITIONID]))
        return $_SESSION[POSITIONID];
    return "";
}

function SetCakePositionID($value) {
    $_SESSION[POSITIONID] = $value;
}

function GetCakePositionName() {
    if (isset($_SESSION[POSITIONNAME]))
        return $_SESSION[POSITIONNAME];
    return "";
}

function SetCakePositionName($value) {
    $_SESSION[POSITIONNAME] = $value;
}

function GetCakeMSG() {
    if (isset($_SESSION[CAKEMSG]))
        return $_SESSION[CAKEMSG];
    return "";
}

function SetCakeMSG($value) {
    $_SESSION[CAKEMSG] = $value;
}

function GetCakeDeliveryID() {
    if (isset($_SESSION[DELIVERYID]))
        return $_SESSION[DELIVERYID];
    return "";
}

function SetCakeDeliveryID($value) {
    $_SESSION[DELIVERYID] = $value;
}

function GetCakeDeliveryName() {
    if (isset($_SESSION[DELIVERYNAME]))
        return $_SESSION[DELIVERYNAME];
    return "";
}

function SetCakeDeliveryName($value) {
    $_SESSION[DELIVERYNAME] = $value;
}

function GetCakeAmount() {
    if (isset($_SESSION[CAKEAMOUNTID]))
        return $_SESSION[CAKEAMOUNTID];
    return "";
}

function SetCakeAmount($value) {
    $_SESSION[CAKEAMOUNTID] = $value;
}

function GetCakePrice() {
    if (isset($_SESSION[CAKEPRICE]))
        return $_SESSION[CAKEPRICE];
    return "";
}

function SetCakePrice($value) {
    $_SESSION[CAKEPRICE] = $value;
}

function AlertandRedirect($msg, $url) {
    return "<script> alert('" . $msg . "'); window.location.href='" . $url . "';</script>";
}

function RedirectClient($url) {
    return "<script> window.location.href='" . $url . "';</script>";
}

function MonthNameThai($monthNo) {
    //error_log("Month No :" . $monthNo);
    $strName = "";
    switch ($monthNo) {
        case 1: $strName = "มกราคม";
            break;
        case 2: $strName = "กุมภาพันธ์";
            break;
        case 3: $strName = "มีนาคม";
            break;
        case 4: $strName = "เมษายน";
            break;
        case 5: $strName = "พฤษภาคม";
            break;
        case 6: $strName = "มิถุนายน";
            break;
        case 7: $strName = "กรกฎาคม";
            break;
        case 8: $strName = "สิงหาคม";
            break;
        case 9: $strName = "กันยายน";
            break;
        case 10: $strName = "ตุลาคม";
            break;
        case 11: $strName = "พฤศจิกายน";
            break;
        case 12: $strName = "ธันวาคม";
            break;
    }

    return $strName;
}
