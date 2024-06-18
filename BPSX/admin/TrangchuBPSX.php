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
    <ul class="menu">
        <li class="menu-item"><a href="../admin/PhieuYCXuatNVL.php">Lập phiếu yêu cầu xuất NVL</a></li>
        <li class="menu-item"><a href="">Lập phiếu yêu cầu nhập TP</a></li>
        <li class="menu-item"><a href="../../xuly/index.php">Đăng xuất</a></li>
    </ul>
    <h1 style="text-align: center;">Chào mừng đã trở lại!!</h1>
    <img style="height: 50%;width: 50%;align-items: center;display: block;margin-left: auto;margin-right: auto;" src="https://phanmemmienphi.vn/wp-content/uploads/2021/01/phan-mem-quan-ly-kho-2.jpg">
</body>

</html>