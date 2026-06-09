
<h1>Data Produk</h1>

<table border="1" width="100%" cellpadding="5" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Harga</th>
        <th>Jumlah</th>
        <th>Foto</th>
    </tr>

    <?php foreach ($products as $index => $produk) : ?>
    <?php
        $base64 = '';
        if (!empty($produk['foto'])) {
            $path = FCPATH . 'img/' . $produk['foto'];
            $type = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            
            // PENGAMAN: Dompdf sering crash jika memproses format webp secara langsung.
            // Kita hanya izinkan format umum seperti jpg, jpeg, dan png.
            if ($type !== 'webp' && file_exists($path) && is_file($path)) {
                $data = @file_get_contents($path);
                if ($data !== false) {
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                }
            }
        }
    ?>
        <tr>
            <td align="center"><?= $index + 1 ?></td>
            <td><?= $produk['nama'] ?></td>
            <td align="right">Rp <?= number_format($produk['harga'], 0, ",", ".") ?></td>
            <td align="center"><?= $produk['jumlah'] ?></td>
            <td align="center">
<?php
$imgPath = FCPATH . 'img/' . $produk['foto'];

if (file_exists($imgPath)) :
?>
    <img src="<?= $imgPath ?>" width="50" height="50">
<?php endif; ?>
</td>
        </tr>
    <?php endforeach; ?>
</table>

<p><small>Downloaded on: <?= date("Y-m-d H:i:s") ?></small></p>