<?php

session_start();

include '../config/database.php';
include '../models/Transfer.php';
include '../models/Player.php';
include '../models/Team.php';

if ($_SESSION['user_role'] !== 'admin') {
    header('Location: transfers.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $transfer = new Transfer();

    $result = $transfer->findById($id);
    $player_id = $result['player_id'];
    $departure_team_id = $result['departure_team_id'];
    $arrival_team_id = $result['arrival_team_id'];
    $amount = $result['amount'];
    $transfer_status = $result['transfer_status'];

    // var_dump($transfer_status);
    
    $team = new Team();
    $teams = $team->getAll();
} 
else
{
    header('Location: transfers.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $departure_team_id = $_POST['departure_team_id'];
    $arrival_team_id = $_POST['arrival_team_id'];
    $amount = $_POST['amount'];
    $transfer_status = $_POST['transfer_status'];

    $transfer = new Transfer();
    $transfer->setId($id);
    $transfer->setPlayerId($player_id);
    $transfer->setDepartureTeamId($departure_team_id);
    $transfer->setArrivalTeamId($arrival_team_id);
    $transfer->setAmount($amount);
    $transfer->setTransferStatus($transfer_status);
    $transfer->update();

    header('Location: transfers.php');
    exit();
}

include '../includes/header.php';
?>

<div class="max-w-4xl mx-auto p-10">
    <section class="glass-dark rounded-xl p-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-4xl font-bold orange-glow tech-header">EDIT TRANSFER</h2>
            <a href="transfers.php" class="btn-outline">
                <i class="fas fa-arrow-left mr-2"></i>
                BACK TO TRANSFERS
            </a>
        </div>

        <form method="POST" action="" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div> 
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">FROM TEAM</label>
                    <?php if ($transfer_status == 'done'): ?>
                    
                        <select name="departure_team_id" class="form-input" required>
                            <option value="">Select Departure Team</option>
                            <?php foreach ($teams as $t): ?>
                                <option value="<?= $t['id'] ?>" <?= $t['id'] == $departure_team_id ? 'selected' : '' ?>><?= $t['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php else: ?>
                        <input type="text" class="form-input bg-gray-800" value="<?php 
                            foreach ($teams as $t) {
                                if ($t['id'] == $departure_team_id) echo $t['name'];
                            }
                        ?>" disabled>
                        <input type="hidden" name="departure_team_id" value="<?= $departure_team_id ?>">
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">TO TEAM</label>
                    <select name="arrival_team_id" class="form-input" required>
                        <option value="">Select Arrival Team</option>
                        <?php foreach ($teams as $t): ?>
                            <option value="<?= $t['id'] ?>" <?= $t['id'] == $arrival_team_id ? 'selected' : '' ?>><?= $t['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">TRANSFER AMOUNT (€)</label>
                    <input type="number" name="amount" class="form-input" value="<?= $amount ?>" min="0" step="1000000" required>
                </div>

                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">TRANSFER STATUS</label>
                    <select name="transfer_status" class="form-input" required <?= $transfer_status === 'done' ? 'disabled' : ''?>>
                        <option value="">Select Status</option>
                        <option value="in progress" <?= $transfer_status === 'in progress' ? 'selected' : '' ?>>In Progress</option>
                        <option value="done" <?= $transfer_status === 'done' ? 'selected' : '' ?>>Done</option>
                        <option value="cancelled" <?= $transfer_status === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn-orange w-full">
                <i class="fas fa-save mr-2"></i>
                UPDATE TRANSFER
            </button>
        </form>
    </section>
</div>

<?php include '../includes/footer.php'; ?>