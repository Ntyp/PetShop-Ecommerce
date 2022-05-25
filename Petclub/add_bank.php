<?php
    include_once 'database.php';
    session_start();
    error_reporting(0);
    $act = $_GET['act'];
    

    if(isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['Username']);
        echo '<script>alert("ออกจากระบบสำเร็จ");</script>';
        header("Location: index.php");
    } 

    if(isset($_POST['addbank'])) {
        $bank_name = $_POST['bank_name'];
        $bank_num = $_POST['bank_num'];
        $bank_owner = $_POST['bank_owner'];
        $bank_branch = $_POST['bank_branch'];

        $sql = "INSERT INTO bank (Bank_No,Bank_Name,Bank_Owner,Bank_Number,Bank_Branch) VALUES (null,'$bank_name','$bank_owner','$bank_num','$bank_branch')";
        $result = mysqli_query($conn,$sql);
        echo '<script>alert("เพิ่มรายการสำเร็จ");location.href="add_bank.php";</script>';
    }

    $show = "SELECT * FROM bank";
    $resultshow = mysqli_query($conn,$show);

    if($act == 'remove') {
        $Bank_Number = $_GET['Bank_Number'];
        $delete = "DELETE FROM bank WHERE Bank_Number = '$Bank_Number'";
        $resultdelete = mysqli_query($conn,$delete);
        echo '<script>alert("ลบรายการสำเร็จ");location.href="add_bank.php";</script>';
    }

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
                    <h3>จัดการบัญชีการโอนเงิน</h3>
                <form action="" method="POST">
                    <div class="row">
                        <div class="col">
                        <div class="row mt-3">
                        <div class="col">
                                <span>เลือกธนาคาร</span>
                                    <select class="form-control mt-1" name="bank_name" id="bank_name">
                                        <option value="ไทยพาณิชย์">ไทยพาณิชย์</option>
                                        <option value="กสิกร">กสิกร</option>
                                        <option value="กรุงไทย">กรุงไทย</option>
                                        <option value="ออมสิน">ออมสิน</option>
                                        <option value="กรุงไทย">กรุงไทย</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row mt-3">
                                <div class="col">
                                    <span>เลขที่บัญชี</span>
                                    <input class="form-control mt-1" name="bank_num" id="bank_num" type="text">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col">
                            <span>ชื่อบัญชี</span>
                            <input class="form-control mt-1" name="bank_owner" id="bank_owner" type="text">
                        </div>
                    </div>

                    

                    <div class="row mt-3">
                        <div class="col">
                            <span>สาขา</span>
                            <input class="form-control mt-1" name="bank_branch" id="bank_branch" type="text">
                        </div>
                    </div>
                    <button name="addbank" id="addbank" class="btn btn-success mt-3"><i class="fas fa-plus"></i> เพิ่มข้อมูลธนาคาร</button>

                    </form>
                </div>
                <div class="col-6">
                    <table class="table table-bordered">
                        <tr>
                            <td>ธนาคาร</td>
                            <td>ชื่อบัญชี</td>
                            <td>เลขที่บัญชี</td>
                            <td>สาขา</td>
                            <td></td>
                        </tr>
                        <?php
                            while($row = mysqli_fetch_array($resultshow, MYSQLI_ASSOC)){
                        ?>
                        <tr>
                            <td><?php echo $row['Bank_Name'] ?></td>
                            <td><?php echo $row['Bank_Owner'] ?></td>
                            <td><?php echo $row['Bank_Number'] ?></td>
                            <td><?php echo $row['Bank_Branch'] ?></td>
                            <!-- ยังไม่ได้ทำปุ่มลบ -->
                            <td><a href="add_bank.php?Bank_Number=<?php echo $row['Bank_Number']; ?>&act=remove">ลบ</a></td>
                        </tr>
                        <?php
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </section>
   


</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</html>