<?php
include 'includes/auth.php';
include 'config/db.php';

// cek login
$user_id = $_SESSION['user_id'];

// Hitung saldo
$sql_pemasukan   = mysqli_query($conn, "SELECT SUM(jumlah) as total FROM transaksi WHERE user_id = $user_id AND jenis='pemasukan'");
$sql_pengeluaran = mysqli_query($conn, "SELECT SUM(jumlah) as total FROM transaksi WHERE user_id = $user_id AND jenis='pengeluaran'");

$row_pemasukan   = mysqli_fetch_assoc($sql_pemasukan);
$row_pengeluaran = mysqli_fetch_assoc($sql_pengeluaran);

$total_pemasukan   = $row_pemasukan['total'] ?? 0;
$total_pengeluaran = $row_pengeluaran['total'] ?? 0;

$saldo = $total_pemasukan - $total_pengeluaran;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
  <!-- Navbar -->
  <div class="bg-blue-600 text-white px-6 py-4 flex justify-between items-center shadow-md">
    <h1 class="text-xl font-bold">Keuangan Pribadi</h1>
    <div>
      <span class="mr-4">👋 Halo, <?php echo $_SESSION['username']; ?></span>
      <a href="logout.php" class="bg-red-500 px-3 py-1 rounded hover:bg-red-600">Logout</a>
    </div>
  </div>

  <!-- Container -->
  <div class="max-w-6xl mx-auto p-6">
    <!-- Ringkasan -->
    <h2 class="text-2xl font-semibold mb-4">Ringkasan Keuangan</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <div class="bg-white p-6 rounded-lg shadow text-center">
        <h3 class="text-gray-500">Saldo</h3>
        <p class="text-2xl font-bold text-green-600">Rp <?php echo number_format($saldo,0,',','.'); ?></p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow text-center">
        <h3 class="text-gray-500">Pemasukan</h3>
        <p class="text-2xl font-bold text-blue-600">Rp <?php echo number_format($total_pemasukan,0,',','.'); ?></p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow text-center">
        <h3 class="text-gray-500">Pengeluaran</h3>
        <p class="text-2xl font-bold text-red-600">Rp <?php echo number_format($total_pengeluaran,0,',','.'); ?></p>
      </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="mb-4 flex gap-4">
      <a href="transaksi/tambah.php" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">+ Tambah Transaksi</a>
      <a href="laporan.php" class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700">Lihat Laporan</a>
    </div>

    <!-- Tabel Transaksi -->
    <div class="bg-white rounded-lg shadow overflow-x-auto">
      <table class="w-full border-collapse">
        <thead class="bg-gray-200">
          <tr>
            <th class="p-3 text-left">Tanggal</th>
            <th class="p-3 text-left">Jenis</th>
            <th class="p-3 text-left">Kategori</th>
            <th class="p-3 text-left">Jumlah</th>
            <th class="p-3 text-left">Keterangan</th>
            <th class="p-3 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $result = $conn->query("SELECT * FROM transaksi WHERE user_id='$user_id' ORDER BY tanggal DESC");
          while ($row = $result->fetch_assoc()) {
              echo "<tr class='border-b hover:bg-gray-50'>
                      <td class='p-3'>".$row['tanggal']."</td>
                      <td class='p-3 capitalize'>".$row['jenis']."</td>
                      <td class='p-3'>".$row['kategori']."</td>
                      <td class='p-3 font-semibold'>Rp ".number_format($row['jumlah'],0,',','.')."</td>
                      <td class='p-3'>".$row['keterangan']."</td>
                      <td class='p-3 text-center'>
                        <a href='transaksi/edit.php?id=".$row['id']."' class='text-blue-600 hover:underline'>Edit</a> | 
                        <a href='transaksi/hapus.php?id=".$row['id']."' onclick=\"return confirm('Yakin hapus?')\" class='text-red-600 hover:underline'>Hapus</a>
                      </td>
                    </tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
