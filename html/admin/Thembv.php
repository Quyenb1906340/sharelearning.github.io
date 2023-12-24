<?php
session_start();

include("./includes/connect.php");

if (!isset($_SESSION['Admin'])) {
    echo "<script>alert('Bạn chưa đăng nhập! Hãy đăng nhập để tiếp tục.');</script>";
    header("Refresh: 0;url=login.php");
} else {
    if (isset($_POST['Them'])) {
        $tieude = $_POST['tieude'];
        $danhmuc = $_POST['danhmuc'];
        $noidung = $_POST['noidung'];
        $username = $_SESSION['Admin'];
        $kichthuoc = 0; // Mặc định

        // if (isset($_FILES['file'])) {
        //     $file = $_FILES['file']['name'];
        //     $file_tmp_name = $_FILES['file']['tmp_name'];
        //     move_uploaded_file($file_tmp_name, './uploads/' . $file);

        //     // Lấy kích thước tệp tin (đơn vị bytes)
        //     $kichthuoc = filesize('./uploads/' . $file);
        // }

        $them_baiviet = "INSERT INTO bai_viet (dm_ma, nd_username, bv_tieude, bv_noidung) VALUES ('$danhmuc','$username','$tieude','$noidung')";
        mysqli_query($conn, $them_baiviet);

        $bv_ma = mysqli_insert_id($conn);

        // Kiểm tra xem tệp tin đã được tải lên hay không
        // if (!empty($file)) {
        //     $them_tailieu = "INSERT INTO tai_lieu (bv_ma, tl_tentaptin, tl_kichthuoc) VALUES ('$bv_ma','$file','$kichthuoc')";
        //     mysqli_query($conn, $them_tailieu);
        // }

        if (!empty(array_filter($_FILES['file']['name']))) {
            $files = array_filter($_FILES['file']['name']);

            foreach ($files as $key => $file_name) {
                $file_tmp_name = $_FILES['file']['tmp_name'][$key];
                $upload_directory = './uploads/';
                move_uploaded_file($file_tmp_name, $upload_directory . $file_name);

                $kichthuoc = filesize($upload_directory . $file_name);

                $them_tailieu = "INSERT INTO tai_lieu (bv_ma, tl_tentaptin, tl_kichthuoc) VALUES ('$bv_ma','$file_name','$kichthuoc')";
                mysqli_query($conn, $them_tailieu);
            }
        }

        echo "<script>alert('Thêm bài viết mới thành công!');</script>";
        // header("Refresh: 0;url=QL_Baiviet.php");
    }
}
?>

