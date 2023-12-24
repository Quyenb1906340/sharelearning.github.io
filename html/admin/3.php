<?php
    session_start();
    include('./includes/connect.php');
    unset($thongbao);
    // unset($bv_daxem);
    // unset($bl_daxem);
    $thongbao = [];



    
    $bai_viet_moi = "SELECT a.bv_ma, nd_hinh, nd_hoten, a.nd_username, bv_tieude, bv_ngaydang
                    FROM bai_viet a 
                    LEFT JOIN nguoi_dung b ON a.nd_username = b.nd_username
                    ORDER BY bv_ngaydang DESC";
    $result_bai_viet_moi = mysqli_query($conn,$bai_viet_moi);
    while ($row_bai_viet_moi = mysqli_fetch_array($result_bai_viet_moi)) { 
       
        $thongbao[] = array(
            "ma_bv" => $row_bai_viet_moi["bv_ma"],
            "bl_ma" => "",
            "hinh" => $row_bai_viet_moi["nd_hinh"],
            "hoten" => $row_bai_viet_moi["nd_hoten"],
            "username" => $row_bai_viet_moi["nd_username"],
            "tieude" => $row_bai_viet_moi["bv_tieude"],
            "ngaydang" => $row_bai_viet_moi["bv_ngaydang"],
            "ma_bl" => "",
            "nd_bl" => "",
            "da_xem" => ""


        );
    } 

    $bai_viet_xem = "SELECT a.bv_ma, nd_hinh, nd_hoten, a.nd_username, bv_tieude, bv_ngaydang, ls_thoigian
    FROM bai_viet a 
    LEFT JOIN nguoi_dung b ON a.nd_username = b.nd_username
    LEFT JOIN lich_su_xem l ON l.bv_ma = a.bv_ma
    where l.nd_username = '".$_SESSION['Admin']."'
    ORDER BY bv_ngaydang DESC";
    $result_bai_viet_xem = mysqli_query($conn,$bai_viet_xem);
    while ($row_bai_viet_xem = mysqli_fetch_array($result_bai_viet_xem)) { 
        $found = false;

        // Kiểm tra xem dữ liệu mới có tồn tại trong mảng $thongbao[] không
        foreach ($thongbao as $key => $value) {
            if ($value['ma_bv'] == $row_bai_viet_xem["bv_ma"]) {
                $found = true;
                // Nếu đã tồn tại 'ma_bv', kiểm tra và cập nhật 'da_xem' thành "Đã xem"
                if (empty($thongbao[$key]['da_xem'])) {
                    $thongbao[$key]['da_xem'] = "Đã xem";
                }
                break;
            }
        }
} 

    $binhluan_bv_moi = "SELECT c.bv_ma, bl_noidung, a.bl_ma, nd_hinh, nd_hoten, c.nd_username, bv_tieude, bl_thoigian
                        FROM binh_luan a  
                        LEFT JOIN bai_viet c ON c.bv_ma = a.bv_ma 
                        LEFT JOIN nguoi_dung b ON c.nd_username = b.nd_username
                        ORDER BY bl_thoigian DESC";
    $result_binhluan_bv_moi = mysqli_query($conn,$binhluan_bv_moi);
    while ($row_binhluan_bv_moi = mysqli_fetch_array($result_binhluan_bv_moi)) { 
        $thongbao[] = array(
            "bl_ma" => $row_binhluan_bv_moi["bl_ma"],
            "ma_bv" => $row_binhluan_bv_moi["bv_ma"],
            "hinh" => $row_binhluan_bv_moi["nd_hinh"],
            "hoten" => $row_binhluan_bv_moi["nd_hoten"],
            "username" => $row_binhluan_bv_moi["nd_username"],
            "tieude" => $row_binhluan_bv_moi["bv_tieude"],
            "ngaydang" => $row_binhluan_bv_moi["bl_thoigian"],
            "ma_bl" => $row_binhluan_bv_moi["bl_ma"],
            "nd_bl" => $row_binhluan_bv_moi["bl_noidung"],
            "da_xem" =>  ""

        );
    } 


    $binhluan_bv_xem = "SELECT c.bv_ma, bl_noidung, a.bl_ma, nd_hinh, nd_hoten, c.nd_username, bv_tieude, bl_thoigian, ls_thoigian
                        FROM binh_luan a  
                        LEFT JOIN bai_viet c ON c.bv_ma = a.bv_ma 
                        LEFT JOIN nguoi_dung b ON c.nd_username = b.nd_username
                        LEFT JOIN lich_su_xem l ON l.bl_ma = a.bl_ma
                        where l.nd_username = '".$_SESSION['Admin']."'
                        ORDER BY bl_thoigian DESC";
    $result_binhluan_bv_xem = mysqli_query($conn,$binhluan_bv_xem);
    while ($row_binhluan_bv_xem = mysqli_fetch_array($result_binhluan_bv_xem)) { 
        $found = false;

        // Kiểm tra xem dữ liệu mới có tồn tại trong mảng $thongbao[] không
        foreach ($thongbao as $key => $value) {
            if ($value['bl_ma'] == $row_binhluan_bv_xem["bl_ma"]) {
                $found = true;
                // Nếu đã tồn tại 'ma_bv', kiểm tra và cập nhật 'da_xem' thành "Đã xem"
                if (empty($thongbao[$key]['da_xem'])) {
                    $thongbao[$key]['da_xem'] = "Đã xem";
                }
                break;
            }
        }
    } 

    // Sắp xếp mảng $thongbao dựa trên cột "ngaydang" giảm dần
    usort($thongbao, function($a, $b) {
        return strtotime($b['ngaydang']) - strtotime($a['ngaydang']);
    });

   

    echo "<pre>"; // Sử dụng thẻ <pre> để hiển thị dữ liệu dễ nhìn
    echo "<h2>User Array:</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Mã</th><th> BL</th><th>Username</th><th>Tiêu đề</th><th>Ngày đăng</th><th>Bình luận</th><th>Trang thai</th></tr>";

    foreach ($thongbao as $tb) {
        
        echo "<tr>";
        echo "<td>{$tb['ma_bv']}</td>";
        echo "<td>{$tb['bl_ma']}</td>";
        echo "<td>{$tb['username']}</td>";
        echo "<td>{$tb['tieude']}</td>";
        echo "<td>{$tb['ngaydang']}</td>";
        echo "<td>{$tb['nd_bl']}</td>";
        echo "<td>{$tb['da_xem']}</td>";
        echo "</tr>";
       
    }

    echo "</table>";
    echo "</pre>";

     // $bai_viet_dx = "SELECT * 
    //                 FROM bai_viet a 
    //                 LEFT JOIN lich_su_xem b ON a.bv_ma = b.bv_ma
    //                 ORDER BY bv_ngaydang DESC";
    // $result_bai_viet_dx = mysqli_query($conn,$bai_viet_dx);
    // while ($row_bai_viet_dx = mysqli_fetch_array($result_bai_viet_dx)) { 
    //     foreach ($thongbao as $tb) {
    //         if($tb['ma_bv'] == $row_bai_viet_dx['bv_ma'] && $tb['ma_bl'] == ''){
    //         $bv_daxem[] = array( "ma_bv" => $tb["ma_bv"]);
    //         }
    //     }
    // }

    // $bai_viet_dx = "SELECT * 
    //     FROM binh_luan a 
    //     LEFT JOIN lich_su_xem b ON a.bl_ma = b.bl_ma
    //     ORDER BY bl_thoigian DESC";
    // $result_bai_viet_dx = mysqli_query($conn,$bai_viet_dx);
    //     while ($row_bai_viet_dx = mysqli_fetch_array($result_bai_viet_dx)) { 
    //         foreach ($thongbao as $tb) {
    //         if($tb['ma_bv'] == $row_bai_viet_dx['bv_ma']){
    //         $bl_daxem[] = array( "ma_bl" => $tb["ma_bl"]);
    //         }
    //     }
    // }
    // print_r($bv_daxem);
    // print_r($bl_daxem);

    // print_r($thongbao);
    

  
?>