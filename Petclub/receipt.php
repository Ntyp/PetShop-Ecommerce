<?php
    include_once 'database.php';
    session_start();
    error_reporting(0);

    $order_id = $_GET['order_id'];
    $searchpost = "SELECT * FROM postcode_detail WHERE order_id = '$order_id'";
    $resultpost = mysqli_query($conn,$searchpost);
    $rowpost = mysqli_fetch_array($resultpost);

    $order_id = $_GET['order_id'];
    $count = 1;
    $cost = 50;
    $sumtotal = 0;
    $discount = 0;
    $searchdate = "SELECT * FROM payment_order WHERE order_id = '$order_id'";
    $resultdate = mysqli_query($conn,$searchdate);
    $rowdate = mysqli_fetch_array($resultdate);
    // สิ่งของที่สั่ง
    $sql = "SELECT * FROM order_detail WHERE order_id = '$order_id'";
    $result = mysqli_query($conn,$sql);

    // รายละเอียดคำสั่งซื้อ ชื่อ ที่อยู่ เมล์
    $sql1 = "SELECT * FROM order_head WHERE order_id = '$order_id'";
    $result1 = mysqli_query($conn,$sql1);
    $row1 = mysqli_fetch_array($result1);
    
    $user_owner = $row1['order_owner'];
    // ADDRESS USER
    $search_address = "SELECT * FROM member WHERE username = '$user_owner'";
    $result_address = mysqli_query($conn,$search_address);
    $row_address = mysqli_fetch_array($result_address);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <title>PETCLUB | ใบเสร็จรับเงิน</title>
</head>
<body>
    <section>
        <div class="container">
            <div class="row">
                
                <div class="mt-5">
                    <table class="table table-bordered">
                        <tr align='center'>
                            <td colspan='4' style="border:1px solid #000"><h3><b>SUGAR ZONE</b></h3></td>
                        </tr>
                        <tr align='center'>
                            <td colspan='4' style="border:1px solid #000"><p>ใบสั่งซื้อสินค้า</p></td>
                        </tr>
                        <tr>
                            <td colspan='4' style="border:1px solid #000" align='left'>
                                พิกัดร้าน:  604/578 เพรชเกษม 2 ซอย 14 ถนนเพชรเกษม 92/1 แขวงบางแคเหนือ ภาษีเจริญ กรุงเทพมหานคร 10160
                            </td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000" align='left'>คำสั่งซื้อเลขที่: <?php echo $order_id; ?></td>
                            <td style="border:1px solid #000" align='left'>เลขที่พัสดุ: <?php echo $rowpost['postcode_code'] ?></td>
                            <td  style="border:1px solid #000" align='left'>ผู้สั่ง: <?php echo $row1['order_owner']; ?></td>
                            <td style="border:1px solid #000" align='left'>วันที่สั่งซื้อ: <?php echo $rowdate['payment_date'] ?></td>
                        </tr>
                        <tr>
                            <td colspan='4' style="border:1px solid #000" align='left'>ที่อยู่การจัดส่งสินค้า: <p><span>ชื่อ-นามสกุล: </span><?php echo $row_address['firstname']." ".$row_address['lastname']." "."ที่อยู่: ".$row_address['address']." ".$row_address['tambon']." ".$row_address['amphoe']." ".$row_address['province']." ".$row_address['zipcode']." เบอร์ติดต่อ: ".$row_address['phone'] ?></p></td>

                        </tr>
                        <tr>
                            <td colspan='4' style="border:1px solid #000" align='left'>ที่อยู่ในการออกใบกำกับภาษี: 
                            <?php echo $row1['order_name']." ".$row1['order_address']." ".
                            $row1['order_email']." ".$row1['order_phone']; ?></td>
                        </tr>
                        <tr style="border:1px solid #000">
                            <td style="border:1px solid #000"   align='right'><b>ลำดับ</b></td>
                            <td style="border:1px solid #000"   align='left'><b>รายการสินค้า</b></td>
                            <td style="border:1px solid #000"   align='right'><b>จำนวน (ชิ้น)</b></td>
                            <td style="border:1px solid #000"   align='right'><b>ราคารวม (บาท)</b></td>
                        </tr>
                        <?php
                            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                        ?>
                        <tr style="border:1px solid #000">
                            <td style="border:1px solid #000" align='right' width:20px><?php echo $count++?></td>
                            <td style="border:1px solid #000" align='left'><?php echo $row['product_ID'];?></td>
                            <td style="border:1px solid #000" align='right'><?php echo $row['detail_qty'];?></td>
                            <td style="border:1px solid #000" align='right'><?php echo number_format($row['detail_subtotal'],2);?></td>
                            <?php $sumtotal += $row['detail_subtotal']?>
                        </tr>
                        <?php 
                            }
                        ?>
                        <tr style="border:1px solid #000">
                            <td style="border:1px solid #000" colspan='3'>ค่าจัดส่งสินค้า</td>
                            <td style="border:1px solid #000" align='right'><?php echo number_format($cost,2) ?></td>
                        </tr>
                        <?php $sumtotal += $cost+$discount ?>
                        <tr style="border:1px solid #000">
                            <td style="border:1px solid #000" colspan='3'>ราคารวมทั้งสิ้น </td>
                            <td style="border:1px solid #000" align='right'><?php echo number_format($sumtotal,2) ?></td>
                        </tr>
                    </table>
                </div>
                    
                
            </div>
        </div>
    </section>
</body>
<script src="https://www.markuptag.com/bootstrap/5/js/bootstrap.bundle.min.js"></script>
</html>
