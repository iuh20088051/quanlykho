<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
   
    <title>Quản Lý Kho</title>
    
    
</head>
<style>
    
        

    body {
            font-family: Arial, sans-serif;
        }

        .nav {
            background-color: #333;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
        }

        #menu {
            list-style: none;
            height: 48px;
            padding-left: 0;
            margin-left: 15px;
        }

        #menu li {
            text-align: left;
            color: #fff;
        }

        #menu li a {
            text-decoration: none;
            font-size: 1em;
            display: block;
            padding: 15px;
            color: #fff;
            background-color: transparent;
            transition: 1s ease;
            font-weight: 500;
        }

        #menu>li {
            float: left;
            position: relative;
        }

        #menu>li>ul.dropdown_menu {
            position: absolute;
            list-style: none;
            display: none;
            top: 48px;
            left: -40px;
            width: 200px;
        }

        #menu>li:hover>a {
            background-color: #5C5C5C;
            opacity: 0.8;
            color: aqua;
        }

        #menu>li:hover>ul.dropdown_menu {
            z-index: 100;
            display: block;
        }

        .dashboard-section {
            margin-top: 150px;
            text-align: center;
        }

        .nvl,
        .tp {
            display: inline-block;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

</style>

<?php
header('Content-Type: text/html; charset=UTF-8');

session_start();

class clsKetnoi
{
    public function ketnoiDB()
    {
        $connect = mysqli_connect('localhost', 'qlkho', '123456', 'quanlykho');

        // Kiểm tra kết nối
        if (!$connect) {
            die('Không thể kết nối tới database. ' . mysqli_connect_error());
        }

        // Đặt bảng kí tự kết nối
        mysqli_set_charset($connect, 'UTF8');

        return $connect;
    }
}

// Tạo đối tượng kết nối từ lớp clsKetnoi
$objKetnoi = new clsKetnoi();

// Biến để lưu trữ kết nối CSDL
$conn = $objKetnoi->ketnoiDB();

// Thực hiện truy vấn SQL cho nvl
$sqlNVL = "SELECT phieunhapkhonvl.ngaynhap, phieunhapkhonvl.IDKHO, nguyenvatlieu.TenNVL, nhanvien.TenNV FROM phieunhapkhonvl INNER JOIN nguyenvatlieu ON phieunhapkhonvl.IDNVL = nguyenvatlieu.idNVL INNER JOIN nhanvien ON phieunhapkhonvl.IDNV = nhanvien.idNV $where_condition";

// Lấy kết quả cho NVL
$resultNVL = $conn->query($sqlNVL);

// Thực hiện truy vấn SQL cho TP
$sqlTP = "SELECT phieunhapkhotp.ngaynhap, phieunhapkhotp.IDKHO, thanhpham.TenTP, nhanvien.TenNV FROM phieunhapkhotp INNER JOIN thanhpham ON phieunhapkhotp.IDTP = thanhpham.idTP INNER JOIN nhanvien ON phieunhapkhotp.IDNV = nhanvien.idNV $where_condition";

// Lấy kết quả cho TP
$resultTP = $conn->query($sqlTP);

?>

<body>
    <!-- Menu -->
    <div id="horizontal-nav" class="nav">
        <ul id="menu">
            <li><a href="TrangchuQL.php">Tổng Quan</a></li>
            <li><a href="thongke.php">Thống kê</a></li>
            <li><a href="Trahang.php">Trả hàng</a></li>
            <li><a href="Lichtrinh.php">Lịch trình</a></li>
            <li><a href="../../xuly/index.php">Đăng xuất</a></li>
        </ul>
    </div>

    <!-- Phần Thống kê -->
    <div class="dashboard-section">
        <h1>Điều phối Lịch trình</h1>

        <!-- Phần NVL -->
        <div class="nvl">
            <h2>Nguyên Vật Liệu</h2>
            <table>
                <tr>
                    <th>STT</th>
                    <th>Ngày Nhập</th>
                    <th>Kho</th>
                    <th>Tên NVL</th>
                    <th>Nhân viên</th>
                </tr>
                <?php
                $sttNVL = 1;
                while ($rowNVL = $resultNVL->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>$sttNVL</td>";
                    echo "<td>{$rowNVL['ngaynhap']}</td>";
                    echo "<td>{$rowNVL['IDKHO']}</td>";
                    echo "<td>{$rowNVL['TenNVL']}</td>";
                    echo "<td>{$rowNVL['TenNV']}</td>";
                    echo "</tr>";
                    $sttNVL++;
                }
                ?>
            </table>
        </div>

        <!-- Phần TP -->
        <div class="tp">
            <h2>Thành Phẩm</h2>
            <table>
                <tr>
                    <th>STT</th>
                    <th>Ngày Nhập</th>
                    <th>Kho</th>
                    <th>Tên TP</th>
                    <th>Nhân viên</th>
                </tr>
                <?php
                $sttTP = 1;
                while ($rowTP = $resultTP->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>$sttTP</td>";
                    echo "<td>{$rowTP['ngaynhap']}</td>";
                    echo "<td>{$rowTP['IDKHO']}</td>";
                    echo "<td>{$rowTP['TenTP']}</td>";
                    echo "<td>{$rowTP['TenNV']}</td>";
                    echo "</tr>";
                    $sttTP++;
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>
