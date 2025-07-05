<?php require('connection.php');

session_start();
$user_first_name= $_SESSION['user_first_name'];
$user_last_name =$_SESSION['user_last_name'];
if(!empty($user_first_name) && !empty($user_last_name)){

      
      $sql1="SELECT * FROM `product`";
      $query1=$conn->query($sql1);
      
      $data_list=array();

       while($data1=mysqli_fetch_assoc($query1)){
      $product_id=$data1['product_id'];
      $product_name=$data1['product_name'];
      $data_list[$product_id]=$product_name;
       }

    //    print_r($data_list);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Spand Products</title>
</head>
<body>

<?php 
  $sql=" SELECT * FROM `spand_product`";
  $query= $conn->query($sql);
  echo "<table border='1'> <tr><th>Id</th><th>Product Name</th><th>Product Quantity</th><th>Spand date</th><th>Action</th></tr>";
  
  while($data= mysqli_fetch_assoc($query)){
     $spand_product_id= $data['spand_product_id'];
     $spand_product_name= $data['spand_product_name'];
     $spand_product_quantity= $data['spand_product_quantity'];
     $spand_date= $data['spand_date'];

    echo "<tr>
             <td>$spand_product_id</td>
             <td>$data_list[$spand_product_name]</td>
             <td>$spand_product_quantity</td>
             <td>$spand_date</td>
             <td><a href='edit_spand_product.php?id=$spand_product_id'>Edit</a></td>
          </tr>";

  }

  echo "</table>";
  
?>
    
</body>
</html>
<?php 
       }else{
        header('location:login_system.php');
       }

?>