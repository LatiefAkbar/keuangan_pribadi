<?php
include '../includes/auth.php';
include '../config/db.php';

if(isset($_POST['submit'])){
    $user_id   = $_SESSION['user_id'];
    $tanggal   = $_POST['tanggal'];
    $jenis     = $_POST['jenis'];
    $kategori  = $_POST['kategori'];
    $jumlah    = $_POST['jumlah'];
    $keterangan= $_POST['keterangan'];

    $query = "INSERT INTO transaksi (user_id, tanggal, jenis, kategori, jumlah, keterangan) 
              VALUES ('$user_id', '$tanggal', '$jenis', '$kategori', '$jumlah', '$keterangan')";
    if(mysqli_query($conn, $query)){
        header("Location: ../dashboard.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Transaksi</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
  <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-lg">
    <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">➕ Tambah Transaksi</h2>

    <form method="post" class="space-y-4">
      <!-- Tanggal -->
      <div>
        <label class="block text-gray-600 mb-1">Tanggal</label>
        <input type="date" name="tanggal" required
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
      </div>

      <!-- Jenis -->
      <div>
        <label class="block text-gray-600 mb-1">Jenis</label>
        <select name="jenis" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
          <option value="pemasukan">Pemasukan</option>
          <option value="pengeluaran">Pengeluaran</option>
        </select>
      </div>

      <!-- Kategori -->
      <div>
        <label class="block text-gray-600 mb-1">Kategori</label>
        <input type="text" name="kategori" placeholder="misal: gaji, makan, transport" required
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
      </div>

      <!-- Jumlah -->
      <div>
        <label class="block text-gray-600 mb-1">Jumlah</label>
        <input type="text" name="jumlah" id="jumlah" required
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
      </div>

      <!-- Keterangan -->
      <div>
        <label class="block text-gray-600 mb-1">Keterangan</label>
        <textarea name="keterangan" rows="3"
                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400"></textarea>
      </div>

      <!-- Tombol -->
      <div class="flex justify-between items-center">
        <a href="../dashboard.php" class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">⬅ Kembali</a>
        <button type="submit" name="submit" 
                class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">Simpan</button>
      </div>
    </form>
  </div>
</body>
<script src="../assets/js/script.js"></script>
</html>
