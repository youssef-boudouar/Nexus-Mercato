<?php


// Include header
include './includes/header.php';
?>

<div class="max-w-7xl mx-auto p-10 space-y-8">

    <section id="players" class="glass-dark rounded-xl p-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-4xl font-bold orange-glow tech-header">PLAYER REGISTRY</h2>
            <a href="add_player.php" class="btn-outline">
                <i class="fas fa-plus mr-2"></i>
                ADD PLAYER
            </a>
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
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Sample static r -->
                    <tr>
                        <td class="font-bold text-gray-500">#001</td>
                        <td class="font-bold text-white text-lg">Player Name</td>
                        <td class="text-gray-400 tracking-wide">Nationality</td>
                        <td><span class="badge badge-orange">POSITION</span></td>
                        <td class="font-bold text-[#14b8a6] text-lg">€0</td>
                        <td>
                            <button class="text-[#FF5722] hover:text-[#F4511E] transition-colors">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

</div>

<?php include './includes/footer.php'; ?>