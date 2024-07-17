<?php
// query produk
$sqlStok = "SELECT SUM(stok) AS total_stok FROM produk";
$resultStok = $conn->query($sqlStok);

// query nota
$sqlNota = "SELECT SUM(total) AS total_nota FROM nota";
$resultNota = $conn->query($sqlNota);

// query kasir
$sqlKasir = "SELECT COUNT(*) AS sum_nota FROM nota";
$resultKasir = $conn->query($sqlKasir);
echo '<script src="reset.js"></script>';
?>
<div class="badan">
    <h2>Dashboard</h2>
    <br>
    <?php if ($resultStok && $resultKasir && $resultNota) {

        // Ambil nilai total stok produk
        $rowStok = $resultStok->fetch_assoc();
        $totalStok = $rowStok['total_stok'];

        // Ambil nilai banyaknya query kasir
        $rowKasir = $resultKasir->fetch_assoc();
        $totalKasir = $rowKasir['sum_nota'];

        // Ambil nilai total nota
        $rowNota = $resultNota->fetch_assoc();
        $totalNota = isset($rowNota['total_nota']) ? $rowNota['total_nota'] : 0;
        ?>
        <div class="d-flex flex-row bd-highlight mb-3">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h6 class="pt-2"><i class="bi bi-basket2-fill mr-2"></i> Stok Barang</h6>
                    </div>
                    <div class="card-body">
                <center>
                    <h1>
                        <?= $totalStok > 0 ? $totalStok : 0 ?>
                    </h1>
                </center>
            </div>
            <div class="card-footer">
                <a href='index.php?page=barang'>Tabel Barang</a>
                <button type="button" class="btn btn-danger" onclick="hapusDataProduk()">Hapus Data Produk</button>
            </div>
                </div>
            </div>
            <!--/grey-card -->
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h6 class="pt-2"><i class="bi bi-shop mr-2"></i> Penjualan</h6>
                    </div>
                    <div class="card-body">
                        <center>
                            <h1>
                                <?= $totalKasir ?>
                            </h1>
                        </center>
                    </div>
                    <div class="card-footer">
                        <a href='index.php?page=kasir'>Kasir </a>
                    </div>
                </div>
            </div>
            <!--/grey-card -->
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h6 class="pt-2"><i class="bi bi-cash-stack mr-2"></i> Pendapatan</h6>
                    </div>
                    <div class="card-body">
                        <center>
                            <h1 class="font-weight-bold">
                                Rp
                                <?= number_format($totalNota, 0, ",", ".") ?>
                            </h1>
                        </center>
                    </div>
                    <div class="card-footer">
                        <a href='index.php?page=nota'>Tabel Nota</a>
                        <button type="button" class="btn btn-danger" onclick="hapusDataNota()">Hapus Data Nota</button>
                    </div>
                </div>
            </div>
            <!--/grey-card -->
        </div>
    <?php } ?>
</div>