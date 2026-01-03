<?php


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>nexus MERCATO | Elite Football Management</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@700;800;900&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body class="bg-stadium">
    <!-- Fixed gradient overlay -->
    <div class="overlay-gradient"></div>

    <!-- Top Header -->
    <header class="top-header">
        <!-- TODO: Show login button if user is visitor -->
        <a href="login.php" class="btn-orange">
            <i class="fas fa-sign-in-alt mr-2"></i>
            LOGIN
        </a>


    </header>

    <!-- Sidebar -->
    <aside class="sidebar">
        <!-- Logo -->
        <div class="logo-container">
            <div class="flex items-center gap-5">
                <div class="logo-icon-enhanced">
                    <img src="./assets/img/logo.png" alt="nexus Logo" class="object-contain p-3">
                </div>
                <div class="flex-1">
                    <h1 class="logo-text-main">NEXUS</h1>
                    <p class="logo-text-sub">MERCATO</p>
                </div>
            </div>
       </div>

        <!-- Navigation -->
        <nav class="py-10">
            <!-- TODO: Add 'active' class to current page -->
            <a href="index.php" class="nav-link">
                <i class="fas fa-chart-line"></i>
                <span>DASHBOARD</span>
            </a>
            <a href="players.php" class="nav-link">
                <i class="fas fa-users"></i>
                <span>PLAYERS</span>
            </a>
            <a href="teams.php" class="nav-link">
                <i class="fas fa-shield-alt"></i>
                <span>TEAMS</span>
            </a>
            <a href="transfers.php" class="nav-link">
                <i class="fas fa-exchange-alt"></i>
                <span>TRANSFERS</span>
            </a>
            <a href="contracts.php" class="nav-link">
                <i class="fas fa-file-contract"></i>
                <span>CONTRACTS</span>
            </a>


        </nav>

        <!-- Footer -->
        <div class="absolute bottom-0 left-0 right-0 p-8 border-t-2 border-white/10">
            <p class="text-xs text-gray-600 tracking-widest font-bold">© 2025 nexus SYSTEMS</p>
            <p class="text-xs text-gray-700 tracking-wider mt-1">v2.5.1 ELITE</p>
        </div>
    </aside>

    <!-- Main Content Start -->
    <main class="main-content" style="padding-top: 80px;">