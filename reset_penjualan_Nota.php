<?php
// File: reset_penjualan.php

// Lakukan koneksi database (pastikan sesuai dengan pengaturan koneksi Anda)
include 'function.php'; // Sesuaikan dengan nama file koneksi Anda

// Lakukan query untuk menghapus semua data nota
$sqlResetNota = "DELETE FROM nota";
if ($conn->query($sqlResetNota) === TRUE) {
    echo "success"; // Balasan yang bisa dikenali oleh JavaScript
} else {
    echo "Error: " . $sqlResetNota . "<br>" . $conn->error;
}

// Tutup koneksi database jika perlu
$conn->close();
?>