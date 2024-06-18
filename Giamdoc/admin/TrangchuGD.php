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
    <!-- Thanh menu -->
  <div id="horizontal-nav" class="nav" >
    <ul id="menu">
      <li><a href="TrangchuGD.php">Tổng Quan</a></li>

      <li><a href="#">Cập nhật</a>
        <span class="arrow arrow-down"></span>
        <ul class="dropdown_menu">
          <li><a href="capnhatTP.php">Cập nhật TP</a></li>
          <li><a href="capnhatNVL.php">Cập nhật NVL</a></li>
        </ul>
      </li>

      <li><a href="#">Xem BCTK</a>
        <span class="arrow arrow-down"></span>
        <ul class="dropdown_menu">
          <li><a href="xemBCTKTP.php">Báo cáo tồn kho TP</a></li>
          <li><a href="xemBCTKNVL.php">Báo cáo tồn kho NVL</a></li>
        </ul>
      </li>
      <li><a href="giamdocduyetphieu.php">Duyệt phiếu</a></li>

      <li><a href="giamdoclapphieu.php">Lập phiếu</a></li>
      
      <li><a href="kiemke.php">Kiểm kê</a></li>

      <li><a href="../../xuly/index.php">Đăng xuất</a></li>
    </ul>
  </div>
    <h1 style="text-align: center;">Chào mừng đã trở lại!!</h1>
    <img style="height: 50%;width: 50%;align-items: center;display: block;margin-left: auto;margin-right: auto;" src="https://phanmemmienphi.vn/wp-content/uploads/2021/01/phan-mem-quan-ly-kho-2.jpg">
</body>

</html>