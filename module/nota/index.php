<?php
// Inisialisasi variabel
$result = null;
$totalKeuntungan = 0;
$rows = [];
$tanggal = null;

// Mendapatkan tanggal hari ini
$tanggalHariIni = date('Y-m-d');

// Cek jika terdapat parameter tanggal pada URL
if (isset($_GET['tanggal'])) {
    $tanggal = $_GET['tanggal'];
    // Menggunakan prepared statements untuk keamanan SQL injection
    $stmt = $conn->prepare("SELECT nota.*, produk.harga_beli, produk.harga_jual 
                            FROM nota 
                            JOIN produk ON nota.id_barang = produk.id_barang
                            WHERE nota.tgl_input = ?");
    $stmt->bind_param("s", $tanggal);
} else {
    // Mengambil data dari 30 hari kebelakang hingga hari ini
    $tanggalAwal = date('Y-m-d', strtotime('-30 days'));
    $tanggalAkhir = $tanggalHariIni;

    $stmt = $conn->prepare("SELECT nota.*, produk.harga_beli, produk.harga_jual 
                            FROM nota 
                            JOIN produk ON nota.id_barang = produk.id_barang
                            WHERE nota.tgl_input BETWEEN ? AND ?
                            ORDER BY nota.tgl_input DESC");
    $stmt->bind_param("ss", $tanggalAwal, $tanggalAkhir);
}

$stmt->execute();
$result = $stmt->get_result();

// Menghitung total keuntungan per tanggal
// Menghitung total keuntungan dan total modal per tanggal
$totalKeuntungan = 0;
$totalModal = 0;
while ($row = $result->fetch_assoc()) {
    $keuntungan = $row['harga_jual'] - $row['harga_beli'];
    $totalKeuntungan += $keuntungan;
    $totalModal += $row['harga_beli']; // Menambahkan harga_beli ke total modal
    $row['keuntungan'] = $keuntungan;
    $rows[] = $row;
    // Menyimpan tanggal terbaru
    if ($tanggal === null) {
        $tanggal = $row['tgl_input'];
    }
}
$stmt->close();
?>
<!--/grey-card -->
<div class="col-md-4 mb-3">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h6 class="pt-2"><i class="bi bi-shop mr-2"></i> Keuntungan bulan ini</h6>
        </div>
        <div class="card-body">
            <center>
                <h1>Rp <?= htmlspecialchars(number_format($totalKeuntungan, 0, ',', '.')) ?></h1>
            </center>
        </div>
    </div>
</div>
<div class="card mt-5">
    <div class="card-header">
        <h2>Tabel Nota</h2>
    </div>
    <div class="card-body">
        <p>Cari nota berdasarkan tanggal input:</p>
        <!-- Form input tanggal -->
        <form method="GET" action="index.php" class="row g-3">
            <input type="hidden" name="page" value="nota">
            <div class="col-auto">
                <input type="date" name="tanggal" id="tanggal" class="form-control" required>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>
        <br>
        <?php if ($tanggal !== null && !empty($rows)): ?>
            <h5 class='text-right'>
                <?= htmlspecialchars($tanggal) ?>
            </h5>
        <?php endif; ?>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Tanggal Input</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Harga Beli</th>
                    <th scope="col">Harga Jual</th>
                    <th scope="col">Keuntungan</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php if (!empty($rows)): ?>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= htmlspecialchars($row['tgl_input']) ?></td>
                            <td><?= htmlspecialchars(getProdukById($row['id_barang'])['nama_barang']) ?></td>
                            <td><?= htmlspecialchars(number_format($row['jumlah'], 0, ',', '.')) ?></td>
                            <td><?= htmlspecialchars(number_format($row['harga_beli'], 0, ',', '.')) ?></td>
                            <td><?= htmlspecialchars(number_format($row['harga_jual'], 0, ',', '.')) ?></td>
                            <td><?= htmlspecialchars(number_format($row['keuntungan'], 0, ',', '.')) ?></td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th>Total Modal</th>
                    <td><?= htmlspecialchars(number_format($totalModal, 0, ',', '.')) ?></td>
                    <th>Total Keuntungan</th>
                    <td><?= htmlspecialchars(number_format($totalKeuntungan, 0, ',', '.')) ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>