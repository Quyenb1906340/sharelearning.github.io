<?php
include "include/conn.php";
require 'vendor/autoload.php';
if (!isset($_SESSION['user'])) {
    header("Location: 404.php");
}



$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->Test;
$baivietCollection = $database->baiviet;
$chimuctieudeCollection = $database->chimuctieude;
$chimucnoidungCollection = $database->chimucnoidung;
$tachtutieudeCollection = $database->tachtutieude;
$tachtunoidungCollection = $database->tachtunoidung;



if (isset($_POST['gui'])) {
    $tendangnhap = $_POST['tendangnhap'];
    $tieude = $_POST['tieude'];
    $noidung = $_POST['noidung'];
    $danhmuc_ma = $_POST['danh-muc'];
    $baiviet_id = $_POST['baiviet_id']; // Assuming you have this in the form

    $tailieus = array(); // Mảng này sẽ lưu trữ tên tệp đính kèm
    if(isset($_FILES["formFileMultiple"]) && !empty($_FILES['formFileMultiple']['name'])) {
        $targetDir = "uploads/";
        $convertedText = ""; // Khởi tạo biến
    
        // Duyệt qua từng tệp tin
        for ($i = 0; $i < count($_FILES["formFileMultiple"]["name"]); $i++) {
            $targetFile = $targetDir . basename($_FILES["formFileMultiple"]["name"][$i]);
            $uploadOk = 1;
            $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
            // Kiểm tra định dạng tệp tin hợp lệ
            if ($fileType != "pdf" && $fileType != "docx") {
                echo "Xin lỗi, chỉ cho phép tệp PDF và DOCX cho tệp " . ($i + 1) . ".<br>";
                $uploadOk = 0;
            }
    
            // Kiểm tra tệp tin đã được tải lên mà không có lỗi
            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["formFileMultiple"]["tmp_name"][$i], $targetFile)) {
                    echo "Tệp " . ($i + 1) . ": " . basename($_FILES["formFileMultiple"]["name"][$i]) . " đã được tải lên.<br>";


    
                    // Gọi script Python để chuyển đổi tệp tin
                    $command = escapeshellcmd("python docfile.py " . $targetFile);
                    $output = shell_exec($command);
                    if ($output === false) {
                        echo "Lỗi khi thực thi script Python: $command<br>";
                    } else {
                        // Đọc và hiển thị nội dung văn bản đã chuyển đổi từ tệp PHP
                        $convertedTextFile = "uploads/" . pathinfo($targetFile, PATHINFO_FILENAME) . ".txt";
                        if (file_exists($convertedTextFile)) {
                            $convertedText .= file_get_contents($convertedTextFile) . "<br>"; // Nối vào nội dung hiện tại
                        } else {
                            echo "Lỗi: Không tìm thấy tệp văn bản đã chuyển đổi cho tệp " . ($i + 1) . ".<br>";
                        }
                    }
                } else {
                    echo "Xin lỗi, có lỗi khi tải lên tệp tin " . ($i + 1) . ".<br>";
                }
            }
        }
       

        // Thêm dữ liệu vào bảng 'tailieu' cho mỗi tệp đính kèm (MySQL)
        foreach ($_FILES["formFileMultiple"]["name"] as $tailieu) {
            if ( $tailieu == '') {
                echo "Xin lỗi, không có file nào được tải lên ";
            }else{

                $xoa_tl_cu = "DELETE FROM tai_lieu where bv_ma = '$baiviet_id'";
                mysqli_query($conn, $xoa_tl_cu);

                $chimucnoidungCollection->deleteMany(
                    ['doc.doc_id' => intval($baiviet_id)]
                );

                $tachtunoidungCollection->deleteMany(
                    ['doc_id' => intval($baiviet_id)]
                );

                $noidung = strip_tags($noidung);
                // $noidung = preg_replace("/[.,!?`~]/", " ", $noidung);
                $noidung = str_replace('&nbsp;', ' ', $noidung);
            
                $baivietData = [
                    'id' => $baiviet_id,
                    'danhmuc' => $danhmuc_ma,
                    'trangthai' => "Chờ duyệt",
                    'bv_noidung' => $noidung,
                    'bv_tieude' =>$tieude,
                ];
            
                $baivietCollection->insertOne($baivietData);
            
                // Tách từ bài viết
                $pythonScript = "C:/xampp/htdocs/VnCoreNLP-master/tachtu.py";
                $pythonScript2 = "C:/xampp/htdocs/VnCoreNLP-master/tachtieude.py";
                $command = "python $pythonScript";
                $command2 = "python $pythonScript2";
                $command3 = "python $pythonScript3";
                exec($command, $output, $return_var);
                exec($command2, $output, $return_var);
                exec($command3, $output, $return_var);
                // Trả về kết quả (nếu cần)
                echo json_encode(array("output" => $output, "return_var" => $return_var));
                if ($return_var !== 0) {
                    echo "Error executing command. Return code: $return_var\n";
                }
                // Kết thúc tách từ bài viết

                $sql2 = "INSERT INTO tai_lieu (bv_ma, tl_tentaptin, tl_kichthuoc) 
                VALUES ($baiviet_id, '$tailieu', 30)";
                $res2 = mysqli_query($conn, $sql2);
            }
        }
    
        
    } 




    // Update the main content of the post
    $sql1 = "UPDATE bai_viet SET dm_ma = $danhmuc_ma, nd_username = '$tendangnhap', bv_tieude = '$tieude', bv_noidung = '$noidung' WHERE bv_ma = $baiviet_id";
    $res1 = mysqli_query($conn, $sql1);

    $sql3 = "DELETE FROM kiem_duyet WHERE bv_ma = $baiviet_id";
    $res3 = mysqli_query($conn, $sql3);

    $chimucnoidungCollection->deleteMany(
        ['doc.doc_id' => intval($baiviet_id)]
    );

    $tachtunoidungCollection->deleteMany(
        ['doc_id' => intval($baiviet_id)]
    );

    $baivietCollection->deleteOne(
        ['id' => intval($baiviet_id)]
    );

    $chimuctieudeCollection->deleteMany(
        ['doc.doc_id' => intval($baiviet_id)]
    );

    $tachtutieudeCollection->deleteMany(
        ['doc_id' => intval($baiviet_id)]
    );


   
    $noidung = strip_tags($noidung);
    // $noidung = preg_replace("/[.,!?`~]/", " ", $noidung);
    $noidung = str_replace('&nbsp;', ' ', $noidung);

    $baivietData = [
        'id' => $baiviet_id,
        'danhmuc' => $danhmuc_ma,
        'trangthai' => "Chờ duyệt",
        'bv_noidung' => $noidung,
        'bv_tieude' =>$tieude,
    ];

    $baivietCollection->insertOne($baivietData);

    // Tách từ bài viết
    $pythonScript = "C:/xampp/htdocs/VnCoreNLP-master/tachtu.py";
    $pythonScript2 = "C:/xampp/htdocs/VnCoreNLP-master/tachtieude.py";
    $command = "python $pythonScript";
    $command2 = "python $pythonScript2";
    $command3 = "python $pythonScript3";
    exec($command, $output, $return_var);
    exec($command2, $output, $return_var);
    exec($command3, $output, $return_var);
    // Trả về kết quả (nếu cần)
    echo json_encode(array("output" => $output, "return_var" => $return_var));
    if ($return_var !== 0) {
        echo "Error executing command. Return code: $return_var\n";
    }
    // Kết thúc tách từ bài viết





    // Tách từ bài viết (Optional: Uncomment if needed)
    /*
    $pythonScript = "C:/xampp/htdocs/VnCoreNLP-master/tachtu.py";
    $pythonScript2 = "C:/xampp/htdocs/VnCoreNLP-master/tachtieude.py";
    $pythonScript3 = "C:/xampp/htdocs/VnCoreNLP-master/tachnoidung.py";

    $command = "python $pythonScript";
    $command2 = "python $pythonScript2";
    $command3 = "python $pythonScript3";
    exec($command, $output, $return_var);
    exec($command2, $output, $return_var);
    exec($command3, $output, $return_var);
    echo json_encode(array("output" => $output, "return_var" => $return_var));
    if ($return_var !== 0) {
        echo "Error executing command. Return code: $return_var\n";
    }
    */

    if ($res1 || $res2 ) {
        $_SESSION['dangbai'] = true;
        header("Location: sua_baiviet.php?id=$tendangnhap&bv=$baiviet_id");
        exit; // Make sure to exit after sending the location header
    } 
}
?>
