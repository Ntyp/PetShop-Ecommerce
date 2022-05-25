<?php
    include_once 'database.php';
    session_start();

    echo '<pre>';
    print_r($_SESSION);
    echo'</pre>';
    // error_reporting(0);
    $order_name = $_POST['order_name'];
    $order_address = $_POST['order_address'];
    $order_email = $_POST['order_email'];
    $order_phone = $_POST['order_phone'];
        // จังหวัด
        $Province = $_POST['Ref_prov_id1'];
        $sql_province = "SELECT * FROM provinces WHERE id = '$Province'";
        $result_province = mysqli_query($conn,$sql_province);
        $row_province = mysqli_fetch_array($result_province);
        $Province2 = $row_province['name_th'];
        // อำเภอ
        $Amphoe = $_POST['Ref_dist_id1'];
        $sql_amphoe = "SELECT * FROM amphures WHERE id = '$Amphoe'";
        $result_amphoe = mysqli_query($conn,$sql_amphoe);
        $row_amphoe = mysqli_fetch_array($result_amphoe);
        $Amphoe2 = $row_amphoe['name_th'];
        // ตำบล
        $Tambon = $_POST['Ref_subdist_id1'];
        $sql_tambon = "SELECT * FROM districts WHERE id = '$Tambon'";
        $result_tambon = mysqli_query($conn,$sql_tambon);
        $row_tambon = mysqli_fetch_array($result_tambon);
        $Tambon2 = $row_tambon['name_th'];
        $Zipcode2 = $_POST['zip_code1'];

    $order_ads = $order_address." ".$Amphoe2." ".$Tambon2." ".$Province2." ".$Zipcode2;
    


    
    $order_total = $_POST['order_total'];
    
    $order_status = 'ยังไม่ได้ชำระเงิน';
    $order_owner = $_SESSION['Username'];

    $sql = "INSERT INTO order_head VALUES(null,'$order_name','$order_ads','$order_email','$order_phone','$order_total','$order_status','$order_owner')";
    $query = mysqli_query($conn,$sql);

    // เอาออเดอร์ล่าสุดเก็บข้อมูลลงไปยัง order_detail
    $sql2 = "SELECT MAX(order_id) AS order_id FROM order_head WHERE order_name = '$order_name' and 
    order_email = '$order_email'";
    $query2 = mysqli_query($conn,$sql2);
    $row2 = mysqli_fetch_array($query2);
    $order_id = $row2["order_id"];
    // 

    // $find = "SELECT order_id FROM order_head WHERE "
    // add Color Size ด้วย


    foreach($_SESSION['cart'] as $Code=>$qty){
        
        // เช็คจาก Stock_product เพื่อเอา Code
        $sql3 = "SELECT * FROM stock_product  WHERE Code= '$Code'";
        $query3 = mysqli_query($conn, $sql3);         
        $sum = $_SESSION['cart'][$Code]['Price']*$_SESSION['cart'][$Code]['qty'] ;
        $qty1 = $_SESSION['cart'][$Code]['qty'];
        $product_ID= $_SESSION['cart'][$Code]['Code'];
        $size1= $_SESSION['cart'][$Code]['Size'];
        $sql4 = "INSERT INTO order_detail (detail_id,order_id,product_ID,detail_size,detail_qty,detail_subtotal) VALUES 
        (null,'$order_id','$product_ID','$size1',$qty1 ,$sum)";
        $query4 = mysqli_query($conn,$sql4);
    }
    
    echo '<script>alert("ยืนยันออเดอร์ สามารถตรวจสอบคำสั่งซื้อได้ที่สถานะคำสั่งซื้อ");location.href="index.php";</script>';
    unset($_SESSION['cart']);
?>