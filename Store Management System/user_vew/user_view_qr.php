<?php
$url = "http://localhost/Store%20Management%20System/user_vew/product.php"; // Adjust as needed
$qr_code = "https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=" . rawurlencode($url);
?>

<!DOCTYPE html>
<html>
<head>
    <title>STOCKIFY QR</title>
    <style>
        .qr-wrapper {
            text-align: center;
            margin-top: 50px;
        }
        .qr-wrapper img {
            border: 5px solid #007bff;
            border-radius: 10px;
        }
        .qr-text {
            font-family: Arial, sans-serif;
            margin-top: 10px;
            font-size: 20px;
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="qr-wrapper">
        <img src="<?php echo $qr_code; ?>" alt="QR Code">
        <div class="qr-text">STOCKIFY</div>
    </div>
</body>
</html>
