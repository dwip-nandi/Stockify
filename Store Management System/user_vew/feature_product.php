<?php
require('D:/Ampps/www/Store Management System/connection.php');

$query = "SELECT * FROM feature_products";
$result = mysqli_query($conn, $query);
$slides = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Feature Product Slider</title>
    <style>
        .container {
            padding: 0;
            margin: 0 auto;
            max-width: 100%;
        }

        .slider {
            position: relative;
            width: 100%;
            height: 650px;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }

        .slide {
            display: none;
            position: absolute;
            width: 100%;
            height: 100%;
            animation: fadeEffect 1s ease-in-out;
        }

        .slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        @keyframes fadeEffect {
            from { opacity: 0.4; }
            to { opacity: 1; }
        }

        .text, .text2 {
            position: absolute;
            bottom: 30px;
            padding: 12px 24px;
            font-size: 20px;
            color: #fff;
            background: rgba(0, 0, 0, 0.6);
            border-radius: 8px;
            z-index: 1;
        }

        .text { left: 30px; animation: slideInLeft 1s forwards; }
        .text2 { right: 30px; animation: slideInRight 1s forwards; }

        @keyframes slideInLeft {
            0% { transform: translateX(-100%); opacity: 0; }
            100% { transform: translateX(0); opacity: 1; }
        }

        @keyframes slideInRight {
            0% { transform: translateX(100%); opacity: 0; }
            100% { transform: translateX(0); opacity: 1; }
        }

        .radio-buttons {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            gap: 10px;
        }

        .radio-buttons input[type="radio"] { display: none; }

        .radio-buttons label {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background-color: #ccc;
            cursor: pointer;
            transition: background 0.3s;
        }

        .radio-buttons input:checked + label {
            background-color: #007bff;
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.4);
        }

        @media (max-width: 768px) {
            .slider { height: 300px; }
            .text, .text2 { font-size: 16px; padding: 10px 16px; }
        }
    </style>
</head>

<body>
    <div class="container">
        <?php require('D:/Ampps/www/Store Management System/banner.php'); ?>

        <div class="slider">
            <?php foreach ($slides as $index => $slide): ?>
                <?php
                    // Safely extract just the filename and encode it for URL usage
                    $imageName = rawurlencode(basename($slide['image']));
                    $imagePath = "/Store%20Management%20System/user_vew/imgs/" . $imageName;
                ?>
                <div class="slide" style="display: <?= $index === 0 ? 'block' : 'none' ?>;">
                    <img src="<?= $imagePath ?>" alt="Slide <?= $index + 1 ?>" />
                    <div class="text"><?= htmlspecialchars($slide['name']) ?></div>
                    <div class="text2"><?= htmlspecialchars($slide['description']) ?></div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="radio-buttons">
            <?php foreach ($slides as $index => $_): ?>
                <input type="radio" name="slider" id="radio<?= $index ?>" onclick="currentSlide(<?= $index ?>)" <?= $index === 0 ? 'checked' : '' ?> />
                <label for="radio<?= $index ?>"></label>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        let currentIndex = 0;
        const slides = document.getElementsByClassName("slide");
        const radios = document.getElementsByName("slider");
        let autoSlide;

        function showSlides() {
            for (let i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
                radios[i].checked = false;
            }
            currentIndex = (currentIndex + 1) % slides.length;
            slides[currentIndex].style.display = "block";
            radios[currentIndex].checked = true;
            autoSlide = setTimeout(showSlides, 3000);
        }

        function currentSlide(n) {
            clearTimeout(autoSlide);
            for (let i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
                radios[i].checked = false;
            }
            slides[n].style.display = "block";
            radios[n].checked = true;
            currentIndex = n;
            autoSlide = setTimeout(showSlides, 3000);
        }

        showSlides(); // Initialize slider
    </script>
</body>
</html>
