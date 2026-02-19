<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Player.php';

// Security Check: Role Based Access Control
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: players.php');
    exit();
}

$error = null;
$success = null;

// Handle Form Submission (Controller Logic)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // 1. Sanitize & Validate Input
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $nationality = filter_input(INPUT_POST, 'nationality', FILTER_SANITIZE_SPECIAL_CHARS);
        $position = filter_input(INPUT_POST, 'position', FILTER_SANITIZE_SPECIAL_CHARS);
        $marketValue = filter_input(INPUT_POST, 'market_value', FILTER_VALIDATE_FLOAT);

        if (!$name || !$nationality || !$position || $marketValue === false) {
            throw new InvalidArgumentException("All fields are required and must be valid.");
        }

        // 2. Initialize Entity
        $player = new Player();
        $player->setName($name);
        $player->setNationality($nationality);
        $player->setPosition($position);
        $player->setMarketValue((float)$marketValue);

        // 3. Persist Data
        if ($player->create()) {
            header('Location: players.php?msg=created');
            exit();
        } else {
            throw new Exception("Failed to save player to database.");
        }

    } catch (Throwable $e) {
        $error = $e->getMessage();
    }
}

include __DIR__ . "/../includes/header.php";
?>

<div class="max-w-4xl mx-auto p-10">
    <section class="glass-dark rounded-xl p-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-4xl font-bold orange-glow tech-header">ADD NEW PLAYER</h2>
            <a href="players.php" class="btn-outline">
                <i class="fas fa-arrow-left mr-2"></i>
                BACK TO PLAYERS
            </a>
        </div>

        <?php if ($error): ?>
            <div class="bg-red-500/20 border border-red-500 text-red-500 p-4 rounded-lg mb-6">
                <i class="fas fa-exclamation-circle mr-2"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">PLAYER NAME</label>
                    <input type="text" name="name" class="form-input" placeholder="Lionel Messi" required>
                </div>

                <!-- Nationality -->
                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">NATIONALITY</label>
                    <input type="text" name="nationality" class="form-input" placeholder="Argentine" required>
                </div>

                <!-- Position -->
                <div class="md:col-span-2">
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">POSITION</label>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <label class="cursor-pointer">
                            <input type="radio" name="position" value="Goalkeeper" class="peer sr-only" required>
                            <div class="glass-light p-4 rounded-lg text-center peer-checked:bg-orange-500/20 peer-checked:border-orange-500 border border-transparent transition">
                                <i class="fas fa-hand-paper text-2xl mb-2 text-gray-300"></i>
                                <div class="text-xs font-bold tracking-widest text-white">GOALKEEPER</div>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="position" value="Defender" class="peer sr-only" required>
                            <div class="glass-light p-4 rounded-lg text-center peer-checked:bg-orange-500/20 peer-checked:border-orange-500 border border-transparent transition">
                                <i class="fas fa-shield-alt text-2xl mb-2 text-gray-300"></i>
                                <div class="text-xs font-bold tracking-widest text-white">DEFENDER</div>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="position" value="Midfielder" class="peer sr-only" required>
                            <div class="glass-light p-4 rounded-lg text-center peer-checked:bg-orange-500/20 peer-checked:border-orange-500 border border-transparent transition">
                                <i class="fas fa-running text-2xl mb-2 text-gray-300"></i>
                                <div class="text-xs font-bold tracking-widest text-white">MIDFIELDER</div>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="position" value="Attacker" class="peer sr-only" required>
                            <div class="glass-light p-4 rounded-lg text-center peer-checked:bg-orange-500/20 peer-checked:border-orange-500 border border-transparent transition">
                                <i class="fas fa-futbol text-2xl mb-2 text-gray-300"></i>
                                <div class="text-xs font-bold tracking-widest text-white">ATTACKER</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Market Value -->
                <div class="md:col-span-2">
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">MARKET VALUE (€)</label>
                    <input type="number" name="market_value" class="form-input" placeholder="50000000" min="0" step="1000" required>
                </div>
            </div>

            <button type="submit" class="btn-orange w-full py-4 text-lg font-black tracking-widest">
                <i class="fas fa-plus mr-2"></i>
                ADD PLAYER TO REGISTRY
            </button>
        </form>
    </section>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
