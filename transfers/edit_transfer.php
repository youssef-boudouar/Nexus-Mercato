<?php
// =====================================================
// EDIT TRANSFER FORM
// =====================================================

// TODO: Start session

// TODO: Check if user is admin (redirect if not)

// TODO: Include database connection

// TODO: Include Transfer, Player, Team models

// TODO: Initialize error and success variables

// TODO: Get transfer ID from URL (?id=X)

// TODO: Validate ID exists

// TODO: Fetch transfer data from database using ID

// TODO: If transfer not found, redirect to transfers.php

// TODO: Fetch all players from database

// TODO: Fetch all teams from database

// TODO: Handle form submission (if POST request)
// TODO: Get form data (player_id, departure_team_id, arrival_team_id, amount, transfer_status)
// TODO: Validate inputs
// TODO: Validate departure and arrival teams are different
// TODO: Update transfer using model
// TODO: If success: redirect to transfers.php
// TODO: If error: set error message

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

        <!-- TODO: Display error message if exists -->

        <form method="POST" action="" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Player -->
                <div class="md:col-span-2">
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">SELECT PLAYER</label>
                    <!-- TODO: Loop through players and select current player -->
                    <select name="player_id" class="form-input" required>
                        <option value="">Select Player</option>
                        <!-- TODO: Loop and select current -->
                    </select>
                </div>

                <!-- Departure Team -->
                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">FROM TEAM</label>
                    <!-- TODO: Loop through teams and select current departure team -->
                    <select name="departure_team_id" class="form-input" required>
                        <option value="">Select Departure Team</option>
                        <!-- TODO: Loop and select current -->
                    </select>
                </div>

                <!-- Arrival Team -->
                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">TO TEAM</label>
                    <!-- TODO: Loop through teams and select current arrival team -->
                    <select name="arrival_team_id" class="form-input" required>
                        <option value="">Select Arrival Team</option>
                        <!-- TODO: Loop and select current -->
                    </select>
                </div>

                <!-- Transfer Amount -->
                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">TRANSFER AMOUNT (€)</label>
                    <!-- TODO: Pre-fill with current amount -->
                    <input type="number" name="amount" class="form-input" value="" min="0" step="1000000" required>
                </div>

                <!-- Transfer Status -->
                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">TRANSFER STATUS</label>
                    <!-- TODO: Select current status -->
                    <select name="transfer_status" class="form-input" required>
                        <option value="">Select Status</option>
                        <option value="in progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
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