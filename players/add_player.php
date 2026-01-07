<?php


session_start();


include '../config/database.php';
include '../models/Player.php';


if($_SESSION['user_role'] !== 'admin')
{
    header('Location: players.php');
    exit();
}



if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $name = $_POST['name'];
    $nationality = $_POST['nationality'];
    $position = $_POST['position'];
    $marketValue = $_POST['market_value'];

    $player = new Player();
    $player->setName($name);
    $player->setNationality($nationality);
    $player->setPosition($position);
    $player->setMarketValue($marketValue);
    $player->create();

    header('Location: players.php');
    exit();

}
include "../includes/header.php";
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
                    <div>
                        <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">POSITION</label>

                        <div class="position-grid">
                            <label class="position-option">
                                <input type="radio" name="position" value="Goalkeeper" required>
                                <span class="position-label">
                                    <i class="fas fa-hand-paper"></i>
                                    GOALKEEPER
                                </span>
                            </label>

                            <label class="position-option">
                                <input type="radio" name="position" value="Defender" required>
                                <span class="position-label">
                                    <i class="fas fa-shield-alt"></i>
                                    DEFENDER
                                </span>
                            </label>

                            <label class="position-option">
                                <input type="radio" name="position" value="Midfielder" required>
                                <span class="position-label">
                                    <i class="fas fa-running"></i>
                                    MIDFIELDER
                                </span>
                            </label>

                            <label class="position-option">
                                <input type="radio" name="position" value="Attacker" required>
                                <span class="position-label">
                                    <i class="fas fa-futbol"></i>
                                    ATTACKER
                                </span>
                            </label>
                        </div>
                    </div>

                <!-- Market Value -->
                <div class="md:col-span-2">
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">MARKET VALUE (€)</label>
                    <input type="number" name="market_value" class="form-input" placeholder="50000000" min="0" step="1000" required>
                </div>
            </div>

            <button type="submit" class="btn-orange w-full">
                <i class="fas fa-plus mr-2"></i>
                ADD PLAYER
            </button>
        </form>
    </section>
</div>

<?php include '../includes/footer.php'; ?>
