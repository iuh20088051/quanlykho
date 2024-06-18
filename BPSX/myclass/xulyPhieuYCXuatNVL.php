<?php
header('Content-Type: text/html; charset=UTF-8');

class clsKetnoi {
    function ketnoiDB(&$connect) {
        $connect = mysqli_connect('localhost', 'qlkho', '123456', 'quanlykho') or die('Không thể kết nối tới database');
        mysqli_set_charset($connect, 'UTF8');
        if ($connect === false) {
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }
    }
}

$objKetnoi = new clsKetnoi();
$conn = null;
$objKetnoi->ketnoiDB($conn);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST["phieu_data"])) {
    try {
        $ngaylap = date("Y-m-d");
        $phieuData = json_decode($_POST["phieu_data"], true);

        // Lặp qua từng phần tử trong mảng $phieuData để lấy thông tin
        foreach ($phieuData as $phieu) {
            $tennvl = $phieu['name_nguyen_vat_lieu'];
            $soluong = $phieu['so_luong'];
            $DVT = $phieu['don_vi_tinh'];
            $maphieu = $phieu['ma_phieu'];

            // Thực hiện câu lệnh INSERT vào bảng
            $sql_bb = "INSERT INTO phieuycxuatnvl(ngaylap, TenNVL, Soluong, DVT, Maphieu, Trangthai) VALUES ('$ngaylap', '$tennvl', '$soluong', '$DVT', '$maphieu', 2)";
            $result_bb = $conn->query($sql_bb);

            if (!$result_bb) {
                throw new Exception("Lỗi khi thêm dữ liệu vào bảng: " . $conn->error);
            }
        }

        echo "<script>alert('Lập phiếu yêu cầu thành công')</script>";
        header("refresh:3;url=../admin/PhieuYCXuatNVL.php");
    } catch (Exception $e) {
        echo "Caught exception: ",  $e->getMessage(), "\n";
    }
}
?>
