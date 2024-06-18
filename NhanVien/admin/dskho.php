<?php
 include ("../myclass/clsnhap.php"); 
 $p = new nhapkho(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<title>Danh sách kho</title>
</head>

<body>
<!-- Thanh menu -->

<div id="horizontal-nav" class="nav">
  <ul id="menu">
    <li><a href="TrangchuNV.php">Tổng Quan</a></li>

    <li>
      <a href="dskho.php">Nhập kho
        <span class="arrow arrow-down"></span>
      </a>
      <ul class="dropdown_menu">
        <li><a href="nhapkhoNVL.php">Nhập kho NVL</a></li>
        <li><a href="nhapkhoTP.php">Nhập kho TP</a></li>
        <li><a href="bienban.php">Biên bản</a></li>
      </ul>
    </li>

    <li>
      <a href="dsxuat.php">Xuất kho
        <span class="arrow arrow-down"></span>
      </a>
      <ul class="dropdown_menu">
        <li><a href="xuatkhoNVL.php">Xuất kho NVL</a></li>
        <li><a href="xuatkhoTP.php">Xuất kho TP</a></li>
      </ul>
    </li>

    <li><a href="xem.php">Quản lý</a></li>

    <li><a href="kiemke.php">Kiểm kê</a></li>

    <li><a href="canhbao.php">Cảnh báo</a></li>

    <li><a href="../../xuly/index.php">Đăng xuất</a></li>
  </ul>
</div>

<!-- Bảng danh sách -->
  <div class="body">
    <br />
    <br /> 
    <form id="form1" name="form1" method="post" action="">
    <h2 style="text-align: center;"><strong>DANH SÁCH HÀNG HÓA ĐÃ NHẬP CỦA KHO NGUYÊN VẬT LIỆU </strong></h2>
    <div align="center">
    <select name="txtnhap" id="txtnhap">
      <option>Chọn loại hàng hóa muốn xem </option>
      <option> <a href="#">Nguyên vật liệu</a> </option>
      <option>Thành phẩm </option>
    </select>
    </div>
    <br /> 
    
     <br /> 
   <?php
   	$p->load_ds_nhap_nvl("SELECT nguyenvatlieu.*, phieunhapkhonvl.ngaynhap
							FROM nguyenvatlieu
							JOIN phieunhapkhonvl ON nguyenvatlieu.idnhapnvl = phieunhapkhonvl.idPhieunhapnvl");
   
   ?>
   <br />
   <hr />
   <br />
   <h2 style="text-align: center;"><strong>DANH SÁCH HÀNG HÓA ĐÃ NHẬP CỦA KHO THÀNH PHẨM  </strong></h2>
    <br />
    <?php
   	$p->load_ds_nhap_tp("SELECT thanhpham.*, phieunhapkhotp.ngaynhap
							FROM thanhpham
							JOIN phieunhapkhotp ON thanhpham.idnhaptp = phieunhapkhotp.idPhieunhapTP");
    ?>
    </form>
 </div>
    
</body>
</html>