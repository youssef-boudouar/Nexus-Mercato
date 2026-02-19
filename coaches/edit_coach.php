<?php

session_start();


include '../config/database.php';
include '../models/Coach.php';


if ($_SESSION['user_role'] !== 'admin') {
    header('Location: coaches.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $coach = new Coach();

    $result = $coach->findById($id);
    $name = $result['name'];
    $nationality = $result['nationality'];
    
} 
else
{
    header('Location: coaches.php');
    exit();
}


if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $name = $_POST['name'];
    $nationality = $_POST['nationality'];

    $coach = new Coach();
    $coach->setId($id);
    $coach->setName($name);
    $coach->setNationality($nationality);
    $coach->update();

    header('Location: coaches.php');
    exit();
}


include '../includes/header.php';
?>

<div class="max-w-4xl mx-auto p-10">
    <section class="glass-dark rounded-xl p-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-4xl font-bold orange-glow tech-header">EDIT COACH</h2>
            <a href="coaches.php" class="btn-outline">
                <i class="fas fa-arrow-left mr-2"></i>
                BACK TO COACHES
            </a>
        </div>

        <form method="POST" action="" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">COACH NAME</label>
                    <input type="text" name="name" class="form-input" value="<?= $name ?>" required>
                </div>

                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">NATIONALITY</label>
                    <input type="text" name="nationality" class="form-input" value="<?= $nationality ?>" required>
                </div>
            </div>

            <button type="submit" class="btn-orange w-full">
                <i class="fas fa-save mr-2"></i>
                UPDATE COACH
            </button>
        </form>
    </section>
</div>

<?php include '../includes/footer.php'; ?>