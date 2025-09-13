<?php
include 'includes/auth.php';
include 'config/db.php';

$user_id = $_SESSION['user_id'];

// Ambil filter tanggal jika ada
$tanggal_awal = $_GET['awal'] ?? '';
$tanggal_akhir = $_GET['akhir'] ?? '';

$where = "WHERE user_id = $user_id";
if($tanggal_awal && $tanggal_akhir){
    $where .= " AND tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
}

// Hitung total pemasukan dan pengeluaran
$sql_pemasukan = mysqli_query($conn, "SELECT SUM(jumlah) as total FROM transaksi $where AND jenis='pemasukan'");
$sql_pengeluaran = mysqli_query($conn, "SELECT SUM(jumlah) as total FROM transaksi $where AND jenis='pengeluaran'");

$total_pemasukan = mysqli_fetch_assoc($sql_pemasukan)['total'] ?? 0;
$total_pengeluaran = mysqli_fetch_assoc($sql_pengeluaran)['total'] ?? 0;
$saldo = $total_pemasukan - $total_pengeluaran;

// Ambil daftar transaksi
$result = mysqli_query($conn, "SELECT * FROM transaksi $where ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-6 text-gray-700 text-center">📊 Laporan Keuangan</h2>

        <!-- Filter Tanggal -->
        <form method="get" class="flex gap-4 mb-6">
            <input type="date" name="awal" value="<?= $tanggal_awal ?>" class="border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400">
            <input type="date" name="akhir" value="<?= $tanggal_akhir ?>" class="border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Filter</button>
        </form>

        <!-- Ringkasan -->
        <div class="grid grid-cols-3 gap-4 mb-6 text-center">
            <div class="bg-green-100 p-4 rounded-lg">
                <p class="text-gray-600">Total Pemasukan</p>
                <p class="font-bold text-green-700">Rp <?= number_format($total_pemasukan,0,',','.') ?></p>
            </div>
            <div class="bg-red-100 p-4 rounded-lg">
                <p class="text-gray-600">Total Pengeluaran</p>
                <p class="font-bold text-red-700">Rp <?= number_format($total_pengeluaran,0,',','.') ?></p>
            </div>
            <div class="bg-yellow-100 p-4 rounded-lg">
                <p class="text-gray-600">Saldo</p>
                <p class="font-bold text-yellow-700">Rp <?= number_format($saldo,0,',','.') ?></p>
            </div>
        </div>

        <!-- Daftar Transaksi -->
        <table class="w-full border border-gray-300 rounded-lg overflow-hidden text-left">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 border-b">Tanggal</th>
                    <th class="px-4 py-2 border-b">Jenis</th>
                    <th class="px-4 py-2 border-b">Kategori</th>
                    <th class="px-4 py-2 border-b">Jumlah</th>
                    <th class="px-4 py-2 border-b">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border-b"><?= $row['tanggal'] ?></td>
                            <td class="px-4 py-2 border-b"><?= ucfirst($row['jenis']) ?></td>
                            <td class="px-4 py-2 border-b"><?= $row['kategori'] ?></td>
                            <td class="px-4 py-2 border-b">Rp <?= number_format($row['jumlah'],0,',','.') ?></td>
                            <td class="px-4 py-2 border-b"><?= $row['keterangan'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center text-gray-500">Tidak ada transaksi</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="mt-6 text-right">
            <button onclick="window.print()" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">🖨️ Cetak Laporan</button>
        </div>
    </div>
</body>
</html>
