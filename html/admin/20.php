<?php
// Kết nối MySQL
include "includes/connect.php";

// Kết nối MongoDB
require '../vendor/autoload.php';
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->Test;
$collection = $database->tachtunoidung;
$collection2 = $database->tachcaunoidung;
$collection3 = $database->tachtucau;
$baivietCollection = $database->baiviet;



// Hàm tính độ đo Jaccard
function jaccardSimilarity($set1, $set2)
{
    $set1 = preg_replace('/[(,;"\':?)]/', '',$set1);
    $set2 = preg_replace('/[(,;"\':?)]/', '',$set2);
     
    $intersection = array_intersect($set1, $set2);
    $union = array_unique(array_merge($set1, $set2));

    if (count($union) === 0) {
        return 0;
    }
    
    $jaccard = count($intersection) / count($union);
    $jaccard = min($jaccard, 1);

    return $jaccard;
}

// Truy vấn MySQL
$bvQuery = "SELECT a.*, b.*, c.*, d.*, e.*, t.*
            FROM bai_viet a
            LEFT JOIN danh_muc b ON a.dm_ma = b.dm_ma
            LEFT JOIN nguoi_dung e ON a.nd_username = e.nd_username
            LEFT JOIN mon_hoc c ON b.mh_ma = c.mh_ma
            LEFT JOIN khoi_lop d ON c.kl_ma = d.kl_ma
            LEFT JOIN tai_lieu f ON f.bv_ma = a.bv_ma
            LEFT JOIN kiem_duyet k ON k.bv_ma = a.bv_ma
            LEFT JOIN trang_thai t ON t.tt_ma = k.tt_ma
            WHERE k.tt_ma IS NULL OR k.tt_ma = 3";

$result_bv = mysqli_query($conn, $bvQuery);

if (mysqli_num_rows($result_bv) > 0) {
    while ($row_bv = mysqli_fetch_array($result_bv)) {
        $idCondition = intval($row_bv['bv_ma']);
        echo  "ID chờ duyệt: ".$idCondition."| ";
        // Lấy danh sách các ID bài viết cùng danh mục từ MongoDB
        $baivietIdsCursor = $baivietCollection->find(['danhmuc' => $row_bv['dm_ma'], 'trangthai' => 'Đã duyệt']);
        $baivietIds = [];
        foreach ($baivietIdsCursor as $doc) {
            $baivietIds[] = $doc['id'];
        }

        // Lấy dữ liệu từ MongoDB
        // $record = $collection->find(['doc_id' => $idCondition]);
        $record2 = $collection3->find(['doc_id' => $idCondition]);

        $words1 = array(); // Tạo mảng để lưu trữ từng bài viết
        $wordCountById = [];
        

        $currentSentence = [];
        $currentSentence2 = [];

        foreach ($record2 as $doc) {
            $id = $doc['id_cau'];
        
            // Kiểm tra nếu chưa có mảng con tương ứng với id_cau, khởi tạo một mảng con rỗng
            if (!isset($words1[$id])) {
                $words1[$id] = array(); // Khởi tạo một mảng con rỗng cho id_cau này nếu chưa tồn tại
            }
        
            // Thêm từ vào mảng con tương ứng với id_cau
            $words1[$id][] = $doc['wordForm'];
        }
        echo "<pre>";
        print_r($words1);
        echo "</pre>";
        // Tạo cursor mới cho $cursor
        $cursor = $collection2->find(['doc_id' => ['$ne' => $idCondition, '$in' => $baivietIds]]);

        $words2 = array();
        $wordCountById2 = [];
        foreach ($cursor as $document) {
            $id2 = $document['doc_id'];
            if (!isset($words2[$id2])) {
                $words2[$id2] = array(); // Nếu chưa có, khởi tạo một mảng rỗng cho ID này
            }

            $words2[$id][] = $doc['wordForm'];
        }

        echo "<pre>";
        print_r($words2);
        echo "</pre>";
       
        foreach ($words1 as $index1 => $subArray1) {
            foreach ($words2 as $index2 => $subArray2) {
                foreach ($subArray1 as $subArray1Item) {
                    foreach ($subArray2 as $subArray2Item) {
                        $similarity = jaccardSimilarity($subArray1Item, $subArray2Item);
                        $dotuongdong = round($similarity * 100);
                        if ($similarity >= 0.3) {
                            $similarRows[] = [
                                'id' => $index1,
                                'content1' => $subArray1Item,
                                'id2' => $index2,
                                'content2' => $subArray2Item,
                                'similarity' => $dotuongdong,
                            ];
                      
                        }
                    }
                }
            }
        }

              // echo "Mảng $index2: <br>";
                // echo "<pre>"; // Sử dụng thẻ <pre> để hiển thị mảng một cách định dạng
                // print_r($subArray2); // Sử dụng print_r để in ra nội dung của mảng con
                // echo "</pre>";


            // foreach ($words1 as $index => $subArray) {
            //     echo "Mảng $index: <br>";
            //     $text = implode('<hr>', array_map(function ($sentence) {
            //         return implode(' ', $sentence);
            //     }, $subArray));
            //     echo $text."<br><br>"; // In ra văn bản của mảng con
            // }

            // $words2[$id2][] = $document['wordForm'];  

            // if (!isset($wordCountById[$id2])) {
            //     $wordCountById2[$id2] = 1; // Khởi tạo giá trị bằng 1 nếu chưa tồn tại
            // } else {
            //     $wordCountById2[$id2]++; // Tăng số lượng đếm lên 1 nếu đã tồn tại
            // }
            // echo $document['doc_id']."<br>";
        // }
        
        // print_r($wordCountById2);
        // echo '<br>';
        // echo "<hr>";
        // print_r( $words2 );

        // foreach ($words1 as $id => $wordsSet1) {
        //     if($id == $idCondition){
               
        //         // print_r( $wordsSet1);
        //         $similarity = jaccardSimilarity($wordsSet1, $words2[$id2]);
        //         if ($similarity >= 0.25) {
        //             $dotuongdong = round($similarity * 100);
        //             $similarRows[] = [
        //                 'id' => $idCondition, 
        //                 'tieude' => $row_bv['bv_tieude'], 
                        
        //                 'similarity' => $dotuongdong,
        //             ];
        //         }
        //     }
            
           
        // }
    }
} else {
    echo "Không tìm thấy bản ghi!";
}



