<?php
    session_start();
    include("./includes/connect.php");

    if(!isset($_SESSION['Admin'])){
        echo "<script>alert('Bạn chưa đăng nhập! Hãy đăng nhập để tiếp tục.');</script>"; 
        header("Refresh: 0;url=login.php");  
    }else{}
    $this_kl_ma = $_GET['this_kl_ma'];

    // $mon_hoc="SELECT * FROM mon_hoc where kl_ma= '$this_kl_ma'";
    // $result_mon_hoc = mysqli_query($conn,$mon_hoc);
    // $row_mon_hoc = mysqli_fetch_assoc($result_mon_hoc);

    // if(mysqli_num_rows($result_mon_hoc) == 0)
    // {}
    try{
        $xoa_khoi_lop="DELETE FROM khoi_lop where kl_ma= '$this_kl_ma'";
        mysqli_query($conn,$xoa_khoi_lop); 

        $_SESSION['bg_thongbao'] = "bg-success";
        $_SESSION['thongbao_thucthi'] = "Bạn đã xóa khối lớp thành công!"; 
    }catch(mysqli_sql_exception $e){
        // echo "<script>alert('Dữ liệu đang được sử dụng không thể xóa! Vui lòng kiểm tra lại');</script>"; 
        $_SESSION['bg_thongbao'] = "bg-danger";
        $_SESSION['thongbao_thucthi'] = "Dữ liệu đang được sử dụng không thể xóa! Vui lòng kiểm tra lại!"; 
    }
	header("Refresh: 0;url=QL_KhoiLop.php");  
   

?>

