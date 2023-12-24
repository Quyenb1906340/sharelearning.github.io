 <!-- Thông báo -->
 <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script src="sweetalert2.all.min.js"></script>

 <?php
    
    include("include/conn.php");

    $dg_ma = $_GET['dg_ma'];
    $bv_ma = $_GET['bv_ma'];
    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];
        $username =$user ['nd_username'];

    }
    
    // $id = $_GET['id'];
    // $tt = $_GET['tt'];

    // if( $tt == null){
    //     $tt = 3;
    // }

   
  
    
    
            $xoa_bai_viet = "DELETE from danh_gia where dg_ma = '$dg_ma'";
            mysqli_query($conn, $xoa_bai_viet);
            
            
            $cap_nhat = "UPDATE bai_viet 
            SET bv_diemtrungbinh = IFNULL((SELECT ROUND(AVG(dg_diem), 1) FROM danh_gia WHERE bv_ma = $bv_ma), 0)
            WHERE bv_ma = $bv_ma";
mysqli_query($conn, $cap_nhat);

        


        // echo "<script>alert('Bạn đã xóa dữ liệu thành công!');</script>";  
            $_SESSION['bg_thongbao_nd'] = "bg-success";
            $_SESSION['thongbao_thucthi_nd'] = "Bạn đã xóa dữ liệu thành công!"; 
             header("Refresh: 0;url=ls-danhgia.php?id=".$username);  
   

?>