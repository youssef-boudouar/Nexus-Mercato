<?php
session_start();

include '../models/Contract.php';

$contractModel = new Contract();
$contracts = $contractModel->getAll();

// Stats
$totalContracts = count($contracts);
$totalPlayers   = count(array_filter($contracts, fn($c) => !empty($c['player'])));
$totalCoaches   = count(array_filter($contracts, fn($c) => !empty($c['coach'])));
$totalAnnual    = array_sum(array_column($contracts, 'salary')) * 12;

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
        <div class="flex items-start justify-between mb-8">
            <div>
                <h2 class="text-5xl font-black orange-glow tech-header">CONTRACT REGISTRY</h2>
                <p class="text-gray-600 text-sm tracking-widest mt-2">
                    TOTAL ANNUAL COST &mdash; <span class="text-[#14b8a6] font-black"><?= fmt($totalAnnual) ?>/yr</span>
                </p>
            </div>
        </div>

        <!-- Stat Pills -->
        <div class="flex flex-wrap gap-4 mb-10">
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

        <!-- Contract Cards Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <?php foreach ($contracts as $c):
                $isPlayer   = !empty($c['player']);
                $personName = $isPlayer ? $c['player'] : $c['coach'];
                $photoUrl   = $c['person_image'] ?? null;
                $teamLogo   = $c['team_logo'] ?? null;

                // Progress bar
                $start = strtotime($c['start_date']);
                $end   = strtotime($c['end_date']);
                $now   = time();
                $pct   = ($end > $start) ? min(100, max(0, (int) round(($now - $start) / ($end - $start) * 100))) : 0;
                $barColor = $pct > 75 ? '#FF5722' : '#14b8a6';

                // Team initials fallback
                $words    = preg_split('/\s+/', trim($c['team']));
                $initials = count($words) === 1
                    ? strtoupper(substr($c['team'], 0, 2))
                    : strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
            ?>
            <div class="glass-dark rounded-2xl p-6 relative flex flex-col gap-5">

                <!-- Admin Actions -->
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

                <!-- Top Row: Photo + Name + Badge -->
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full overflow-hidden flex-shrink-0 border-2 <?= $isPlayer ? 'border-blue-500/50' : 'border-[#FF5722]/50' ?>">
                        <?php if (!empty($photoUrl)): ?>
                            <img src="<?= htmlspecialchars($photoUrl) ?>"
                                 alt="<?= htmlspecialchars($personName) ?>"
                                 class="w-full h-full object-cover object-top">
                        <?php else: ?>
                            <div class="w-full h-full <?= $isPlayer ? 'bg-blue-900/30' : 'bg-[#FF5722]/10' ?> flex items-center justify-center">
                                <i class="fas <?= $isPlayer ? 'fa-user' : 'fa-clipboard-list' ?> text-gray-500"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="flex-1 min-w-0 <?= isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin' ? 'pr-16' : '' ?>">
                        <p class="text-xl font-black text-white tracking-wide leading-tight truncate">
                            <?= htmlspecialchars($personName) ?>
                        </p>
                        <div class="mt-1">
                            <?php if ($isPlayer): ?>
                                <span class="px-3 py-0.5 rounded-lg bg-blue-500/20 border border-blue-400/30 text-blue-300 text-[10px] font-black tracking-widest">
                                    <i class="fas fa-running mr-1"></i>PLAYER
                                </span>
                            <?php else: ?>
                                <span class="px-3 py-0.5 rounded-lg bg-orange-500/20 border border-orange-400/30 text-orange-300 text-[10px] font-black tracking-widest">
                                    <i class="fas fa-clipboard-list mr-1"></i>COACH
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Middle Row: Team + Salary -->
                <div class="flex items-center gap-4 border-t border-white/5 pt-5">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        <?php if (!empty($teamLogo)): ?>
                            <img src="<?= htmlspecialchars($teamLogo) ?>" alt=""
                                 class="w-9 h-9 rounded-full object-cover flex-shrink-0">
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
                        <p class="text-xl font-black text-[#14b8a6]">
                            <?= fmt((float) $c['salary']) ?><span class="text-xs text-gray-600 font-normal">/mo</span>
                        </p>
                        <p class="text-[10px] text-gray-600 tracking-widest">MONTHLY SALARY</p>
                    </div>
                </div>

                <!-- Bottom Row: Duration Bar -->
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

    </section>

</div>

<?php include '../includes/footer.php'; ?>
