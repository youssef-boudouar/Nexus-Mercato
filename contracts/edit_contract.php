<?php

session_start();

include '../config/database.php';
include '../models/Contract.php';

if ($_SESSION['user_role'] !== 'admin') {
    header('Location: contracts.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $contract = new Contract();

    $result = $contract->findById($id);
    
    $player_id = $result['player_id'];
    $coach_id = $result['coach_id'];
    $team_id = $result['team_id'];
    $salary = $result['salary'];
    $start_date = $result['start_date'];
    $end_date = $result['end_date'];
} 
else
{
    header('Location: contracts.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $salary = $_POST['salary'];
    $end_date = $_POST['end_date'];

    $contract = new Contract();
    $contract->setId($id);
    $contract->setPlayerId($player_id);
    $contract->setCoachId($coach_id);
    $contract->setTeamId($team_id);
    $contract->setSalary($salary);
    $contract->setStartDate($start_date);
    $contract->setEndDate($end_date);
    $contract->update();

    header('Location: contracts.php');
    exit();
}

include '../includes/header.php';
?>

<div class="max-w-4xl mx-auto p-10">
    <section class="glass-dark rounded-xl p-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-4xl font-bold orange-glow tech-header">RENEW CONTRACT</h2>
            <a href="contracts.php" class="btn-outline">
                <i class="fas fa-arrow-left mr-2"></i>
                BACK TO CONTRACTS
            </a>
        </div>


        <form method="POST" action="" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Salary -->
                <div class="md:col-span-2">
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">MONTHLY SALARY (€)</label>
                    <input type="number" name="salary" class="form-input" value="<?= $salary ?>" min="0" step="1000" required>
                </div>

                <!-- Current End Date (Read-only) -->
                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">CURRENT END DATE</label>
                    <input type="date" class="form-input bg-gray-800" value="<?= $end_date ?>" disabled>
                </div>

                <!-- New End Date -->
                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">NEW END DATE</label>
                    <input type="date" name="end_date" class="form-input" value="<?= $end_date ?>" min="<?= $end_date ?>" required>
                </div>
            </div>

            <button type="submit" class="btn-orange w-full">
                <i class="fas fa-sync mr-2"></i>
                RENEW CONTRACT
            </button>
        </form>
    </section>
</div>

<?php include '../includes/footer.php'; ?>