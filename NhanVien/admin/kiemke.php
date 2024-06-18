<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Thống Kê</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/style.css"/>
   <style>
        /* CSS cho thanh menu */
        ul.menu {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333;
        }

        li.menu-item {
            float: left;
        }

        li.menu-item a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        li.menu-item a:hover {
            background-color: #444;
        }

        /* CSS cho bảng nhập liệu */
        table.input-table {
            border-collapse: collapse;
            width: 100%;
        }

        table.input-table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        /* CSS cho bảng hiển thị dữ liệu đã nhập */
        table.display-table {
            border-collapse: collapse;
            width: 100%;
        }

        table.display-table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        /* CSS cho modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        body{
            margin-top: 100px;
        }
    </style>
    <?php

// Thay đổi thông tin này theo cài đặt của bạn
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
// Xử lý yêu cầu lọc
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$whereClause = '';

if ($filter == 'con') {
    $whereClause = ' WHERE Soluong > 0';
} elseif ($filter == 'hethang') {
    $whereClause = ' WHERE Soluong = 0';
}

// Truy vấn thống kê
$queryNVL = "SELECT COUNT(*) AS totalNVL, SUM(Soluong) AS totalQuantityNVL, GROUP_CONCAT(TenNVL) AS itemNames FROM nguyenvatlieu" . $whereClause;
$resultNVL = $conn->query($queryNVL);
$rowNVL = $resultNVL->fetch_assoc();


// Xử lý yêu cầu xóa nguyên vật liệu
if (isset($_GET['action']) && $_GET['action'] == 'deleteNVL' && isset($_GET['idNVL'])) {
    $idNVL = $_GET['idNVL'];
    $deleteQuery = "DELETE FROM nguyenvatlieu WHERE idNVL = $idNVL";
    $conn->query($deleteQuery);
    // Chuyển hướng về trang thống kê sau khi xóa
    header("Location: thongke.php?filter=$filter");
    exit();
}

// Xử lý yêu cầu thêm danh sách sản phẩm
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addProducts"])) {
    $productList = $_POST["productList"];
    $productList = explode("\n", $productList);

    foreach ($productList as $product) {
        // Tách thông tin sản phẩm từ dòng
        $productInfo = explode(",", $product);
        $tenNVL = trim($productInfo[0]);
        $dvt = trim($productInfo[1]);
        $soluong = trim($productInfo[2]);
        $ngaySX = trim($productInfo[3]);
        $hsd = trim($productInfo[4]);

        // Thêm sản phẩm vào CSDL
        $insertQuery = "INSERT INTO nguyenvatlieu (TenNVL, DVT, Soluong, NgaySX, HSD) VALUES ('$tenNVL', '$dvt', $soluong, '$ngaySX', '$hsd')";
        $conn->query($insertQuery);
    }

    // Chuyển hướng về trang thống kê sau khi thêm
    header("Location: thongke.php?filter=$filter");
    exit();
}

// Đóng kết nối
$conn->close();
?>
</head>
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
<body>


<div>
    <h2 style="text-align: center;">Kiểm kê hàng tồn trong kho</h2>

    <form action="#" method="get">
        <label for="filter">Lọc sản phẩm:</label>
        <select name="filter" id="filter">
            <option value="all" <?php echo ($filter == 'all') ? 'selected' : ''; ?>>Tất cả</option>
            <option value="con" <?php echo ($filter == 'con') ? 'selected' : ''; ?>>Còn hàng</option>
            <option value="hethang" <?php echo ($filter == 'hethang') ? 'selected' : ''; ?>>Hết hàng</option>
        </select>
        <button type="submit">Lọc</button>
    </form>
    <h3 style="text-align: center;">Nguyên Vật Liệu</h3>
<table class=display-table>
    <tr>
        <td>Tổng số nguyên vật liệu:</td>
        <td><?php echo $rowNVL['totalNVL']; ?></td>
    </tr>
    <tr>
        <td>Tổng số lượng:</td>
        <td><?php echo $rowNVL['totalQuantityNVL']; ?></td>
    </tr>
    <?php if ($filter == 'con' || $filter == 'hethang') : ?>
        <tr>
            <td>Danh sách nguyên vật liệu:</td>
            <td><?php echo $rowNVL['itemNames']; ?></td>
        </tr>
    <?php endif; ?>
</table>
<canvas id="myChart" style="width: 4; height: 2;" ></canvas>
</div>

<script>
    
    // Mã JavaScript để vẽ biểu đồ cột
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Tổng số nguyên vật liệu', 'Tổng số lượng'],
            datasets: [{
                label: 'Thống kê nguyên vật liệu',
                data: [<?php  echo $rowNVL['totalNVL']; ?>, <?php  echo $rowNVL['totalQuantityNVL']; ?>],
                backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

</script>
</body>
</html>