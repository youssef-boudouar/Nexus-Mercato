<?php
// =====================================================
// ADD CONTRACT FORM
// =====================================================

// TODO: Start session

// TODO: Check if user is admin (redirect if not)

// TODO: Include database connection

// TODO: Include Contract, Player, Coach, Team models

// TODO: Initialize error and success variables

// TODO: Fetch all players from database

// TODO: Fetch all coaches from database

// TODO: Fetch all teams from database

// TODO: Handle form submission (if POST request)
// TODO: Get form data (person_type, player_id OR coach_id, team_id, salary, start_date, end_date)
// TODO: Validate inputs
// TODO: Create contract using model
// TODO: If success: redirect to contracts.php
// TODO: If error: set error message

include '../includes/header.php';
?>

<div class="max-w-4xl mx-auto p-10">
    <section class="glass-dark rounded-xl p-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-4xl font-bold orange-glow tech-header">ADD NEW CONTRACT</h2>
            <a href="contracts.php" class="btn-outline">
                <i class="fas fa-arrow-left mr-2"></i>
                BACK TO CONTRACTS
            </a>
        </div>

        <!-- TODO: Display error message if exists -->

        <form method="POST" action="" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Person Type -->
                <div class="md:col-span-2">
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">CONTRACT TYPE</label>
                    <select name="person_type" id="person_type" class="form-input" required>
                        <option value="">Select Type</option>
                        <option value="player">Player Contract</option>
                        <option value="coach">Coach Contract</option>
                    </select>
                </div>

                <!-- Player Select (hidden by default) -->
                <div id="player_select" class="md:col-span-2" style="display: none;">
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">SELECT PLAYER</label>
                    <select name="player_id" class="form-input">
                        <option value="">Select Player</option>
                        <!-- TODO: Loop through players and display options -->
                    </select>
                </div>

                <!-- Coach Select (hidden by default) -->
                <div id="coach_select" class="md:col-span-2" style="display: none;">
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">SELECT COACH</label>
                    <select name="coach_id" class="form-input">
                        <option value="">Select Coach</option>
                        <!-- TODO: Loop through coaches and display options -->
                    </select>
                </div>

                <!-- Team -->
                <div class="md:col-span-2">
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">SELECT TEAM</label>
                    <select name="team_id" class="form-input" required>
                        <option value="">Select Team</option>
                        <!-- TODO: Loop through teams and display options -->
                    </select>
                </div>

                <!-- Salary -->
                <div class="md:col-span-2">
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">MONTHLY SALARY (€)</label>
                    <input type="number" name="salary" class="form-input" placeholder="500000" min="0" step="1000" required>
                </div>

                <!-- Start Date -->
                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">START DATE</label>
                    <input type="date" name="start_date" class="form-input" required>
                </div>

                <!-- End Date -->
                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">END DATE</label>
                    <input type="date" name="end_date" class="form-input" required>
                </div>
            </div>

            <button type="submit" class="btn-orange w-full">
                <i class="fas fa-plus mr-2"></i>
                ADD CONTRACT
            </button>
        </form>
    </section>
</div>

<!-- TODO: Add JavaScript to toggle player/coach select based on contract type -->

<?php include '../includes/footer.php'; ?>