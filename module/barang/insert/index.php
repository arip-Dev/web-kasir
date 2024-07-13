<?php

// cek apakah tombol submit sudah ditekan
if (isset($_POST['submit'])) {
    // cek apakah gambar sudah diupload
    if (add_produk($_POST) > 0) {
        echo "<script>
        alert('Berhasil menambahkan produk!');
        window.location.href = 'index.php?page=barang';
        </script>";
    } else {
        echo "<script>
        alert('Gagal menambahkan produk!, Kode Produk sudah ada');
        window.location.href = 'index.php?page=barang';
        </script>";
    }
}
echo '<script src="dots.js"></script>';
?>

<a href="index.php?page=barang" class="btn btn-primary mb-3"><i class="bi bi-chevron-left"></i> Kembali</a>
<div class="card card-body">
    <div class="table-responsive">
        <table class="table table-striped">
            <h2>Tambah Barang</h2>
            <form action="" method="POST">
                <tr>
                    <td><label for="kode_produk">Kode Produk:</label></td>
                    <td><input type="int" name="kode_produk" class="form-control "required=""></td>
                </tr>
                <tr>
                    <td><label for="nama_barang">Nama Barang:</label></td>
                    <td><input type="text" name="nama_barang" class="form-control "required=""></td>
                </tr>
                <tr>
                    <td><label for="stok">Stok:</label></td>
                    <td><input type="text" name="stok" onkeyup="formatRupiah(this)" class="form-control "required=""></td>
                </tr>
                <tr>
                    <td><label for="harga_jual">Harga Jual:</label></td>
                    <td><input type="text" name="harga_jual" onkeyup="formatRupiah(this)" class="form-control "required=""></td>
                </tr>
                <tr>
                    <td><label for="harga_beli">Harga Beli:</label></td>
                    <td><input type="text" name="harga_beli" onkeyup="formatRupiah(this)" class="form-control "required=""></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name='submit' value="Update" class="btn btn-primary"></td>
                </tr>
            </form>
        </table>
    </div>
</div>