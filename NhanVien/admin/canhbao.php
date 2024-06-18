<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cảnh báo hàng tồn</title>
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
// Lấy ngày hiện tại
$currentDate = date('Y-m-d');

// Truy vấn SQL để lấy các sản phẩm có HSD ít hơn 7 ngày tính từ ngày hiện tại
$query = "SELECT idNVL, TenNVL, HSD FROM nguyenvatlieu WHERE HSD <= DATE_ADD('$currentDate', INTERVAL 7 DAY) ORDER BY HSD ASC";
$result = $conn->query($query);


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
<div class="dashboard-section">
        <div>
            <h2>Cảnh báo hàng hết hạn</h2>
            <table>
              <tr>
                <th>STT</th>
                <th>ID</th>
                <th>Tên nguyên vật liệu</th>
                <th>Hạn sử dụng</th>
              </tr>
              <tr>
                <?php
              if ($result->num_rows > 0) {

              $stt = 1;
              while ($row = $result->fetch_assoc()) {
                  echo "<td>{$stt}</td>";
                  echo "<td>{$row["idNVL"]}</td>";
                  echo "<td>{$row["TenNVL"]}</td>";
                  echo "<td>{$row["HSD"]}</td>";
                  echo "</tr>";
                  $stt++;
              }

              echo "</table>";
              } else {
              echo "Không có sản phẩm nào có HSD ít hơn 7 ngày.";
              }
              ?>
              </tr>
            </table>
        </div>
    </div>
<div>
  
</div>


</body>
</html>