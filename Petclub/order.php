<?php
    include_once 'database.php';
    session_start();
    error_reporting(0);

    $act = $_GET['act'];
    $order_id = $_GET['order_id'];

    

    if(isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['Username']);
        echo '<script>alert("ออกจากระบบสำเร็จ");</script>';
        header("Location: index.php");
    } 

    $Username =  $_SESSION['Username'];
    $sql = "SELECT * FROM order_head WHERE order_owner = '$Username' ORDER BY order_head . order_id DESC";
    $result = $conn->query($sql);
    $Code = $_POST['Code'];

    // $remove = "DELETE FROM order_head WHERE Code = '$Code'";
    // $resultremove = mysqli_query($conn,$remove);

    if($act == 'remove') {

        $deleteorderdetail = "DELETE FROM order_detail WHERE order_id = '$order_id'";
        $resultdetail = mysqli_query($conn,$deleteorderdetail);
        $deleteorderhead = "DELETE FROM order_head WHERE order_id = '$order_id'";
        $resulthead = mysqli_query($conn,$deleteorderhead);
        $deletepayment = "DELETE FROM payment_order WHERE order_id = '$order_id'";
        $resultpayment = mysqli_query($conn,$deletepayment);
        $deletepostcode = "DELETE FROM postcode_detail WHERE order_id = '$order_id'";
        $resultpostcode = mysqli_query($conn,$deletepostcode);
        echo '<script>alert("ลบรายการสำเร็จ");location.href="order.php";</script>';
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
        <a href="./index.php"><img  class="navbar-brand" style="width:60%"   src="./img/PETClub_Logo_314x86px.png" alt=""></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                id="navbarDropdown"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
                style="color:#fff "
              >
                สินค้า <i class="fas fa-store"></i>
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="small_size.php">ขนาดเล็ก</a></li>
                <li><a class="dropdown-item" href="medium_size.php">ขนาดกลาง</a></li>
                <li><a class="dropdown-item" href="big_size.php">ขนาดใหญ่</a></li>
                <li><a class="dropdown-item" href="jumbo_size.php">ขนาดใหญ่พิเศษ</a></li>
              </ul>
            </li>
            <li class="nav-item">
                <a style="color:#fff !important" class="nav-link" href="./howtobuy.php">วิธีการสั่งซื้อ <i class="far fa-credit-card"></i></a>
            </li>
            <?php 
                if(!empty($_SESSION['Username'])){
            ?>
            <li class="nav-item">
                <a style="color:#fff " class="nav-link" href="./contract.php">ติดต่อเรา <i class="fas fa-phone-volume"></i></a>
            </li>
            <?php
                }
            ?>
        </ul>

        <div class="d-flex">

        
            <!-- Dropdown  -->
            <?php if(!empty($_SESSION['Username'])){ ?>
            <li style="list-style-type: none;" class="nav-item">
                <a style="color:#fff " class="nav-link" href="https://www.flashexpress.co.th/tracking/">เช็คพัสดุ</a>
            </li>
            <li style="list-style-type: none;" class="nav-item">
                <a style="color:#fff " class="nav-link" href="./cart.php">ตะกร้าสินค้า <i class="fas fa-shopping-cart"></i></a>
            </li>
            <li style="list-style-type: none;" class="nav-item dropdown ">
                <a  style="text-decoration:none;color:white" class="nav-link  dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    
                ผู้ใช้งาน: <span>
                    
                    <?php 
                        if(!empty($_SESSION['Username'])){
                            echo $_SESSION['Username'];
                        }
                        else {
                                
                        }
                    ?>
                    </span>
                    </a>
                <!-- เพิ่ม Session ชื่อผู้ใช้งาน -->
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a style="color:black" class="dropdown-item" href="edit_profile.php">แก้ไขข้อมูลส่วนตัว</a></li>
                    <li><a style="color:black" class="dropdown-item" href="order.php">สถานะคำสั่งซื้อ</a></li>
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
                                <form action="login.php" method="POST">
                                    <div class="mb-3">
                                        <label class="form-label">ชื่อผู้ใช้งาน</label>
                                        <input type="text" class="form-control" id="Username" name="Username" placeholder="ชื่อผู้ใช้งาน" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">รหัสผ่าน</label>
                                        <input type="password" class="form-control" id="Password" name="Password" placeholder="รหัสผ่าน" />
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
                                    <form action="./register.php" method="POST">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <span>ชื่อผู้ใช้งาน</span><span style="color:red;">*</span>
                                                <input type="text" id="Username" name="Username" class="form-control" required>
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
                                                <span>จังหวัด</span><span style="color:red;">*</span>
                                                <select class="form-control" name="Ref_prov_id" id="provinces">
                                                    <option  value="" selected disabled>-กรุณาเลือกจังหวัด-</option>
                                                    <?php foreach ($query_provinces as $value) { ?>
                                                        <!-- // ผลลัพธ์ออกมาเป็นตัวเลข -->
                                                        <option value="<?=$value['id']?>"><?=$value['name_th']?></option>
                                                    <?php } ?>
                                                </select>
                                                
                                            </div>
                                            <div class="col-6">
                                                <span>อำเภอ</span><span style="color:red;">*</span>
                                                <!-- <input type="text" id="Amphoe" name="Amphoe" class="form-control" required> -->
                                                <select class="form-control" name="Ref_dist_id" id="amphures">
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <span>ตำบล</span><span style="color:red;">*</span>
                                                <!-- <input type="text" id="Tambon" name="Tambon" class="form-control" required> -->
                                                <select class="form-control" name="Ref_subdist_id" id="districts">
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <span>รหัสไปรษณี</span><span style="color:red;">*</span>
                                                <input type="text" id="zip_code" name="zip_code" class="form-control" required>
                                            </div>
                                            <div class="col-12 mt-5">                        
                                                <button type="submit" class="btn btn-success float-end">สมัครสมาชิก</button>
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
            <div class="table-responsive">
                <form action="" method="POST">
                    <table  class="table table-bordered mt-3">
                        <tr>
                            <td align='left'>เลขที่ใบสั่งซื้อ</td>
                            <td align='left'>ชื่อผู้รับ</td>
                            <td align='left'>ที่อยู่จัดส่ง</td>
                            <td align='left'>อีเมล์</td>
                            <td align='right'>เบอร์ติดต่อ</td>
                            <td align='right'>จำนวนเงิน</td>
                            <td align='left'>สถานะคำสั่งซื้อ</td>
                            <td align='left'>รายละเอียด</td>
                            <td align='left'>ยกเลิกรายการ</td>
                            <!-- <td>เลขพัสดุ</td>
                            <td>ใบเสร็จ</td> -->
                        </tr>
                        <h3>ออเดอร์ของฉัน</h3>
                        <?php
                            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                        ?>
                        <tr>
                            <td align='left'><?php echo $row["order_id"]?></td>
                            <td align='left'><?php echo $row["order_name"]?></td>
                            <td align='left'><?php echo $row["order_address"]?></td>
                            <td align='left'><?php echo $row["order_email"]?></td>
                            <td align='right'><?php echo $row["order_phone"]?></td>
                            <td align='right'><?php echo $row["order_total"]?></td>
                            <td align='left'><?php echo $row["order_status"]?></td>
                            <td align='left'><a href="order_detail_member.php?order_id=<?php echo $row['order_id'];?>">รายละเอียด</a></td>

                            <?php if($row['order_status'] == "ยังไม่ได้ชำระเงิน"  || $row['order_status'] == "รอตรวจสอบ") {?>
                                <td align='center'><a style="color:red" href='order.php?order_id=<?php echo $row['order_id']; ?>&act=remove'>ลบ</a></td>
                            <?php }else{ ?>
                                <td></td>
                            <?php } ?></tr>
                        <?php
                            }
                        ?>

                    </table>
                </form>
            </div>
        </div>
    </div>
    </section>

   


</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</html>