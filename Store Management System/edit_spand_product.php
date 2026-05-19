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
    <title>Edit Spand Product</title>
</head>
<body>
    <?php
    if(isset($_GET['id'])){
        $spand_product_id=$_GET['id'];
        $sql2="SELECT * FROM `spand_product` WHERE spand_product_id =$spand_product_id";
        $query2=$conn->query($sql2);
        $data2=mysqli_fetch_assoc($query2);
          $spand_product_name= $data2['spand_product_name'];
          $spand_product_quantity= $data2['spand_product_quantity'];
          $spand_date=$data2['spand_date'];
    }
    
    if(isset($_GET['spand_product_name'])){
        $new_spand_product_id=$_GET['spand_product_id'];
        $new_spand_product_name=$_GET['spand_product_name'];
        $new_spand_product_quantity=$_GET['spand_product_quantity'];
        $new_spand_product_update_date=$_GET['spand_date'];
    }
    $sql3= "UPDATE spand_product SET 
                              spand_product_name='$new_spand_product_name',
                              spand_product_quantity='$new_spand_product_quantity',
                              spand_date='$new_spand_product_update_date'  
                              WHERE spand_product_id='$new_spand_product_id' ";

        if($conn->query($sql3)===TRUE){
               echo "Update Successfully";
        }else echo "Not Update";

    ?>
    
<form action="<?php $_SERVER['PHP_SELF'];?>" method="GET">
    Product : 
    <select name="spand_product_name" id="">
        <?php
           $sql1="SELECT * FROM `product`";
           $query1= $conn->query($sql1);
         
           while($data1=mysqli_fetch_assoc($query1)){
             $product_id=$data1['product_id'];
             $product_name=$data1['product_name'];
        ?>
         

            <option value='<?php echo $product_id?>'<?php if($product_id==$spand_product_name){echo 'selected';}  ?> > <?php echo $product_name?></option>
        <?php      
            }
        ?>
        
    </select><br>
    Product Quantity : <input type="text" name="spand_product_quantity" value="<?php echo $spand_product_quantity?>"><br>
    Product Spand  Date : <input type="date" name="spand_date"value="<?php echo $spand_date?>"><br>
    <input type="text" name="spand_product_id" value="<?php echo $spand_product_id  ?>"  >
    <input type="submit" value="Update">
</form>
</body>
</html>
<?php 
       }else{
        header('location:login_system.php');
       }

?>
<style>
        body { background-color: #f8f9fa; font-family: Arial, sans-serif; }
        h1 { text-align: center; margin: 30px 0; font-weight: bold; color: #343a40; animation: slideText 3s linear infinite; }
        @keyframes slideText { 0% { transform: translateX(0); } 50% { transform: translateX(30px); } 100% { transform: translateX(0); } }
        .search-form { display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; margin-bottom: 30px; }
        .search-form input[type="text"], .search-form select { padding: 8px; border: 1px solid #ced4da; border-radius: 5px; width: 200px; }
        .search-form input[type="submit"] { background-color: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; }
        table { width: 100%; background-color: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        thead { background-color: #007bff; color: #fff; }
        th, td { padding: 10px; text-align: center; font-size: 14px; }
        tbody tr:hover { background-color: #f1f1f1; }
        .low-stock { background-color: #ffecec; }
        .inline-form input[type="number"] { width: 70px; padding: 5px; margin-right: 5px; }
        .inline-form input[type="submit"] { padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer; }
        .inline-form input[name="add_product"] { background-color: #28a745; color: white; }
        .inline-form input[name="sell_product"] { background-color: #dc3545; color: white; }
        .edit-button { background-color: #ffc107; color: white; padding: 5px 10px; border: none; border-radius: 5px; text-decoration: none; }
        .edit-button:hover { background-color: #e0a800; }
        .pagination { text-align: center; margin-top: 30px; }
        .pagination a, .pagination strong { margin: 0 5px; padding: 8px 12px; text-decoration: none; border-radius: 4px; }
        .pagination a { background-color: #e9ecef; color: #007bff; }
        .pagination strong { background-color: #007bff; color: white; }
    </style>