<?php
// getDetails.php

$maPhieu = $_GET['Maphieu'];

// Kết nối đến cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "quanlykho");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Truy vấn dữ liệu từ cơ sở dữ liệu
$sql = "SELECT TenNVL, Soluong, DVT FROM phieuycxuatnvl WHERE Maphieu = '$maPhieu'";
$result = $conn->query($sql);

// Hiển thị dữ liệu trong modal
if ($result->num_rows > 0) {
    echo "<h3>Thông tin chi tiết phiếu</h3>";
    echo "<table>";
    echo "<tr><th>STT</th><th>Tên NVL</th><th>Số lượng</th><th>Đơn vị tính</th></tr>";
    $stt = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$stt}</td>";
        echo "<td>{$row['TenNVL']}</td>";
        echo "<td>{$row['Soluong']}</td>";
        echo "<td>{$row['DVT']}</td>";
        echo "</tr>";
        $stt++;
    }
    echo "</table>";
} else {
    echo "Không có thông tin chi tiết.";
}

// Đóng kết nối
$conn->close();
?>
