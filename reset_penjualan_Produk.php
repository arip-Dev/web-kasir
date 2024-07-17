<?php
// File: reset_penjualan.php

// Lakukan koneksi database (pastikan sesuai dengan pengaturan koneksi Anda)
include 'function.php'; // Sesuaikan dengan nama file koneksi Anda

// Lakukan query untuk menghapus semua data produk
$sqlResetProduk = "DELETE FROM produk";
if ($conn->query($sqlResetProduk) === TRUE) {
    echo "success"; // Balasan yang bisa dikenali oleh JavaScript
} else {
    echo "Error: " . $sqlResetProduk . "<br>" . $conn->error;
}

// Tutup koneksi database jika perlu
$conn->close();
?>