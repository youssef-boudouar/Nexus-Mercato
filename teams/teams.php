<?php
session_start();

include '../models/Team.php';

$team = new Team();
$teams = $team->getAll();


include '../includes/header.php';
?>

<div class="max-w-7xl mx-auto p-10 space-y-8">

    <section id="teams" class="glass-dark rounded-xl p-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-4xl font-bold orange-glow tech-header">TEAM DIRECTORY</h2>
            <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
            <a href="add_team.php" class="btn-outline">
                <i class="fas fa-plus mr-2"></i>
                ADD TEAM
            </a>
            <?php endif; ?>
        </div>
        
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr class="tech-header">
                        <th>ID</th>
                        <th>TEAM NAME</th>
                        <th>MANAGER</th>
                        <th>BUDGET</th>
                        <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <th>ACTIONS</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <!-- Sample static row -->
                     <?php foreach($teams as $team): ?>
                    <tr>
                        <td class="font-bold text-gray-500">#<?= $team['id'] ?></td>
                        <td class="font-bold text-white text-lg"><?= $team['name'] ?></td>
                        <td class="text-gray-400 tracking-wide"><?= $team['manager'] ?></td>
                        <td class="font-bold text-[#FF5722] text-lg">€<?= number_format($team['budget']) ?></td>
                        <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <td class="flex gap-4">
                            <!-- EDIT -->
                            <a href="edit_team.php?id= <?= $team['id'] ?>"
                                class="text-blue-400 hover:text-blue-300 transition">
                                <i class="fas fa-edit"></i>
                            </a>

                            <!-- DELETE -->
                            <a href="delete_team.php?id=<?= $team['id'] ?>"
                                onclick="return confirm('Are you sure you want to delete this team?');"
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