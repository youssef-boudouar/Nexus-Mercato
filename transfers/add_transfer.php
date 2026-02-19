<?php

session_start();

include '../config/database.php';
include '../models/Transfer.php';
include '../models/Player.php';
include '../models/Team.php';
include '../models/Contract.php';

if ($_SESSION['user_role'] !== 'admin') {
    header('Location: transfers.php');
    exit();
}

$player = new Player();
$players = $player->getAll();

$team = new Team();
$teams = $team->getAll();

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $player_id = $_POST['player_id'];
    $departure_team_id = $_POST['departure_team_id'];
    $arrival_team_id = $_POST['arrival_team_id'];
    $amount = $_POST['amount'];
    $salary = $_POST['salary'];
    $transfer_status = $_POST['transfer_status'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $transfer = new Transfer();
    $transfer->setPlayerId($player_id);
    $transfer->setDepartureTeamId($departure_team_id);
    $transfer->setArrivalTeamId($arrival_team_id);
    $transfer->setAmount($amount);
    $transfer->setTransferStatus($transfer_status);
    $transfer->create();

    if ($transfer_status === 'done') {
        $contract = new Contract();
        $contract->setPlayerId($player_id);
        $contract->setCoachId(null);
        $contract->setTeamId($arrival_team_id);
        $contract->setSalary($salary);
        $contract->setStartDate($start_date);
        $contract->setEndDate($end_date);
        $contract->create();
    }

    header('Location: transfers.php');
    exit();
}

include '../includes/header.php';
?>

<div class="max-w-4xl mx-auto p-10">
    <section class="glass-dark rounded-xl p-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-4xl font-bold orange-glow tech-header">ADD NEW TRANSFER</h2>
            <a href="transfers.php" class="btn-outline">
                <i class="fas fa-arrow-left mr-2"></i>
                BACK TO TRANSFERS
            </a>
        </div>

        <form method="POST" action="" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Player -->
                <div class="md:col-span-2">
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">SELECT PLAYER</label>
                    <select name="player_id" class="form-input" required>
                        <option value="">Select Player</option>
                        <?php foreach ($players as $p): ?>
                            <option value="<?= $p['id'] ?>"><?= $p['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Departure Team -->
                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">FROM TEAM</label>
                    <select name="departure_team_id" class="form-input" required>
                        <option value="">Select Departure Team</option>
                        <?php foreach ($teams as $t): ?>
                            <option value="<?= $t['id'] ?>"><?= $t['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Arrival Team -->
                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">TO TEAM</label>
                    <select name="arrival_team_id" class="form-input" required>
                        <option value="">Select Arrival Team</option>
                        <?php foreach ($teams as $t): ?>
                            <option value="<?= $t['id'] ?>"><?= $t['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Transfer Amount -->
                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">TRANSFER AMOUNT (€)</label>
                    <input type="number" name="amount" class="form-input" placeholder="50000000" min="0" step="1000000" required>
                </div>

                <!-- Monthly Salary -->
                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">MONTHLY SALARY (€)</label>
                    <input type="number" name="salary" class="form-input" placeholder="100000" min="0" step="1000" required>
                </div>

                <!-- Contract Start Date -->
                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">CONTRACT START</label>
                    <input type="date" name="start_date" class="form-input" required>
                </div>

                <!-- Contract End Date -->
                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">CONTRACT END</label>
                    <input type="date" name="end_date" class="form-input" required>
                </div>

                <!-- Transfer Status -->
                <div class="md:col-span-2">
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">TRANSFER STATUS</label>
                    <select name="transfer_status" class="form-input" required>
                        <option value="">Select Status</option>
                        <option value="in progress">In Progress</option>
                        <option value="done">Done</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn-orange w-full">
                <i class="fas fa-plus mr-2"></i>
                ADD TRANSFER
            </button>
        </form>
    </section>
</div>

<?php include '../includes/footer.php'; ?>