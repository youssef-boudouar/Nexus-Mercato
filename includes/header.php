<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
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
    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body class="bg-black min-h-screen">
    
    <!-- Top Header -->
    <header class="top-header">
        <!-- Show login button if user is visitor -->
        <?php if(!isset($_SESSION['user_role'])): ?>
            <a href="../auth/login.php" class="relative group overflow-hidden pl-6 pr-8 py-2.5 rounded-lg bg-gradient-to-r from-orange-500 to-red-600 text-white font-bold text-sm tracking-wide shadow-lg shadow-orange-500/20 hover:shadow-orange-500/40 transition-all duration-300 border border-white/10 hover:-translate-y-0.5">
                <span class="relative z-10 flex items-center gap-2">
                    <i class="fas fa-sign-in-alt"></i> LOGIN ACCESS
                </span>
                <div class="absolute inset-0 bg-gradient-to-r from-red-600 to-orange-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </a>
        <?php else: ?>
            <!-- Show user role and logout button if logged in -->
            <div class="flex items-center gap-4">
                <div>
                    <p class="text-xs text-gray-400 tracking-widest font-bold">LOGGED IN AS</p>
                    <p class="text-sm font-black text-white uppercase tracking-wide tech-header">
                        <?php if($_SESSION['user_role'] === 'admin'): ?>
                            <i class="fas fa-shield-alt text-[#FF5722] mr-1"></i>
                        <?php else: ?>
                            <i class="fas fa-pen text-[#14b8a6] mr-1"></i>
                        <?php endif; ?>
                        <?= $_SESSION['user_role'] ?>
                    </p>
                </div>
                <a href="../auth/logout.php" class="btn-outline">
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    LOGOUT
                </a>
            </div>
        <?php endif; ?>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar">
        <!-- Logo -->
        <div class="logo-container">
            <div class="flex items-center gap-5">
                <div class="logo-icon-enhanced">
                    <img src="../assets/img/logo.png" alt="nexus Logo" class="object-contain p-3">
                </div>
                <div class="flex-1">
                    <h1 class="logo-text-main">NEXUS</h1>
                    <p class="logo-text-sub">MERCATO</p>
                </div>
            </div>
       </div>

        <!-- Navigation -->
        <nav class="py-10 space-y-1">
            <a href="../index.php" class="flex items-center gap-4 px-8 py-4 text-slate-400 hover:text-white transition-colors duration-300 group">
                <i class="fas fa-chart-line w-6 text-center group-hover:text-blue-400 transition-colors"></i>
                <span class="font-bold tracking-wider text-sm">DASHBOARD</span>
            </a>
            <a href="../players/players.php" class="flex items-center gap-4 px-8 py-4 text-slate-400 hover:text-white transition-colors duration-300 group">
                <i class="fas fa-users w-6 text-center group-hover:text-blue-400 transition-colors"></i>
                <span class="font-bold tracking-wider text-sm">PLAYERS</span>
            </a>
            <a href="../coaches/coaches.php" class="flex items-center gap-4 px-8 py-4 text-slate-400 hover:text-white transition-colors duration-300 group">
                <i class="fas fa-chalkboard-teacher w-6 text-center group-hover:text-blue-400 transition-colors"></i>
                <span class="font-bold tracking-wider text-sm">COACHES</span>
            </a>
            <a href="../teams/teams.php" class="flex items-center gap-4 px-8 py-4 text-slate-400 hover:text-white transition-colors duration-300 group">
                <i class="fas fa-shield-alt w-6 text-center group-hover:text-blue-400 transition-colors"></i>
                <span class="font-bold tracking-wider text-sm">TEAMS</span>
            </a>
            <a href="../transfers/transfers.php" class="flex items-center gap-4 px-8 py-4 text-slate-400 hover:text-white transition-colors duration-300 group">
                <i class="fas fa-exchange-alt w-6 text-center group-hover:text-blue-400 transition-colors"></i>
                <span class="font-bold tracking-wider text-sm">TRANSFERS</span>
            </a>
            <a href="../contracts/contracts.php" class="flex items-center gap-4 px-8 py-4 text-slate-400 hover:text-white transition-colors duration-300 group">
                <i class="fas fa-file-contract w-6 text-center group-hover:text-blue-400 transition-colors"></i>
                <span class="font-bold tracking-wider text-sm">CONTRACTS</span>
            </a>
        </nav>

        <!-- Footer -->
        <div class="absolute bottom-0 left-0 right-0 p-8 border-t-2 border-white/10">
            <p class="text-xs text-gray-600 tracking-widest font-bold">© 2025 NEXUS SYSTEMS</p>
            <p class="text-xs text-gray-700 tracking-wider mt-1">v2.5.1 ELITE</p>
        </div>
    </aside>

    <!-- Main Content Start -->
    <main class="main-content" style="padding-top: 80px;">