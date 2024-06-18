<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
    <title>Quản lý kho</title>
</head>
<?php
header('Content-Type: text/html; charset=UTF-8');

session_start();

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

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user'])) {
    header('Location: ../xuly/index.php');
    exit();
}

//tạo ngẫu nhiên mã phiếu
function taoMaPhieu() {
    // Tạo một số ngẫu nhiên có 4 chữ số
    $soNgauNhien = sprintf("%04d", rand(0, 9999));
    
    // Kết hợp với chuỗi "PL"
    $maPhieu = 'PL' . $soNgauNhien;

    return $maPhieu;
}


// Lấy tên đăng nhập từ session
$username = $_SESSION['user'];

// Lấy ngày hiện tại từ PHP và định dạng theo định dạng mong muốn
$ngay_hien_tai = date("Y-m-d");

// Truy vấn để lấy dữ liệu từ bảng nguyen_lieu
$sql = "SELECT idNVL, TenNVL, DVT FROM nguyenvatlieu";
$result = $conn->query($sql);


?>
<body>
    <!-- Thanh menu -->
    <ul class="menu">
        <li class="menu-item"><a href="trangchuBPSX.php">Trang chủ</a></li>
        <li class="menu-item"><a href="PhieuYCNhapTP.php">Lập phiếu yêu cầu nhập TP</a></li>
        <li class="menu-item"><a href="../../xuly/index.php">Đăng xuất</a></li>
    </ul>
    <!-- Bảng nhập liệu -->
    <h2 style="text-align: center;">Lập phiếu yêu cầu xuất nguyên vật liệu </h2>
    <table class="input-table">
            
        
        <tr>
            <th>Tên nguyên vật liệu</th>
            <th>Số lượng</th>
            <th>Đơn vị tính</th>
            <th></th>
        </tr>
        <tr>
            <td>
                <select name="name_nguyen_vat_lieu" id="name_nguyen_vat_lieu" onchange="updateDonViTinh()">
                    <?php
                    if ($result->num_rows > 0) {
                        // Lặp qua từng dòng dữ liệu
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["idNVL"] . '" data-don-vi-tinh="' . $row["DVT"] . '">' . $row["TenNVL"] . '</option>';
                        }
                    } else {
                        echo '<option value="">Không có nguyên vật liệu</option>';
                    }
                    ?>
                </select>
            </td>
            <td><input type="text" name="so_luong" id="so_luong"></td>
            <td><input disabled="disabled" type="text" name="don_vi_tinh" id="don_vi_tinh"></td>
            <td><button type="button" onclick="themPhieuMua()">Thêm</button></td>
        </tr>
    </table>

    <!-- Bảng hiển thị dữ liệu đã nhập -->
    <h2 style="text-align: center;">Danh sách dữ liệu đã nhập</h2>
    <form name="xuatnvl" action="../myclass/xulyPhieuYCXuatNVL.php" method="POST">
        <table class="display-table">
            <tr>
                <th>Số thứ tự</th>
                <th>Tên nguyên vật liệu</th>
                <th>Số lượng</th>
                <th>Đơn vị tính</th>
                <th>Mã phiếu</th>
                <td class="hidden" style="display: none;"><input type="text" name="ma_phieu" id="ma_phieu" value="<?php echo taoMaPhieu(); ?>" readonly></td>   
                <th>Ngày lập phiếu</th>
                <td class="hidden" style="display: none;"><input type="text" id="ngay_lap_phieu" readonly></td>
            </tr>
        </table>
        <input type="hidden" name="phieu_data" id="phieu_data" value="">
        <button type="submit" name="xac_nhan">Xác nhận</button>
        <button type="reset" style="float: right;">Hủy bỏ</button>
    </form>
    <script>
        // Biến đếm số thứ tự
        var soThuTu = 1;

        var phieuData = [];
        // Hàm để thêm phiếu mua vào bảng hiển thị
        function themPhieuMua() {
            var selectElement = document.getElementById("name_nguyen_vat_lieu");
            var soLuongElement = document.getElementsByName("so_luong")[0];
            var donViTinhElement = document.getElementsByName("don_vi_tinh")[0];
            var maphieuElement = document.getElementById("ma_phieu");
            var ngaylapElement = document.getElementById("ngay_lap_phieu");
            

            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var tenNVL = selectedOption.textContent;
            var soLuong = soLuongElement.value;
            var donViTinh = donViTinhElement.value;
            var maphieu = maphieuElement.value;
            var ngaylap = ngaylapElement.value;

            // Kiểm tra xem đã chọn nguyên vật liệu chưa
            if (selectedOption.value !== "") {
                // Kiểm tra số lượng phải lớn hơn 0
                if (parseFloat(soLuong) > 0) {
                    // Thêm dòng mới vào bảng hiển thị
                    var displayTable = document.querySelector(".display-table");
                    var newRow = displayTable.insertRow(-1);
                    var cellSTT = newRow.insertCell(0);
                    var cellTenNVL = newRow.insertCell(1);
                    var cellSoLuong = newRow.insertCell(2);
                    var cellDonViTinh = newRow.insertCell(3);
                    var cellmaphieu = newRow.insertCell(4);
                    var cellngaylap = newRow.insertCell(5);

                    cellSTT.innerHTML = displayTable.rows.length - 1;
                    cellTenNVL.innerHTML = tenNVL;
                    cellSoLuong.innerHTML = soLuong;
                    cellDonViTinh.innerHTML = donViTinh;
                    cellmaphieu.innerHTML = maphieu;
                    cellngaylap.innerHTML = ngaylap;

                    // Lưu thông tin phiếu vào mảng
                    phieuData.push({
                        name_nguyen_vat_lieu: tenNVL,
                        so_luong: soLuong,
                        don_vi_tinh: donViTinh,
                        ma_phieu: maphieu
                    });

                    // Cập nhật giá trị của input ẩn phieu_data
                    document.getElementById("phieu_data").value = JSON.stringify(phieuData);
                } else {
                    alert("Số lượng phải lớn hơn 0.");
                }
            }
        }

        // ngày lập phiếu
        document.getElementById("ngay_lap_phieu").value = "<?php echo $ngay_hien_tai; ?>";
       
        // đơn vị tính
        function updateDonViTinh() {
            var selectElement = document.getElementById("name_nguyen_vat_lieu");
            var donViTinhElement = document.getElementsByName("don_vi_tinh")[0];

            // Kiểm tra xem có nguyên vật liệu được chọn không
            if (selectElement.selectedIndex !== -1) {
                // Lấy giá trị đơn vị tính từ thuộc tính data-don-vi-tinh của option
                var donViTinh = selectElement.options[selectElement.selectedIndex].getAttribute("data-don-vi-tinh");
                donViTinhElement.value = donViTinh;
            } else {
                // Nếu không có nguyên vật liệu được chọn, đặt giá trị đơn vị tính về trống
                donViTinhElement.value = "";
            }
        }
        // Gọi hàm khi trang web được tải
            document.addEventListener("DOMContentLoaded", function() {
                updateDonViTinh();
            });

    </script>
</body>
</html>
