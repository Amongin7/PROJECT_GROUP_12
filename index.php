<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Page Title -->
    <title>Automatic Crime Record Management System</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/logo/favicon.png" type="image/x-icon">
    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/animate-3.7.0.css">
    <link rel="stylesheet" href="assets/css/font-awesome-4.7.0.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-4.1.3.min.css">
    <link rel="stylesheet" href="assets/css/owl-carousel.min.css">
    <link rel="stylesheet" href="assets/css/jquery.datetimepicker.min.css">
    <link rel="stylesheet" href="assets/css/linearicons.css">
    <style>
        body {3
            font-family: Arial, sans-serif;
            background: url('assets/images/training.webp') no-repeat center center fixed;
            background-size: cover;
            position: relative;
            margin: 0;
            padding: 0;
        }

        body::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Adjust opacity here */
            z-index: -1;
        }

        .header-area {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 10px 0;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        #logo img {
            width: 120px;
            height: auto;
        }

        .header-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin: 0;
        }

        .nav-menu {
            display: flex;
            justify-content: center;
            align-items: center;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-menu li {
            margin: 0 15px;
        }

        .nav-menu li a {
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            color: #333;
            padding: 8px 12px;
            border-radius: 4px;
        }

        .nav-menu li a:hover {
            background-color: #007bff;
            color: white;
        }

        .banner-area {
            color: #fff;
            text-align: left;
            padding: 80px 0;
        }

        .banner-area h4 {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #ffc107;
        }

        .banner-area h1 {
            font-size: 50px;
            font-weight: bold;
            line-height: 1.2;
            margin-bottom: 20px;
        }

        .banner-area p {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
 
    <header class="header-area">
        <div id="header" id="home">
            <div class="container">
                <div class="row align-items-center justify-content-between d-flex">
                    <!-- Logo -->
                    <div id="logo">
                        <a href="index.php"><img src="download.png" alt="Logo"></a>
                    </div>
                    <!-- Heading -->
                    <div class="header-title">
                        ACRMS
                    </div>
                    <!-- Navigation Menu -->
                    <nav id="nav-menu-container">
                        <ul class="nav-menu">
                           
                            <li><a href="backend/staff/index.php">Login As Staff</a></li>
                            <li><a href="backend/admin/index.php">Login as Adminstrator</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- Header Area End -->
    <!-- Banner Area Starts -->
    <section class="banner-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h4>Manage your Police Station Records in a simpler manner</h4>
                    <h1>ACRMS leads the way in Police Records digitization</h1>
                    <p>
                    Automatic Crime Record Management System provides a convenient way to store and manage records of Suspects, Complainants, Exhibits, Witnesses, case files and Station Staff
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Area End -->

    <!-- Footer Section -->
    <footer style="background-color: rgba(0, 0, 0, 0.8); color: white; text-align: center; padding: 10px 0; margin-top: 20px;">
        &copy; 2025 Automatic Crime Record Management System. All rights reserved.
    </footer>

</body>
</html>
