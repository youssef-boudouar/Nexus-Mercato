<?php
session_start();

include '../models/Transfer.php';

$transfer = new Transfer();
$transfers = $transfer->getAll();


include '../includes/header.php';
?>

<div class="max-w-7xl mx-auto p-10 space-y-8">

    <section id="transfers" class="glass-dark rounded-xl p-8 mb-12">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-4xl font-bold orange-glow tech-header">TRANSFER MARKET</h2>
            <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
            <a href="add_transfer.php" class="btn-orange">
                <i class="fas fa-plus mr-2"></i>
                NEW TRANSFER
            </a>
            <?php endif; ?>
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
                        <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <th>ACTIONS</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($transfers as $transfer): ?>
                    <tr>
                        <td class="font-bold text-gray-500">#<?= $transfer['id'] ?></td>
                        <td class="font-bold text-white text-lg"><?= $transfer['player'] ?></td>
                        <td class="text-gray-400 tracking-wide"><?= $transfer['departure_team'] ?></td>
                        <td class="text-gray-400 tracking-wide"><?= $transfer['arrival_team'] ?></td>
                        <td>
                            <span class="badge badge-orange"><?= $transfer['transfer_status'] ?></span>
                        </td>
                        <td class="font-bold text-[#FF5722] text-lg"><?= $transfer['amount'] == 0 ? "Free Agent" : '€'.number_format($transfer['amount'])?></td>
                        <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <td class="flex gap-4">
                            <!-- EDIT -->
                            <a href="edit_transfer.php?id=<?= $transfer['id'] ?>"
                                class="text-blue-400 hover:text-blue-300 transition">
                                <i class="fas fa-edit"></i>
                            </a>

                            <!-- DELETE -->
                            <a href="delete_transfer.php?id=<?= $transfer['id'] ?>"
                                onclick="return confirm('Are you sure you want to delete this transfer?');"
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