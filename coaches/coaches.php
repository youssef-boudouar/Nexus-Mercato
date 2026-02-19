<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../models/Coach.php';

$coaches = [];
$error = null;

try {
    $coachModel = new Coach();
    $coaches = $coachModel->getAll();
} catch (Exception $e) {
    $error = "Unable to load coaches: " . $e->getMessage();
    error_log($error);
}

include __DIR__ . '/../includes/header.php';
?>

<div class="max-w-7xl mx-auto p-10 space-y-8">

<?php
// Helper function to map country names to ISO 2-letter codes (Same as Players)
function getCountryCode(string $countryName): string {
    $map = [
        'France' => 'fr', 'Brazil' => 'br', 'Argentina' => 'ar', 'Portugal' => 'pt', 
        'Spain' => 'es', 'England' => 'gb', 'Germany' => 'de', 'Italy' => 'it', 
        'Netherlands' => 'nl', 'Belgium' => 'be', 'Morocco' => 'ma', 'Croatia' => 'hr',
        'Uruguay' => 'uy', 'Colombia' => 'co', 'USA' => 'us', 'Senegal' => 'sn',
        'Egypt' => 'eg', 'Japan' => 'jp', 'South Korea' => 'kr', 'Canada' => 'ca'
    ];
    // Simple normalization/fallback
    return $map[$countryName] ?? 'un'; 
}
?>
    <section id="coaches" class="glass-dark rounded-xl p-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-4xl font-bold orange-glow tech-header">COACH REGISTRY</h2>
            <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                <a href="add_coach.php" class="btn-outline">
                    <i class="fas fa-plus mr-2"></i>
                    ADD COACH
                </a>
            <?php endif; ?>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-white/5 bg-slate-900/50">
                        <th class="py-5 px-6 text-center">Photo</th>
                        <th class="py-5 px-6 text-left">Name</th>
                        <th class="py-5 px-6 text-center">Nationality</th>
                        <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                            <th class="py-5 px-6 text-right">Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php foreach($coaches as $c): ?>
                        <tr class="group hover:bg-white/[0.02] transition-colors duration-200">
                            <!-- Photo -->
                            <td class="py-5 px-6 text-center">
                                <div class="flex-shrink-0">
                                    <img src="<?= htmlspecialchars($c['image_url'] ?? 'assets/img/default_pro.png') ?>" 
                                         alt="<?= htmlspecialchars($c['name']) ?>" 
                                         class="w-16 h-20 rounded-xl object-cover object-top border border-white/10 mx-auto">
                                </div>
                            </td>

                            <!-- Name -->
                            <td class="py-5 px-6 text-left">
                                <div class="text-lg font-bold text-white"><?= $c['name'] ?></div>
                            </td>

                            <!-- Nationality -->
                            <td class="py-5 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <img src="https://flagcdn.com/24x18/<?= getCountryCode($c['nationality']) ?>.png" 
                                         alt="<?= $c['nationality'] ?>"
                                         class="h-3 w-4 rounded-sm opacity-80">
                                    <span class="text-sm font-medium text-slate-400"><?= $c['nationality'] ?></span>
                                </div>
                            </td>

                            <!-- Actions -->
                            <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                                <td class="py-5 px-6 text-right">
                                    <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="edit_coach.php?id=<?= $c['id'] ?>" class="p-2 text-slate-400 hover:text-white transition-colors border border-transparent hover:border-white/10 rounded-lg">
                                            <i class="fas fa-pen-to-square"></i>
                                        </a>
                                        <a href="delete_coach.php?id=<?= $c['id'] ?>" 
                                           onclick="return confirm('Are you sure?');"
                                           class="p-2 text-red-500 hover:text-red-400 transition-colors border border-transparent hover:border-red-500/20 rounded-lg">
                                            <i class="fas fa-trash-can"></i>
                                        </a>
                                    </div>
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