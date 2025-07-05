<?php 
    require('connection.php');
    require('select_item.php');
    session_start();
    $user_first_name= $_SESSION['user_first_name'];
    $user_last_name =$_SESSION['user_last_name'];
    if(!empty($user_first_name) && !empty($user_last_name)){


?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Stor Product</title>
</head>
<body>
    <?php
    if(isset($_GET['stor_product_name'])){
         $stor_product_name= $_GET['stor_product_name'];
         $stor_product_quantity= $_GET['stor_product_quantity'];
         $stor_product_entry_date= $_GET['stor_product_entry_date'];

        $sql="INSERT INTO stor_product(stor_product_name,stor_product_quantity,stor_product_entry_date)
              VALUES ('$stor_product_name','$stor_product_quantity','$stor_product_entry_date' );";

              if ($conn->multi_query($sql) === TRUE) {
                echo "New records created successfully";
              } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
              }
    } 
    ?>
    
<form action="<?php $_SERVER['PHP_SELF'];?>" method="GET">
    Product : 
    <select name="stor_product_name" id="">
        <?php
           data_list('product','product_id','product_name');
        ?>
        
    </select><br>
    Product Quantity : <input type="text" name="stor_product_quantity"><br>
    Stor Product Entry Date : <input type="date" name="stor_product_entry_date"><br>
    <input type="submit" value="submit">
</form>
</body>
</html>
<?php 
       }else{
        header('location:login_system.php');
       }

?>