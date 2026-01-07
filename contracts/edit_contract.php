<?php
// =====================================================
// EDIT CONTRACT FORM
// =====================================================

// TODO: Start session

// TODO: Check if user is admin (redirect if not)

// TODO: Include database connection

// TODO: Include Contract, Player, Coach, Team models

// TODO: Initialize error and success variables

// TODO: Get contract ID from URL (?id=X)

// TODO: Validate ID exists

// TODO: Fetch contract data from database using ID

// TODO: If contract not found, redirect to contracts.php

// TODO: Fetch all players from database

// TODO: Fetch all coaches from database

// TODO: Fetch all teams from database

// TODO: Handle form submission (if POST request)
// TODO: Get form data (person_type, player_id OR coach_id, team_id, salary, start_date, end_date)
// TODO: Validate inputs
// TODO: Update contract using model
// TODO: If success: redirect to contracts.php
// TODO: If error: set error message

include '../includes/header.php';
?>

<div class="max-w-4xl mx-auto p-10">
    <section class="glass-dark rounded-xl p-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-4xl font-bold orange-glow tech-header">EDIT CONTRACT</h2>
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
                    <!-- TODO: Select current type (player or coach) -->
                    <select name="person_type" id="person_type" class="form-input" required>
                        <option value="">Select Type</option>
                        <option value="player">Player Contract</option>
                        <option value="coach">Coach Contract</option>
                    </select>
                </div>

                <!-- Player Select -->
                <div id="player_select" class="md:col-span-2" style="display: none;">
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">SELECT PLAYER</label>
                    <!-- TODO: Loop through players and select current player -->
                    <select name="player_id" class="form-input">
                        <option value="">Select Player</option>
                        <!-- TODO: Loop and select current -->
                    </select>
                </div>

                <!-- Coach Select -->
                <div id="coach_select" class="md:col-span-2" style="display: none;">
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">SELECT COACH</label>
                    <!-- TODO: Loop through coaches and select current coach -->
                    <select name="coach_id" class="form-input">
                        <option value="">Select Coach</option>
                        <!-- TODO: Loop and select current -->
                    </select>
                </div>

                <!-- Team -->
                <div class="md:col-span-2">
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">SELECT TEAM</label>
                    <!-- TODO: Loop through teams and select current team -->
                    <select name="team_id" class="form-input" required>
                        <option value="">Select Team</option>
                        <!-- TODO: Loop and select current -->
                    </select>
                </div>

                <!-- Salary -->
                <div class="md:col-span-2">
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">MONTHLY SALARY (€)</label>
                    <!-- TODO: Pre-fill with current salary -->
                    <input type="number" name="salary" class="form-input" value="" min="0" step="1000" required>
                </div>

                <!-- Start Date -->
                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">START DATE</label>
                    <!-- TODO: Pre-fill with current start date -->
                    <input type="date" name="start_date" class="form-input" value="" required>
                </div>

                <!-- End Date -->
                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">END DATE</label>
                    <!-- TODO: Pre-fill with current end date -->
                    <input type="date" name="end_date" class="form-input" value="" required>
                </div>
            </div>

            <button type="submit" class="btn-orange w-full">
                <i class="fas fa-save mr-2"></i>
                UPDATE CONTRACT
            </button>
        </form>
    </section>
</div>

<!-- TODO: Add JavaScript to toggle player/coach select based on contract type -->

<?php include '../includes/footer.php'; ?>