<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    <title>Quản lý kho</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bảng nhập liệu -->

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

        body{
            margin-top: 100px;
        }
    </style>
</head>
 <!-- Thanh menu -->
 <div id="horizontal-nav" class="nav" >
    <ul id="menu">
        <li><a href="TrangchuGD.php">Tổng Quan</a></li>

        <li><a href="#">Xem BCTK</a>
            <span class="arrow arrow-down"></span>
        <ul class="dropdown_menu">
            <li><a href="capnhatTP.php">Cập nhật TP</a></li>
            <li><a href="capnhatNVL.php">Cập nhật NVL</a></li>
        </ul>
        </li>

        <li><a href="#">Xem BCTK</a>
            <span class="arrow arrow-down"></span>
        <ul class="dropdown_menu">
            <li><a href="xemBCTKTP.php">Báo cáo tồn kho TP</a></li>
            <li><a href="xemBCTKNVL.php">Báo cáo tồn kho NVL</a></li>
        </ul>
        </li>
        <li><a href="giamdocduyetphieu.php">Duyệt phiếu</a></li>

        <li><a href="giamdoclapphieu.php">Lập phiếu</a></li>
        
        <li><a href="kiemke.php">Kiểm kê</a></li>

        <li><a href="../../xuly/index.php">Đăng xuất</a></li>
    </ul>
    </div>
