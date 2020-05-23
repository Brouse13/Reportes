<?php
    require_once 'db.php';

    function getReporte($Id) { //Get from sql
        global $con;
        $query = $con->query("SELECT * FROM reportes WHERE Id= \"". $Id ."\"");
        if ($query->num_rows > 0) {
           return $query->fetch_array();
        }
    }

    function myReports($Name) {
        global $con;
        $query = $con->query("SELECT * FROM reportes WHERE Reportante= \"". $Name ."\"");
        if ($query->num_rows > 0) {
           return $query->num_rows;
        }else{
            return 0;
        }
    }
    
    function noReplyReport() {
        global $con;
        $query = $con->query("SELECT * FROM reportes WHERE Estado=\"esperando\"");
        if ($query->num_rows > 0) {
           return $query->num_rows;
        }else{
            return 0;
        }
    }

    function getUser($User){
        global $con;
        $query = $con->query("SELECT * FROM users WHERE Username= \"". $User ."\"");
        if ($query->num_rows > 0) {
           return $query->fetch_array();
        }
    }

    function getLog($Id){
        global $con;
        $query = $con->query("SELECT * FROM log WHERE Id= \"". $Id ."\"");
        if ($query->num_rows > 0) {
           return $query->fetch_array();
        }
    }
    
    function getStaffs(){//return array
        global $con;
        $staff = array();

        $query = $con->query("SELECT Username FROM users WHERE Type= \"staff\" OR Type=\"admin\"");
        if ($query->num_rows > 0) {
           while ($row = $query->fetch_array()) {
            array_push($staff, $row['Username']);
           }
           return $staff;
        }
        return $staff;
    }

    function isAdmin($Name){
        $user = getUser($Name);
        if($user['Type']== 'admin') {
            return true;
        } return false;
    }

    function isStaff($Name){
        $user = getUser($Name);
        if($user['Type'] == 'admin' || $user['Type'] == 'staff') {
            return true;
        } return false;
    }

    function getRango($Name){
        $User = getUser($Name);
        return $User['Rango']; 
    }

?>