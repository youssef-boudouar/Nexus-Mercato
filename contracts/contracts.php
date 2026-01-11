<?php

session_start();

include '../models/Contract.php';

$contract = new Contract();
$contracts = $contract->getAll();


include '../includes/header.php';
?>

<div class="max-w-7xl mx-auto p-10 space-y-8">

    <section id="contracts" class="glass-dark rounded-xl p-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-4xl font-bold orange-glow tech-header">CONTRACT REGISTRY</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr class="tech-header">
                        <th>ROLE</th>
                        <th>NAME</th>
                        <th>TEAM</th>
                        <th>SALARY</th>
                        <th>START DATE</th>
                        <th>END DATE</th>
                        <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <th>ACTIONS</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($contracts as $c): ?>
                    <tr>
                        <td>
                            <?php if($c['player']): ?>
                                <span class="px-3 py-1 rounded-lg bg-blue-500/20 border border-blue-400/30 text-blue-300 text-xs font-bold">
                                    <i class="fas fa-running"></i> PLAYER
                                </span>
                            <?php else: ?>
                                <span class="px-3 py-1 rounded-lg bg-orange-500/20 border border-orange-400/30 text-orange-300 text-xs font-bold">
                                    <i class="fas fa-clipboard-list"></i> COACH
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="font-bold text-white text-lg"><?= $c['player'] ?? $c['coach'] ?></td>
                        <td class="text-gray-400 tracking-wide"><?= $c['team'] ?></td>
                        <td class="font-bold text-[#14b8a6] text-lg">€<?= number_format($c['salary'] / 1000000, 2)?>M</td>
                        <td class="text-gray-500"><?= $c['start_date'] ?></td>
                        <td class="text-gray-500"><?= $c['end_date'] ?></td>
                        <?php if(isset($_SESSION['user_role']) &&  $_SESSION['user_role'] === 'admin'): ?>
                        <td class="flex gap-4">
                            <!-- EDIT -->
                            <a href="edit_contract.php?id=<?= $c['id'] ?>"
                                class="text-blue-400 hover:text-blue-300 transition">
                                <i class="fas fa-edit"></i>
                            </a>

                            <!-- DELETE -->
                            <a href="delete_contract.php?id=<?= $c['id'] ?>"
                                onclick="return confirm('Are you sure you want to delete this player?');"
                                class="text-red-500 hover:text-red-400 transition">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

</div>

<?php include '../includes/footer.php'; ?>