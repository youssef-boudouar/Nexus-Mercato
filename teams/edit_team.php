<?php

session_start();


include '../config/database.php';
include '../models/Team.php';


if ($_SESSION['user_role'] !== 'admin') {
    header('Location: teams.php');
    exit();
}

if(isset($_GET['id']))
{
    $id = $_GET['id'];

    $team = new Team();
    $teamData = $team->findById($id);

    $name = $teamData['name'];
    $budget = $teamData['budget'];
    $manager = $teamData['manager'];
   
}
else
{
    header('Location: teams.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $name = $_POST['name'];
    $budget = $_POST['budget'];
    $manager = $_POST['manager'];

    $team = new Team();
    $team->setId($id);
    $team->setName($name);
    $team->setBudget($budget);
    $team->setManager($manager);

    $team->update();

    header('Location: teams.php');
    exit();  
}


include '../includes/header.php';
?>

<div class="max-w-4xl mx-auto p-10">
    <section class="glass-dark rounded-xl p-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-4xl font-bold orange-glow tech-header">EDIT TEAM</h2>
            <a href="teams.php" class="btn-outline">
                <i class="fas fa-arrow-left mr-2"></i>
                BACK TO TEAMS
            </a>
        </div>

        <!-- TODO: Display error message if exists -->

        <form method="POST" action="" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Team Name -->
                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">TEAM NAME</label>
                    <!-- TODO: Pre-fill value with existing team name -->
                    <input type="text" name="name" class="form-input" value="" required>
                </div>

                <!-- Manager -->
                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">MANAGER</label>
                    <!-- TODO: Pre-fill value with existing manager -->
                    <input type="text" name="manager" class="form-input" value="" required>
                </div>

                <!-- Budget -->
                <div class="md:col-span-2">
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">BUDGET (€)</label>
                    <!-- TODO: Pre-fill value with existing budget -->
                    <input type="number" name="budget" class="form-input" value="" min="0" step="1000000" required>
                </div>
            </div>

            <button type="submit" class="btn-orange w-full">
                <i class="fas fa-save mr-2"></i>
                UPDATE TEAM
            </button>
        </form>
    </section>
</div>

<?php include '../includes/footer.php'; ?>