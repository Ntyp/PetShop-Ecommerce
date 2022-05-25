<?php
    include_once 'database.php';
    session_start();
    error_reporting(0);
    // โชว์ข้อมูลในตาราง
    $sql_show = "SELECT * FROM stock ORDER BY `Code` DESC ";
    $result_show = $conn->query($sql_show);
    
    
    

    $Code = $_POST['product_ID'];
    
    $sql2 = "SELECT * FROM stock WHERE Code = '$Code'";
    $result2 = $conn->query($sql2);
    $row2 = mysqli_fetch_array($result2);
    $Price = $row2['Price'];
    $Name = $row2['Name'];
    $Size = $_POST['Size'];
    $Scale =  $_POST['Scale'];
    $Quatity = $_POST['Quatity'];
    if(isset($_POST['addbtn'])) {
        $sql = "INSERT INTO stock_detail (Code,Name,Size,Scale,Quatity,Price) VALUES 
        ('$Code','$Name','$Size','$Scale','$Quatity','$Price')";;
        $result = mysqli_query($conn,$sql);
        echo '<script>alert("เพิ่มรายการสำเร็จ");location.href="add_product_detail.php";</script>';
    }
    


    if(isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['Username']);
        echo '<script>alert("ออกจากระบบสำเร็จ");</script>';
        header("Location: index.php");
    } 
    if(!$_SESSION['Status'] == "Admin") {
        header("Location: index.php");
    }
    else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.3.1/css/all.css'>
    <link rel="stylesheet" href="./css/style.css">
    <title>PetClub</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #149c82;">
    <div class="container-fluid">
    <a href="./admin.php"><img  class="navbar-brand" style="width:60%"   src="./img/PETClub_Logo_314x86px.png" alt=""></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            
            
        </ul>

        <div class="d-flex">

        
            <!-- Dropdown  -->
            <?php if(!empty($_SESSION['Username'])){ ?>
            <li style="list-style-type: none;" class="nav-item dropdown ">
                <a  style="text-decoration:none;color:white" class="nav-link  dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    
                ผู้ดูแลระบบ:
                    
                    <?php 
                        if(!empty($_SESSION['Username'])){
                            echo $_SESSION['Username'];
                        }
                        else {
                                
                        }
                    ?>
                    </a>
                <!-- เพิ่ม Session ชื่อผู้ใช้งาน -->
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="store.php">คลังสินค้า</a></li>
                    <li><a class="dropdown-item" href="add_product.php">เพิ่มข้อมูลสินค้า</a></li>
                    <li><a class="dropdown-item" href="add_product_detail.php">เพิ่มจำนวนสินค้า</a></li>
                    <li><a class="dropdown-item" href="add_bank.php">บัญชีธนาคาร</a></li>
                    <li><a class="dropdown-item" href="mange_member.php">ปรับสถานะผู้ใช้งาน</a></li>
                    <li><a class="dropdown-item" href="report_history.php">รีพอทคำร้อง</a></li>
                    <li><a class="dropdown-item" href="mange_order.php">สถานะคำสั่งซื้อ</a></li>
                    <li><a class="dropdown-item" href="lowstock.php">สินค้าใกล้หมด</a></li>
                    <li><a class="dropdown-item" href="https://www.flashexpress.co.th/tracking/">เช็คพัสดุ</a></li>
                    <li><a href="index.php?logout='1'" style="color: red;" class="dropdown-item">ออกจากระบบ</a></li>
                </ul>
            </li>

            <?php } ?>
            <!-- End Dropdown  -->

            <!-- Start Login  -->
            <?php if(empty($_SESSION['Username'])){ ?>
                <div class="btn-cart">
                <!-- <button class="btn btn-success" type="submit"><a href="./login.php">เข้าสู่ระบบ</a></button> -->
                <button type="button" class="btn  btn-primary mx-auto " data-bs-toggle="modal" data-bs-target="#modalLoginForm">
                เข้าสู่ระบบ
                </button>
                <!-- Modal Login -->
                <!-- modalLoginForm -->
                <div class="modal fade" id="modalLoginForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">เข้าสู่ระบบ</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="loginform.php" method="POST">
                                    <div class="mb-3">
                                        <label class="form-label">ชื่อผู้ใช้งาน</label>
                                        <input type="text" class="form-control" id="User_Username" name="User_Username" placeholder="ชื่อผู้ใช้งาน" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">รหัสผ่าน</label>
                                        <input type="password" class="form-control" id="User_Password" name="User_Password" placeholder="รหัสผ่าน" />
                                    </div>
                                    <div class="modal-footer d-block">
                                        <p class="float-start">ยังไม่ได้เป็นสมาชิก ? <a href="" data-bs-toggle="modal"  data-bs-target="#modalRegisterForm">สมัครสมาชิก</a></p>
                                        <button type="submit" class="btn btn-success float-end">ยืนยัน</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                
                <!-- Modal Register -->
                <div class="modal fade" id="modalRegisterForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">สมัครสมาชิก</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                    <form action="./registerform.php" method="POST">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <span>ชื่อผู้ใช้งาน</span><span style="color:red;">*</span>
                                                <input type="text" id="User_Username" name="User_Username" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <span>รหัสผ่าน</span><span style="color:red;">*</span>
                                                <input type="password" id="Password" name="Password" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <span>ชื่อ</span><span style="color:red;">*</span>
                                                <input type="text" id="Firstname" name="Firstname" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <span>นามสกุล</span><span style="color:red;">*</span>
                                                <input type="text" id="Lastname" name="Lastname" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <span>อีเมล์</span><span style="color:red;">*</span>
                                                <input type="email" id="Email" name="Email" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <span>เบอร์ติดต่อ</span><span style="color:red;">*</span>
                                                <input type="tel" id="Phone" name="Phone" class="form-control" required>
                                            </div>
                                            <div class="col-12">
                                                <span>ที่อยู่</span><span style="color:red;">*</span>
                                                <textarea class="form-control" id="Address" name="Address" placeholder="ที่อยู่" required></textarea>
                                            </div>
                                            <div class="col-6">
                                                <span>ตำบล</span><span style="color:red;">*</span>
                                                <input type="text" id="Tambon" name="Tambon" class="form-control" required>
                                            </div>
                                            <div class="col-6">
                                                <span>อำเภอ</span><span style="color:red;">*</span>
                                                <input type="text" id="Amphoe" name="Amphoe" class="form-control" required>
                                            </div>
                                            <div class="col-6">
                                                <span>จังหวัด</span><span style="color:red;">*</span>
                                                <input type="text" id="Province" name="Province" class="form-control" required>
                                            </div>
                                            <div class="col-6">
                                                <span>รหัสไปรษณี</span><span style="color:red;">*</span>
                                                <input type="text" id="Zipcode" name="Zipcode" class="form-control" required>
                                            </div>
                                            <div class="col-12 mt-5">                        
                                                <button type="submit" class="btn btn-success float-end">สมัครสมาชิก</button>
                                                <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-outline-secondary float-end me-2 ">ยกเลิก</button>
                                            </div>
                                        </div>
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>

                <?php } ?>
                <!-- Emd Login  -->
        </div>

        </div>
    </div>
    </nav>
    
    <section>
        <div class="container">
            <div class="row mt-5">
                <div class="col-6">
                    <h3>เพิ่มจำนวนสินค้าเข้าสต็อก</h3>
                <form action="" method="POST">

                    <div class="row mt-3">
                        <div class="col">
                            <span>ชื่อสินค้า</span>
                            <select class="form-control" name="product_ID" id="product_ID">
                                    <?php
                                        while($row_show = mysqli_fetch_array($result_show, MYSQLI_ASSOC)){
                                    ?>
                                    <option value="<?php echo $row_show['Code']; ?>"><?php echo $row_show['Name']; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col">
                            <span>ประเภท</span>
                            <select class="form-control" name="Size" id="Size">
                                    <option value="ขนาดเล็ก">ขนาดเล็ก</option>
                                    <option value="ขนาดกลาง">ขนาดกลาง</option>
                                    <option value="ขนาดใหญ่">ขนาดใหญ่</option>
                                    <option value="ขนาดจัมโบ้">ขนาดจัมโบ้</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col">
                            <span>ขนาดสินค้า</span>
                            <select class="form-control" name="Scale" id="Scale">
                                    <option value="8x10ซม.">8x10ซม.</option>
                                    <option value="33x40.5x10ซม.">33x40.5x10ซม.</option>
                                    <option value="50x40x11ซม.">50x40x11ซม.</option>
                                    <option value="58x48x15ซม.">58x48x15ซม.</option>
                                    <option value="49x29ซม.">49x29ซม.</option>
                                    <option value="57x43ซม.">57x43ซม.</option>
                                    <option value="67x53ซม.">67x53ซม</option>
                                    <option value="80x70ซม.">80x70ซม.</option>

                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col">
                            <span>จำนวน</span>
                            <input name="Quatity" id="Quatity" class="form-control mt-1" type="text" required>
                        </div>
                    </div>

                    <!-- <button class="btn btn-success mt-3 float-end"><i class="fas fa-plus"></i> เพิ่มข้อมูลสินค้า</button> -->
                    <input style="margin-bottom:40px"  class="btn btn-success mt-5 float-end" name="addbtn" id="addbtn" value="เพิ่มข้อมูลสินค้า"type="submit">
                </form>
                </div>
                <div class="col-6">
                    <img style="width:100%" src="./img/french-bulldog-young-dog-posing-removebg-preview.png" alt="">
                </div>
            </div>
        </div>
    </section>
   


</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</html>
<?php
    }
?>