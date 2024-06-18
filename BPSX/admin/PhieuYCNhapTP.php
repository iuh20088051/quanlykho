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

// tạo mã phiếu
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
$sql = "SELECT idTP, TenTP, DVT FROM thanhpham";
$result = $conn->query($sql);

?>
<body>
    <!-- Thanh menu -->
    <ul class="menu">
        <li class="menu-item"><a href="trangchuBPSX.php">Trang chủ</a></li>
        <li class="menu-item"><a href="PhieuYCXuatNVL.php">Lập phiếu yêu cầu xuất NVL</a></li>
        <li class="menu-item"><a href="../../xuly/index.php">Đăng xuất</a></li>
    </ul>
    <!-- Bảng nhập liệu -->
    <h2 style="text-align: center;">Lập phiếu yêu cầu nhập thành phẩm </h2>
    <table class="input-table">
            
        
        <tr>
            <th>Tên thành phẩm</th>
            <th>Số lượng</th>
            <th>Đơn vị tính</th>
            <th>Ngày sản xuất</th>
            <th>Hạn sử dụng</th>
        </tr>
        <tr>
            <td>
                <select name="name_tp" id="name_tp" onchange="updateDonViTinh()">
                    <?php
                    if ($result->num_rows > 0) {
                        // Lặp qua từng dòng dữ liệu
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["idTP"] . '" data-don-vi-tinh="' . $row["DVT"] . '">' . $row["TenTP"] . '</option>';
                        }
                    } else {
                        echo '<option value="">Không có thành phẩm</option>';
                    }
                    ?>
                </select>
            </td>    
            <td><input type="text" name="so_luong" id="so_luong"></td>
            <td><input disabled="disabled" type="text" name="don_vi_tinh" id="don_vi_tinh"></td>
            <td><input type="date" name="ngay_san_xuat" id="ngay_san_xuat" value=""></td>
            <td><input type="date" name="han_su_dung" id="han_su_dung" value=""></td>
            <td><button type="button" onclick="themPhieuMua()">Thêm</button></td>
        </tr>
    </table>

    <!-- Bảng hiển thị dữ liệu đã nhập -->
    <h2 style="text-align: center;">Danh sách dữ liệu đã nhập</h2>
    <form name="xuatnvl" action="../myclass/xulyPhieuYCNhapTP.php" method="POST">
        <table class="display-table">
            <tr>
                <th>Số thứ tự</th>
                <th>Tên thành phẩm</th>
                <th>Số lượng</th>
                <th>Đơn vị tính</th>
                <th>Ngày sản xuất</th>
                <input type="hidden" id="ngay_san_xuat" name="ngay_san_xuat" value="">
                <th>Hạn sử dụng</th>
                <input type="hidden" id="han_su_dung" name="han_su_dung" value="">
                <th>Mã phiếu</th>
                <input type="hidden" id="ma_phieu" name="ma_phieu" value="<?php echo taoMaPhieu(); ?>">
                <th>Ngày lập phiếu</th>
                <input type="hidden" id="ngay_lap_phieu" name="ngay_lap_phieu" value="">
            </tr>
        </table>
        <input type="hidden" id="phieu_data" name="phieu_data" value="">
        <button type="submit" name="xac_nhan">Xác nhận</button>
        <button type="reset" style="float: right;">Hủy bỏ</button>
    </form>
    <script>
        // Biến đếm số thứ tự
        var soThuTu = 1;
        var phieuData = [];

        // Hàm để thêm phiếu mua vào bảng hiển thị
        function themPhieuMua() {
            // Thêm các dòng mới vào bảng hiển thị
            var selectElement = document.getElementById("name_tp");
            var soLuongElement = document.getElementsByName("so_luong")[0];
            var donViTinhElement = document.getElementsByName("don_vi_tinh")[0];
            var ngaySXElement = document.getElementById("ngay_san_xuat");
            var hanSDElement = document.getElementById("han_su_dung");
            var maphieuElement = document.getElementById("ma_phieu");
            var ngaylapElement = document.getElementById("ngay_lap_phieu");

            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var tenTP = selectedOption.textContent;
            var soLuong = soLuongElement.value;
            var donViTinh = donViTinhElement.value;
            var ngaySX = ngaySXElement.value;
            var hanSD = hanSDElement.value;
            var maphieu = maphieuElement.value;
            var ngaylap = ngaylapElement.value;

            // Kiểm tra điều kiện ngày sản xuất và hạn sử dụng
            if (!kiemTraNgay()) {
                return;
            }
            // Kiểm tra xem đã chọn chưa
            if (selectedOption.value !== "") {
                // Kiểm tra số lượng phải lớn hơn 0
                if (parseFloat(soLuong) > 0) {

                    // Thêm dòng mới vào bảng hiển thị
                    var displayTable = document.querySelector(".display-table");
                    var newRow = displayTable.insertRow(-1);
                    var cellSTT = newRow.insertCell(0);
                    var cellTenTP = newRow.insertCell(1);
                    var cellSoLuong = newRow.insertCell(2);
                    var celldonViTinh = newRow.insertCell(3);
                    var cellngaySX = newRow.insertCell(4);
                    var cellhanSD = newRow.insertCell(5);
                    var cellmaphieu = newRow.insertCell(6);
                    var cellngaylap = newRow.insertCell(7);

                    cellSTT.innerHTML = displayTable.rows.length - 1;
                    cellTenTP.innerHTML = tenTP;
                    cellSoLuong.innerHTML = soLuong;
                    celldonViTinh.innerHTML = donViTinh;
                    cellngaySX.innerHTML = ngaySX;
                    cellhanSD.innerHTML = hanSD;
                    cellmaphieu.innerHTML = maphieu;
                    cellngaylap.innerHTML = ngaylap;

                    phieuData.push({
                        name_tp: tenTP,
                        so_luong: soLuong,
                        don_vi_tinh: donViTinh,
                        NSX: ngaySX,
                        HSD: hanSD,
                        ma_phieu: maphieu
                    });

                    // Cập nhật giá trị của input ẩn phieu_data
                    document.getElementById("phieu_data").value = JSON.stringify(phieuData);
        }else {
                alert("Số lượng phải lớn hơn 0.");
        }
        }
        }

        // điều kiện ngày sản xuất và hạn sử dụng
        function kiemTraNgay() {
            var ngaySX = document.getElementById("ngay_san_xuat").value;
            var hanSD = document.getElementById("han_su_dung").value;

            // Chuyển đổi giá trị ngày từ chuỗi sang đối tượng Date
            var ngaySanXuatDate = new Date(ngaySX);
            var hanSuDungDate = new Date(hanSD);
            var ngayHienTai = new Date();

            // Kiểm tra ngày sản xuất không vượt qua ngày hiện tại
            if (ngaySanXuatDate > ngayHienTai) {
                alert("Ngày sản xuất không thể vượt quá ngày hiện tại.");
                return false;
            }

            // Kiểm tra hạn sử dụng không nhỏ hơn ngày sản xuất
            if (hanSuDungDate < ngaySanXuatDate) {
                alert("Hạn sử dụng phải lớn hơn hoặc bằng ngày sản xuất.");
                return false;
            }

            return true;
        }

        // Tự động tạo ID phiếu lập và ngày lập phiếu
        document.getElementById("ngay_lap_phieu").value = "<?php echo $ngay_hien_tai; ?>";

        function updateDonViTinh() {
            var selectElement = document.getElementById("name_tp");
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
