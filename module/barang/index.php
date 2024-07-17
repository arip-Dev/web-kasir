<div class="card mt-5">
    <div class="card-header">
        <h2>Tabel Barang</h2>
        <a class="btn btn-primary mb-2" href="index.php?page=barang/insert"><i class="bi bi-plus-square"></i>
            Insert produk</a>
    </div>

    <div class="card-body">
        <table class="table table-hover" id="example">
            <thead>
                <tr>
                <th scope="col">ID Barang</th>
                    <th scope="col">Kode Produk</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Stok</th>
                    <th scope="col">Harga Jual</th>
                    <th scope="col">Harga Beli</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $sql = "SELECT * FROM produk";
                $result = $conn->query($sql);
                ?>
                <?php if ($result) { ?>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $row['id_barang']   ?></td>
                            <td><?= $row['kode_produk'] ?></td>
                            <td><?= $row['nama_barang'] ?></td>
                            <td><?= number_format($row['stok'], 0, '', '.')        ?></td>
                            <td><?= number_format($row['harga_jual'], 0, '', '.') ?></td>
                            <td><?= number_format($row['harga_beli'], 0, '', '.') ?></td>
                            <td>
                                <!-- Form untuk tombol Edit -->
                                <form action="index.php" method="get" style="display:inline;">
                                    <input type="hidden" name="page" value="barang/edit">
                                    <input type="hidden" name="id_barang" value="<?= $row['id_barang'] ?>">
                                    <button type="submit" class="btn btn-primary">Edit</button>
                                </form>

                                <!-- Form untuk tombol Delete -->
                                <form action="index.php" method="get" style="display:inline;" onsubmit="return confirm('Hapus Data Produk ?');">
                                    <input type="hidden" name="page" value="barang/delete">
                                    <input type="hidden" name="id_barang" value="<?= $row['id_barang'] ?>">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

