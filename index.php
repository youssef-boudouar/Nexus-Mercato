<?php

session_start();


// Include header
include './includes/header.php';
?>

<div class="max-w-7xl mx-auto p-10 space-y-10">

    <!-- Hero Banner -->
    <section id="dashboard" class="hero-banner">
        <div class="hero-overlay"></div>
        <div class="hero-content p-16">
            <h1 class="text-8xl font-black orange-glow-strong tech-header mb-6" style="line-height: 0.9;">nexus<br>COMMAND CENTER</h1>
            <p class="text-gray-300 text-2xl tracking-widest mb-16 font-bold">ELITE FOOTBALL MANAGEMENT PLATFORM</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 max-w-5xl">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-4 h-4 rounded-full bg-[#FF5722] pulse-live"></div>
                        <p class="text-gray-400 text-sm font-black tech-header tracking-widest">PLAYER VALUE GROWTH</p>
                    </div>
                    <p class="stat-number orange-glow-strong">€0</p>
                    <p class="text-gray-500 text-xs tracking-widest mt-3 font-bold">TOTAL MARKET VALUE</p>
                </div>

                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-4 h-4 rounded-full bg-[#14b8a6] pulse-live"></div>
                        <p class="text-gray-400 text-sm font-black tech-header tracking-widest">TROPHIES</p>
                    </div>
                    <p class="stat-number teal-glow">0</p>
                    <p class="text-gray-500 text-xs tracking-widest mt-3 font-bold">CLUBS IN SYSTEM</p>
                </div>

                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-4 h-4 rounded-full bg-[#FF5722] pulse-live"></div>
                        <p class="text-gray-400 text-sm font-black tech-header tracking-widest">ACTIVE CONTRACTS</p>
                    </div>
                    <p class="stat-number orange-glow-strong">0</p>
                    <p class="text-gray-500 text-xs tracking-widest mt-3 font-bold">BINDING AGREEMENTS</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Cards -->
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-euro-sign text-4xl text-[#FF5722]"></i>
            </div>
            <h3 class="text-gray-400 text-xs font-black tech-header mb-4 tracking-widest">TOTAL BUDGET</h3>
            <p class="stat-number orange-glow">€0</p>
            <p class="text-gray-500 text-xs mt-4 tracking-widest font-bold">COMBINED PORTFOLIO</p>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users text-4xl text-[#14b8a6]"></i>
            </div>
            <h3 class="text-gray-400 text-xs font-black tech-header mb-4 tracking-widest">ACTIVE SQUAD</h3>
            <p class="stat-number teal-glow">0</p>
            <p class="text-gray-500 text-xs mt-4 tracking-widest font-bold">REGISTERED PLAYERS</p>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-exchange-alt text-4xl text-[#FF5722]"></i>
            </div>
            <h3 class="text-gray-400 text-xs font-black tech-header mb-4 tracking-widest">TRANSFER WINDOW</h3>
            <p class="stat-number orange-glow">0</p>
            <p class="text-gray-500 text-xs mt-4 tracking-widest font-bold">TOTAL TRANSACTIONS</p>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-chart-line text-4xl text-[#14b8a6]"></i>
            </div>
            <h3 class="text-gray-400 text-xs font-black tech-header mb-4 tracking-widest">ANNUAL COSTS</h3>
            <p class="stat-number teal-glow">€0</p>
            <p class="text-gray-500 text-xs mt-4 tracking-widest font-bold">YEARLY SALARIES</p>
        </div>
    </section>

    <!-- Elite Players & Live Trans -->
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Elite Players -->
        <div class="glass-dark rounded-2xl p-10">
            <div class="flex items-center justify-between mb-10">
                <h2 class="text-4xl font-black orange-glow tech-header">ELITE PLAYERS</h2>
                <span class="text-xs text-gray-500 tracking-widest font-bold">TOP 5 BY VALUE</span>
            </div>
            <div class="space-y-5">
                <!-- Sample static player card -->
                <div class="glass-dark player-card-enhanced rounded-xl p-6 flex items-center justify-between">
                    <div class="flex items-center gap-5">
                        <div class="w-16 h-16 rank-badge rounded-xl flex items-center justify-center">
                            <span class="text-white font-black text-2xl">1</span>
                        </div>
                        <div>
                            <p class="font-black text-white text-xl tracking-wide">Player Name</p>
                            <p class="text-sm text-gray-400 tracking-widest font-bold mt-1">Position • Nationality</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-black text-[#FF5722] text-2xl">€0</p>
                        <p class="text-xs text-gray-500 tracking-widest font-bold mt-1">MARKET VALUE</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Live Transfers -->
        <div class="glass-dark rounded-2xl p-10">
            <div class="flex items-center justify-between mb-10">
                <h2 class="text-4xl font-black teal-glow tech-header">LIVE TRANSFERS</h2>
                <div class="w-4 h-4 rounded-full bg-[#14b8a6] pulse-live shadow-[0_0_30px_rgba(20,184,166,0.8)]"></div>
            </div>
            <div class="space-y-5">

                <p class="text-gray-500 text-center py-16 tracking-widest font-bold">NO RECENT TRANSFERS</p>
            </div>
        </div>
    </section>



</div>

<?php include './includes/footer.php'; ?>