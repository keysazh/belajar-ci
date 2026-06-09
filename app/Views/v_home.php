<?php helper('form'); ?> <?= $this->extend('layout') ?>
<?= $this->section('content') ?>   

<?php
if (session()->getFlashData('success')) {
?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}
?>

<div class="row">
    <?php foreach ($products as $key => $item) : ?>         
        <div class="col-lg-6 mb-4"> <?= form_open('keranjang') ?>
            <?= form_hidden([
                'id'    => $item['id'],
                'nama'  => $item['nama'],
                'harga' => $item['harga'],
                'foto'  => $item['foto']
            ]) ?>

            <div class="card">
                <div class="card-body text-center"> <img src="<?= base_url('img/' . $item['foto']) ?>" alt="<?= $item['nama'] ?>" class="img-fluid mb-3" style="max-height: 200px; object-fit: contain;">
                    
                    <h5 class="card-title"><?= $item['nama'] ?><?= number_to_currency($item['harga'], 'IDR') ?></h5>
                    <p class="card-text text-danger fw-bold">Rp <?= number_format($item['harga'], 0, ',', '.') ?></p>
                    
                    <button type="submit" class="btn btn-info rounded-pill">Beli</button>
                </div>
            </div>

            <?= form_open('keranjang') ? form_close() : '' ?> </div> 
    <?php endforeach ?> 
</div>
<?= $this->endSection() ?>