<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Đăng nhập</title>
</head>
<style>
    body {
        background: url('../images/bg.jpeg');
        background-size: cover;
        background-position-y: -80px;
        font-size: 16px;
    }
    
    #wrapper {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    #form-login {
        max-width: 400px;
        background: rgba(0, 0, 0, 0.8);
        flex-grow: 1;
        padding: 30px 30px 40px;
        box-shadow: 0px 0px 17px 2px rgba(255, 255, 255, 0.8);
    }
    
    .form-heading {
        font-size: 25px;
        color: #f5f5f5;
        text-align: center;
        margin-bottom: 30px;
    }
    
    .form-group {
        border-bottom: 1px solid #fff;
        margin-top: 15px;
        margin-bottom: 20px;
        display: flex;
    }
    
    .form-group i {
        color: #fff;
        font-size: 14px;
        padding-top: 5px;
        padding-right: 10px;
    }
    
    .form-input {
        background: transparent;
        border: 0;
        outline: 0;
        color: #f5f5f5;
        flex-grow: 1;
    }
    
    .form-input::placeholder {
        color: #f5f5f5;
    }
    
    #eye i {
        padding-right: 0;
        cursor: pointer;
    }
    
    .form-submit {
        background: transparent;
        border: 1px solid #f5f5f5;
        color: #fff;
        width: 100%;
        text-transform: uppercase;
        padding: 6px 10px;
        transition: 0.25s ease-in-out;
        margin-top: 30px;
    }
    
    .form-submit:hover {
        border: 1px solid #54a0ff;
    }
</style>
<?php
//Khai báo sử dụng session
session_start();
//Khai báo utf-8 để hiển thị được tiếng việt
header('Content-Type: text/html; charset=UTF-8');
//Xử lý đăng nhập
if (isset($_POST['dangnhap']))
{
//Kết nối tới database
include('connect.php');
$con;
$p = new clsKetnoi();
$p -> ketnoiDB($con);

  
//Lấy dữ liệu nhập vào
$user = addslashes($_POST['user']);
$pass = addslashes($_POST['pass']);
  
//Kiểm tra đã nhập đủ tên đăng nhập với mật khẩu chưa
if (!$user || !$pass) {
    echo "<script>alert('Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu.')</script>";
exit;
}
  
  
//Kiểm tra tên đăng nhập có tồn tại không
$query = "SELECT * FROM taikhoan where user='$user'";
$result = mysqli_query($con, $query) or die( mysqli_error($con));
$row = mysqli_fetch_array($result);

if ($user != isset($row['user'])) {
    echo "<script>alert('Tên đăng nhập hoặc mật khẩu không đúng!')</script>";
}elseif($pass != $row['pass']){
    echo "<script>alert('Mật khẩu không đúng!')</script>";
}
else {
    $_SESSION['user'] = $user;
    echo "<script>alert('Xin chào " .$user . ". Bạn đã đăng nhập thành công.')</script>";
    if($row['role'] == 1){
        header("Location: ../Giamdoc/admin/TrangchuGD.php");
        exit;
    }elseif($row['role'] == 2){
        header("Location: ../NhanVien/admin/TrangchuNV.php");
        exit;
    }elseif($row['role'] == 3){
        header("Location:../QuanLy/admin/TrangchuQL.php");
        exit;
    }elseif($row['role'] == 4){
        header("Location: ../BPSX/admin/TrangchuBPSX.php");
        exit;
    }else{
        die();
        $con->close();
    }
    // die();
    // $connect->close();
}
  
//Lấy mật khẩu trong database ra
// $row = mysqli_fetch_array($result);
  
// //So sánh 2 mật khẩu có trùng khớp hay không
// if ($password != $row['password']) {
// echo "Mật khẩu không đúng. Vui lòng nhập lại. <a href='javascript: history.go(-1)'>Trở lại</a>";
// exit;
// }
  
//Lưu tên đăng nhập
// $_SESSION['username'] = $username;
// echo "Xin chào <b>" .$username . "</b>. Bạn đã đăng nhập thành công. <a href=''>Thoát</a>";
// die();
// $connect->close();
}
?>
<body>
    <div id="wrapper">
        <form id="form-login" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <h1 class="form-heading">Đăng nhập</h1>
            <div class="form-group">
               
                <input id="user" name='user' type="text" class="form-input" placeholder="Tên đăng nhập">
            </div>
            <div class="form-group">
                
                <input id="pass" name='pass' type="password" class="form-input" placeholder="Mật khẩu">
                <div id="eye">
             
                </div>
            </div>
            <input name="dangnhap" type="submit" value="Đăng Nhập">
        </form>
    </div>
</body>

</html>