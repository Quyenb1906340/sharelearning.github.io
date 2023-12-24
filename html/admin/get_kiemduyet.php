<!-- <div class="modal-body"> -->
<?php 
 include "../include/conn.php";
 require '../vendor/autoload.php';

 $postdata = file_get_contents("php://input");
$request = json_decode($postdata);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($request->id) && isset($request->id2) && isset($request->similarRows)) {
        $id = $request->id;
        $id2 = $request->id2;
        $similarRows = $request->similarRows;

        if (!empty($similarRows)) {
            $sl_causosanh = []; // Mảng để theo dõi các giá trị duy nhất của 'content1'
            $sl_caugoc = []; // Mảng để theo dõi các giá trị duy nhất của 'content2'

            foreach ($similarRows as $row) {
                if ($row->id == $id && $row->id2 == $id2) {
                    $serializedContent1 = serialize($row->content1);
                    $serializedContent2 = serialize($row->content2);

                    if (!isset($sl_causosanh[$serializedContent1])) {
                        $sl_causosanh[$serializedContent1] = true;
                    }

                    if (!isset($sl_caugoc[$serializedContent2])) {
                        $sl_caugoc[$serializedContent2] = true;
                    }
                }
            }

            $count_sl_causosanh = count($sl_causosanh);
            $count_sl_caugoc = count($sl_caugoc);

            echo '<p>(Theo kiểm tra thì tài liệu này có <b style="color: red">' . $count_sl_causosanh . ' câu</b> được cho là trùng lặp được liệt kê ở bảng bên dưới.) </p>';
        }
    }
}


                                                ?>
    <div class="table-responsive text-nowrap border-top">
        <table class="table">
            <thead>
                <th>STT</th>
                <th>#</th>
                
                <!-- <th>Tiêu đề</th> -->
                <th style='white-space: normal'>Nội dung được cho là trùng
                    lặp </th>
                <th>#</th>
                <th>Nội dung bài viết góc</th>
                <th>Độ tương đồng</th>
            </thead>
            <tbody id="data">
                <?php
                   
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                      
                        // $tieude = $_POST['tieude'];

                        if (isset($request->id) && isset($request->id2) && isset($request->similarRows)) {
                            $id = $request->id;
                            echo '<input type="hidden" name="bv_ma" value="'.$id.'">';
                            $id2 = $request->id2;
                           
                            
                            $similarRows = $request->similarRows;
                            
                            $stt = 0;
                            if (!empty($similarRows))
                            {
                                foreach ($similarRows as $row)
                                {
                                    if ($row->id == $id && $row->id2 == $id2) {
                                        $stt = $stt + 1;
                                    $words1 = $row->content1;
                                    $words2 = $row->content2;

                                  
                                    // $bai = "SELECT * FROM bai_viet where bv_ma = $id";
                                    // $result_bai = mysqli_query($conn, $bai);
                                    // while ($row_bai = mysqli_fetch_array($result_bai)) {
                                    //     $td = $row_bai['bv_tieude'];
                                    // }
                               
                                    $commonWords = array_intersect(preg_replace('/[(,;"\':?|)]/', '', $words1), preg_replace('/[(,;"\':?|)]/', '', $words2));
                            
                                 
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
                                                <td><b>{$stt}</b></td>
                                                <td>{$row->id}</td>
                                                
                                                <td style='white-space: normal'>{$words1}</td>
                                                <td>{$row->id2}</td>
                                                <td style='white-space: normal'>{$words2}</td>
                                                <td>{$row->similarity}%</td>
                                            </tr>
                                        ";
                                    }
                                }
                                
                            }
                        }
                    }
                    
                ?>

            </tbody>
        </table>
    <!-- </div> -->
