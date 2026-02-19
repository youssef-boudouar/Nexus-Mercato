<?php
session_start();

include '../models/Team.php';

$team = new Team();

$result = $team->getTotalTeams();
$total = $result['total'];
$resultPerPage = 10;

$totalPages = ceil($total / $resultPerPage);
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$start = ($page - 1) * $resultPerPage;
$teams = $team->getAllPagination($start, $resultPerPage);



include '../includes/header.php';
?>

<div class="max-w-7xl mx-auto p-10 space-y-8">

    <section id="teams" class="glass-dark rounded-xl p-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-4xl font-bold orange-glow tech-header">TEAM DIRECTORY</h2>
            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                <a href="add_team.php" class="btn-outline">
                    <i class="fas fa-plus mr-2"></i>
                    ADD TEAM
                </a>
            <?php endif; ?>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-white/5 bg-slate-900/50">
                        <th class="py-5 px-6 text-left">Club Identity</th>
                        <th class="py-5 px-6 text-left">Manager</th>
                        <th class="py-5 px-6 text-right">Financial Cap</th>
                        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                            <th class="py-5 px-6 text-right">Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php foreach ($teams as $team): ?>
                        <tr class="group hover:bg-white/[0.02] transition-colors duration-200">
                            <td class="py-5 px-6">
                                <div class="flex items-center gap-6">
                                    <!-- Apple-style Logo Container -->
                                    <div class="h-20 w-20 flex-shrink-0 bg-white/5 rounded-xl p-4 flex items-center justify-center border border-white/10 shadow-lg">
                                        <img src="<?= htmlspecialchars($team['logo_url'] ?? '') ?>" alt="<?= htmlspecialchars($team['name']) ?>" class="max-h-full max-w-full object-contain filter drop-shadow hover:scale-110 transition-transform duration-300">
                                    </div>
                                    
                                    <div>
                                        <div class="text-xl font-bold text-white tracking-tight mb-1"><?= $team['name'] ?></div>
                                        <div class="flex items-center gap-2 text-slate-500 text-sm font-mono">
                                            <i class="fas fa-hashtag text-slate-700 text-[10px]"></i> EST. 2024
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-5 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center border border-white/5 text-slate-400">
                                        <i class="fas fa-user-tie text-xs"></i>
                                    </div>
                                    <span class="text-slate-300 font-medium"><?= $team['manager'] ?></span>
                                </div>
                            </td>
                            <td class="py-5 px-6 text-right">
                                <?php if ($team['budget'] >= 1000000000): ?>
                                    <span class="font-mono font-bold text-purple-400 text-lg">€<?= number_format($team['budget'] / 1000000000, 2) ?>bn</span>
                                    <div class="text-[10px] text-purple-400/50 uppercase tracking-widest font-bold mt-1">Mega Cap</div>
                                <?php elseif ($team['budget'] >= 1000000): ?>
                                    <span class="font-mono font-bold text-blue-400 text-lg">€<?= number_format($team['budget'] / 1000000, 2) ?>M</span>
                                    <div class="text-[10px] text-blue-400/50 uppercase tracking-widest font-bold mt-1">High Cap</div>
                                <?php else: ?>
                                    <span class="font-mono font-bold text-slate-400 text-lg">€<?= number_format($team['budget'] / 1000, 2) ?>K</span>
                                    <div class="text-[10px] text-slate-500 uppercase tracking-widest font-bold mt-1">Low Cap</div>
                                <?php endif; ?>
                            </td>
                            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                                <td class="py-5 px-6 text-right">
                                    <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="edit_team.php?id=<?= $team['id'] ?>" class="p-2 text-slate-400 hover:text-white transition-colors border border-transparent hover:border-white/10 rounded-lg">
                                            <i class="fas fa-pen-to-square"></i>
                                        </a>
                                        <a href="delete_team.php?id=<?= $team['id'] ?>" 
                                            onclick="return confirm('Are you sure you want to delete this team?');"
                                            class="p-2 text-red-500 hover:text-red-400 transition-colors border border-transparent hover:border-red-500/20 rounded-lg">
                                            <i class="fas fa-trash-can"></i>
                                        </a>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-center gap-4 mt-8">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>" class="px-6 py-2 bg-gray-800 hover:bg-gray-700 text-white rounded-lg transition">
                    Previous
                </a>
            <?php endif; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>" class="px-6 py-2 bg-gray-800 hover:bg-gray-700 text-white rounded-lg transition">
                    Next
                </a>
            <?php endif; ?>
        </div>
    </section>

</div>

<?php include '../includes/footer.php'; ?>