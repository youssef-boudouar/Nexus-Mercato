<?php
session_start();
include '../models/Coach.php';

$coach = new Coach();
$coaches = $coach->getAll();

include '../includes/header.php';
?>

<div class="max-w-7xl mx-auto p-10 space-y-8">

    <section id="coaches" class="glass-dark rounded-xl p-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-4xl font-bold orange-glow tech-header">COACH REGISTRY</h2>
            <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                <a href="add_coach.php" class="btn-outline">
                    <i class="fas fa-plus mr-2"></i>
                    ADD COACH
                </a>
            <?php endif; ?>
        </div>

        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr class="tech-header">
                        <th>PHOTO</th>
                        <th>NAME</th>
                        <th>NATIONALITY</th>
                        <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                            <th>ACTIONS</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($coaches as $c): ?>
                        <tr>
                            <td><img src="<?= $c['image_url'] ?>" alt="" class="player-img"></td>
                            <td class="font-bold text-white text-lg"><?= $c['name'] ?></td>
                            <td class="text-gray-400 tracking-wide"><?= $c['nationality'] ?></td>
                            <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                                <td class="flex gap-4">
                                    <a href="edit_coach.php?id=<?= $c['id'] ?>" class="text-blue-400 hover:text-blue-300 transition">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="delete_coach.php?id=<?= $c['id'] ?>" 
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