<?php

//require_once('config.php') ;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Database
 *
 * @author Poy
 */
class MyDatabase {

    //put your code here
    public $result;
    private $db;

    function __construct() {
        $this->db = new mysqli('localhost', 'root', '1234', 'Mybakery') or die("Error Connect to Database");
        $this->db->query("SET character_set_results=utf8");
        $this->db->query("SET character_set_client=utf8");
        $this->db->query("SET character_set_connection=utf8");
    }

    function __destruct() {
        if (isset($this->con)) {
            unset($this->con);
        }
    }

    public function Query($sql) {
        $this->result = $this->db->query($sql);
        }

    public function FetchQuery() {
        return $this->result->fetch_array();
    }

    public function ExcuteNonQuery($sql) {
        mysqli_query($this->con, $sql);
    }

    public function Num_rows() {
        if (is_object($this->result))
            return $this->result->num_rows;
        return 0;
    }

    public function Insert_ID() {
        return mysqli_insert_id($this->db);
    }

    public function GetError(){
        return $this->db->error;
    }
}
