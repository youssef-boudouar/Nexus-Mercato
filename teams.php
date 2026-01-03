<?php


// Include header
include './includes/header.php';
?>

<div class="max-w-7xl mx-auto p-10 space-y-8">

    <section id="teams" class="glass-dark rounded-xl p-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-4xl font-bold orange-glow tech-header">TEAM DIRECTORY</h2>
            <a href="add_team.php" class="btn-outline">
                <i class="fas fa-plus mr-2"></i>
                ADD TEAM
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr class="tech-header">
                        <th>ID</th>
                        <th>TEAM NAME</th>
                        <th>MANAGER</th>
                        <th>BUDGET</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Sample static row -->
                    <tr>
                        <td class="font-bold text-gray-500">#001</td>
                        <td class="font-bold text-white text-lg">Team Name</td>
                        <td class="text-gray-400 tracking-wide">Manager Name</td>
                        <td class="font-bold text-[#FF5722] text-lg">€0</td>
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