$sumSimilarity = [];
$countSimilarity = [];
if(!empty($similarRows)){


    foreach ($similarRows as $row)
    {
        $id = $row['id'];
        $id2 = $row['id2'];
        // $td1 = $row['tieude'];

        if (!isset($sumSimilarity[$id][$id2]))
        {
            $sumSimilarity[$id][$id2] = 0;
            $countSimilarity[$id][$id2] = 0;
        }

        $sumSimilarity[$id][$id2] += $row['similarity'];
        $countSimilarity[$id][$id2]++;
    }
}
$averageSimilarity = [];

foreach ($sumSimilarity as $id => $idData)
{
    foreach ($idData as $id2 => $total)
    {
        $averageSimilarity[$id][$id2] = round($total / $countSimilarity[$id][$id2], 2);
        // echo "<ul><li>Bài viết có ID = <a href = 'Xem_BaiViet.php?this_bv_ma=$id'>$id</a> có thể trùng lặp với bài viết có ID = <a href = 'Xem_BaiViet.php?this_bv_ma=$id2'>$id2</a> với tỷ lệ: <b>" . $averageSimilarity[$id][$id2] . "%</b> </li></ul>";
        
    }
}

?>
<!-- <br> -->
<style>
                            .highlight {
                                background-color: yellow;
                                /* Màu nền nổi bật */
                                font-weight: bold;
                                /* Độ đậm */
                            }
                            </style>
<table border="2">
    <thead>
        <th>STT</th>

        <th style='white-space: normal'>Bài viết có nội dung được cho là trùng lặp
        </th>
        <th style='white-space: normal'>Bài viết có nội dung góc</th>
        <th>Độ tương đồng</th>

    </thead>
    <tbody>
        <?php
            $i = 0;
            if(!empty($similarRows)){
            foreach ($sumSimilarity as $id => $idData)
            {
                foreach ($idData as $id2 => $total)
                {
                    $bai = "SELECT * FROM bai_viet where bv_ma = $id";
                    $result_bai = mysqli_query($conn, $bai);
                    while ($row_bai = mysqli_fetch_array($result_bai))
                    {
                        $td = $row_bai['bv_tieude'];
                    }
                    $bai2 = "SELECT * FROM bai_viet where bv_ma = $id2";
                    $result_bai2 = mysqli_query($conn, $bai2);
                    while ($row_bai2 = mysqli_fetch_array($result_bai2))
                    {
                        $td2 = $row_bai2['bv_tieude'];
                    }

                    $i++;
                    $averageSimilarity[$id][$id2] = round($total / $countSimilarity[$id][$id2]);
                    echo '
                        <tr>
                            <td>' . $i . '</td>
                            <td style="white-space: normal"><b><a href="Xem_BaiViet.php?this_bv_ma=' . $id . '">#' . $id . '<a/> -</b> ' . $td . '</td>
                            <td style="white-space: normal"><b><a href="Xem_BaiViet.php?this_bv_ma=' . $id2 . '">#' . $id2 . '<a/> -</b> ' . $td2 . '</td>
                            <td>' . $averageSimilarity[$id][$id2] . '%</td>
                        </tr>';

                }
            }
        }
        ?>
    </tbody>
