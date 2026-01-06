<?php
session_start();
include '../models/Player.php';

$player = new Player();
$players = $player->getAll();

include '../includes/header.php';
?>

<div class="max-w-7xl mx-auto p-10 space-y-8">

    <section id="players" class="glass-dark rounded-xl p-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-4xl font-bold orange-glow tech-header">PLAYER REGISTRY</h2>
            <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                <a href="add_player.php" class="btn-outline">
                    <i class="fas fa-plus mr-2"></i>
                    ADD PLAYER
                </a>
            <?php endif; ?>
        </div>

        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr class="tech-header">
                        <th>ID</th>
                        <th>NAME</th>
                        <th>NATIONALITY</th>
                        <th>POSITION</th>
                        <th>MARKET VALUE</th>
                        <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                            <th>ACTIONS</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($players as $p): ?>
                        <tr>
                            <td class="font-bold text-gray-500">#<?=$p['id']?></td>
                            <td class="font-bold text-white text-lg"><?= $p['name'] ?></td>
                            <td class="text-gray-400 tracking-wide"><?= $p['nationality'] ?></td>
                            <td><span class="badge badge-orange"><?= strtoupper($p['position']) ?></span></td>
                            <td class="font-bold text-[#14b8a6] text-lg">€<?= number_format($p['market_value'], 0) ?></td>    
                            <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                                <td class="flex gap-4">
                                    <a href="edit_player.php?id=<?= $p['id'] ?>" class="text-blue-400 hover:text-blue-300 transition">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="delete_player.php?id=<?= $p['id'] ?>" 
                                       onclick="return confirm('Are you sure?');"
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