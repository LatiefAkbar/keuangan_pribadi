<?php
session_start();
include 'config/db.php';
mysqli_report(MYSQLI_REPORT_OFF); // default di PHP 8

if(isset($_SESSION['user_id'])){
    header("Location: dashboard.php");
    exit;
}

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $data = "INSERT INTO users(username, password) VALUES('$username', '$password_hash')";
    $execute = mysqli_query($conn, $data);
    
    if(mysqli_errno($conn) == 1062){
        $error = 'Username sudah terdaftar!';
    } elseif($execute){
        $success = 'Registrasi berhasil! Silahkan <a href="login.php" class="underline text-blue-600">Login</a>';
    } else{
        $error = 'Registrasi gagal, coba lagi.';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Akun</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-700">📝 Registrasi</h2>

        <?php if(isset($error)): ?>
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4"><?= $error ?></div>
        <?php elseif(isset($success)): ?>
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4"><?= $success ?></div>
        <?php endif; ?>

        <form method="post" class="space-y-4">
            <div>
                <label class="block text-gray-600 mb-1">Username</label>
                <input type="text" name="username" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                       placeholder="Masukkan username">
            </div>
            <div>
                <label class="block text-gray-600 mb-1">Password</label>
                <input type="password" name="password" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                       placeholder="Masukkan password">
            </div>
            <button type="submit" name="submit"
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition-colors">
                Register
            </button>
        </form>

        <p class="text-center text-gray-500 mt-4">Sudah punya akun? 
            <a href="index.php" class="text-blue-600 underline">Login</a>
        </p>
    </div>
</body>
</html>
