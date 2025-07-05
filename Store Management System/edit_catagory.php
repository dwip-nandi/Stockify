<?php require('connection.php'); 
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
    <title>Edit Catagory</title>
</head>
<body>

<?php 
//    echo $_GET['id'];
   if(isset($_GET['id'])){
       $get_catagory_id =$_GET['id'];
       $sql="SELECT * FROM `catagory_icatagory` WHERE `catagory_id`=$get_catagory_id";
       $query= $conn->query($sql);
       $data= mysqli_fetch_assoc($query);
       $catagory_id=$data['catagory_id'];
       $catagory_name=$data['catagory_name'];
       $catagory_entry_date=$data['catagory_entry_date'];

   }
   if(isset($_GET['catagory_name'])){
   $new_catagory_id= $_GET['catagory_id'];
   $new_catagory_name= $_GET['catagory_name'];
   $new_catagory_date= $_GET['catagory_entry_date'];
   }
   $sql1= "UPDATE catagory_icatagory SET 
   catagory_name='$new_catagory_name',
   catagory_entry_date='$new_catagory_date'
   WHERE catagory_id='$new_catagory_id' ";

   if($conn->query($sql1)===TRUE){
       echo "Update Successfully";
   }else echo "Not Update";

  
?>
<form action="edit_catagory.php" method="GET">
    Catagory : <br><input type="text" name="catagory_name" value="<?php echo $catagory_name ?>"><br>
    Catagory Entry Date : <br><input type="date" name="catagory_entry_date" value="<?php echo $catagory_entry_date; ?>"><br>
    <input type="text"name="catagory_id"value="<?php echo $catagory_id ?>" hidden>
    <input type="submit" value="Update">
</form>
    
</body>
</html>
<?php 
       }else{
        header('location:login_system.php');
       }

?>