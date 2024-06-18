<?php
 include ("../myclass/clsnhap.php"); 
 $p = new nhapkho()
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<title>Biên bản</title>
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

    <!-- Lập biên bản -->
<div class="body">

<br />
<br /> 

  <form id="form1" name="form1" method="post" action="">
  <h2 style="text-align: center;"><strong>BIÊN BẢN KHO HÀNG </strong></h2>
  <table width="800" border="1" align="center" cellpadding="2"> 
    <tr>
      <td width="379" height="50" align="center" valign="middle"><h3>Mã phiếu biên bản </h3></td>
      <td width="401" height="50" align="center" valign="middle">
        <input name="txtma" type="text" id="txtma" size="50" />
      </td>
      </tr>
      <tr>
      <td width="379" height="50" align="center" valign="middle"><h3>Tên nguyên vật liệu </h3></td>
      <td width="401" height="50" align="center" valign="middle">
        <input name="txtten" type="text" id="txtten" size="50" />
      </td>
      </tr>
      <tr>
      <td height="50" align="center" valign="middle"><h3>Ngày mua </h3></td>
      <td height="50" align="center" valign="middle">
        <input name="ngaymua" type="date" id="ngaymua" size="50" /></td>
      </tr>
    <tr>
      <td height="50" align="center" valign="middle"><h3>Ngày sản xuất </h3></td>
      <td height="50" align="center" valign="middle">
        <input name="ngaysx" type="date" id="ngaysx" size="50" /></td>
      </tr>
    <tr>
      <td height="50" align="center" valign="middle"><h3>Ngày hết hạn </h3></td>
      <td height="50" align="center" valign="middle">
        <input name="hsd" type="date" id="hsd" size="50" /></td>
      </tr>
    <tr>
      <td height="50" align="center" valign="middle"><h3>Ghi chú </h3></td>
      <td height="50" align="center" valign="middle">
        <textarea name="txtmota" cols="50" rows="5" id="txtmota"></textarea></td>
      </tr>
      <td height="50" colspan="2" align="center" valign="middle">
        <input type="submit" name="nhap" id="nhap" value="Lập biên bản" />
        <input type="reset" name="huy" id="huy" value="Hủy" />
      </td>
    </tr>
  </table>
  
	<?php
         switch($_POST['nhap'])
         {
            case 'Lập biên bản':
            {
				$mabienban=$_REQUEST['txtma'];
				$ten=$_REQUEST['txtten'];
                $ngaymua=$_REQUEST['ngaymua'];
				$ngaysx=$_REQUEST['ngaysx'];
				$hsd=$_REQUEST['hsd'];
				$ghichu=$_REQUEST['txtmota'];
                
                    if($p->themxoasua("INSERT INTO bienban(maphieu,tenNVL,ngaymua,nsx,hsd,ghichu)VALUES ('$mabienban','$ten','$ngaymua','$ngaysx','$hsd','$ghichu')")==1)
                        {
                        echo '<script language="javascript">
                            alert("Lập biên bản thành công");
                                </script>';
                        echo '<script language="javascript">
                                window.location="../admin/bienban.php";
                                </script>';								
                        }		
                        else
                        {
                            echo 'Lập biên bản thành công';
                        }		 
                break;
            }
         }
        ?>
<br />
<hr />
<br />
      <h2 style="text-align: center;"><strong>DANH SÁCH CHI TIẾT CÁC BIÊN BẢN ĐÃ LẬP </strong></h2>
	   <?php
        $p->load_ds_bien_ban("select * from bienban order by idbienban asc");
       
       ?>
  </form>

</div>

</body>
</html>