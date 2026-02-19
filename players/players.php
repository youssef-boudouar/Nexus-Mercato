<?php
session_start();
include '../models/Player.php';

$player = new Player();
$players = $player->getAll();
// var_dump($players);

include '../includes/header.php';
?>

<div class="max-w-7xl mx-auto p-10 space-y-8">

    <section id="players" class="glass-dark rounded-xl p-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-4xl font-bold orange-glow tech-header">PLAYER REGISTRY</h2>
            <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                <a href="add_player.php" class="btn-outline">
                    <i class="fas fa-plus mr-2"></i>
                    ADD PLAYER
                </a>
            <?php endif; ?>
        </div>

        <div class="overflow-x-auto">
<?php
// ... existing imports ...

// Helper function to map country names to ISO 2-letter codes
function getCountryCode(string $countryName): string {
    $map = [
        'France' => 'fr', 'Brazil' => 'br', 'Argentina' => 'ar', 'Portugal' => 'pt', 
        'Spain' => 'es', 'England' => 'gb', 'Germany' => 'de', 'Italy' => 'it', 
        'Netherlands' => 'nl', 'Belgium' => 'be', 'Morocco' => 'ma', 'Croatia' => 'hr',
        'Uruguay' => 'uy', 'Colombia' => 'co', 'USA' => 'us', 'Senegal' => 'sn',
        'Egypt' => 'eg', 'Japan' => 'jp', 'South Korea' => 'kr', 'Canada' => 'ca'
    ];
    return $map[$countryName] ?? 'un'; // 'un' for United Nations/Unknown generic flag
}
?>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-white/5 bg-slate-900/50">
                        <th class="py-5 px-6 text-left">Athlete Profile</th>
                        <th class="py-5 px-6 text-left">Role</th>
                        <th class="py-5 px-6 text-right">Market Value</th>
                        <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                            <th class="py-5 px-6 text-right">Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php foreach($players as $p): ?>
                        <tr class="group hover:bg-white/[0.02] transition-colors duration-200">
                            <td class="py-5 px-6">
                                <div class="flex items-center gap-6">
                                    <!-- Soft Vertical Avatar (Fixed Crop) -->
                                    <div class="flex-shrink-0">
                                        <img src="<?= htmlspecialchars($p['image_url'] ?? '') ?>" 
                                             alt="<?= htmlspecialchars($p['name']) ?>" 
                                             class="w-16 h-20 rounded-xl object-cover object-top border border-white/10 shadow-lg shadow-black/50">
                                    </div>
                                    
                                    <!-- Name & Flag -->
                                    <div>
                                        <div class="text-xl font-bold text-white tracking-tight mb-1"><?= $p['name'] ?></div>
                                        <div class="flex items-center gap-2 text-slate-400 text-sm font-medium">
                                            <!-- FlagCDN Integration -->
                                            <img src="https://flagcdn.com/24x18/<?= getCountryCode($p['nationality']) ?>.png" 
                                                 alt="<?= $p['nationality'] ?>"
                                                 class="h-3 w-4 rounded-sm shadow-sm opacity-80">
                                            <span class="text-slate-500"><?= $p['nationality'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-5 px-6">
                                <span class="px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wide bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                    <?= $p['position'] ?>
                                </span>
                            </td>
                            <td class="py-5 px-6 text-right">
                                <div class="font-mono font-bold text-emerald-400 text-xl tracking-tight">
                                    €<?= number_format($p['market_value'] / 1000000, 2) ?>M
                                </div>
                            </td>
                            <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                                <td class="py-5 px-6 text-right">
                                    <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="edit_player.php?id=<?= $p['id'] ?>" class="p-2 text-slate-400 hover:text-white transition-colors border border-transparent hover:border-white/10 rounded-lg">
                                            <i class="fas fa-pen-to-square"></i>
                                        </a>
                                        <a href="delete_player.php?id=<?= $p['id'] ?>" 
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