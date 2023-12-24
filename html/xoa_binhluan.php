 <!-- Thông báo -->
 <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script src="sweetalert2.all.min.js"></script>

 <?php
    
    include("include/conn.php");

    $this_bv_ma = $_GET['bl_ma'];
    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];
        $username =$user ['nd_username'];
    }
    
    // $id = $_GET['id'];
    // $tt = $_GET['tt'];

    // if( $tt == null){
    //     $tt = 3;
    // }

   
  
        $kt="select * from rep_bl where bl_cha =  '$this_bv_ma'";
        $result_kt = mysqli_query($conn,$kt);
        $row_kt = mysqli_fetch_assoc($result_kt);

        if(mysqli_num_rows($result_kt) > 0){
            $xoa_bai_viet = "UPDATE binh_luan SET trangthai = '4' where bl_ma = '$this_bv_ma'";
            mysqli_query($conn, $xoa_bai_viet);
            $xoa_bai_viet2 = "UPDATE binh_luan bl  join rep_bl r on r.bl_cha = bl.bl_ma   SET trangthai = '4' where bl_cha = '$this_bv_ma'";
            mysqli_query($conn, $xoa_bai_viet2);
           
        }else{
            $xoa_bai_viet = "UPDATE binh_luan SET trangthai = '4' where bl_ma = '$this_bv_ma'";
            mysqli_query($conn, $xoa_bai_viet);
        }


        // echo "<script>alert('Bạn đã xóa dữ liệu thành công!');</script>";
        $_SESSION['bg_thongbao_nd'] = "bg-success";
        $_SESSION['thongbao_thucthi_nd'] = "Bạn đã xóa dữ liệu thành công!";  
  
             header("Refresh: 0;url=ls-binhluan.php?id=".$username);  
   

?>