<body>
   
    <!-- Bảng nhập liệu -->
    <h2 style="text-align: center;">LẬP PHIẾU MUA NGUYÊN VẬT LIỆU</h2>
    <th></th>
            <th>Mã phiếu</th>
            <td><input type="text" id="id_phieu_lap" readonly></td>
            <th>Ngày lập phiếu</th>
            <td><input type="text" id="ngay_lap_phieu" readonly></td>
            
    <table style="background-color: #c1cdcd" class="input-table">
        <tr>
            <th>ID nguyên vật liệu</th>
            <th>Tên nguyên vật liệu</th>
            <th>Số lượng</th>
            <th>Đơn vị tính</th>
            <th></th>
        </tr>
        <tr>
            <td>
            <select name="id_nguyen_vat_lieu" id="id_nguyen_vat_lieu">
                <?php
                    // Kết nối đến cơ sở dữ liệu trên XAMPP
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "quanlykho";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Kiểm tra kết nối
                    if ($conn->connect_error) {
                        die("Kết nối thất bại: " . $conn->connect_error);
                    }

                    // Truy vấn nguyên vật liệu từ cơ sở dữ liệu
                    $sql = "SELECT idNVL FROM nguyenvatlieu";
                    $result = $conn->query($sql);

                    // Hiển thị danh sách nguyên vật liệu trong dropdown
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["idNVL"] . "'>" . $row["idNVL"] . "</option>";
                        }
                    }

                    // Đóng kết nối
                    $conn->close();
                ?>
            </select>
            </td>
            <td><input type="text" name="ten_nguyen_vat_lieu" disabled="disabled"></td>
            <td><input type="text" name="so_luong"></td>
            <td><input disabled="disabled" type="text" name="don_vi_tinh"></td>
            <td><button type="button" onclick="themPhieuMua()">Thêm</button></td>
        </tr>
    </table>

    <!-- Bảng hiển thị dữ liệu đã nhập -->
    <h2 >Danh sách dữ liệu đã nhập:</h2>
    <table style="background-color: #c1cdcd" class="display-table">
        <tr>
            <th>Số thứ tự</th>
            <th>ID nguyên vật liệu</th>
            <th>Tên nguyên vật liệu</th>
            <th>Số lượng</th>
            <th>Đơn vị tính</th>
        </tr>
    </table>
    <button style="background-color: green" onclick="luuPhieuMua()">Xác nhận</button>
    <button onclick="resetBangHienThi()" style="float: right;background-color: red">Hủy bỏ</button>
    <script>
        // Biến đếm số thứ tự
        var soThuTu = 1;

        // Hàm để thêm phiếu mua vào bảng hiển thị
        // Hàm để thêm phiếu mua vào bảng hiển thị
        function capNhatDonViTinh() {
        var idNVL = document.getElementById("id_nguyen_vat_lieu").value;
        var donViTinhInput = document.getElementsByName("don_vi_tinh")[0];

        // Truy vấn đơn vị tính từ cơ sở dữ liệu
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                var donViTinh = JSON.parse(this.responseText).donViTinh;

                // Cập nhật ô đơn vị tính
                donViTinhInput.value = donViTinh;
            }
        };

        xhr.open("GET", "getDonViTinh.php?idNVL=" + idNVL, true);
        xhr.send();
        }
        function capNhatThongTinNVL() {
            var idNVL = document.getElementById("id_nguyen_vat_lieu").value;
            var tenNVLInput = document.getElementsByName("ten_nguyen_vat_lieu")[0];

            // Truy vấn tên nguyên vật liệu từ cơ sở dữ liệu
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    var tenNguyenVatLieu = JSON.parse(this.responseText).tenNguyenVatLieu;

                    // Cập nhật ô tên nguyên vật liệu
                    tenNVLInput.value = tenNguyenVatLieu;
                }
            };

            xhr.open("GET", "getTenNguyenVatLieu.php?idNVL=" + idNVL, true);
            xhr.send();
        }
        // Lắng nghe sự kiện khi chọn idNVL từ dropdown
        document.getElementById("id_nguyen_vat_lieu").addEventListener("change", capNhatDonViTinh);
        document.getElementById("id_nguyen_vat_lieu").addEventListener("change", capNhatThongTinNVL);

        // Hàm để thêm phiếu mua vào bảng hiển thị
        function themPhieuMua() {
            var idNVL = document.getElementsByName("id_nguyen_vat_lieu")[0].value;
            var soLuong = document.getElementsByName("so_luong")[0].value;
            var tenNVL = document.getElementsByName("ten_nguyen_vat_lieu")[0].value;
            var donViTinh = document.getElementsByName("don_vi_tinh")[0].value;
            // Kiểm tra số lượng
            if (soLuong <= 0 || isNaN(soLuong)) {
                alert("Số lượng phải lớn hơn 0 và là một số hợp lệ.");
                return;
            }

            // Truy vấn thông tin nguyên vật liệu từ cơ sở dữ liệu
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    var nguyenVatLieu = JSON.parse(this.responseText);

                    // Thêm dữ liệu vào bảng hiển thị
                    var displayTable = document.querySelector(".display-table");
                    var newRow = displayTable.insertRow(displayTable.rows.length);

                    var cell1 = newRow.insertCell(0);
                    var cell2 = newRow.insertCell(1);
                    var cell3 = newRow.insertCell(2);
                    var cell4 = newRow.insertCell(3);
                    var cell5 = newRow.insertCell(4);

                    cell1.innerHTML = soThuTu++;
                    cell2.innerHTML = idNVL;
                    cell3.innerHTML = tenNVL; // Thêm cột tên nguyên vật liệu
                    cell4.innerHTML = soLuong;
                    cell5.innerHTML = donViTinh; // Thêm cột đơn vị tính
                }
            };
            xhr.open("GET", "getDonViTinh.php?idNVL=" + idNVL, true);
            xhr.open("GET", "getTenNguyenVatLieu.php?idNVL=" + idNVL, true);
            xhr.send();
        }


    function luuPhieuMua() {
        // Lấy thông tin từ form
        var idPhieuLap = document.getElementById("id_phieu_lap").value;
        var ngayLapPhieu = document.getElementById("ngay_lap_phieu").value;

        // Lặp qua từng dòng trong bảng hiển thị
        var displayTable = document.querySelector(".display-table");
        var rows = displayTable.rows;
        
        if(rows.length == 1){
            alert("Bạn chưa nhập dữ liệu!!");
        }else{
            var confirmation = confirm("Bạn có chắc chắn với quyết định này?");
            if (confirmation){
            alert("Phiếu đã được lập thành công!");

            for (var i = 1; i < rows.length; i++) {
        
                var idNVL = rows[i].cells[1].innerHTML;
                var soLuong = rows[i].cells[3].innerHTML;
                var donViTinh = rows[i].cells[4].innerHTML;

                // Gửi dữ liệu đến server để lưu vào cơ sở dữ liệu
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (this.readyState === 4 && this.status === 200) {
                        console.log(this.responseText); // Log kết quả từ server

                        
                    }
                    
                };
                
                xhr.open("POST", "luuPhieuMua.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("idPhieuLap=" + idPhieuLap + "&ngayLapPhieu=" + ngayLapPhieu + "&idNVL=" + idNVL + "&soLuong=" + soLuong + "&donViTinh=" + donViTinh);
            }
            //resetBangHienThi();
        
            location.reload();}

}

        }
        
        
        
    function resetBangHienThi() {
        var confirmation = confirm("Bạn có chắc chắn với quyết định này?");
            if (confirmation){
        var displayTable = document.querySelector(".display-table");
        // Xóa tất cả các dòng, bắt đầu từ dòng thứ 1
        while (displayTable.rows.length > 1) {
            displayTable.deleteRow(1);
        }
        // Reset lại số thứ tự
        soThuTu = 1;}
    }

        // Tự động tạo ID phiếu lập và ngày lập phiếu
        window.onload = function () {
            var idPhieuLap ="PL"+Math.floor(1000 + Math.random() * 5555);
            var ngayLapPhieu1 = new Date();
            var ngayLapPhieu = ngayLapPhieu1.toISOString().slice(0, 10);
            document.getElementById("id_phieu_lap").value = idPhieuLap;
            document.getElementById("ngay_lap_phieu").value = ngayLapPhieu;
        };

        
    </script>
</body>
</html>
