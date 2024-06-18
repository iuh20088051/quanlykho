<?php
 include ("../myclass/clsquanlykho.php");
 $p = new quanlykho()
?>
<?php
	if(isset($_REQUEST['layid']))
	{
		$layid=$_REQUEST['layid'];
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<title>Cập nhật số lượng tồn kho </title>
</head>

<body>
<div id="horizontal-nav" class="nav" >
  <ul id="menu">
    <li><a href="TrangchuGD.php">Tổng Quan</a></li>

    <li><a href="#">Cập nhật SLTK</a>
    	 <span class="arrow arrow-down"></span>
      <ul class="dropdown_menu">
        <li><a href="capnhatTP.php">Cập nhật SLTK TP</a></li>
        <li><a href="capnhatNVL.php">Cập nhật SLTK NVL</a></li>
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
<div class="body">
<form id="form1" name="form1" method="post" action="">

    <h2 style="text-align: center;"><strong>CẬP NHẬT SỐ LƯỢNG TỒN KHO NVL</strong></h2>
    <table width="1300" border="1" align="center">
    <tr>
      <td height="50" align="center" valign="middle"><h3>ID </h3></td>
      <td height="50" align="center" valign="middle"><h3>TÊN NGUYÊN VẬT LIỆU</h3></td>
      <td height="50" align="center" valign="middle"><h3>SL </h3></td>
      <td height="50" align="center" valign="middle"><h3>KHO </h3></td>
      
    </tr>
    <tr>
      <td height="50" align="center" valign="middle">
      <input name="id" type="text" id="id" size="10" value="<?php echo $layid;?>">
      
      </td>
      <td height="50" align="center" valign="middle"><input name="txtsp" type="text" id="txtsp" size="30" value="<?php echo $p->laycot("select TenNVL from nguyenvatlieu where idNVL='$layid' limit 1");?>"></td>
      <td height="50" align="center" valign="middle" ><input name="soluong" type="text" id="soluong" size="20" value="<?php echo $p->laycot("select Soluong from nguyenvatlieu where idNVL='$layid' limit 1");?>"></td>
      <td height="50" align="center" valign="middle">
	  <?php
	  $idkho=$p->laycot("select idkho from nguyenvatlieu where idNVL='$layid' limit 1");
      	$p->loadcombo_kho("select*from kho order by TenKho asc", $idkho);
	  	?>
 
    </tr>
    <tr align="center">
     <td height="40" colspan="5" valign="middle">
        <input  class="button-link" type="submit" name="nhap" id="nhap" value="Cập nhật" />
        <a href="kiemke.php" class="button-link"> Quay lại </a>
    </tr>
  </table>
  </div>
	<?php
         switch($_POST['nhap'])
         {
            case 'Cập nhật':
            {
				$idsua=$_REQUEST['id'];
				$tenloaihang=$_REQUEST['txtsp'];
                $soluong=$_REQUEST['soluong'];
				$tenkho=$_REQUEST['tenkho'];
              if($soluong >= 0)
			  {
				if($idsua>0)
				{
					 if($p->themxoasua("UPDATE nguyenvatlieu SET TenNVL = '$tenloaihang', Soluong = '$soluong' , idkho = '$tenkho' WHERE idNVL ='$idsua' LIMIT 1")==1)
                        {
                        echo '<script language="javascript">
                            alert("Cập nhật thành công");
                                </script>';
                        echo '<script language="javascript">
                                window.location="../admin/capnhatNVL.php";
                                </script>';								
                        }		
                        else
                        {
                            echo 'Cập nhật không thành công';
                        }		 
				}
				else
			{
				echo 'Vui lòng chọn sản phẩm cần sửa';
			}
			  }
			  else
			  {
				  echo'số lượng không hợp lệ, vui lòng nhập lại';
			  }
                   
                break;
            }
         }
        ?>
        
        <br />
<hr />
<br />
     <h2 style="text-align: center;"><strong>DANH SÁCH  </strong></h2>

     <?php
        $p->load_ds_nvl("select * from nguyenvatlieu order by idNVL asc");
       
       ?>
    
   </form>
   

</body>
</html>