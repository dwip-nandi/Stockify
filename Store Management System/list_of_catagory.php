<?php
require('connection.php');
session_start();

$user_first_name = $_SESSION['user_first_name'];
$user_last_name = $_SESSION['user_last_name'];

if (!empty($user_first_name) && !empty($user_last_name)) {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>List of Categories</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background-color: #f8f9fa;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <?php require('D:\Ampps\www\Store Management System\banner.php'); ?>

            <div class="container mt-5">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h2>📋 List of Categories</h2>
                    </div>
                    <div class="card-body">
                        <?php
                        $sql = "SELECT * FROM `catagory_icatagory`";
                        $query = $conn->query($sql);

                        if ($query->num_rows > 0) {
                            echo "<div class='table-responsive'>";
                            echo "<table class='table table-bordered table-hover'>";
                            echo "<thead class='table-dark text-white'>
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
                            <th>Date Added</th>
                            <th>Action</th>
                        </tr>
                      </thead><tbody>";

                            while ($data = mysqli_fetch_assoc($query)) {
                                $id = $data['catagory_id'];
                                $catagory_name = $data['catagory_name'];
                                $catagory_date = $data['catagory_entry_date'];

                                echo "<tr>
                            <td>$id</td>
                            <td>$catagory_name</td>
                            <td>$catagory_date</td>
                            <td>
                                <a href='edit_catagory.php?id=$id' class='btn btn-warning btn-sm'>✏️ Edit</a>
                            </td>
                          </tr>";
                            }
                            echo "</tbody></table></div>";
                        } else {
                            echo "<p class='text-danger text-center fw-bold'>No categories found.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>


    </body>

    </html>

<?php
} else {
    header('location:login_system.php');
}
?>