function hapusDataNota() {
    if (confirm('Anda yakin ingin menghapus semua data nota?')) {
        // Buat permintaan AJAX ke server
        fetch('reset_penjualan_Nota.php', {
            method: 'POST',
        })
        .then(response => response.text())
        .then(data => {
            if (data.trim() === "success") {
                alert('Data nota berhasil dihapus.');
                window.location.reload();
            } else {
                alert('Terjadi kesalahan saat menghapus data nota.');
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan koneksi.');
            console.error('Error:', error);
        });
    }
}
function hapusDataProduk() {
    if (confirm('Anda yakin ingin menghapus semua data Produk?')) {
        // Buat permintaan AJAX ke server
        fetch('reset_penjualan_Produk.php', {
            method: 'POST',
        })
        .then(response => response.text())
        .then(data => {
            if (data.trim() === "success") {
                alert('Data Produk berhasil dihapus.');
                window.location.reload();
            } else {
                alert('Terjadi kesalahan saat menghapus data Produk.');
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan koneksi.');
            console.error('Error:', error);
        });
    }
}

