<?php

include 'MyDatabase.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomerEntity
 *
 * @author Poy
 */
class CustomerEntity {

    //put your code here

    public $customerID;
    public $customerName;
    public $ORC_Address;
    public $ORC_Tel;
    public $custPasword;
    public $custConfirmPassword;
    public $custOldPassword;
    public $errMsg;

    public function RegisCustomer() {
        try {
            $isSuccess = TRUE;
            $errorMsg = "";

            error_log($this->customerName);
            if ($isSuccess && empty($this->customerName)) {
                $isSuccess = FALSE;
                $errorMsg = "กรุณาระบุชื่อและนามสกุล";
                error_log($errorMsg);
            }
            if ($isSuccess && empty($this->ORC_Tel)) {
                $isSuccess = FALSE;
                $errorMsg = "กรุณาระบุเบอร์โทรศัพท์";
                error_log($errorMsg);
            }
            if ($isSuccess && empty($this->ORC_Address)) {
                $isSuccess = FALSE;
                $errorMsg = "กรุณาระบุสถานที่ส่ง";
                error_log($errorMsg);
            }
            if ($isSuccess && empty($this->customerID)) {
                $isSuccess = FALSE;
                $errorMsg = "กรุณาระบุชื่อผู้ใช้";
                error_log($errorMsg);
            }

            if ($isSuccess && (empty($this->custPasword) || empty($this->custConfirmPassword))) {
                $isSuccess = FALSE;
                $errorMsg = "กรุณากรอกรหัสผ่าน";
                error_log($errorMsg);
            }

            //write_log
            error_log($errorMsg);
            error_log($this->customerName);
            error_log($this->customerID);
            error_log($this->ORC_Address);
            error_log($this->ORC_Tel);
            error_log($this->custPasword);

            error_log($isSuccess ? "TRUE" : "FALSE");
            if ($isSuccess) {
                //เชค user format
                $pattern = "/^[a-zA-Z0-9]{5,16}$/"; // a-z A-Z 0-9 5 ถึง 16 ตัว
                if (!preg_match($pattern, $this->customerID)) {
                    $isSuccess = FALSE;
                    $errorMsg = "กรุณาระบุชื่อผู้ใช้ให้ถูกต้อง";
                    error_log("UserName does not match");
                }

                //เชคว่า duplicate user หรือเปล่า 
                $sql = "SELECT  COUNT(cus_id)cus FROM customer WHERE CUS_ID = '" . $this->customerID . "'";
                $db = new MyDatabase();
                $result = $db->Query($sql);
                if ($result["cus"] > 0) {
                    $isSuccess = FALSE;
                    $errorMsg = "กรุณาระบุชื่อผู้ใช้ใหม่";
                    error_log($errorMsg);
                }

                error_log("ชื่อผู้ใช้" . $this->customerID . ":" . $result["cus"]);
            }
            if ($isSuccess) {
                if ($this->custPasword != $this->custConfirmPassword) {
                    $isSuccess = FALSE;
                    $errorMsg = "กรุณาระบุรหัสผ่านให้ตรงกัน";
                }
            }

            if ($isSuccess) {
                //Insert to database
                $sql = "INSERT INTO CUSTOMER(CUS_ID,NAME_LAST,ORC_ADD,ORC_TEL,PWD) ";
                $sql .= "VALUES('" . $this->customerID . "','" . $this->customerName . "','" . $this->ORC_Address . "','" . $this->ORC_Tel . "','" . $this->custConfirmPassword . "')";
                error_log($sql);
                $db = new MyDatabase();
                $db->Query($sql);
                $isSuccess = $db->result === TRUE;
                if (!$isSuccess) {
                    $errorMsg = "ไม่สามารถเพิ่มข้อมูลได้";
                    error_log($errorMsg);
                }
            }

            if ($isSuccess)
                return "success";
            else
                return $errorMsg;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), "", "");
            error_log($e->getMessage());
        }
    }

    public function CustomerLogin($userName, $password) {
        try {
            if ($userName != "" && $password != "") {
                $db = new MyDatabase();
                $sql = "SELECT * FROM CUSTOMER WHERE CUS_ID = '" . $userName . "' AND PWD='" . $password . "'";
                error_log($sql);
                $db->Query($sql);
                if ($db->Num_rows() > 0) {
                    error_log("got customer login");
                    $result = $db->FetchQuery();
                    $customerEntity = new CustomerEntity();
                    $customerEntity->customerID = $result["CUS_ID"];
                    $customerEntity->customerName = $result["NAME_LAST"];
                    $customerEntity->ORC_Address = $result["ORC_ADD"];
                    $customerEntity->ORC_Tel = $result["ORC_TEL"];
                    return $customerEntity;
                }
            } else {
                return FALSE;
                error_log("cannot login");
            }
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            return FALSE;
        }
    }

    public function ChangeUserProfile($isChangePassword) {
        try {
            $db = new MyDatabase();
            $sql = "SELECT * FROM CUSTOMER WHERE CUS_ID = '" . $this->customerID . "'";
            $db->Query($sql);
            $result = $db->FetchQuery();
            if ($isChangePassword && $this->custOldPassword == $result["PWD"] &&
                    $this->custPasword == $this->custConfirmPassword) {
                $sql = "UPDATE CUSTOMER SET ";
                $sql.="NAME_LAST = '" . $this->customerName . "', ";
                $sql.="ORC_ADD ='" . $this->ORC_Address . "', ";
                $sql.="ORC_TEL ='" . $this->ORC_Tel . "', ";
                $sql.="PWD ='" . $this->custPasword . "' ";
                $sql.="WHERE CUS_ID ='" . $this->customerID . "'";
            } else if (!$isChangePassword) {
                $sql = "UPDATE CUSTOMER SET ";
                $sql.="NAME_LAST = '" . $this->customerName . "', ";
                $sql.="ORC_ADD ='" . $this->ORC_Address . "', ";
                $sql.="ORC_TEL ='" . $this->ORC_Tel . "' ";
                $sql.="WHERE CUS_ID ='" . $this->customerID . "'";
            }
            else
                return FALSE ;

            error_log($sql);
            $db->Query($sql);
            return true;
        } catch (Exception $ex) {
            error_log($ex);
            return FALSE;
        }
    }

}
