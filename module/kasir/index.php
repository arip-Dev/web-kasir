<?php

// Ambil data produk
$produk = getProduk();

// Proses input barang ke tabel kasir
if (isset($_POST['input_barang'])) {
    $id_barang = $_POST['id_barang'];
    $jumlah = str_replace(["Rp ", ".", ","], "", $_POST['jumlah']);
    $jumlah = is_numeric($jumlah) ? intval($jumlah) : 0;

    $produk_data = getProdukById($id_barang);
    $harga_jual = $produk_data['harga_jual'];
    $total = $harga_jual * $jumlah;

    inputBarangKasir($id_barang, $jumlah, $total);
    
}
// echo '<script src="dots.js"></script>';
// Proses pembayaran
if (isset($_POST['bayar'])) {
    // Hilangkan simbol dan pemisah ribuan
    $bayar = str_replace(["Rp ", ".", ","], "", $_POST['bayar']);

    // Validasi input adalah angka
    if (is_numeric($bayar)) {
        $kembalian = hitungKembalian($bayar);

        if (is_numeric($kembalian)) {
            if ($kembalian >= 0) {
                // Masukkan data ke tabel nota
                masukkanDataNota();
                kurangiStokBarang(); // Kurangi stok barang
                clearDataKasir(); // Hapus data dari tabel kasir
                echo "<script>alert('Kembalian: Rp " . number_format($kembalian, 0, ",", ".") . "');</script>";
            } else {
                echo "<script>alert('Jumlah pembayaran tidak mencukupi.');</script>";
            }
        } else {
            // Jika kembalian bukan angka, tampilkan pesan kesalahan
            echo "<script>alert('$kembalian');</script>";
        }
    } else {
        echo "<script>alert('Input pembayaran harus berupa angka.');</script>";
    }
}

// Proses menghapus data di tabel kasir
if (isset($_POST["clear"])) {
    clearDataKasir();
    echo '<script>alert("Data berhasil dihapus");</script>';
}


?>

<div class="card mt-5 mb-5">
    <div class='row'>
        <div class='col-md-max-width mb-4'>
            <div class='card mb-5'>
                <div class="card-header py-3">
                    <h2 class='mb-0'>Kasir</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-outline mb-4">
                            <label for="id_barang">Nama Barang:</label>
                            <select name="id_barang" class='form-control'>
                                <?php foreach ($produk as $row): ?>
                                    <option value="<?php echo $row['id_barang']; ?>"><?php echo $row['nama_barang']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-outline mb-4">
                            <label for="jumlah">Jumlah:</label>
                            <input type="text" name="jumlah" id="jumlahInput" onkeyup="formatRupiah(this)" required class='form-control'>
                        </div>
                        <br>
                        <input type="submit" name="input_barang" value="Tambahkan ke Kasir"
                            class="btn btn-primary btn-lg btn-block">
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-0">
            <div class="card mb-">
                <div class="card-header py-3">
                    <?php $kasir = getDataKasir(); ?>
                    <h2 class="mb-0">Keranjang</h2>
                </div>
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
                        <?php echo "Total Harga: Rp " . number_format(hitungTotalHarga(), 0, ",", "."); ?>
                    </p>
                    <form method="POST" action="" onsubmit="removeFormat(document.getElementById('bayarInput'));">
                        <br><br>
                        <label for="bayar">Bayar:</label>
                        <input type="text" name="bayar" id="bayarInput" class="form-control" onkeyup="formatRupiahteks(this)"
                            placeholder="Rp ">
                        <br>
                        <input type="submit" name="bayar" value="Bayar" class="btn btn-primary btn-sm">
                        <button name="clear" value="Clear" class="btn btn-primary btn-sm">Clear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function formatRupiahteks(input) {
    var value = input.value;
    value = value.replace(/[^,\d]/g, '').toString();
    var split = value.split(',');
    var sisa = split[0].length % 3;
    var rupiah = split[0].substr(0, sisa);
    var ribuan = split[0].substr(sisa).match(/\d{3}/gi);
    if (ribuan) {
        var separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    input.value = 'Rp ' + rupiah;
}
</script>
<script src="dots.js"></script>
