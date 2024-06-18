<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quanlykho";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy dữ liệu từ request
$idPhieuLap = $_POST['idPhieuLap'];
//$ngayLapPhieu = $_POST['ngay_lap_phieu'];
$ngayLapPhieu = date("Y-m-d");

$idNVL = $_POST['idNVL'];
$soLuong = $_POST['soLuong'];
$donViTinh = $_POST['donViTinh'];

// Thực hiện câu truy vấn để lưu vào cơ sở dữ liệu
$sql = "INSERT INTO phieumuanvl (ngaymua, Soluong, DVT, idNVL, maPhieu) VALUES ('$ngayLapPhieu', '$soLuong', '$donViTinh', '$idNVL','$idPhieuLap')";

if ($conn->query($sql) === TRUE) {
    echo "Dữ liệu đã được lưu thành công";
} else {
    echo "Lỗi: " . $sql . "<br>" . $conn->error;
}

// Đóng kết nối
$conn->close();
?>
