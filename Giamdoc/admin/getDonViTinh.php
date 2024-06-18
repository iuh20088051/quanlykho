<?php
// Kết nối đến cơ sở dữ liệu trên XAMPP
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quanlykho";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy idNVL từ tham số GET
$idNVL = $_GET['idNVL'];

// Truy vấn đơn vị tính từ cơ sở dữ liệu
$sql = "SELECT DVT FROM nguyenvatlieu WHERE idNVL = '$idNVL'";
$result = $conn->query($sql);

// Tạo một mảng kết quả
$response = array();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $response['donViTinh'] = $row['DVT'];
} else {
    $response['donViTinh'] = ''; // Nếu không tìm thấy, để trống
}

// Đóng kết nối
$conn->close();

// Trả về dữ liệu JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
