<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem thông tin hàng tồn</title>
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
            margin-top:100px;
            font-family: "Arial", sans-serif;
        }
    </style>
    <?php

// Replace the database credentials with your actual values
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

// Truy vấn từ CSDL
$sql_all = "SELECT idNVL, TenNVL, DVT, Soluong, NgaySX, HSD, Gia FROM nguyenvatlieu";
$result_all = $conn->query($sql_all);

// Đóng kết nối
$conn->close();
?>
</head>
 <!-- Thanh menu -->
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
    <!-- Bảng nhập liệu -->
    <div>
        <h2 style="text-align: center;">Xem thông tin hàng tồn</h2>
        <form action="#" method="post">
            <table class="input-table">
                <tr>
                    <th>Tên nguyên vật liệu</th>
                    <th><input type="text" name="product_name" placeholder="Nhập tên NVL"></th>
                    <th><button type="submit">Tìm</button></th>
                </tr>
            </table>
        </form>
    </div>

    <!-- Bảng hiển thị dữ liệu -->
    <div>
        <?php
        // Replace the database credentials with your actual values
        $host = "localhost";
        $dbname = "quanlykho";
        $user = "root";
        $pass = "";

        // Tạo kết nối
        $conn = new mysqli($host, $user, $pass, $dbname);

        // Kiểm tra kết nối
        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }
        $conn->set_charset("utf8");
        // Truy vấn từ CSDL
        //$sql_all = "SELECT idNVL, TenNVL, DVT, Soluong, NgaySX, HSD, Gia FROM nguyenvatlieu";
        //$result_all = $conn->query($sql_all);

        // Kiểm tra xem đã nhập tên sản phẩm chưa
        $product_name = $_POST["product_name"];
        if ($product_name!=null) {
            echo "<h2>Thông tin hàng tồn cho sản phẩm '$product_name':</h2>";

            // Truy vấn với điều kiện dựa trên tên sản phẩm đã nhập
            $sql_filtered = "SELECT idNVL, TenNVL, DVT, Soluong, NgaySX, HSD, Gia FROM nguyenvatlieu WHERE TenNVL = '$product_name'";
            $result_filtered = $conn->query($sql_filtered);

            if ($result_filtered->num_rows > 0) {
                echo "<table class='display-table'>
                        <tr>
                            <th>STT</th>
                            <th>ID</th>
                            <th>Tên NVL</th>
                            <th>Đơn vị tính</th>
                            <th>Số lượng</th>
                            <th>Ngày Sản Xuất</th>
                            <th>Hạn Sử Dụng</th>
                            <th>Giá</th>
                            <th>Thao tác</th>
                        </tr>";
                $stt = 1;
                while ($row = $result_filtered->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $stt++ . "</td>
                            <td>" . $row["idNVL"] . "</td>
                            <td>" . $row["TenNVL"] . "</td>
                            <td>" . $row["DVT"] . "</td>
                            <td>" . $row["Soluong"] . "</td>
                            <td>" . $row["NgaySX"] . "</td>
                            <td>" . $row["HSD"] . "</td>
                            <td>" . $row["Gia"] . "</td>
                            <td><button onclick=\"openModal('{$row['idNVL']}', '{$row['TenNVL']}', '{$row['DVT']}', '{$row['Soluong']}', '{$row['NgaySX']}', '{$row['HSD']}', '{$row['Gia']}')\">Xem chi tiết</button></td>
                        </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Không tìm thấy thông tin cho sản phẩm '$product_name'.</p>";
            }
        } else {

            // Hiển thị tất cả các NVL nếu chưa nhập tên sản phẩm
            echo "<h2>Thông tin tất cả NVL trong kho :</h2>";
            echo "<table class='display-table'>
                    <tr>
                        <th>STT</th>
                        <th>ID</th>
                        <th>Tên NVL</th>
                        <th>Đơn vị tính</th>
                        <th>Số lượng</th>
                        <th>Ngày Sản Xuất</th>
                        <th>Hạn Sử Dụng</th>
                        <th>Giá</th>
                        <th>Thao tác</th>
                    </tr>";
            $stt = 1;
            while ($row = $result_all->fetch_assoc()) {
                echo "<tr>
                        <td>" . $stt++ . "</td>
                        <td>" . $row["idNVL"] . "</td>
                        <td>" . $row["TenNVL"] . "</td>
                        <td>" . $row["DVT"] . "</td>
                        <td>" . $row["Soluong"] . "</td>
                        <td>" . $row["NgaySX"] . "</td>
                        <td>" . $row["HSD"] . "</td>
                        <td>" . $row["Gia"] . "</td>
                        <td><button onclick=\"openModal('{$row['idNVL']}', '{$row['TenNVL']}', '{$row['DVT']}', '{$row['Soluong']}', '{$row['NgaySX']}', '{$row['HSD']}', '{$row['Gia']}')\">Xem chi tiết</button></td>
                    </tr>";
            }
            echo "</table>";
        }

        // Đóng kết nối
        $conn->close();
        ?>
    </div>

    <!-- JavaScript cho modal -->
    <script>
        function openModal(idNVL, TenNVL, DVT, Soluong, NgaySX, HSD, Gia) {
            document.getElementById("modal-idNVL").innerHTML = idNVL;
            document.getElementById("modal-TenNVL").innerHTML = TenNVL;
            document.getElementById("modal-DVT").innerHTML = DVT;
            document.getElementById("modal-Soluong").innerHTML = Soluong;
            document.getElementById("modal-NgaySX").innerHTML = NgaySX;
            document.getElementById("modal-HSD").innerHTML = HSD;
            document.getElementById("modal-Gia").innerHTML = Gia;
            document.getElementById("myModal").style.display = "block";
        }

        // Đóng modal
        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }

        // Đóng modal khi nhấn nút đóng (x)
        window.onclick = function (event) {
            var modal = document.getElementById("myModal");
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <!-- Hiển thị thông tin chi tiết của hàng tồn -->
            <h3>Chi tiết thông tin hàng tồn</h3>
            <p><strong>ID:</strong> <span id="modal-idNVL"></span></p>
            <p><strong>Tên NVL:</strong> <span id="modal-TenNVL"></span></p>
            <p><strong>Đơn vị tính:</strong> <span id="modal-DVT"></span></p>
            <p><strong>Số lượng:</strong> <span id="modal-Soluong"></span></p>
            <p><strong>Ngày Sản Xuất:</strong> <span id="modal-NgaySX"></span></p>
            <p><strong>Hạn Sử Dụng:</strong> <span id="modal-HSD"></span></p>
            <p><strong>Giá:</strong> <span id="modal-Gia"></span></p>
        </div>
    </div>
</body>
</html>
