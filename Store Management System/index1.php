<?php
session_start();
$user_first_name = $_SESSION['user_first_name'] ?? null;
$user_last_name = $_SESSION['user_last_name'] ?? null;

if (!empty($user_first_name) && !empty($user_last_name)) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Stockify - Store Management System</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
        <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />
        <style>
            .container {
                max-width: 1400px;
                margin: auto;
                padding: 2rem 1rem;
            }

            .navbar-custom {
                background-color: #343a40;
                color: #fff;
                padding: 1rem 2rem;
                border-radius: 15px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 2rem;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
                overflow: hidden;
            }

            .logout-btn a {
                color: #fff;
                text-decoration: none;
            }

            .logout-btn {
                background-color: #dc3545;
                border-radius: 8px;
                padding: 0.45rem 1.25rem;
                font-weight: 600;
                border: none;
            }

            .logout-btn:hover {
                background-color: #c82333;
            }

            .section-title {
                background-color: #0d6efd;
                color: white;
                padding: 0.75rem 1rem;
                border-radius: 12px;
                font-size: 1.4rem;
                font-weight: bold;
                margin-bottom: 1.5rem;
                text-align: center;
                box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            }

            .card {
                border-radius: 20px;
                transition: 0.3s;
                text-align: center;
                background: #ffffff;
                padding: 1.5rem 1rem;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }

            .card.card-animate {
                transition: transform 0.4s ease, box-shadow 0.4s ease;
            }

            .card.card-animate:hover {
                transform: scale(1.05) rotateZ(1deg);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            }

            .card i {
                font-size: 2.5rem;
                margin-bottom: 1rem;
            }

            .card a {
                text-decoration: none;
                font-weight: bold;
                color: #333;
                display: block;
            }

            .card a:hover {
                color: #007bff;
            }

            .qr-container {
                text-align: center;
                margin-bottom: 3rem;
            }

            .qr-container h3 {
                font-weight: 600;
                color: #333;
            }

            /* Slide-in loop animation */
            @keyframes slideRightLoop {
                0% {
                    transform: translateX(-100%);
                    opacity: 0;
                }
                50% {
                    transform: translateX(0);
                    opacity: 1;
                }
                100% {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }

            .slide-in-right-loop {
                display: inline-block;
                white-space: nowrap;
                animation: slideRightLoop 5s ease-in-out infinite;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <?php require('D:\Ampps\www\Store Management System\banner.php'); ?>

            <div class="navbar-custom">
                <h2 class="slide-in-right-loop">Welcome to STOCKIFY</h2>
                <div>
                    <span class="me-3">Hello, <strong><?php echo htmlspecialchars("$user_first_name $user_last_name"); ?></strong></span>
                    <button class="logout-btn">
                        <a href="logout_system.php">Logout <i class="fa-solid fa-right-from-bracket ms-1"></i></a>
                    </button>
                </div>
            </div>

            <?php
            $sections = [
                'Admin Management' => [
                    ["add_users.php", "fa-user-plus", "Add Admin", "text-danger"],
                    ["list_of_users.php", "fa-users", "List of Admin", "text-danger"],
                    ["edit_user.php", "fa-user-edit", "Edit Admin", "text-danger"],
                    ["delete_admin.php", "fa-user-times", "Delete Admin", "text-danger"],
                ],
                'Product Management' => [
                    ["add_product.php", "fa-box-open", "Add Product", "text-primary"],
                    ["store_vew/sells.php", "fa-boxes", "List of Product", "text-primary"],
                    ["edit_product.php", "fa-edit", "Edit Product", "text-primary"],
                    ["delete_product.php", "fa-trash-alt", "Delete Product", "text-primary"],
                ],
                'Category Management' => [
                    ["add_catagory.php", "fa-folder-plus", "Add Category", "text-success"],
                    ["list_of_catagory.php", "fa-folder-open", "List of Category", "text-success"],
                    ["edit_category.php", "fa-edit", "Edit Category", "text-success"],
                    ["delete_category.php", "fa-trash-alt", "Delete Category", "text-success"],
                ],
                'Discount Calendar' => [
                    ["event_calander/add_event.php", "fa-calendar-plus", "Add Event", "text-info"],
                    ["event_calander/event_calander.php", "fa-calendar-alt", "Discount Calendar", "text-info"],
                    ["edit_user.php", "fa-edit", "Edit Event", "text-info"],
                    ["delete_user.php", "fa-calendar-times", "Delete Event", "text-info"],
                ],
                'Feature Products' => [
                    ["user_vew/add_featur_product.php", "fa-plus", "Add Feature Product", "text-warning"],
                    ["user_vew/feature_product.php", "fa-list-check", "Feature Product List", "text-warning"],
                    ["edit_user.php", "fa-edit", "Edit Feature Product", "text-warning"],
                    ["delete_user.php", "fa-calendar-times", "Delete Feature Product", "text-warning"],
                ],
                'Dynamic Features' => [
                    ["store_vew/calender_view.php", "fa-chart-line", "Profit Calendar", "text-success"],
                    ["store_vew/daily_report.php", "fa-calendar-day", "Daily Report", "text-success"],
                    ["store_vew/monthly_repert.php", "fa-calendar-alt", "Monthly Report", "text-success"],
                    ["store_vew/analytics.php", "fa-chart-pie", "Analytics", "text-success"],
                ]
            ];

            $aosEffects = ['zoom-in', 'flip-left', 'flip-up', 'fade-up'];

            foreach ($sections as $title => $items) {
                echo "<div class='section-title' data-aos='fade-left' data-aos-duration='1000'>{$title}</div>";
                echo "<div class='row g-4 mb-5' data-aos='fade-up'>";
                foreach ($items as $index => $item) {
                    $effect = $aosEffects[$index % count($aosEffects)];
                    echo "<div class='col-6 col-md-3' data-aos='{$effect}' data-aos-delay='" . ($index * 150) . "'>
                        <div class='card card-animate'>
                            <i class='fa-solid {$item[1]} icon {$item[3]}'></i>
                            <a href='{$item[0]}'>{$item[2]}</a>
                        </div>
                      </div>";
                }
                echo "</div>";
            }
            ?>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
        <script>
            AOS.init({
                once: true,
                duration: 1000,
            });
        </script>
    </body>

    </html>
<?php
} else {
    header('location:login_system.php');
    exit();
}
?>
