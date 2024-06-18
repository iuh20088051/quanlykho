<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
   
    <title>Quản Lý Kho</title>
    
    
</head>
<style>
    
        

/* CSS Document */

  /* Body */
  .body {
    margin-top: 100px;
	
  }

  /*Menu*/
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
    /* background-color: #333; */
  }

  #menu>li {
    float: left;
    /*border-right: 1px solid #fff;*/
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

  #menu>li>ul.dropdown_menu li a{
    background-color: #333;
  }

  #menu>li>ul.dropdown_menu li:first-child a{
    border-radius: 0 20px 0 0 ;
  }

  #menu>li>ul.dropdown_menu li:last-child a{
    border-radius: 0 0 20px 10px ;
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

  ul.dropdown_menu>li>ul.submenu {
    position: absolute;
    display: none;
    left: 200px;
    list-style: none;
    width: 200px;
  }

  ul.dropdown_menu>li:hover>a {
    background-color: #5C5C5C !important;
  }

  ul.dropdown_menu>li:hover>ul.submenu {
    z-index: 100;
    display: block;
  }

  ul.submenu>li:hover>a {
    background-color: #5C5C5C !important;
  }

  .arrow {
    width: 0;
    height: 0;
    display: inline-block;
    vertical-align: middle;
    margin-left: 5px;
  }

  .arrow-down {
    border-left: 7px solid transparent;
    border-right: 7px solid transparent;
    border-top: 7px solid #fff;
  }

  .arrow-right {
    border-top: 7px solid transparent;
    border-bottom: 7px solid transparent;
    border-left: 7px solid #fff;
  }
  .dashboard-section {
    margin-top: 100px !important;
    display: flex;
    justify-content: space-between; /* Cách đều các thành phần bên trong */
    max-width: 90%; 
    margin-left: auto;
    margin-right: auto;
}

.chart-container {
    margin-bottom: 20px;
    flex: 1; /* Để các biểu đồ chia đều không gian */
    margin: 10px; /* Khoảng cách giữa các biểu đồ */
}

.chart {
    width: 100%; /* Biểu đồ chiếm toàn bộ width của container */
    height: auto; /* Đảm bảo tỷ lệ khung hình không bị méo */
}

</style>

<?php
header('Content-Type: text/html; charset=UTF-8');

session_start();

class clsKetnoi
{
    function ketnoiDB(&$connect)
    {
        $connect = mysqli_connect('localhost', 'qlkho', '123456', 'quanlykho') or die('Không thể kết nối tới database');
        mysqli_set_charset($connect, 'UTF8');
        if ($connect === false) {
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }
    }
}
// Tạo đối tượng kết nối từ lớp clsKetnoi
$objKetnoi = new clsKetnoi();

// Biến để lưu trữ kết nối CSDL
$conn = null;

// Gọi phương thức ketnoiDB để kết nối CSDL
$objKetnoi->ketnoiDB($conn);

// Thực hiện truy vấn SQL với điều kiện WHERE
$sql = "SELECT phieunhapkhonvl.idphieunhapnvl, phieunhapkhonvl.ngaynhap, phieunhapkhonvl.IDNVL, phieunhapkhonvl.IDKHO, phieunhapkhonvl.IDNV, nguyenvatlieu.TenNVL, nhanvien.TenNV FROM phieunhapkhonvl INNER JOIN nguyenvatlieu ON phieunhapkhonvl.IDNVL = nguyenvatlieu.idNVL INNER JOIN nhanvien ON phieunhapkhonvl.IDNV = nhanvien.idNV $where_condition";

// Thực hiện truy vấn và lấy kết quả
$result = $conn->query($sql);

$queryTP = "SELECT TenTP, SUM(Soluong) AS totalQuantityTP FROM thanhpham GROUP BY TenTP";
$resultTP = $conn->query($queryTP);

$colors = array('rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)', 'rgba(255, 205, 86, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)');

$queryNVL2 = "SELECT TenNVL, SUM(Soluong) AS totalQuantityNVL FROM nguyenvatlieu GROUP BY TenNVL";
$resultNVL2 = $conn->query($queryNVL2);
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
        <div class="chart-container">
            <h2 style="text-align: center;">Biểu đồ tròn thể hiện số lượng thành phẩm trong kho</h2>
            <canvas id="myChart" class="chart"></canvas>
        </div>
        <div class="chart-container">
        <h2 style="text-align: center;">Biểu đồ tròn thể hiện số lượng nguyên liệu trong kho</h2>
            <canvas id="myblopt" class="chart"></canvas>
        </div>
    </div>

    <script>
        if (window.Chart) {
        console.log("Chart.js is loaded.");
        console.log("Creating chart");

        var ctx2 = document.getElementById('myChart').getContext('2d');
        var myChart2 = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: [<?php
                            while ($rowTP = $resultTP->fetch_assoc()) {
                                echo "'" . $rowTP['TenTP'] . "', ";
                            }
                            ?>],
                datasets: [{
                    label: 'Số lượng',
                    data: [<?php
                            $resultTP->data_seek(0); // Reset pointer đến đầu kết quả
                            while ($rowTP = $resultTP->fetch_assoc()) {
                                echo $rowTP['totalQuantityTP'] . ', ';
                            }
                            ?>],
                    backgroundColor: [<?php
                                        $colorIndex = 0;
                                        $resultTP->data_seek(0); // Reset pointer đến đầu kết quả
                                        while ($rowTP = $resultTP->fetch_assoc()) {
                                            echo "'" . $colors[$colorIndex] . "', ";
                                            $colorIndex = ($colorIndex + 1) % count($colors);
                                        }
                                        ?>],
                    borderColor: [<?php
                                    $resultTP->data_seek(0); // Reset pointer đến đầu kết quả
                                    while ($rowNVL2 = $resultTP->fetch_assoc()) {
                                        echo "'" . $colors[$colorIndex] . "', ";
                                    }
                                    ?>],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true // Thêm thuộc tính responsive
            }
        });


var ctx2 = document.getElementById('myblopt').getContext('2d');
        var myChart2 = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: [<?php
                            while ($rowNVL2 = $resultNVL2->fetch_assoc()) {
                                echo "'" . $rowNVL2['TenNVL'] . "', ";
                            }
                            ?>],
                datasets: [{
                    label: 'Số lượng',
                    data: [<?php
                            $resultNVL2->data_seek(0); // Reset pointer đến đầu kết quả
                            while ($rowNVL2 = $resultNVL2->fetch_assoc()) {
                                echo $rowNVL2['totalQuantityNVL'] . ', ';
                            }
                            ?>],
                    backgroundColor: [<?php
                                        $colorIndex = 0;
                                        $resultNVL2->data_seek(0); // Reset pointer đến đầu kết quả
                                        while ($rowNVL2 = $resultNVL2->fetch_assoc()) {
                                            echo "'" . $colors[$colorIndex] . "', ";
                                            $colorIndex = ($colorIndex + 1) % count($colors);
                                        }
                                        ?>],
                    borderColor: [<?php
                                    $resultNVL2->data_seek(0); // Reset pointer đến đầu kết quả
                                    while ($rowNVL2 = $resultNVL2->fetch_assoc()) {
                                        echo "'" . $colors[$colorIndex] . "', ";
                                    }
                                    ?>],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true // Thêm thuộc tính responsive
            }
        }); 
      }else {
        console.error("Chart.js is not loaded!");
    }
    </script>

</body>

</html>
