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
    <title>Add Spand Product</title>
</head>
<body>
    <?php
    if(isset($_GET['spand_product_name'])&& isset($_GET['spand_product_quantity'])&& isset($_GET['spand_date'])){
         $spand_product_name= $_GET['spand_product_name'];
         $spand_product_quantity= $_GET['spand_product_quantity'];
         $spand_date= $_GET['spand_date'];

        $sql="INSERT INTO spand_product(spand_product_name,spand_product_quantity,spand_date)
              VALUES ('$spand_product_name','$spand_product_quantity','$spand_date' );";

              if ($conn->multi_query($sql) === TRUE) {
                echo "New records created successfully";
              } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
              }
    } 
    ?>
    
<form action="<?php $_SERVER['PHP_SELF'];?>" method="GET">
    Product Name: 
    <select name="spand_product_name" id="">
        <?php
           data_list('product','product_id','product_name');
        ?>
        
    </select><br>
    Spand Product Quantity : <input type="number" name="spand_product_quantity"><br>
    Spand Date : <input type="date" name="spand_date"><br>
    <input type="submit" value="submit">
</form>
</body>
</html>
<?php 
       }else{
        header('location:login_system.php');
       }

?>