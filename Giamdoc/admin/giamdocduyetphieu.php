<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý kho - Duyệt phiếu</title>
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

        /* CSS cho bảng hiển thị dữ liệu đã nhập */
        table.display-table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        table.display-table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        button {
            background-color: green;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
        }

        button.deny {
            background-color: red;
        }

        button:hover {
            background-color: #4CAF50;
        }

        button.deny:hover {
            background-color: #e74c3c;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.8);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
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
</head>
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

    <!-- Bảng hiển thị dữ liệu đã nhập -->
    <h2 style="text-align: center;">DUYỆT PHIẾU XUẤT NGUYÊN VẬT LIỆU</h2>
    <h4>Danh sách các phiếu yêu cầu cần duyệt</h4>

    <table class="display-table" style="background-color: #c1cdcd" class="input-table">
        <!-- <tr>
            <th>STT</th>
            <th>ID phiếu</th>
            <th>Ngày xuất</th>
            <th>Trạng thái</th>
            <th>Chi tiết</th>
            <th>Chọn</th>
        </tr> -->
        <?php
            // Kết nối đến cơ sở dữ liệu trên XAMPP
            $conn = new mysqli("localhost", "root", "", "quanlykho");
        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }

        // Truy vấn dữ liệu từ cơ sở dữ liệu
        $sql = "SELECT Maphieu, ngaylap, GROUP_CONCAT(TenNVL ORDER BY TenNVL) AS TenNVLs, GROUP_CONCAT(Soluong ORDER BY TenNVL) AS Soluongs, GROUP_CONCAT(DVT ORDER BY TenNVL) AS DVTs, Trangthai FROM phieuycxuatnvl GROUP BY Maphieu, ngaylap, Trangthai";
        $result = $conn->query($sql);

        // Hiển thị dữ liệu trong bảng
        $stt = 1;
        if ($result->num_rows >0 ) {
            echo "<table class='display-table' style='background-color: #c1cdcd' class='input-table'>";
            echo "<tr><th>STT</th><th>ID phiếu</th><th>Ngày xuất</th><th>Trạng thái</th><th>Chi tiết</th><th>Chọn</th></tr>";
            while ($row = $result->fetch_assoc()) {
                if ($row['Trangthai'] == '2') {
                    echo "<tr>";
                    echo "<td>{$stt}</td>";
                    echo "<td>{$row['Maphieu']}</td>";
                    echo "<td>{$row['ngaylap']}</td>";
                    //echo "<td>{$row['Trangthai']}</td>";
                    echo "<td>Chờ duyệt</td>";
                    echo "<td><button onclick=\"openModal('{$row['Maphieu']}', '{$row['TenNVLs']}','{$row['ngaylap']}', '{$row['Soluongs']}' , '{$row['DVTs']}')\">Chi tiết</button></td>";
                    echo "<td>";
                    echo "<button onclick=\"updateStatus('{$row['Maphieu']}', '1')\">Đồng ý</button>";
                    echo "<button class='deny' onclick=\"updateStatus('{$row['Maphieu']}', '3')\">Từ chối</button>";
                    echo "</td>";
                    echo "</tr>";
                    $stt++;
                }
            }
            echo "</table>";
        } else {
            echo "Không có phiếu để hiển thị.";
        }

        // Đóng kết nối
        $conn->close();
        ?>
    </table>
    <!-- Modal -->
    <div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <!-- Hiển thị thông tin chi tiết của phiếu -->
        <h3>Thông tin chi tiết phiếu</h3>
        <p><strong>ID phiếu:</strong> <span id="modal-maPhieu"></span></p>
        <p><strong>Tên NVL:</strong> <span id="modal-tenNVL"></span></p>
        <p><strong>Ngày xuất:</strong> <span id="modal-Ngayxuat"></span></p>
        <!-- Thêm các thông tin khác -->
        <p><strong>Số lượng:</strong> <span id="modal-Soluong"></span></p>
        <p><strong>Đơn vị tính:</strong> <span id="modal-DVT"></span></p>
        <!-- <p><strong>ID kho:</strong> <span id="modal-IDkho"></span></p>
        <p><strong>ID nhân viên:</strong> <span id="modal-IDNV"></span></p> -->
    </div>
</div>
<script>
    // Mở modal và hiển thị thông tin chi tiết của phiếu
    function openModal(maPhieu) {
        var modalContent = document.querySelector(".modal-content");
        
        // Gửi yêu cầu AJAX để lấy thông tin chi tiết từ server
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                modalContent.innerHTML = this.responseText;
                document.getElementById("myModal").style.display = "block";
            }
        };

        xhr.open("GET", "getDetails.php?Maphieu=" + maPhieu, true);
        xhr.send();
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
    function updateStatus(Maphieu, newStatus) {
    // Hiển thị hộp thoại xác nhận tích hợp
    var confirmation = confirm("Bạn có chắc chắn với quyết định này?");

    // Nếu người dùng chọn OK (Yes)
    if (confirmation) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                // Cập nhật trạng thái trên trang mà không cần tải lại
                var row = document.querySelector("tr[data-ma-phieu='" + Maphieu + "']");
                var statusCell = row.querySelector(".status-column");
                statusCell.textContent = newStatus;
            }
        };
        alert("Cập nhật thành công");

        xhr.open("GET", "updateStatus.php?Maphieu=" + Maphieu + "&newStatus=" + newStatus, true);
        xhr.send();
        setTimeout(function() {
            location.reload();
        }, 500);
    }
    // Ngược lại, nếu người dùng chọn Cancel (No)
    else {
        // Không làm gì hoặc thực hiện các hành động khác nếu cần
    }
}


</script>
</body>
</html>