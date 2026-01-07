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
            <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
            <a href="add_contract.php" class="btn-outline">
                <i class="fas fa-plus mr-2"></i>
                ADD CONTRACT
            </a>
            <?php endif; ?>
        </div>
        
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr class="tech-header">
                        <th>ID</th>
                        <th>PLAYER/COACH</th>
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
                        <td class="font-bold text-gray-500">#<?= $c['id'] ?></td>
                        <td class="font-bold text-white text-lg"><?= $c['player'] ?></td>
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