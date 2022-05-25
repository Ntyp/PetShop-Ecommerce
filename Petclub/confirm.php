<?php
    include_once 'database.php';
    session_start();

    // echo '<pre>';
    // print_r($_SESSION);
    // echo'</pre>';
    if(isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['Username']);
        echo '<script>alert("ออกจากระบบสำเร็จ");</script>';
        header("Location: index.php");
    } 
    $Cost = 50;
    $product_ID = 1;
    $total=0;
    $user_name = $_SESSION['Username'];

    $sql_provinces = "SELECT * FROM provinces";
    $query_provinces = mysqli_query($conn,$sql_provinces);

    // ADDRESS USER
    $search_address = "SELECT * FROM member WHERE username = '$user_name'";
    $result_address = mysqli_query($conn,$search_address);
    $row_address = mysqli_fetch_array($result_address);
    

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
                <li><a class="dropdown-item" href="small_size.php">ชูก้าไรเดอร์</a></li>
                <li><a class="dropdown-item" href="medium_size.php">แมว</a></li>
                <li><a class="dropdown-item" href="big_size.php">หมา</a></li>
                <li><a class="dropdown-item" href="jumbo_size.php">สัตว์ขนาดใหญ่พิเศษ</a></li>
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
                    <li><a style="color:black" class="dropdown-item" href="user.php">ข้อมูลส่วนตัว</a></li>
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
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label">ชื่อผู้ใช้งาน</label>
                                                <input type="text" class="form-control" id="Username" name="Username" placeholder="ชื่อผู้ใช้งาน" />
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label">รหัสผ่าน</label>
                                                <input type="password" class="form-control" id="Password" name="Password" placeholder="รหัสผ่าน" />
                                            </div>
                                        </div>
                                    </div>
                                    
                                   
                                    <div class="modal-footer d-block">
                                        <p class="float-start"><a href="" data-bs-toggle="modal"  data-bs-target="#modalRegisterForm">สมัครสมาชิก</a></p>
                                        <button type="submit" class="btn btn-success float-end">ยืนยัน</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                
                <!-- Modal Register -->
                <div  class="modal fade" id="modalRegisterForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div  class="modal-dialog">
                        <div style="width:600px" class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">สมัครสมาชิก</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                    <form action="./register.php" method="POST">
                                        <div class="row g-3">
                                            <div class="col-md-12">
                                                <span>ชื่อผู้ใช้งาน</span><span style="color:red;"> *</span>
                                                <input type="text" id="Username" name="Username" class="form-control" required>
                                            </div>
                                            <div class="col-md-12">
                                                <span>รหัสผ่าน</span><span style="color:red;"> *</span>
                                                <input type="password" id="Password" name="Password" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <span>ชื่อจริง</span><span style="color:red;"> *</span>
                                                <input type="text" id="Firstname" name="Firstname" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <span>นามสกุล</span><span style="color:red;"> *</span>
                                                <input type="text" id="Lastname" name="Lastname" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <span>อีเมล์</span><span style="color:red;"> *</span>
                                                <input type="email" id="Email" name="Email" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <span>เบอร์ติดต่อ</span><span style="color:red;"> *</span>
                                                <input type="tel" id="Phone" name="Phone" class="form-control" required>
                                            </div>
                                            <div class="col-12">
                                                <span>ที่อยู่</span><span style="color:red;"> *</span>
                                                <textarea class="form-control" id="Address" name="Address" placeholder="ที่อยู่" required></textarea>
                                            </div>
                                            <div class="col-12">
                                                <span>จังหวัด</span><span style="color:red;"> *</span>
                                                <select class="form-control" name="Ref_prov_id" id="provinces">
                                                    <option  value="" selected disabled>-กรุณาเลือกจังหวัด-</option>
                                                    <?php foreach ($query_provinces as $value) { ?>
                                                        <!-- // ผลลัพธ์ออกมาเป็นตัวเลข -->
                                                        <option value="<?=$value['id']?>"><?=$value['name_th']?></option>
                                                    <?php } ?>
                                                </select>
                                                
                                            </div>
                                            <div class="col-12">
                                                <span>อำเภอ</span><span style="color:red;"> *</span>
                                                <!-- <input type="text" id="Amphoe" name="Amphoe" class="form-control" required> -->
                                                <select class="form-control" name="Ref_dist_id" id="amphures">
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <span>ตำบล</span><span style="color:red;"> *</span>
                                                <!-- <input type="text" id="Tambon" name="Tambon" class="form-control" required> -->
                                                <select class="form-control" name="Ref_subdist_id" id="districts">
                                                </select>
                                            </div>
                                            <div class="col-12">
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
            <center>
            <form id="frmcart" name="frmcart" action="saveorder.php" method="POST">
               <h3>ข้อมูลออเดอร์</h3>
               <div class="col-4"></div>
               <div class="col-7">
               
                        <table  class="table table-bordered mt-5">
                            
                            <tr>
                                <td align="center">ลำดับ</td>
                                <td align="center">รหัสสินค้า</td>
                                <td align="center">ชื่อสินค้า</td>
                                <td align="center">ขนาด</td>
                                <td width="100" align="center">ราคา</td>
                                <td align="center">จำนวน</td>
                                <td width="100" align="center">รวม</td>
                            </tr>
                            <?php
                
                if(!empty($_SESSION['cart']))
                {
                    foreach($_SESSION['cart'] as $Code=>$qty)
                    {
                        $sql = "SELECT * FROM stock_detail  WHERE Code= '$Code'";
                        $query = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_array($query);           
                        $sum = $_SESSION['cart'][$Code]['Price']*$_SESSION['cart'][$Code]['qty']  ;
                        $total += $sum;
                        
                        echo "<tr>";
                        echo "<td align='right'>".$product_ID++ ."</td>"; //ลำดับสินค้า
                        echo "<td align='right'>" . $_SESSION['cart'][$Code]['Code'] . "</td>"; //รหัสสินค้า
                        echo "<td align='left'>" . $_SESSION['cart'][$Code]['Name'] . "</td>"; //สินค้า
                        echo "<td align='left'>" . $_SESSION['cart'][$Code]['Size'] . "</td>"; //ขนาดสินค้า
                        echo "<td align='right'>" . number_format($_SESSION['cart'][$Code]['Price'],2) . "</td>"; //ราคา
                        echo "<td align='right'>" . $_SESSION['cart'][$Code]['qty'] . "</td>"; //จำนวน
                        echo "<td align='right'>" . number_format($sum,2) . "</td>"; //รวม(บาท)

                        
                        //รวม
                        //remove product
                        //<input type="hidden" name="product_ID" value="<?php echo $row["product_ID"];
                        
                        echo "</tr>";
                    }
                    echo "<tr>";
                    echo "<td colspan='3' bgcolor='#CEE7FF' align='center'><b>ราคารวม</b></td>";
                    echo "<td  colspan='4' align='right' colspan='5'><b> ". number_format($total,2) . " </b></td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<td colspan='3' bgcolor='#CEE7FF' align='center'><b>ค่าจัดส่งสินค้า</b></td>";
                    echo "<td  colspan='4' align='right' colspan='5'><b> ". number_format($Cost,2) . " </b></td>";
                    echo "</tr>";


                    $total1 = $total+$Cost;
                    echo "<tr>";
                    echo "<td colspan='3' bgcolor='#CEE7FF' align='center'><b>ราคารวมทั้งสิ้น</b></td>";
                    echo "<td colspan='4' align='right' bgcolor='#CEE7FF'>"."<b>".number_format($total1,2) ."</b>"."</td>";
                    echo "</tr>";
                }
                ?>
                <input type="hidden" name="order_total" id="order_total" value=<?php echo $lasttotal = $total+$Cost;?>>
                </table>
                </center>
                
               </div> 
                        <h3><u>ที่อยู่การจัดส่งสินค้า</u></h3>
                        <div class="col-6">
                            <p><span>ชื่อ-นามสกุล: </span><?php echo $row_address['firstname']." ".$row_address['lastname']."<br>"."ที่อยู่: ".$row_address['address']." ".$row_address['tambon']." ".$row_address['amphoe']." ".$row_address['province']." ".$row_address['zipcode']."<br>"."เบอร์ติดต่อ: ".$row_address['phone'] ?> <br></p>
                            <a style="color:red" href="edit_profile.php">แก้ไขที่อยู่ในการจัดส่งสินค้า</a>
                            <h3 class="mt-3"><u>ที่อยู่ในการออกใบกำกับภาษี</u></h3>
                            <div class="mt-2">
                                <input name="order_name" id="order_name" class="form-control" placeholder="ผู้รับสินค้า" type="text" required>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mt-3">
                                        <input name="order_email" id="order_email" class="form-control" placeholder="อีเมล์" type="text" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mt-3">
                                        <input name="order_phone" id="order_phone" class="form-control" placeholder="เบอร์ติดต่อ" type="text" required>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <textarea class="form-control" name="order_address" id="order_address" placeholder="ที่อยู่" cols="30" rows="5" required></textarea>
                                </div>
                                <div class="col-6">
                                    <br>
                                    <span>จังหวัด</span>
                                    <select class="form-control" name="Ref_prov_id1" id="provinces">
                                            <option  value="" selected disabled>-กรุณาเลือกจังหวัด-</option>
                                            <?php foreach ($query_provinces as $value) { ?>
                                            <option value="<?=$value['id']?>"><?=$value['name_th']?></option>
                                        <?php } ?>
                                    </select>  
                                </div>
                                <div class="col-6">
                                <br>
                                    <span>อำเภอ</span>
                                    <select class="form-control" name="Ref_dist_id1" id="amphures">
                                    </select>
                                </div>
                                <div class="col-6">
                                    <br>
                                    <span>ตำบล</span>
                                    <select class="form-control" name="Ref_subdist_id1" id="districts">
                                    </select>
                                </div>
                                <div class="col-6">
                                    <br>
                                    <span>รหัสไปรษณี</span>
                                    <input type="text" id="zip_code" name="zip_code1" class="form-control" required>
                                </div>
                            </div>
                            
                            
                            <input style="width:100%;margin-bottom:40px" class="btn btn-primary mt-5" name="Submit2" type="submit" value="ยืนยัน">
                            
                        
                    </div>
                    
               </form>
            
               <div class="col-3"></div>
           </div>
           
       </div>
   </section>


</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</html>
<?php include('script.php');?>