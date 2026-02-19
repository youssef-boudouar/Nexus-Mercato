<?php
session_start();

include '../models/Transfer.php';
include '../models/Contract.php';

$transferModel = new Transfer();
$transfers = $transferModel->getAll();

// Build current-club lookup from contracts (player name → active team)
$allContracts = (new Contract())->getAll();
$currentClubMap = [];
foreach ($allContracts as $c) {
    if (!empty($c['player'])) {
        $currentClubMap[$c['player']] = [
            'team'      => $c['team'],
            'team_logo' => $c['team_logo'] ?? null,
        ];
    }
}

// Group transfers by player name (preserving DB order = chronological)
$grouped = [];
foreach ($transfers as $t) {
    $grouped[$t['player']][] = $t;
}

// Sort players by market value descending
$pdo = Database::getInstance()->getConnection();
$playerValues = [];
foreach ($grouped as $playerName => $transfers) {
    $stmt = $pdo->prepare("SELECT market_value FROM players WHERE name = ? LIMIT 1");
    $stmt->execute([$playerName]);
    $playerValues[$playerName] = (float)($stmt->fetchColumn() ?? 0);
}
uksort($grouped, fn($a, $b) => $playerValues[$b] <=> $playerValues[$a]);

// Stats (full dataset)
$totalPlayers = count($grouped);
$totalDone    = count(array_filter($transfers, fn($t) => strtolower($t['transfer_status']) === 'done'));
$totalInProg  = count(array_filter($transfers, fn($t) => strtolower($t['transfer_status']) === 'in progress'));
$totalVolume  = array_sum(array_column($transfers, 'amount'));

function fmt(float $n): string {
    if ($n >= 1_000_000) return '€' . number_format($n / 1_000_000, 2) . 'M';
    if ($n >= 1_000)     return '€' . number_format($n / 1_000, 1) . 'K';
    return '€' . number_format($n, 0);
}

function teamInitials(string $name): string {
    $words = preg_split('/\s+/', trim($name));
    if (count($words) === 1) return strtoupper(substr($name, 0, 2));
    return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
}

$isGuest = !isset($_SESSION['user_role']);
$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

include '../includes/header.php';
?>

