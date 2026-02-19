<?php

session_start();

// Require models - chdir to models/ so relative paths inside model files resolve correctly
$_originalDir = getcwd();
chdir(__DIR__ . '/models');
require_once __DIR__ . '/models/Player.php';
require_once __DIR__ . '/models/Team.php';
require_once __DIR__ . '/models/Contract.php';
require_once __DIR__ . '/models/Transfer.php';
chdir($_originalDir);

// Instantiate models
$playerModel = new Player();
$teamModel = new Team();
$contractModel = new Contract();
$transferModel = new Transfer();

// Fetch data
$players = $playerModel->getAll();
$teams = $teamModel->getAll();
$contracts = $contractModel->getAll();
$transfers = $transferModel->getAll();

// Compute stats
$totalPlayers = count($players);
$totalTeams = count($teams);
$totalContracts = count($contracts);
$totalTransfers = count($transfers);
$totalMarketValue = array_sum(array_column($players, 'market_value'));
$totalBudget = array_sum(array_column($teams, 'budget'));
$totalSalaries = array_sum(array_column($contracts, 'salary')) * 12;

/**
 * Format a number as €125.3M / €850K / €500
 */
function fmt(float $n): string {
    if ($n >= 1_000_000) {
        return '€' . round($n / 1_000_000, 1) . 'M';
    } elseif ($n >= 1_000) {
        return '€' . round($n / 1_000) . 'K';
    }
    return '€' . number_format($n, 0);
}

// Top 5 players (already sorted by market_value DESC from getAll)
$topPlayers = array_slice($players, 0, 5);

// 5 most recent transfers (reverse to get latest first, then slice)
$recentTransfers = array_slice(array_reverse($transfers), 0, 5);

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
                    <p class="stat-number orange-glow-strong"><?= fmt($totalMarketValue) ?></p>
                    <p class="text-gray-500 text-xs tracking-widest mt-3 font-bold">TOTAL MARKET VALUE</p>
                </div>

                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-4 h-4 rounded-full bg-[#14b8a6] pulse-live"></div>
                        <p class="text-gray-400 text-sm font-black tech-header tracking-widest">TROPHIES</p>
                    </div>
                    <p class="stat-number teal-glow"><?= $totalTeams ?></p>
                    <p class="text-gray-500 text-xs tracking-widest mt-3 font-bold">CLUBS IN SYSTEM</p>
                </div>

                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-4 h-4 rounded-full bg-[#FF5722] pulse-live"></div>
                        <p class="text-gray-400 text-sm font-black tech-header tracking-widest">ACTIVE CONTRACTS</p>
                    </div>
                    <p class="stat-number orange-glow-strong"><?= $totalContracts ?></p>
                    <p class="text-gray-500 text-xs tracking-widest mt-3 font-bold">BINDING AGREEMENTS</p>
                </div>
            </div>
        </div>
    </section>


    <!-- Elite Players & Live Transfers -->
    <section class="<?= isset($_SESSION['user_role']) ? 'grid grid-cols-1 lg:grid-cols-2 gap-8' : '' ?>">
        <!-- Elite Players -->
        <div class="glass-dark rounded-2xl p-10">
            <div class="flex items-center justify-between mb-10">
                <h2 class="text-4xl font-black orange-glow tech-header">ELITE PLAYERS</h2>
                <span class="text-xs text-gray-500 tracking-widest font-bold">TOP 5 BY VALUE</span>
            </div>
            <div class="space-y-4">
                <?php if (empty($topPlayers)): ?>
                    <p class="text-gray-500 text-center py-16 tracking-widest font-bold">NO PLAYERS REGISTERED</p>
                <?php else: ?>
                    <?php foreach ($topPlayers as $rank => $p): ?>
                        <div class="glass-dark rounded-2xl p-6 flex items-center border-l-4 border-[#FF5722] border-[#FF5722]/20">
                            <!-- Rank -->
                            <div class="w-8 h-8 rounded-full bg-[#FF5722] flex items-center justify-center flex-shrink-0">
                                <span class="text-white text-sm font-black"><?= $rank + 1 ?></span>
                            </div>
                            <!-- Photo -->
                            <div class="w-16 h-20 rounded-xl overflow-hidden flex-shrink-0 ml-4">
                                <?php if (!empty($p['image_url'])): ?>
                                    <img src="<?= htmlspecialchars($p['image_url']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" class="object-cover object-top w-full h-full">
                                <?php else: ?>
                                    <div class="bg-gray-900 w-full h-full flex items-center justify-center">
                                        <i class="fas fa-user text-gray-600 text-2xl"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- Info -->
                            <div class="flex-1 flex flex-col justify-center gap-1 ml-5">
                                <p class="text-xl font-black text-white tracking-wide"><?= htmlspecialchars($p['name']) ?></p>
                                <span class="px-2 py-0.5 rounded bg-[#FF5722]/10 border border-[#FF5722]/30 text-[#FF5722] text-[10px] font-black tracking-widest inline-block w-fit"><?= htmlspecialchars($p['position']) ?></span>
                                <p class="text-xs text-gray-500 tracking-widest mt-1"><?= htmlspecialchars($p['nationality']) ?></p>
                            </div>
                            <!-- Value -->
                            <div class="ml-auto text-right flex-shrink-0 flex flex-col justify-center">
                                <p class="text-2xl font-black text-[#FF5722]"><?= fmt((float) $p['market_value']) ?></p>
                                <p class="text-[10px] text-gray-600 tracking-widest mt-1">MARKET VALUE</p>
                                <p class="text-xs text-gray-500 mt-2">EST. ANNUAL COST <?= fmt((float) $p['market_value'] * 0.2) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Live Transfers (logged-in only) -->
        <?php if (isset($_SESSION['user_role'])): ?>
        <div class="glass-dark rounded-2xl p-10">
            <div class="flex items-center justify-between mb-10">
                <h2 class="text-4xl font-black teal-glow tech-header">LIVE TRANSFERS</h2>
                <div class="w-4 h-4 rounded-full bg-[#14b8a6] pulse-live shadow-[0_0_30px_rgba(20,184,166,0.8)]"></div>
            </div>
            <div class="space-y-5">
                <?php if (empty($recentTransfers)): ?>
                    <p class="text-gray-500 text-center py-16 tracking-widest font-bold">NO RECENT TRANSFERS</p>
                <?php else: ?>
                    <?php foreach ($recentTransfers as $t): ?>
                        <?php
                            $statusLower = strtolower($t['transfer_status']);
                            $statusColor = match($statusLower) {
                                'in progress' => 'text-yellow-400',
                                'done' => 'text-green-400',
                                default => 'text-gray-400',
                            };
                        ?>
                        <div class="glass-dark rounded-xl p-6 flex items-center justify-between">
                            <div>
                                <p class="font-black text-white text-lg tracking-wide"><?= htmlspecialchars($t['player']) ?></p>
                                <p class="text-sm text-gray-400 tracking-widest font-bold mt-1"><?= htmlspecialchars($t['departure_team']) ?> &rarr; <?= htmlspecialchars($t['arrival_team']) ?></p>
                            </div>
                            <div class="text-right">
                                <p class="font-black text-[#14b8a6] text-xl"><?= fmt((float) $t['amount']) ?></p>
                                <p class="text-xs tracking-widest font-bold mt-1 <?= $statusColor ?>"><?= strtoupper(htmlspecialchars($t['transfer_status'])) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </section>



</div>

<?php include './includes/footer.php'; ?>
