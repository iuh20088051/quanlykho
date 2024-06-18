<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lập Biên Bản Trả Hàng</title>
  <!-- Link to Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>
  <style>
/* CSS Document */

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
  main{
    margin-top: 100px;
  }

  
  </style>
<body>
<div id="horizontal-nav" class="nav">
        <ul id="menu">
            <li><a href="TrangchuQL.php">Tổng Quan</a></li>

            <li><a href="thongke.php">Thống kê</a></li>

            <li><a href="Trahang.php">Trả hàng</a></li>

            <li><a href="Lichtrinh.php">Lịch trình</a></li>

            <li><a href="../../xuly/index.php">Đăng xuất</a></li>
        </ul>
    </div>
  <main>
    <?php
      class clsKetnoi {
        function ketnoiDB(&$connect) {
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
      $sql1 = "SELECT MAX(maBienBan) as max_maPhieu FROM bienbantrahang";
      $result1 = $conn->query($sql1);

      //Lấy mã phiếu mới nhất + 1
      if ($result1->num_rows > 0) {
        $row = $result1->fetch_assoc();
        $nextPrimaryKey = $row["max_maPhieu"] + 1;
      } else {
        $nextPrimaryKey = 1;
      }

      // Lấy ngày hôm nay
      $ngayHomNay = date("Y-m-d");

      $sql_tp = "SELECT DISTINCT idNVL, TenNVL FROM nguyenvatlieu";
    ?>
    
    <center>
      <h3>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</h3>
      <h4>Độc lập - Tự do - Hạnh phúc</h4>
      <p>---------------------------</p>
      <h4><b>BIÊN BẢN TRẢ HÀNG</b></h4>
    </center>
    <form onsubmit="return confirmSubmission()" action="../myclass/xulyBienBanTraHang.php" method="get">
      <FIELDSET style="background-color: #eeeeee;" class="mt-5 pb-3 ml-5 mr-5">
        <legend class="ml-2">Chi tiết biên bản</legend>
          <div class="form-row ml-4">
            <table style="width: 25%;">
              <tr>
                <td>Mã biên bản:</td>
                <td><input type="text" class="col-11 form-control" value="<?php echo $nextPrimaryKey  ?>" disabled></td>
              </tr>
              <tr>
                <td>Ngày lập:</td>
                <td><input type="date" class="col-11 form-control" name="ngaylap" value="<?php echo date('Y-m-d'); ?>"></td>
              </tr>
              <tr>
                <td>Người lập:</td>
                <td><input type="text" class="col-11 form-control" value="Quản lý" disabled></td>
              </tr>
            </table>
          </div>
      </FIELDSET>
      <FIELDSET style="background-color: #eeeeee;" class="mt-5 pb-3 ml-5 mr-5">
        <legend class="ml-2">Thông tin nguyên vật liệu trả</legend>
        <div class="form-row ml-4 mr-4">
            <div class="col-md-5 form-group mb-3">
                <label class="" for="thanhpham">Nguyên vật liệu</label>
                <?php
                  $kq_tp = $conn->query($sql_tp);
                  echo "<select name='tennvl[]' class='form-control' id='tennvl' required>";
                  echo "<option value=''>Chọn tên nguyên vật liệu</option>";
                  while ($row = $kq_tp->fetch_assoc()) {
                    echo "<option value='". $row["idNVL"]."'>" . $row["TenNVL"] . "</option>";
                  }
                  echo "</select>";
                ?>
            </div>
            <div class="col-md-5 form-group mb-3">
                <label class="" for="nguyennhan">Nguyên nhân trả</label>
                <textarea name="nguyennhan[]" id="" cols="50" rows="1" class="form-control" placeholder="Vui lòng nhập nguyên nhân tại đây!!" required></textarea>
            </div>
            <div class="col-md-1 form-group mb-3">
                <label for="validationDefault01">&nbsp;</label> 

                <input type="button" class="form-control btn btn-outline-primary" onclick="addProduct()" name="them" id="btnThem" value="thêm">
            </div>  
        </div>
        <div class="form-row ml-4 mr-4" id="add_data">

        </div>
      </FIELDSET>
      <center>
        <div class="button" style="padding-top: 100px;">
          <input type="reset" class="col-2 btn btn-danger" value="Nhập lại" style="margin-right: 150px;">
          <input type="submit" class="col-2 btn btn-success" value="Lập biên bản" name="btnlapphieu">
        </div>
      </center>     
    </form>

    <script>
        function confirmSubmission() {
            // Sử dụng hàm confirm để hiển thị hộp thoại xác nhận
            var isConfirmed = confirm("Xác nhận lập biên bản?");
            
            // Nếu người dùng đồng ý, return true để submit form, ngược lại return false
            return isConfirmed;
        }

        function addProduct() {

          // Tạo một div mới để chứa nội dung
        var newDiv1 = document.createElement('div');
        newDiv1.className = 'col-md-5 form-group mb-3';
        var newDiv2 = document.createElement('div');
        newDiv2.className = 'col-md-5 form-group mb-3';

        // Thêm nội dung HTML hiện tại vào div mới
        newDiv1.innerHTML = `
                    <?php
                      $kq_tp = $conn->query($sql_tp);
                      echo "<select name='tennvl[]' class='form-control' id='tennvl' required>";
                      echo "<option value=''>Chọn tên nguyên vật liệu</option>";
                      while ($row = $kq_tp->fetch_assoc()) {
                        echo "<option value='". $row["idNVL"]."'>" . $row["TenNVL"] . "</option>";
                      }
                      echo "</select>";
                    ?>`;
        newDiv2.innerHTML = `<textarea name="nguyennhan[]" id="" cols="50" rows="1" class="form-control" placeholder="Vui lòng nhập nguyên nhân tại đây!!" required></textarea>`;
        // Thêm div mới vào div mục tiêu
        document.getElementById('add_data').appendChild(newDiv1);
        document.getElementById('add_data').appendChild(newDiv2);
        }
    </script>
  </main>
  
  <!-- Link to Bootstrap JS (Popper.js and jQuery are required for Bootstrap) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>