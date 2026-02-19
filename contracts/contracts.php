<?php
session_start();

include '../models/Contract.php';

$contractModel = new Contract();
$allContracts  = $contractModel->getAll();

// Split into players and coaches
$playerContracts = array_values(array_filter($allContracts, fn($c) => !empty($c['player'])));
$coachContracts  = array_values(array_filter($allContracts, fn($c) => !empty($c['coach'])));

// Sort players by salary DESC
usort($playerContracts, fn($a, $b) => (float)$b['salary'] <=> (float)$a['salary']);

// Sort coaches by team name ASC
usort($coachContracts, fn($a, $b) => strcmp($a['team'], $b['team']));

// Stats
$totalContracts = count($allContracts);
$totalPlayers   = count($playerContracts);
$totalCoaches   = count($coachContracts);
$playerAnnual   = array_sum(array_column($playerContracts, 'salary')) * 12;

// Filter
$filter = $_GET['filter'] ?? 'all';

function fmt(float $n): string {
    if ($n >= 1_000_000) return '€' . number_format($n / 1_000_000, 2) . 'M';
    if ($n >= 1_000)     return '€' . number_format($n / 1_000, 1) . 'K';
    return '€' . number_format($n, 0);
}

include '../includes/header.php';
?>

<div class="max-w-7xl mx-auto p-10 space-y-8">

    <section id="contracts">

        <!-- Section Header -->
        <div class="flex items-start justify-between mb-10">
            <div>
                <h2 class="text-5xl font-black orange-glow tech-header leading-none">CONTRACT<br><span class="text-white">REGISTRY</span></h2>
                <p class="text-gray-600 text-sm tracking-widest mt-3">
                    PLAYER ANNUAL COST &mdash; <span class="text-[#14b8a6] font-black"><?= fmt($playerAnnual) ?>/yr</span>
                </p>
            </div>

            <!-- Stat Pills -->
            <div class="flex flex-wrap gap-4">
                <div class="glass-dark rounded-xl px-6 py-4 flex items-center gap-4">
                    <i class="fas fa-file-contract text-[#FF5722] text-lg"></i>
                    <div>
                        <p class="text-2xl font-black text-white"><?= $totalContracts ?></p>
                        <p class="text-[10px] text-gray-600 tracking-widest">TOTAL CONTRACTS</p>
                    </div>
                </div>
                <div class="glass-dark rounded-xl px-6 py-4 flex items-center gap-4">
                    <i class="fas fa-running text-blue-400 text-lg"></i>
                    <div>
                        <p class="text-2xl font-black text-white"><?= $totalPlayers ?></p>
                        <p class="text-[10px] text-gray-600 tracking-widest">PLAYERS</p>
                    </div>
                </div>
                <div class="glass-dark rounded-xl px-6 py-4 flex items-center gap-4">
                    <i class="fas fa-clipboard-list text-[#FF5722] text-lg"></i>
                    <div>
                        <p class="text-2xl font-black text-white"><?= $totalCoaches ?></p>
                        <p class="text-[10px] text-gray-600 tracking-widest">COACHES</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="flex gap-2 mb-8">
            <a href="?filter=all"     class="px-4 py-2 rounded-lg text-xs font-black tracking-widest tech-header <?= (!isset($_GET['filter']) || $_GET['filter']==='all') ? 'bg-[#FF5722] text-white' : 'glass-dark text-gray-400' ?>">ALL</a>
            <a href="?filter=players" class="px-4 py-2 rounded-lg text-xs font-black tracking-widest tech-header <?= (isset($_GET['filter']) && $_GET['filter']==='players') ? 'bg-[#FF5722] text-white' : 'glass-dark text-gray-400' ?>">PLAYERS</a>
            <a href="?filter=coaches" class="px-4 py-2 rounded-lg text-xs font-black tracking-widest tech-header <?= (isset($_GET['filter']) && $_GET['filter']==='coaches') ? 'bg-[#14b8a6] text-white' : 'glass-dark text-gray-400' ?>">COACHING STAFF</a>
        </div>

        <?php if ($filter === 'all' || $filter === 'players'): ?>

        <!-- ── PLAYER CONTRACTS ── -->
        <h3 class="tech-header orange-glow text-3xl font-black mb-6">PLAYER CONTRACTS</h3>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-4">
            <?php foreach ($playerContracts as $c):
                $photoUrl = $c['person_image'] ?? null;
                $teamLogo = $c['team_logo'] ?? null;

                $start    = strtotime($c['start_date']);
                $end      = strtotime($c['end_date']);
                $now      = time();
                $pct      = ($end > $start) ? min(100, max(0, (int) round(($now - $start) / ($end - $start) * 100))) : 0;
                $barColor = $pct > 75 ? '#FF5722' : '#14b8a6';

                $words    = preg_split('/\s+/', trim($c['team']));
                $initials = count($words) === 1
                    ? strtoupper(substr($c['team'], 0, 2))
                    : strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
            ?>
            <div class="glass-dark rounded-2xl p-6 relative flex flex-col gap-5">

                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                <div class="absolute top-4 right-4 flex gap-3">
                    <a href="edit_contract.php?id=<?= $c['id'] ?>"
                       class="text-blue-400 hover:text-blue-300 transition text-sm" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="delete_contract.php?id=<?= $c['id'] ?>"
                       onclick="return confirm('Delete this contract?');"
                       class="text-red-500 hover:text-red-400 transition text-sm" title="Delete">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
                <?php endif; ?>

                <!-- Photo + Name + Badge -->
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full overflow-hidden flex-shrink-0 border-2 border-blue-500/50">
                        <?php if (!empty($photoUrl)): ?>
                            <img src="<?= htmlspecialchars($photoUrl) ?>"
                                 alt="<?= htmlspecialchars($c['player']) ?>"
                                 class="w-full h-full object-cover object-top"
                                 onerror="this.style.display='none';this.parentElement.querySelector('.initials-fallback').style.display='flex'">
                            <div class="initials-fallback w-full h-full bg-blue-900/30 items-center justify-center" style="display:none">
                                <i class="fas fa-user text-gray-500"></i>
                            </div>
                        <?php else: ?>
                            <div class="w-full h-full bg-blue-900/30 flex items-center justify-center">
                                <i class="fas fa-user text-gray-500"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="flex-1 min-w-0 <?= isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin' ? 'pr-16' : '' ?>">
                        <p class="text-xl font-black text-white tracking-wide leading-tight truncate">
                            <?= htmlspecialchars($c['player']) ?>
                        </p>
                        <div class="mt-1">
                            <span class="px-3 py-0.5 rounded-lg bg-blue-500/20 border border-blue-400/30 text-blue-300 text-[10px] font-black tracking-widest">
                                <i class="fas fa-running mr-1"></i>PLAYER
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Team + Salary -->
                <div class="flex items-center gap-4 border-t border-white/5 pt-5">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        <?php if (!empty($teamLogo)): ?>
                            <img src="<?= htmlspecialchars($teamLogo) ?>" alt=""
                                 class="w-9 h-9 rounded-full object-cover flex-shrink-0"
                                 onerror="this.style.display='none';this.parentElement.querySelector('.initials-fallback').style.display='flex'">
                            <div class="initials-fallback w-9 h-9 rounded-full bg-gray-800 border border-gray-700 items-center justify-center text-gray-400 text-[10px] font-black flex-shrink-0" style="display:none">
                                <?= htmlspecialchars($initials) ?>
                            </div>
                        <?php else: ?>
                            <div class="w-9 h-9 rounded-full bg-gray-800 border border-gray-700 flex items-center justify-center text-gray-400 text-[10px] font-black flex-shrink-0">
                                <?= htmlspecialchars($initials) ?>
                            </div>
                        <?php endif; ?>
                        <p class="text-sm text-gray-400 tracking-wide font-bold truncate">
                            <?= htmlspecialchars($c['team']) ?>
                        </p>
                    </div>
                    <div class="w-px h-8 bg-white/10 flex-shrink-0"></div>
                    <div class="text-right flex-shrink-0">
                        <p class="text-2xl font-black text-[#14b8a6]">
                            <?= fmt((float) $c['salary']) ?><span class="text-xs text-gray-600 font-normal">/mo</span>
                        </p>
                        <p class="text-[10px] text-gray-600 tracking-widest">MONTHLY SALARY</p>
                    </div>
                </div>

                <!-- Duration Bar -->
                <div class="border-t border-white/5 pt-4">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-[10px] text-gray-600 tracking-widest"><?= htmlspecialchars($c['start_date']) ?></p>
                        <p class="text-[10px] text-gray-600 tracking-widest"><?= htmlspecialchars($c['end_date']) ?></p>
                    </div>
                    <div class="h-1.5 rounded-full bg-gray-800 overflow-hidden">
                        <div class="h-full rounded-full"
                             style="width: <?= $pct ?>%; background-color: <?= $barColor ?>;"></div>
                    </div>
                    <p class="text-[10px] text-gray-600 tracking-widest mt-1.5 text-right"><?= $pct ?>% elapsed</p>
                </div>

            </div>
            <?php endforeach; ?>
        </div>

        <?php endif; ?>

        <?php if ($filter === 'all' || $filter === 'coaches'): ?>

        <!-- ── COACHING STAFF ── -->
        <h3 class="tech-header teal-glow text-3xl font-black mb-6 mt-12">COACHING STAFF</h3>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <?php foreach ($coachContracts as $c):
                $photoUrl = $c['person_image'] ?? null;
                $teamLogo = $c['team_logo'] ?? null;

                $start    = strtotime($c['start_date']);
                $end      = strtotime($c['end_date']);
                $now      = time();
                $pct      = ($end > $start) ? min(100, max(0, (int) round(($now - $start) / ($end - $start) * 100))) : 0;
                $barColor = $pct > 75 ? '#FF5722' : '#14b8a6';

                $words    = preg_split('/\s+/', trim($c['team']));
                $initials = count($words) === 1
                    ? strtoupper(substr($c['team'], 0, 2))
                    : strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
            ?>
            <div class="glass-dark rounded-2xl p-6 relative flex flex-col gap-5">

                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                <div class="absolute top-4 right-4 flex gap-3">
                    <a href="edit_contract.php?id=<?= $c['id'] ?>"
                       class="text-blue-400 hover:text-blue-300 transition text-sm" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="delete_contract.php?id=<?= $c['id'] ?>"
                       onclick="return confirm('Delete this contract?');"
                       class="text-red-500 hover:text-red-400 transition text-sm" title="Delete">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
                <?php endif; ?>

                <!-- Photo + Name + Badge -->
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full overflow-hidden flex-shrink-0 border-2 border-[#FF5722]/50">
                        <?php if (!empty($photoUrl)): ?>
                            <img src="<?= htmlspecialchars($photoUrl) ?>"
                                 alt="<?= htmlspecialchars($c['coach']) ?>"
                                 class="w-full h-full object-cover object-top"
                                 onerror="this.style.display='none';this.parentElement.querySelector('.initials-fallback').style.display='flex'">
                            <div class="initials-fallback w-full h-full bg-[#FF5722]/10 items-center justify-center" style="display:none">
                                <i class="fas fa-clipboard-list text-gray-500"></i>
                            </div>
                        <?php else: ?>
                            <div class="w-full h-full bg-[#FF5722]/10 flex items-center justify-center">
                                <i class="fas fa-clipboard-list text-gray-500"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="flex-1 min-w-0 <?= isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin' ? 'pr-16' : '' ?>">
                        <p class="text-xl font-black text-white tracking-wide leading-tight truncate">
                            <?= htmlspecialchars($c['coach']) ?>
                        </p>
                        <div class="mt-1">
                            <span class="px-3 py-0.5 rounded-lg bg-orange-500/20 border border-orange-400/30 text-orange-300 text-[10px] font-black tracking-widest">
                                <i class="fas fa-clipboard-list mr-1"></i>COACH
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Team + Salary -->
                <div class="flex items-center gap-4 border-t border-white/5 pt-5">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        <?php if (!empty($teamLogo)): ?>
                            <img src="<?= htmlspecialchars($teamLogo) ?>" alt=""
                                 class="w-9 h-9 rounded-full object-cover flex-shrink-0"
                                 onerror="this.style.display='none';this.parentElement.querySelector('.initials-fallback').style.display='flex'">
                            <div class="initials-fallback w-9 h-9 rounded-full bg-gray-800 border border-gray-700 items-center justify-center text-gray-400 text-[10px] font-black flex-shrink-0" style="display:none">
                                <?= htmlspecialchars($initials) ?>
                            </div>
                        <?php else: ?>
                            <div class="w-9 h-9 rounded-full bg-gray-800 border border-gray-700 flex items-center justify-center text-gray-400 text-[10px] font-black flex-shrink-0">
                                <?= htmlspecialchars($initials) ?>
                            </div>
                        <?php endif; ?>
                        <p class="text-sm text-gray-400 tracking-wide font-bold truncate">
                            <?= htmlspecialchars($c['team']) ?>
                        </p>
                    </div>
                    <div class="w-px h-8 bg-white/10 flex-shrink-0"></div>
                    <div class="text-right flex-shrink-0">
                        <span class="text-gray-500 text-sm font-bold tracking-widest">N/A</span>
                        <p class="text-[10px] text-gray-600 tracking-widest mt-1">SALARY DATA UNAVAILABLE</p>
                    </div>
                </div>

                <!-- Duration Bar -->
                <div class="border-t border-white/5 pt-4">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-[10px] text-gray-600 tracking-widest"><?= htmlspecialchars($c['start_date']) ?></p>
                        <p class="text-[10px] text-gray-600 tracking-widest"><?= htmlspecialchars($c['end_date']) ?></p>
                    </div>
                    <div class="h-1.5 rounded-full bg-gray-800 overflow-hidden">
                        <div class="h-full rounded-full"
                             style="width: <?= $pct ?>%; background-color: <?= $barColor ?>;"></div>
                    </div>
                    <p class="text-[10px] text-gray-600 tracking-widest mt-1.5 text-right"><?= $pct ?>% elapsed</p>
                </div>

            </div>
            <?php endforeach; ?>
        </div>

        <?php endif; ?>

    </section>

</div>

<?php include '../includes/footer.php'; ?>
