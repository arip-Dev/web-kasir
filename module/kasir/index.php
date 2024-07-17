<?php

// Ambil data produk
$produk = getProduk();

// Proses input barang ke tabel kasir
if (isset($_POST['input_barang'])) {
    $id_barang = $_POST['id_barang'];
    $jumlah = $_POST['jumlah'];

    $produk_data = getProdukById($id_barang);
    $harga_jual = $produk_data['harga_jual'];
    $total = $harga_jual * $jumlah;

    inputBarangKasir($id_barang, $jumlah, $total);
    header("Location: index.php?page=kasir");

}

// Proses pembayaran
if (isset($_POST['bayar'])) {
    $bayar = $_POST['bayar'];

    // Validasi input adalah angka
    if (is_numeric($bayar)) {
        $kembalian = hitungKembalian($bayar);

        if (is_numeric($kembalian)) {
            if ($kembalian >= 0) {
                // Masukkan data ke tabel nota
                masukkanDataNota();
                kurangiStokBarang(); // Kurangi stok barang
                clearDataKasir(); // Hapus data dari tabel kasir
                echo "<script>alert('Kembalian: Rp. " . number_format($kembalian, 0, ",", ".") . "');
                window.location.href = 'index.php?page=kasir';</script>";
            } else {
                echo "<script>alert('Jumlah pembayaran tidak mencukupi.');
                window.location.href = 'index.php?page=kasir';</script>";
            }
        } else {
            // Jika kembalian bukan angka, tampilkan pesan kesalahan
            echo "<script>alert('$kembalian');
            window.location.href = 'index.php?page=kasir';</script>";
        }
    } else {
        echo "<script>alert('Input pembayaran harus berupa angka.');
        window.location.href = 'index.php?page=kasir';</script>";
    }
}

// Proses menghapus data di tabel kasir
if (isset($_POST["clear"])) {
    clearDataKasir();
    echo "<script>alert('Data berhasil dihapus');
    window.location.href = 'index.php?page=kasir';</script>";
}

?>

<div class="card mt-5">
    <div class='row'>
        <div class='col-md-12 mb-4'>
            <div class='card mb-4'>
                <div class="card-header py-3">
                    <h2 class='mb-0'>Kasir</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-outline mb-4">
                            <label for="id_barang">Nama Barang:</label>
                            <select id="id_barang" name="id_barang" class="form-control">
                                <?php 
                                $data = mysqli_query($conn,"select * from produk");
                                while($d = mysqli_fetch_array($data)){
                                    ?>
                                    <option value="<?php echo $d['id_barang'] ?>"><?php echo $d['nama_barang'] ?></option>
                                    <?php
                                }
                                ?>				
                            </select>
                        </div>
                        <div class="form-outline mb-4">
                            <label for="jumlah">Jumlah:</label>
                            <input type="number" name="jumlah" id="jumlah" required class='form-control'>
                        </div>
                        <br>
                        <input type="submit" name="input_barang" value="Tambahkan ke Kasir"
                            class="btn btn-primary btn-lg btn-block">
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-4">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <?php $kasir = getDataKasir(); ?>
                    <h2 class="mb-0">Keranjang</h2>
                    <div class="card-body">
                        <div class='table-responsive'>
                            <table class='table'>
                                <tr>
                                    <th>Kode Produk</th>
                                    <th>Nama Barang</th>
                                    <th>Harga Barang</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                </tr>
                                <?php foreach ($kasir as $row): ?>
                                    <tr>
                                        <td>
                                            <?php echo getProdukById($row['id_barang'])['kode_produk']; ?>
                                        </td>
                                        <td>
                                            <?php echo getProdukById($row['id_barang'])['nama_barang']; ?>
                                        </td>
                                        <td>
                                            <?php echo "Rp " . number_format(getProdukById($row['id_barang'])['harga_jual'], 0, ",", "."); ?>
                                        </td>
                                        <td>
                                            <?php echo $row['jumlah']; ?>
                                        </td>
                                        <td>
                                            <?php echo "Rp " . number_format($row['total'], 0, ",", "."); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                        <p class='text-right'>
                            <?php echo "Rp. " . number_format(hitungTotalHarga(), 0, ",", "."); ?>
                        </p>
                    </div>
                    <form method="POST" action="" onsubmit="removeFormat(document.getElementById('bayarInput'));">
                        <br><br>
                        <label for="bayarInput">Bayar:</label>
                        <input type="text" name="bayar" id="bayarInput" class="form-control" onkeyup="formatRupiahteks(this)" placeholder="Rp. ">
                        <br>
                        <input type="submit" value="Bayar" class="btn btn-primary btn-sm">
                        <button name="clear" value="Clear" class="btn btn-primary btn-sm">Clear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>