<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Thêm Người dùng</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="assets/vendor/libs/apex-charts/apex-charts.css" />
    <!-- Thông báo -->

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>
    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="assets/js/config.js"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <?php
                include_once("includes/menu.php");
            ?>

            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <?php
                    include_once("includes/navbar.php");
                ?>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">

                        <!-- Basic Breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.php">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="QL_BaiViet.php">Quản lý bài viết</a> </li>
                                <li class="breadcrumb-item active">Thêm bài viết</li>
                            </ol>
                        </nav>

                        <!-- Basic Layout -->
                        <div class="row">
                            <div class="col-xl">
                                <div class="card mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Thêm bài viết</h5>
                                        <!-- <small class="text-muted float-end">Merged input group</small> -->
                                    </div>
                                    <div class="card-body">
                                        <form class="needs-validation" method="post" action="../dangbai.php"
                                            enctype="multipart/form-data" accept-charset="utf-8" id="myForm">
                                            <input type="hidden" name="tendangnhap" value="<?php $user = $_SESSION['user'];
                                                                    echo $user['nd_username'] ?>">
                                            <style>
                                            #tieude.loading {
                                                background: url(http://www.xiconeditor.com/image/icons/loading.gif) no-repeat right center;
                                            }
                                            </style>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold" for="basic-default-fullname">Tiêu
                                                    đề</label><span style="color: red;font-weight: bold;"> *</span>
                                                <input data-ajax="" required
                                                    oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề!')"
                                                    oninput="this.setCustomValidity('')" name="tieude" type="text"
                                                    class="form-control " id="tieude" placeholder="Nhập tiêu đề" />
                                                <!-- <div style="color: red;">Vui lòng nhập vào tiêu đề!</div> -->
                                                <style>
                                                .resultBox {
                                                    display: none;
                                                    position: absolute;
                                                    background-color: #fff;
                                                    border: 1px solid #979090;
                                                    padding: 10px;
                                                    border-radius: 0 0 10px 10px;
                                                    width: 96%;
                                                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                                                }
                                                </style>
                                                <?php
                                                // if (isset($_GET['tieude']) && !empty($_GET['tieude'])) {
                                                ?>
                                                <div style="background-color: rgb(232, 234, 235);" id="checkResult"
                                                    class="resultBox list-group list-group-flush">

                                                </div>
                                                <?php // } 
                                                ?>
                                                <script>
                                                document.addEventListener("DOMContentLoaded", function() {
                                                    var resultBox = document.getElementById("checkResult");
                                                    // if (resultBox =='') {
                                                    //     // Nếu click bên ngoài .resultBox, ẩn nó
                                                    //     resultBox.style.display = 'none';
                                                    //   }
                                                    document.addEventListener("click", function(event) {
                                                        var isClickedInsideResultBox = event.target
                                                            .closest('#checkResult');

                                                        if (!isClickedInsideResultBox) {
                                                            // Nếu click bên ngoài .resultBox, ẩn nó
                                                            resultBox.style.display = 'none';
                                                        }
                                                    });

                                                    // Mô phỏng sự kiện mở .resultBox (ví dụ: click vào một button)
                                                    var openButton = document.getElementById("openButton");
                                                    openButton.addEventListener("click", function(event) {
                                                        // Hiển thị .resultBox khi click vào button
                                                        resultBox.style.display = 'block';
                                                        // Ngăn chặn sự kiện lan truyền lên để tránh bị ẩn ngay lập tức
                                                        event.stopPropagation();
                                                    });
                                                });
                                                </script>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label" for="selectKhoiLop">Khối lớp</label><span
                                                    style="color: red;font-weight: bold;"> *</span>
                                                <select required class="form-select" id="selectKhoiLop"
                                                    aria-label="Default select example"
                                                    onchange="updateMonHocOptions(this.value)">
                                                    <option value="" hidden>Chọn Khối Lớp</option>
                                                    <?php
                                                    $sql = "SELECT * FROM khoi_lop";
                                                    $result = mysqli_query($conn, $sql);
                                                    while ($khoilop = mysqli_fetch_array($result)) {
                                                    ?>
                                                    <option value="<?php echo $khoilop['kl_ma'] ?>">
                                                        <?php echo $khoilop['kl_ten'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="mb-2">
                                                <label class="form-label" for="selectMonHoc">Môn học</label><span
                                                    style="color: red;font-weight: bold;"> *</span>
                                                <select required class="form-select" id="selectMonHoc"
                                                    aria-label="Default select example"
                                                    onchange="getCategories(this.value)">
                                                    <option value="" hidden>Chọn Môn Học</option>
                                                    <!-- Options will be dynamically added here based on selected Khối lớp -->
                                                </select>
                                            </div>


                                            <div id="category-dropdowns">
                                                <!-- Các select box danh mục sẽ được tạo thông qua JavaScript -->
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold" for="basic-default-message">Nội
                                                    Dung</label><span style="color: red;font-weight: bold;"> *</span>
                                                <textarea name="noidung" id="editor" class="form-control"
                                                    placeholder="Vui lòng nhập nội dung"></textarea>
                                                <!-- <div style="color: red;">Vui lòng nhập vào nội dụng</div> -->
                                            </div>



                                            <div class="mb-3">
                                                <label for="formFileMultiple" class="form-label fw-bold">Tệp Đính
                                                    Kèm</label>
                                                <input class="form-control" type="file" name="formFileMultiple[]"
                                                    id="formFileMultiple" multiple accept=".docx, .pdf" />
                                            </div>




                                            <button type="submit" id="runPythonBtn" name="gui"
                                                class="btn btn-primary">Gửi</button>
                                            <!-- <button type="button" id="runPythonBtn" class="btn btn-outline-primary">tach từ</button> -->
                                            <script>
                                            $(document).ready(function() {
                                                $("#runPythonBtn").click(function() {
                                                    $.ajax({
                                                        url: "../run_python.php",
                                                        type: "POST",
                                                        success: function(response) {
                                                            console.log(response);
                                                            // Xử lý kết quả nếu cần
                                                        },
                                                        error: function(error) {
                                                            console.error(error);
                                                        }
                                                    });
                                                });
                                            });
                                            </script>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Content wrapper -->
                </div>
                <!-- / Layout page -->
            </div>

            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>
        </div>
        <!-- / Layout wrapper -->

        <!-- Core JS -->
        <!-- build:js assets/vendor/js/core.js -->
        <script src="assets/vendor/libs/jquery/jquery.js"></script>
        <script src="assets/vendor/libs/popper/popper.js"></script>
        <script src="assets/vendor/js/bootstrap.js"></script>
        <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

        <script src="assets/vendor/js/menu.js"></script>
        <!-- endbuild -->

        <!-- Vendors JS -->
        <script src="assets/vendor/libs/apex-charts/apexcharts.js"></script>

        <!-- Main JS -->
        <script src="assets/js/main.js"></script>

        <!-- Page JS -->
        <script src="assets/js/dashboards-analytics.js"></script>

        <!-- Place this tag in your head or just before your close body tag. -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>

        <script src="ckeditor/ckeditor/ckeditor.js"></script>
        <script src="ckfinder/ckfinder/ckfinder.js"></script>


        <script src="https://cdn.tiny.cloud/1/xzvijpgncm8saa0ygeagl2xsq4k3e443moey5wts5mjc0r2w/tinymce/6/tinymce.min.js"
            referrerpolicy="origin"></script>

        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script>
        $(document).ready(function() {
            var resultBox = $("#checkResult");
            var checkTieude = $("#tieude");
            var timeout;

            checkTieude.on("input", function() {
                var keyword = $(this).val();
                clearTimeout(timeout);

                timeout = setTimeout(function() {
                    if (keyword.trim() !== '') {
                        // Thêm class 'loading' khi bắt đầu AJAX
                        checkTieude.addClass('loading');

                        $.ajax({
                            type: "GET",
                            url: "../check-tieude.php",
                            data: {
                                tieude: keyword
                            },
                            success: function(response) {
                                resultBox.html(response);

                                // Kiểm tra nếu có nội dung trong khung gợi ý
                                if (response.trim() !== '') {
                                    resultBox.show(); // Hiển thị khung gợi ý
                                } else {
                                    resultBox.hide(); // Ẩn khung gợi ý
                                }

                                // Loại bỏ class 'loading' sau khi nhận được response
                                checkTieude.removeClass('loading');
                            }
                        });
                    } else {
                        resultBox.hide(); // Ẩn khung gợi ý nếu ô tìm kiếm trống
                    }
                }, 700);
            });
        });
        </script>



        <script>
        $(document).ready(function() {
            $("#myForm").submit(function() {
                // Show loader when form is submitted
                $("#loader").show();
            });
        });
        </script>
        <script>
        function updateMonHocOptions(selectedKhoiLop) {
            var selectMonHoc = document.getElementById("selectMonHoc");
            while (selectMonHoc.options.length > 1) {
                selectMonHoc.remove(1);
            }
            clearCategoryDropdowns();
            if (selectedKhoiLop !== "hidden") {
                var url = "../monhoc.php?khoiLop=" + selectedKhoiLop;
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(monhoc => {
                            var option = document.createElement("option");
                            option.value = monhoc.mh_ma;
                            option.text = monhoc.mh_ten;
                            selectMonHoc.add(option);
                        });
                    })
                    .catch(error => console.error('Error:', error));
            }
        }
        </script>
        <script>
        function getCategories(monHocValue) {
            fetch('../get-danh-muc.php?monhoc=' + monHocValue)
                .then(response => response.json())
                .then(data => {
                    clearCategoryDropdowns(); // Clear the existing category dropdowns
                    if (data.length > 0) {
                        createDropdown(data, 1); // Create the new category dropdowns
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function clearCategoryDropdowns() {
            const categoryDropdowns = document.getElementById('category-dropdowns');
            while (categoryDropdowns.firstChild) {
                categoryDropdowns.removeChild(categoryDropdowns.firstChild);
            }
        }
        </script>
        <script>
        function createDropdown(categories, level) {
            const dropdown = document.createElement('select');
            dropdown.dataset.level = level;
            dropdown.classList.add('form-select');
            dropdown.setAttribute('required', true);
            const label = document.createElement('label');
            label.classList.add('form-label');
            label.textContent = `Danh Mục`;
            label.setAttribute('for', `select${level}`);
            dropdown.setAttribute('id', `select${level}`);

            const divGroup = document.createElement('div');
            divGroup.classList.add('mt-3');
            divGroup.appendChild(label);
            divGroup.appendChild(dropdown);
            document.getElementById('category-dropdowns').appendChild(divGroup);

            const defaultOption = document.createElement('option');
            defaultOption.setAttribute('hidden', true);
            defaultOption.text = `Chọn danh mục`;
            defaultOption.disabled = true;
            defaultOption.selected = true;
            defaultOption.value = "";

            dropdown.appendChild(defaultOption);

            categories.forEach(category => {
                const option = document.createElement('option');
                option.value = category.id;
                option.textContent = category.name;
                dropdown.appendChild(option);

                if (category.children && category.children.length > 0) {
                    option.setAttribute('data-has-children', true);
                }
            });

            // if (!categories.some(category => category.children && category.children.length > 0)) {
            //   dropdown.setAttribute('name', 'danh-muc');
            // }

            dropdown.addEventListener('change', function() {
                const currentLevel = parseInt(this.dataset.level);
                const selectedCategoryId = this.value;
                const selectedCategory = categories.find(category => category.id === selectedCategoryId);
                let nextDropdown = this.nextElementSibling;

                // Check if the selected option has data-has-children attribute
                if (selectedCategory && selectedCategory.children && selectedCategory.children.length > 0) {
                    // If it has children, remove the name attribute
                    dropdown.removeAttribute('name');
                    // Create the next dropdown
                    createDropdown(selectedCategory.children, currentLevel + 1);
                } else {
                    // If it doesn't have children, add the name attribute
                    dropdown.setAttribute('name', 'danh-muc');
                    // Remove any subsequent dropdowns
                    while (nextDropdown) {
                        nextDropdown.remove();
                        nextDropdown = this.nextElementSibling;
                    }
                }
            });

            document.getElementById('category-dropdowns').appendChild(dropdown);
        }

        createDropdown(categoriesData, 1);


        createDropdown(categoriesData, 1);
        </script>
        <script>
        <?php if (isset($_SESSION['dangbai']) && $_SESSION['dangbai']) { ?>
        document.addEventListener("DOMContentLoaded", function() {
            const successToast = document.getElementById("dangbai");
            var successToastInstance = new bootstrap.Toast(successToast);
            $("#loader").hide();
            successToastInstance.show();
        });
        <?php
      // Reset the login_success session variable
      unset($_SESSION['dangbai']);
    }
    ?>
        </script>
        <script src="../include/ckeditor.js"></script>
        <!-- <script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/translations/vi.js"></script> -->
        <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                language: 'vi'
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(err => {
                console.error(err.stack);
            });
        </script>



</body>

</html>