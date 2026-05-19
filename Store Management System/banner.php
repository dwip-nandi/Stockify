<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e3f2fd, #ffffff);
            min-height: 100vh;
            position: relative;
            padding-bottom: 60px;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background-image: url('img/stockfy.png');
            background-size: cover;
            background-position: center;
            opacity: 0.07;
            z-index: -1;
        }

        .container {
            max-width: 1400px;
            margin: auto;
            padding: 20px 0;
            /* padding: 2rem 1rem; */
        }

        .banner {
            background: linear-gradient(to right, #007bff, #00c6ff);
            color: #fff;
            border-radius: 20px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            box-shadow: 0 5px 20px rgba(0, 123, 255, 0.3);
            transition: transform 0.3s ease-in-out;
        }

        .banner:hover {
            transform: scale(1.02);
        }

        .banner .logo img {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            margin-right: 1rem;
            transition: transform 0.3s ease-in-out;
        }

        .banner .logo img:hover {
            transform: scale(1.1) rotate(5deg);
        }

        .banner h1 {
            font-size: 32px;
            font-weight: bold;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        }

        .banner h5 {
            font-size: 20px;
            font-weight: 500;
            opacity: 0.9;
        }

        .qr-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 25px;
        }

        .qr-container img {
            width: 80px;
            height: 80px;
            transition: transform 0.3s ease-in-out;
        }

        .qr-container img:hover {
            transform: scale(1.1);
        }

        .user_view {
            background: white;
            color: #007bff;
            margin-top: 10px;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .user_view:hover {
            background: #0056b3;
            color: white;
            transform: scale(1.1);
        }
    </style>
</head>

<body class="bg-light">

    <div class="container">
        <div class="banner" data-aos="fade-down" data-aos-duration="1000">
            <div class="d-flex align-items-center">
                <a class="logo" href="/Store Management System/index1.php"> 
                    <img src="img/logox.png" alt="Logo" data-aos="zoom-in" data-aos-delay="500">
                </a>
                <div>
                    <h1 class="ms-3 mb-0" data-aos="fade-up">Stockify</h1>
                    <h5 class="ms-5 mb-0" data-aos="fade-up" data-aos-delay="300">Store It, Track It, Win It.</h5>
                </div>
            </div>
            <div class="qr-container">
                <a href="/Store Management System/user_vew/product.php">
                    <img src="img/stockify_qr.png" alt="User View QR" class="img-fluid ms-3" data-aos="zoom-in" data-aos-delay="700">
                </a>
                <a class="user_view" href="/Store Management System/user_vew/product.php">
                    <i class="fa-solid fa-circle-user"></i> User View
                </a>
            </div>
        </div>
    </div>

    <!-- Initialize AOS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init();
    </script>

</body>

</html>