</table>

<br>
<h4 style="text-align: center;">----------CHI TIẾT-----------</h4>

<table border="2">
    <thead>
        <th>#</th>
        <!-- <th>Mã</th> -->
        <!-- <th>Tiêu đề</th> -->
        <th style='white-space: normal'>Nội dung được cho là trùng
            lặp </th>
        <th>#</th>
        <th style='white-space: normal'>Nội dung bài viết góc</th>
        <th>Độ tương đồng</th>

    </thead>
    <tbody>
        <?php
$i = 0;
if (!empty($similarRows))
{
    foreach ($similarRows as $row)
    {

        $i++;
        $words1 = $row['content1'];
        $words2 = $row['content2'];

        // Loại bỏ ký tự đặc biệt trong $words1 và $words2
// $words1 = array_map(function ($word) {
//     // Loại bỏ các ký tự đặc biệt như . , ; " :
//     return preg_replace('/[.,;"\':]/', '', $word);
// }, $words1);

// $words2 = array_map(function ($word) {
//     // Loại bỏ các ký tự đặc biệt như . , ; " :
//     return preg_replace('/[.,;"\':]/', '', $word);
// }, $words2);


       

        $commonWords = array_intersect(preg_replace('/[(,;"\':?)]/', '', $words1), preg_replace('/[(,;"\':?)]/', '', $words2));

        // Làm nổi bật các từ trùng nhau
        // foreach ($commonWords as $commonWord) {

        //     // $words1 = str_ireplace($commonWord, "<span class='highlight'>$commonWord</span>", $words1);
        //     // $words2 = str_ireplace($commonWord, "<span class='highlight'>$commonWord</span>", $words2);
        //     $words1 = preg_replace('/\b' . preg_quote($commonWord, '/') . '\b/', "<span class='highlight'>" . htmlspecialchars($commonWord) . "</span>", $words1);
        //     $words2 = preg_replace('/\b' . preg_quote($commonWord, '/') . '\b/', "<span class='highlight'>" . htmlspecialchars($commonWord) . "</span>", $words2);

            
        // }
        foreach ($commonWords as $commonWord) {
            for ($i = 0; $i < count($words1); $i++) {
                if ($words1[$i] === $commonWord) {
                    $words1[$i] = "<span class='highlight'>" . htmlspecialchars($commonWord) . "</span>";
                }
            }
        
            for ($i = 0; $i < count($words2); $i++) {
                if ($words2[$i] === $commonWord) {
                    $words2[$i] = "<span class='highlight'>" . htmlspecialchars($commonWord) . "</span>";
                }
            }
        }
        // for ($i = 0; $i < count($words1); $i++) {
        //     foreach ($commonWords as $commonWord) {
        //         $words1[$i] = preg_replace('/\b' . preg_quote($commonWord, '/') . '\b/', "<span class='highlight'>" . htmlspecialchars($commonWord) . "</span>", $words1[$i]);
        //     }
        // }
        
        // for ($i = 0; $i < count($words2); $i++) {
        //     foreach ($commonWords as $commonWord) {
        //         $words2[$i] = preg_replace('/\b' . preg_quote($commonWord, '/') . '\b/', "<span class='highlight'>" . htmlspecialchars($commonWord) . "</span>", $words2[$i]);
        //     }
        // }
        // print_r($words1);
        // <td style='white-space: normal'>{$row['tieude']}</td>

        // Thay thế ký tự "_" bằng khoảng trắng trong từng từ
        foreach ($words1 as &$word) {
            $word = str_replace("_", " ", $word);
        }
        foreach ($words2 as &$word) {
            $word = str_replace("_", " ", $word);
        }
        if (!is_string($words1) && !is_string($words2)) {
            $words1 = implode(' ', $words1);
            $words2 = implode(' ', $words2);
        }else{
            $words1 = implode('', $words1);
            $words2 = implode('', $words2);
        }

        echo "
                <tr>
                    <td>{$row['id']}</td>
                    
                    <td style='white-space: normal'>{$words1}</td>
                    <td>{$row['id2']}</td>
                    <td style='white-space: normal'>{$words2}</td>
                    <td>{$row['similarity']}%</td>
                </tr>
            ";

    }
}
?>
    </tbody>
</table>
