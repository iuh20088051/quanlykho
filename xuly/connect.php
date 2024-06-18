<?php
    class clsKetnoi{
        function ketnoiDB(& $connect){
            $connect = mysqli_connect ('localhost', 'qlkho', '123456', 'quanlykho') or die ('Không thể kết nối tới database');
            // $connect = mysqli_connect ('localhost', 'root', '', 'dangnhap') or die ('Không thể kết nối tới database');
            mysqli_set_charset($connect, 'UTF8');
            if($connect === false){ 
            die("ERROR: Could not connect. " . mysqli_connect_error()); 
            }
        }
    }

