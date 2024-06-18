<?php
 include ("../myclass/clsnhap.php"); 
 $p = new nhapkho()
?>
<?php
	include ("../myclass/clsphieu.php");
	$q = new phieu()
?>
<?php	

	$link=$q->connect();
	
	$link->set_charset("utf8");
	// Xử lý form khi được submit
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$ngay_nhap = $_POST["ngaynhap"];
		$nhan_vien = $_POST["tennv"];
		$kho = $_POST["tenkho"];
		$nguyen_vat_lieu = $_POST["txtnvl"];
		$so_luong = $_POST["soluong"];
		$dvt = $_POST["dvt"];
		$nsx = $_POST["nsx"];
		$hsd = $_POST["hsd"]; 
	
		// Thêm phiếu nhập kho
		$sql = "INSERT INTO phieunhapkhonvl (ngaynhap, IDkho, IDNV) VALUES ('$ngay_nhap', $kho, '$nhan_vien')";
		if ($link->query($sql) === TRUE) 
		{
			
			$phieu_nhap_id = $link->insert_id;
	
			// Thêm nguyên vật liệu
			foreach ($nguyen_vat_lieu as $key => $value) 
			{
				$tennvl = $nguyen_vat_lieu[$key];
				$soluong = $so_luong[$key];
				$dvtnvl = $dvt[$key];
				$nxsnvl = $nsx[$key];
				$hsdnvl = $hsd[$key];
	
				$sql_nguyen_vat_lieu = "INSERT INTO nguyenvatlieu (TenNVL, Soluong, DVT, NgaySX, HSD, idnhapnvl) VALUES ('$tennvl', '$soluong', '$dvtnvl', '$nxsnvl', '$hsdnvl', '$phieu_nhap_id')";
				$link->query($sql_nguyen_vat_lieu);
				
				// Lấy idNVL sau mỗi lần thêm
    				$idNVL = $link->insert_id;
			}
	
			echo '<script language="javascript">
					alert("Nhập kho thành công");
				  </script>';
			echo '<script language="javascript">
				   window.location="../admin/nhapkhoNVL.php";
				  </script>';
		} 
		else 
		{
			echo "Lỗi: " . $sql . "<br>" . $link->error;
		}
	}
	
	$link->close();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<title>Nhập kho nguyên vật liệu </title>
</head>

<body>

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
    
    <!-- Bảng nhập NVL-->
 <div class="body">
<br />
<br /> 
    <h3>Kiểm tra hàng trước khi nhập có sai xót gì thi lập biên bản <a href="bienban.php">Tại đây</a> để gửi cho nhà cung cấp </h3> 
     <form id="form1" name="form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm()">
    <h2 style="text-align: center;"><strong>PHIẾU NHẬP KHO NGUYÊN VẬT LIỆU</strong></h2>
    <div align="center">
   	<label>Ngày nhập kho NVL:  </label><input name="ngaynhap" type="date" id="ngaynhap" size="50" required  />
    <br />
    <br /> 
   	<label>Kho hàng</label>
      <?php
      	$p->loadcombo_kho("select*from kho order by TenKho asc", $idkho);
	  ?>
     <br /> 
     <br /> 
    <label>Nhân viên thực hiện</label>
       <?php
      	$p->loadcombo_nhanvien("select*from nhanvien order by TenNV asc", $idnv);
	  ?>
     </div>
     <br />
    <table width="1300" border="1" align="center" id="nguyen_vat_lieu">
    <tr>
      <td height="50" align="center" valign="middle"><h3>Tên nguyên vật liệu </h3></td>
      <td height="50" align="center" valign="middle"><h3>Số lượng </h3></td>
      <td height="50" align="center" valign="middle"><h3>Đơn vị tính </h3></td>
      <td height="50" align="center" valign="middle"><h3>Ngày sản xuất </h3></td>
      <td height="50" align="center" valign="middle"><h3>Ngày hết hạn </h3></td>
    </tr>
    <tr>
      <td height="50" align="center" valign="middle"><input name="txtnvl[]" type="text" id="txtnvl" size="40" required /></td>
      <td height="50" align="center" valign="middle"><input name="soluong[]" type="number" id="soluong" size="10" required /></td>
      <td height="50" align="center" valign="middle" >
      <input name="dvt[]" type="text" id="dvt" size="10" required /></td>
      <td height="50" align="center" valign="middle">
      <input name="nsx[]"type="date"  id="nsx" size="20" required /></td>
      <td height="50" align="center" valign="middle">
      <input name="hsd[]" type="date" id="hsd" size="20" required /></td>
    </tr>
    </table>
     <p style="text-align: center;">
          <button type="button" onclick="themNguyenVatLieu()">Thêm nguyên vật liệu</button>
     
  </p>
  <br />

  <p style="text-align: center;">
        
       <input type="submit" name="luu" id="luu" value="Nhập kho" />
       <input type="reset" name="huy" id="huy" value="Hủy " />
     </p>
	
   </form>
 </div>
 <script>
 
 		function themNguyenVatLieu() 
		{
			var table = document.getElementById("nguyen_vat_lieu");
			var lastRow = table.rows[table.rows.length - 1];
			var newRow = lastRow.cloneNode(true);
	
			// Xóa giá trị của các ô input trong hàng mới
			var inputsAndSelect = newRow.querySelectorAll('input, select');
			for (var i = 0; i < inputsAndSelect.length; i++) 
			{
				inputsAndSelect[i].value = '';
			}
	
			table.appendChild(newRow);
    	}
		
         function validateForm() 
		 {
        // Kiểm tra các trường bắt buộc không được để trống
			var ngayNhap = document.getElementById("ngaynhap").value;
			var tenNV = document.getElementById("tennv").value;
			var tenKho = document.getElementById("tenkho").value;
	
			if (ngayNhap === "" || tenNV === "" || tenKho === "") 
			{
				alert("Vui lòng nhập đầy đủ thông tin bắt buộc.");
				return false; // Ngăn chặn việc gửi form nếu có trường bắt buộc để trống
			}
	
			var soluongInputs = document.getElementsByName("soluong[]");
	
			for (var i = 0; i < soluongInputs.length; i++) 
			{
				var soluong = soluongInputs[i].value;
	
				if (soluong === "" || isNaN(soluong) || soluong < 0) 
				{
					alert("Số lượng không hợp lệ. Vui lòng nhập số lượng không âm.");
					return false; // Ngăn chặn việc gửi form nếu số lượng không hợp lệ
				}
        }
		  // Kiểm tra ít nhất một dòng nguyên vật liệu
        if (document.getElementsByName("txtnvl[]").length === 0) {
            alert("Bạn cần thêm ít nhất một dòng nguyên vật liệu.");
            return false; // Ngăn chặn việc gửi form nếu không có dòng nguyên vật liệu
        }

        return true; // Cho phép gửi form nếu thông tin hợp lệ
    }

       
    </script>
</body>
</html>