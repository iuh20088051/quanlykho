<meta charset="UTF-8" />
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
    // $manvl = $_REQUEST["maNVL"];
    $sql1 = "SELECT MAX(maBienBan) as max_maPhieu FROM bienbantrahang";
      $result1 = $conn->query($sql1);

      //Lấy mã phiếu mới nhất + 1
      if ($result1->num_rows > 0) {
        $row = $result1->fetch_assoc();
        $nextPrimaryKey = $row["max_maPhieu"] + 1;
      } else {
        $nextPrimaryKey = 1;
      }
      $sql_tp = "SELECT DISTINCT idNVL, TenNVL FROM nguyenvatlieu";

    $url_trang_truoc = $_SERVER['HTTP_REFERER'];
    
    if(isset($_REQUEST["btnlapphieu"])){
      $maphieu = $nextPrimaryKey;
      $ngayNhap = $_REQUEST["ngaylap"];
      $tennvl_s = $_REQUEST["tennvl"];    
      $nguyennhan_s = $_REQUEST["nguyennhan"];     
      $ngayHienTai = date("Y-m-d");

      
      if (empty($_REQUEST["ngaylap"])){
          echo "<script>alert('Vui lòng chọn ngày lập')</script>";
          echo header("refresh:0 url=../admin/Trahang.php");
      }elseif ($ngayNhap < $ngayHienTai) {
        // So sánh ngày
          echo "<script>alert('Ngày lập nhỏ hơn ngày hiện tại vui lòng nhập lại!!')</script>";
          echo header("refresh:0 url=../admin/Trahang.php");
      }else{  
          // Thực hiện câu lệnh INSERT vào bảng
          $sql_bb = "INSERT INTO bienbantrahang(maBienBan, ngayLap, trangThai) VALUES ($nextPrimaryKey, '$ngayNhap', 2)";
          $result_bb = $conn->query($sql_bb);
          if (!$result_bb) {
              throw new Exception("Lỗi khi thêm dữ liệu vào bảng bienbantrahang: " . $conn->error);
          }
          for ($i = 0; $i < count($tennvl_s); $i++) {
              $sql_bb = "INSERT INTO chitietbienbantrahang(maNVL, lyDoTraHang, maBBTraHang) VALUES ('$tennvl_s[$i]', '$nguyennhan_s[$i]', $nextPrimaryKey)";
              $result_bb = $conn->query($sql_bb);
              if (!$result_bb) {
                  throw new Exception("Lỗi khi thêm dữ liệu vào bảng bienbantrahang: " . $conn->error);
              }
          }
          echo "<script>alert('Lập biên bản trả hàng thành công')</script>";
          header("refresh:0 url=../admin/Trahang.php");
      }
    }
    // }
?>