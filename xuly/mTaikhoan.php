<?php
    include_once("connect.php");
    class modelTaiKhoan{
        function insertTaiKhoan($ten, $pass){
            $con;
            $p = new clsKetnoi();
            $p -> ketnoiDB($con);
            $string = "insert into taikhoan(user, pass, role) values('".$user."','".$pass."','4')";
            $table = mysqli_query($con, $string);
            return $table;
        }
    }
?>