<div class="max-w-7xl mx-auto px-10 pt-10 pb-16">

    <!-- ══════════════════════════════════════════════════════════ PAGE HEADER -->
    <div class="flex items-start justify-between mb-10">

        <!-- Left: Title block -->
        <div>
            <p class="tech-header font-black text-5xl text-white leading-none">TRANSFER</p>
            <p class="tech-header font-black text-7xl orange-glow leading-none">MARKET</p>
            <p class="text-xs text-gray-500 tracking-[0.3em] mt-4">
                COMPLETE CAREER HISTORIES &mdash; <?= count($grouped) ?> PLAYERS TRACKED
            </p>
        </div>

        <!-- Right: Stats + admin button -->
        <div class="flex items-start gap-0 mt-2">

            <!-- Stat blocks -->
            <div class="flex items-stretch">
                <div class="px-8 text-right border-r border-white/5">
                    <p class="text-3xl font-black text-white"><?= count($transfers) ?></p>
                    <p class="text-[10px] text-gray-500 tracking-widest mt-1">TRANSFERS</p>
                </div>
                <div class="px-8 text-right border-r border-white/5">
                    <p class="text-3xl font-black text-green-400"><?= $totalDone ?></p>
                    <p class="text-[10px] text-gray-500 tracking-widest mt-1">COMPLETED</p>
                </div>
                <div class="px-8 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <p class="text-3xl font-black text-amber-400"><?= $totalInProg ?></p>
                        <div class="w-1.5 h-1.5 rounded-full bg-amber-400 pulse-live flex-shrink-0"></div>
                    </div>
                    <p class="text-[10px] text-gray-500 tracking-widest mt-1">IN PROGRESS</p>
                </div>
            </div>

            <?php if ($isAdmin): ?>
                <a href="add_transfer.php" class="btn-orange ml-8 self-start">
                    <i class="fas fa-plus mr-2"></i>NEW TRANSFER
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Full-width divider -->
    <div class="border-b border-white/5 mb-10"></div>

    <!-- ══════════════════════════════════════════ PLAYER JOURNEY CARDS -->
    <?php foreach ($grouped as $playerName => $playerTransfers):
        $lastTransfer = $playerTransfers[count($playerTransfers) - 1];
        $lastStatus   = strtolower($lastTransfer['transfer_status']);
        $isPending    = ($lastStatus === 'in progress');

        // Current club from contracts (authoritative active team)
        $currentClub = $currentClubMap[$playerName]['team']      ?? '—';
        $currentLogo = $currentClubMap[$playerName]['team_logo'] ?? null;

        $firstTransfer = $playerTransfers[0];
        $playerImage   = $firstTransfer['player_image'] ?? null;
        $position      = $firstTransfer['position']     ?? null;
        $nationality   = $firstTransfer['nationality']  ?? null;

        // Drop administrative duplicates (same club as both source and destination)
        $playerTransfers = array_values(array_filter($playerTransfers, fn($t) => $t['departure_team'] !== $t['arrival_team']));

        // Reverse for display: newest-first in timeline, NOW node appended at the end
        $playerTransfers = array_reverse($playerTransfers);

        // First node in display order (departure origin)
        $originTransfer = $playerTransfers[0];

        // NOW node — append only if current club differs from last visible arrival
        $mapEntry        = $currentClubMap[$playerName] ?? null;
        $lastArrival     = $playerTransfers[count($playerTransfers) - 1]['arrival_team'] ?? '';
        $showCurrentNode = $mapEntry && $mapEntry['team'] !== $lastArrival;

        // In-progress transfers for admin manage row
        $inProgressTransfers = array_filter($playerTransfers, fn($t) => strtolower($t['transfer_status']) === 'in progress');
    ?>
    <div class="glass-dark rounded-2xl overflow-hidden mb-8 border-t-2 border-[#FF5722]/20">

        <!-- ── ROW 1: PLAYER IDENTITY BAR ── -->
        <div class="px-8 pt-8 pb-6 flex items-center gap-6">

            <!-- LEFT GROUP -->
            <div class="flex items-center gap-8">

                <!-- Player Photo -->
                <div class="w-20 h-24 rounded-xl overflow-hidden flex-shrink-0 border-2 border-white/10">
                    <?php if (!empty($playerImage)): ?>
                        <img src="<?= htmlspecialchars($playerImage) ?>"
                             alt="<?= htmlspecialchars($playerName) ?>"
                             class="w-full h-full object-cover object-top"
                             onerror="this.src='';this.style.display='none'">
                    <?php else: ?>
                        <div class="w-full h-full bg-gray-900 flex items-center justify-center">
                            <i class="fas fa-user text-gray-600 text-2xl"></i>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Vertical separator -->
                <div class="border-r border-white/5 h-16 self-center flex-shrink-0"></div>

                <!-- Player Info -->
                <div>
                    <p class="text-3xl font-black text-white tracking-wide"><?= htmlspecialchars($playerName) ?></p>
                    <div class="flex items-center mt-2 flex-wrap">
                        <?php if (!empty($position)): ?>
                            <span class="px-2 py-0.5 rounded bg-[#FF5722]/15 border border-[#FF5722]/30 text-[#FF5722] text-[10px] font-black tracking-widest">
                                <?= htmlspecialchars($position) ?>
                            </span>
                        <?php endif; ?>
                        <?php if (!empty($nationality)): ?>
                            <span class="text-sm text-gray-500 ml-3"><?= htmlspecialchars($nationality) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- RIGHT GROUP: Current Club -->
            <div class="ml-auto text-right flex-shrink-0">
                <p class="text-[10px] text-gray-500 tracking-[0.2em] mb-2">CURRENT CLUB</p>
                <div class="flex items-center gap-3 justify-end">
                    <p class="text-xl font-black text-white"><?= htmlspecialchars($currentClub) ?></p>
                    <?php if (!empty($currentLogo)): ?>
                        <img src="<?= htmlspecialchars($currentLogo) ?>" alt=""
                             class="w-12 h-12 object-contain"
                             onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                        <div class="w-12 h-12 rounded-full bg-gray-800 border border-white/10 flex items-center justify-center text-gray-400 text-xs font-black" style="display:none">
                            <?= htmlspecialchars($currentClub !== '—' ? teamInitials($currentClub) : '?') ?>
                        </div>
                    <?php else: ?>
                        <div class="w-12 h-12 rounded-full bg-gray-800 border border-white/10 flex items-center justify-center text-gray-400 text-xs font-black">
                            <?= htmlspecialchars($currentClub !== '—' ? teamInitials($currentClub) : '?') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($isPending && !$isGuest): ?>
                    <span class="inline-block mt-2 text-[9px] px-2 py-1 rounded bg-amber-500/10 border border-amber-500/30 text-amber-400 font-black tracking-widest">
                        TRANSFER PENDING
                    </span>
                <?php endif; ?>
            </div>

        </div>

        <!-- Divider -->
        <div class="border-t border-white/5"></div>

        <!-- ── ROW 2: TIMELINE ── -->
        <div class="px-8 py-8">
            <div class="flex flex-wrap justify-center items-start gap-y-4 gap-x-0">

                <!-- ORIGIN NODE -->
                <div class="flex flex-col items-center w-28 shrink-0">
                    <div class="w-full bg-white/5 backdrop-blur border border-white/8 rounded-2xl p-3 flex flex-col items-center gap-2">
                        <?php if (!empty($originTransfer['departure_logo'])): ?>
                            <img src="<?= htmlspecialchars($originTransfer['departure_logo']) ?>" alt=""
                                 class="w-10 h-10 object-contain"
                                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                            <div class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 text-[10px] font-black" style="display:none">
                                <?= htmlspecialchars(teamInitials($originTransfer['departure_team'])) ?>
                            </div>
                        <?php else: ?>
                            <div class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 text-[10px] font-black">
                                <?= htmlspecialchars(teamInitials($originTransfer['departure_team'])) ?>
                            </div>
                        <?php endif; ?>
                        <p class="text-[10px] text-gray-300 font-bold text-center leading-tight">
                            <?= htmlspecialchars($originTransfer['departure_team']) ?>
                        </p>
                    </div>
                    <p class="text-[8px] text-gray-600 tracking-widest mt-2 uppercase">ORIGIN</p>
                </div>

                <?php foreach ($playerTransfers as $t):
                    $tStatus = strtolower($t['transfer_status']);
                    $tIsDone = ($tStatus === 'done');
                    $tIsProg = ($tStatus === 'in progress');
                    if ($isGuest && $tIsProg) continue;
                ?>

                <!-- CONNECTOR + ARRIVAL (kept together on wrap) -->
                <div class="inline-flex items-start shrink-0">

                    <div class="flex flex-col items-center justify-start pt-3 w-16 shrink-0">
                        <p class="text-[10px] font-black text-center">
                            <?php if ((float)$t['amount'] > 0): ?>
                                <span class="text-[#FF5722]"><?= fmt((float)$t['amount']) ?></span>
                            <?php else: ?>
                                <span class="text-gray-500">FREE</span>
                            <?php endif; ?>
                        </p>
                        <div class="border-t border-dashed border-gray-600/40 w-full mt-2 mb-2"></div>
                        <i class="fas fa-long-arrow-alt-right text-[#14b8a6] text-sm"></i>
                        <div class="w-1.5 h-1.5 rounded-full mt-1 shrink-0 <?= $tIsDone ? 'bg-green-400 shadow-[0_0_6px_#4ade80]' : 'bg-amber-400 shadow-[0_0_6px_#fbbf24]' ?>"></div>
                    </div>

                    <div class="flex flex-col items-center w-28 shrink-0">
                        <div class="w-full bg-white/5 backdrop-blur border border-white/8 rounded-2xl p-3 flex flex-col items-center gap-2">
                            <?php if (!empty($t['arrival_logo'])): ?>
                                <img src="<?= htmlspecialchars($t['arrival_logo']) ?>" alt=""
                                     class="w-10 h-10 object-contain"
                                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                <div class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 text-[10px] font-black" style="display:none">
                                    <?= htmlspecialchars(teamInitials($t['arrival_team'])) ?>
                                </div>
                            <?php else: ?>
                                <div class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 text-[10px] font-black">
                                    <?= htmlspecialchars(teamInitials($t['arrival_team'])) ?>
                                </div>
                            <?php endif; ?>
                            <p class="text-[10px] text-gray-300 font-bold text-center leading-tight">
                                <?= htmlspecialchars($t['arrival_team']) ?>
                            </p>
                        </div>
                    </div>

                </div>

                <?php endforeach; ?>

                <?php if ($showCurrentNode): ?>

                <!-- NOW CONNECTOR + NODE (same card, same connector style) -->
                <div class="inline-flex items-start shrink-0">

                    <div class="flex flex-col items-center justify-start pt-3 w-16 shrink-0">
                        <p class="text-[10px] font-black text-center">
                            <span class="text-gray-500">FREE</span>
                        </p>
                        <div class="border-t border-dashed border-gray-600/40 w-full mt-2 mb-2"></div>
                        <i class="fas fa-long-arrow-alt-right text-[#14b8a6] text-sm"></i>
                    </div>

                    <div class="flex flex-col items-center w-28 shrink-0">
                        <div class="w-full bg-white/5 backdrop-blur border border-white/8 rounded-2xl p-3 flex flex-col items-center gap-2">
                            <?php if (!empty($mapEntry['team_logo'])): ?>
                                <img src="<?= htmlspecialchars($mapEntry['team_logo']) ?>" alt=""
                                     class="w-10 h-10 object-contain"
                                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                <div class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 text-[10px] font-black" style="display:none">
                                    <?= htmlspecialchars(teamInitials($mapEntry['team'])) ?>
                                </div>
                            <?php else: ?>
                                <div class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 text-[10px] font-black">
                                    <?= htmlspecialchars(teamInitials($mapEntry['team'])) ?>
                                </div>
                            <?php endif; ?>
                            <p class="text-[10px] text-gray-300 font-bold text-center leading-tight">
                                <?= htmlspecialchars($mapEntry['team']) ?>
                            </p>
                        </div>
                    </div>

                </div>

                <?php endif; ?>

            </div>
        </div>

        <?php if ($isAdmin && !empty($inProgressTransfers)): ?>
        <!-- ADMIN MANAGE ROW -->
        <div class="border-t border-white/5 px-8 pt-3 pb-4 flex items-center gap-4 flex-wrap">
            <span class="text-[10px] text-gray-600 tracking-widest mr-2">MANAGE TRANSFERS:</span>
            <?php foreach ($inProgressTransfers as $t): ?>
                <a href="edit_transfer.php?id=<?= $t['id'] ?>"
                   class="text-gray-500 hover:text-blue-400 transition text-xs" title="Edit">
                    <i class="fas fa-edit"></i> #<?= $t['id'] ?>
                </a>
                <a href="delete_transfer.php?id=<?= $t['id'] ?>"
                   onclick="return confirm('Delete transfer #<?= $t['id'] ?>?');"
                   class="text-gray-500 hover:text-red-400 transition text-xs" title="Delete">
                    <i class="fas fa-trash"></i>
                </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div><!-- end card -->
    <?php endforeach; ?>

</div>

<?php include '../includes/footer.php'; ?>
