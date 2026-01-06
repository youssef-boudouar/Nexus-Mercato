<?php


// Include header
include '../includes/header.php';
?>

<div class="max-w-7xl mx-auto p-10 space-y-8">

    <section id="transfers" class="glass-dark rounded-xl p-8 mb-12">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-4xl font-bold orange-glow tech-header">TRANSFER MARKET</h2>
            <a href="add_transfer.php" class="btn-orange">
                <i class="fas fa-plus mr-2"></i>
                NEW TRANSFER
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr class="tech-header">
                        <th>ID</th>
                        <th>PLAYER</th>
                        <th>FROM</th>
                        <th>TO</th>
                        <th>STATUS</th>
                        <th>AMOUNT</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
  
                    <tr>
                        <td class="font-bold text-gray-500">#001</td>
                        <td class="font-bold text-white text-lg">Player Name</td>
                        <td class="text-gray-400 tracking-wide">From Team</td>
                        <td class="text-gray-400 tracking-wide">To Team</td>
                        <td>
                            <span class="badge badge-orange">IN PROGRESS</span>
                        </td>
                        <td class="font-bold text-[#FF5722] text-lg">€0</td>
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