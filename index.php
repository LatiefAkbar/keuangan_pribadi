<?php 
session_start();
include 'config/db.php';

if(isset($_SESSION['user_id'])){
    header("Location: dashboard.php");
    exit;
}

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT id, password, username FROM users WHERE username = '$username'");
    $data = mysqli_fetch_assoc($query);

    if(mysqli_num_rows($query) == 1){
        $password_hash = $data['password'];
        if(password_verify($password, $password_hash)){
            $_SESSION['username'] = $data['username'];
            $_SESSION['user_id'] = $data['id'];
            header("Location: dashboard.php");
            exit;
        }else{
            $error = 'Password atau username salah';
        }
    }else{
        $error = 'Username tidak ditemukan';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Akun</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-700">🔑 Login</h2>

        <?php if(isset($error)): ?>
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <?= $error ?>
            </div>
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
                Login
            </button>
               <p class="text-center text-gray-500 mt-4">Belum punya akun? 
               <a href="register.php" class="text-blue-600 underline">Register</a>
            </p>
        </form>
    </div>
</body>
</html>
