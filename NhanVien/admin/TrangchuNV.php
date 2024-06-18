<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
    <title>Quản lý kho</title>
</head>
<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user'])) {
    header('Location: ../../xuly/index.php');
    exit();
}

// Lấy tên đăng nhập từ session
$username = $_SESSION['user'];
?>
<body>
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
    <h1 style="text-align: center;">Chào mừng đã trở lại!!</h1>
    <img style="height: 50%;width: 50%;align-items: center;display: block;margin-left: auto;margin-right: auto;" src="https://phanmemmienphi.vn/wp-content/uploads/2021/01/phan-mem-quan-ly-kho-2.jpg">
</body>

</html>