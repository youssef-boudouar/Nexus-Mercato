<?php
// =====================================================
// EDIT PLAYER FORM
// =====================================================

// TODO: Start session

// TODO: Check if user is admin (redirect if not)

// TODO: Include database connection

// TODO: Include Player model

// TODO: Initialize error and success variables

// TODO: Get player ID from URL (?id=X)

// TODO: Validate ID exists

// TODO: Fetch player data from database using ID

// TODO: If player not found, redirect to players.php

// TODO: Handle form submission (if POST request)
// TODO: Get form data (name, nationality, position, age, market_value)
// TODO: Validate inputs
// TODO: Update player using model
// TODO: If success: redirect to players.php
// TODO: If error: set error message

include './includes/header.php';
?>

<div class="max-w-4xl mx-auto p-10">
    <section class="glass-dark rounded-xl p-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-4xl font-bold orange-glow tech-header">EDIT PLAYER</h2>
            <a href="players.php" class="btn-outline">
                <i class="fas fa-arrow-left mr-2"></i>
                BACK TO PLAYERS
            </a>
        </div>

        <!-- TODO: Display error message if exists -->

        <form method="POST" action="" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">PLAYER NAME</label>
                    <!-- TODO: Pre-fill value with existing player name -->
                    <input type="text" name="name" class="form-input" value="" required>
                </div>

                <!-- Nationality -->
                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">NATIONALITY</label>
                    <!-- TODO: Pre-fill value with existing nationality -->
                    <input type="text" name="nationality" class="form-input" value="" required>
                </div>

                <!-- Position -->
                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">POSITION</label>
                    <!-- TODO: Select current position -->
                    <select name="position" class="form-input" required>
                        <option value="">Select Position</option>
                        <option value="Goalkeeper">Goalkeeper</option>
                        <option value="Defender">Defender</option>
                        <option value="Midfielder">Midfielder</option>
                        <option value="Attacker">Attacker</option>
                    </select>
                </div>

                <!-- Age -->
                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">AGE</label>
                    <!-- TODO: Pre-fill value with existing age -->
                    <input type="number" name="age" class="form-input" value="" min="16" max="45" required>
                </div>

                <!-- Market Value -->
                <div class="md:col-span-2">
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">MARKET VALUE (€)</label>
                    <!-- TODO: Pre-fill value with existing market value -->
                    <input type="number" name="market_value" class="form-input" value="" min="0" step="1000" required>
                </div>
            </div>

            <button type="submit" class="btn-orange w-full">
                <i class="fas fa-save mr-2"></i>
                UPDATE PLAYER
            </button>
        </form>
    </section>
</div>

<?php include './includes/footer.php'; ?>