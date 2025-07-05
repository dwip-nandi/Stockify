<?php 
    require('connection.php');
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
    <title>Edit Stor Product</title>
</head>
<body>
    <?php
    if(isset($_GET['id'])){
        $stor_product_id=$_GET['id'];
        $sql2="SELECT * FROM `stor_product` WHERE stor_product_id =$stor_product_id";
        $query2=$conn->query($sql2);
        $data2=mysqli_fetch_assoc($query2);
         $stor_product_name= $data2['stor_product_name'];
         $stor_product_quantity= $data2['stor_product_quantity'];
         $stor_product_entry_date=$data2['stor_product_entry_date'];
    }
    
    if(isset($_GET['stor_product_name'])){
        echo $new_stor_product_id=$_GET['stor_product_id'];
        $new_stor_product_name=$_GET['stor_product_name'];
        $new_stor_product_quantity=$_GET['stor_product_quantity'];
        $new_stor_product_update_date=$_GET['stor_product_entry_date'];
    }
    $sql3= "UPDATE stor_product SET 
                              stor_product_name='$new_stor_product_name',
                              stor_product_quantity='$new_stor_product_quantity',
                              stor_product_entry_date='$new_stor_product_update_date'  
                              WHERE stor_product_id='$new_stor_product_id' ";

        if($conn->query($sql3)===TRUE){
               echo "Update Successfully";
        }else echo "Not Update";

    ?>
    
<form action="<?php $_SERVER['PHP_SELF'];?>" method="GET">
    Product : 
    <select name="stor_product_name" id="">
        <?php
           $sql1="SELECT * FROM `product`";
           $query1= $conn->query($sql1);
         
           while($data1=mysqli_fetch_assoc($query1)){
             $product_id=$data1['product_id'];
             $product_name=$data1['product_name'];
        ?>
         

            <option value='<?php echo $product_id?>'<?php if($product_id==$stor_product_name){echo 'selected';}  ?> > <?php echo $product_name?></option>
        <?php      
            }
        ?>
        
    </select><br>
    Product Quantity : <input type="text" name="stor_product_quantity" value="<?php echo $stor_product_quantity?>"><br>
    Stor Product Entry Date : <input type="date" name="stor_product_entry_date"value="<?php echo $stor_product_entry_date?>"><br>
    <input type="text" name="stor_product_id" value="<?php echo $stor_product_id  ?>" hidden >
    <input type="submit" value="Update">
</form>
</body>
</html>
<?php 
       }else{
        header('location:login_system.php');
       }

?>