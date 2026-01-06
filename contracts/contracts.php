<?php


// Include header
include '../includes/header.php';
?>

<div class="max-w-7xl mx-auto p-10 space-y-8">

    <section id="contracts" class="glass-dark rounded-xl p-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-4xl font-bold orange-glow tech-header">CONTRACT REGISTRY</h2>
            <a href="add_contract.php" class="btn-outline">
                <i class="fas fa-plus mr-2"></i>
                ADD CONTRACT
            </a>
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
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Sample static row -->
                    <tr>
                        <td class="font-bold text-gray-500">#001</td>
                        <td class="font-bold text-white text-lg">Person Name</td>
                        <td class="text-gray-400 tracking-wide">Team Name</td>
                        <td class="font-bold text-[#14b8a6] text-lg">€0</td>
                        <td class="text-gray-500">2024-01-01</td>
                        <td class="text-gray-500">2027-01-01</td>
                        <td class="flex gap-4">
                            <!-- EDIT -->
                            <a href="edit_player.php?id=<?= $player['id'] ?>"
                                class="text-blue-400 hover:text-blue-300 transition">
                                <i class="fas fa-edit"></i>
                            </a>

                            <!-- DELETE -->
                            <a href="delete_player.php?id=<?= $player['id'] ?>"
                                onclick="return confirm('Are you sure you want to delete this player?');"
                                class="text-red-500 hover:text-red-400 transition">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

</div>

<?php include '../includes/footer.php'; ?>