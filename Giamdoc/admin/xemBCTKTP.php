<?php
 include ("../myclass/clsxemBCTK.php");
 $p = new xemBCTK()
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<title>Untitled Document</title>
</head>
<body>
<div id="horizontal-nav" class="nav" >
  <ul id="menu">
    <li><a href="TrangchuGD.php">Tổng Quan</a></li>

    <li><a href="#">Cập nhật</a>
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
<div class="body">
<?php
        $p->load_ds_tp("select * from thanhpham order by idTP asc");
       
       ?>
</div>
</body>
</html>