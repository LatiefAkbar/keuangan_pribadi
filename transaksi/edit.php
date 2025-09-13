<?php
include '../includes/auth.php';
include '../config/db.php';

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// ambil data transaksi lama
$result = mysqli_query($conn, "SELECT * FROM transaksi WHERE id='$id' AND user_id='$user_id'");
$data = mysqli_fetch_assoc($result);

if(!$data){
    die("Data tidak ditemukan atau bukan milik Anda");
}

if(isset($_POST['submit'])){
    $tanggal   = $_POST['tanggal'];
    $jenis     = $_POST['jenis'];
    $kategori  = $_POST['kategori'];
    $jumlah    = $_POST['jumlah'];
    $keterangan= $_POST['keterangan'];

    $query = "UPDATE transaksi 
              SET tanggal='$tanggal', jenis='$jenis', kategori='$kategori', jumlah='$jumlah', keterangan='$keterangan' 
              WHERE id='$id' AND user_id='$user_id'";

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
  <title>Edit Transaksi</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
  <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-lg">
    <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">✏️ Edit Transaksi</h2>

    <form method="post" class="space-y-4">
      <!-- Tanggal -->
      <div>
        <label class="block text-gray-600 mb-1">Tanggal</label>
        <input type="date" name="tanggal" value="<?php echo $data['tanggal']; ?>" 
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
      </div>

      <!-- Jenis -->
      <div>
        <label class="block text-gray-600 mb-1">Jenis</label>
        <select name="jenis" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
          <option value="pemasukan" <?php if($data['jenis']=="pemasukan") echo "selected"; ?>>Pemasukan</option>
          <option value="pengeluaran" <?php if($data['jenis']=="pengeluaran") echo "selected"; ?>>Pengeluaran</option>
        </select>
      </div>

      <!-- Kategori -->
      <div>
        <label class="block text-gray-600 mb-1">Kategori</label>
        <input type="text" name="kategori" value="<?php echo $data['kategori']; ?>" 
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
      </div>

      <!-- Jumlah -->
      <div>
        <label class="block text-gray-600 mb-1">Jumlah</label>
        <input type="text" id="jumlah" name="jumlah" value="<?php echo $data['jumlah']; ?>" 
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
      </div>

      <!-- Keterangan -->
      <div>
        <label class="block text-gray-600 mb-1">Keterangan</label>
        <textarea name="keterangan" rows="3"
                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"><?php echo $data['keterangan']; ?></textarea>
      </div>

      <!-- Tombol -->
      <div class="flex justify-between items-center">
        <a href="../dashboard.php" class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">⬅ Kembali</a>
        <button type="submit" name="submit" 
                class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">Update</button>
      </div>
    </form>
  </div>
</body>
<script src="../assets/js/script.js"></script>
</html>
