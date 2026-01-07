<?php
// =====================================================
// EDIT TEAM FORM
// =====================================================

// TODO: Start session

// TODO: Check if user is admin (redirect if not)

// TODO: Include database connection

// TODO: Include Team model

// TODO: Initialize error and success variables

// TODO: Get team ID from URL (?id=X)

// TODO: Validate ID exists

// TODO: Fetch team data from database using ID

// TODO: If team not found, redirect to teams.php

// TODO: Handle form submission (if POST request)
// TODO: Get form data (name, manager, budget)
// TODO: Validate inputs
// TODO: Update team using model
// TODO: If success: redirect to teams.php
// TODO: If error: set error message

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