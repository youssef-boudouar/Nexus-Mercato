<?php

session_start();
if (isset($_SESSION['user_role'])) {
    header('Location: ../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($email === "admin@nexus.com" && $password === "nexusadmin") {
        $_SESSION['user_role'] = "admin";
        header('Location: ../index.php');
        exit();
    } else if ($email === "journalist@nexus.com" && $password === "nexusjourn") {
        $_SESSION['user_role'] = "journalist";
        header('Location: ../index.php');
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - nexus MERCATO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="bg-stadium">
    <div class="overlay-gradient"></div>

    <div class="relative z-10 flex items-center justify-center min-h-screen p-6">
        <div class="glass-dark rounded-3xl p-12 max-w-md w-full border-2 border-[#FF5722]/30">

            <!-- Logo -->
            <div class="text-center mb-10">
                <div class="mb-6">
                    <img src="../assets/img/logo.png" alt="nexus Logo" class="login-logo mx-auto">
                </div>
                <h1 class="text-5xl font-black orange-glow-strong tech-header mb-3">ACCESS CONTROL</h1>
                <p class="text-gray-500 text-xs tracking-widest font-bold">AUTHENTICATE TO ENTER COMMAND CENTER</p>
            </div>


            <form class="space-y-6" method="POST" action="">
                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">EMAIL ADDRESS</label>
                    <input type="email" name="email" class="form-input" placeholder="admin@nexusmercato.com" required>
                </div>

                <div>
                    <label class="block text-gray-400 text-xs font-bold tech-header mb-3 tracking-widest">PASSWORD</label>
                    <input type="password" name="password" class="form-input" placeholder="••••••••••" required>
                </div>

                <button type="submit" name="login" class="btn-orange w-full">
                    <i class="fas fa-unlock mr-2"></i>
                    ENTER COMMAND CENTER
                </button>

                <a href="../index.php" class="btn-outline w-full text-center block">
                    <i class="fas fa-arrow-left mr-2"></i>
                    BACK TO SITE
                </a>
            </form>

        </div>
    </div>

</body>

</html>