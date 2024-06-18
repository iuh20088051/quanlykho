<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quanlykho";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$Maphieu = $_GET['Maphieu'];
$newStatus = $_GET['newStatus'];

// Cập nhật trạng thái trong cơ sở dữ liệu
$sql = "UPDATE phieuycxuatnvl SET Trangthai='$newStatus' WHERE Maphieu='$Maphieu'";
$conn->query($sql);

$conn->close();
?>
