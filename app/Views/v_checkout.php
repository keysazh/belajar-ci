<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-6">
        <?= form_open('buy', 'class="row g-3"') ?>

        <?= form_hidden('username', session()->get('username')) ?>
        <?= form_hidden(['name' => 'total_harga', 'id' => 'total_harga', 'value' => '']) ?>

        <div class="col-12">
            <?= form_label('Nama', 'nama', ['class' => 'form-label']) ?>
            <?= form_input([
                'name'     => 'nama',
                'id'       => 'nama',
                'class'    => 'form-control',
                'value'    => session()->get('username'),
                'readonly' => true]) ?>
        </div>
        <div class="col-12">
            <?= form_label('Alamat', 'alamat', ['class' => 'form-label']) ?>
            <?= form_input([
                'name'  => 'alamat',
                'id'    => 'alamat',
                'class' => 'form-control']) ?>
        </div> 
        
        <div class="col-12"> 
            <?= form_label('Kelurahan', 'kelurahan', ['class' => 'form-label']) ?>
            <?= form_dropdown('kelurahan', ['' => 'Cari daerah tujuan'], '', [
                'id'    => 'kelurahan', 
                'class' => 'form-control'
            ]) ?>
        </div>

        <div class="col-12"> 
            <?= form_label('Layanan', 'layanan', ['class' => 'form-label']) ?> 
            <?= form_dropdown('layanan', [], '', ['id' => 'layanan', 'class' => 'form-control']) ?>
        </div>

        <div class="col-12">
            <?= form_label('Kode Kupon Promo', 'kupon_code', ['class' => 'form-label', 'style' => 'font-weight: bold; color: #0d6efd;']) ?>
            <?= form_input([
                'name'        => 'kupon_code',
                'id'          => 'kupon_code',
                'class'       => 'form-control',
                'placeholder' => 'Masukkan kode kupon (Contoh: HEMAT / SUPER)'
            ]) ?>
        </div>

        <div class="col-12">
            <?= form_label('Ongkir', 'ongkir', ['class' => 'form-label']) ?>
            <?= form_input([
                'name'     => 'ongkir',
                'id'       => 'ongkir',
                'class'    => 'form-control',
                'readonly' => true]) ?>
        </div>
        <div class="col-12">
            <?= form_submit(
                'submit',
                'Buat Pesanan',
                ['class' => 'btn btn-primary w-100']) ?>
        </div>

        <?= form_close() ?> 
    </div>
    
    <div class="col-lg-6">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nama</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Sub Total</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (!empty($items)) :
                    foreach ($items as $index => $item) :
                ?>
                        <tr>
                            <td><?= $item['name'] ?></td>
                            <td><?= number_to_currency($item['price'], 'IDR') ?></td>
                            <td><?= $item['qty'] ?></td>
                            <td><?= number_to_currency($item['price'] * $item['qty'], 'IDR') ?></td>
                        </tr>
                <?php
                    endforeach;
                endif;
                ?>
                <tr>
                    <td colspan="2"></td>
                    <td>Subtotal murni</td>
                    <td><?= number_to_currency($total, 'IDR') ?></td>
                </tr>
                
                <?php 
                    // Simpan data kalkulasi awal dari backend
                    $resDiskon = hitung_diskon($total); 
                ?>
                
                <tr>
                    <td colspan="2"></td>
                    <td>Diskon Kupon</td>
                    <td style="color: red; font-weight: bold;">
                        <span id="v_diskon_kupon">-IDR 0</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td>Biaya Admin</td>
                    <td style="color: green; font-weight: bold;">
                        <span id="v_biaya_admin">IDR 0</span>
                    </td>
                </tr>
                <tr class="table-info">
                    <td colspan="2"></td>
                    <td>Cashback</td>
                    <td style="color: blue; font-weight: bold;">
                        <span id="v_cashback">IDR 0</span>
                    </td>
                </tr>
                
                <tr class="table-dark">
                    <td colspan="2"></td>
                    <td><strong>Grand Total</strong></td>
                    <td><strong id="v_grand_total">IDR 0</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    if (typeof jQuery !== 'undefined') {
        
        // Daftarkan event change ongkir agar input dibaca real-time ke sistem
        jQuery("#layanan").on('change', function() {
            var cost = parseInt(jQuery(this).val()) || 0;
            jQuery("#ongkir").val(cost);
            hitungTotal();
        });

        // Trigger hitung pertama kali
        hitungTotal();

        function hitungTotal() {
            var subtotal = <?= $total ?>; 
            var ongkir = parseInt(jQuery("#ongkir").val()) || 0;
            var kupon = jQuery("#kupon_code").val().toUpperCase(); 

            var diskon_kupon = 0;
            var biaya_admin = 0;
            var cashback = 0;

            // 1. LOGIKA DISKON KUPON
            if (kupon === 'HEMAT') {
                diskon_kupon = subtotal * 0.15; 
            } else if (kupon === 'SUPER') {
                diskon_kupon = subtotal * 0.20; 
            }

            // 2. LOGIKA BIAYA ADMIN
            if (subtotal > 20000000) {
                biaya_admin = subtotal * 0.0075; 
            } else {
                biaya_admin = subtotal * 0.005; 
            }

            // 3. LOGIKA CASHBACK
            if (subtotal > 10000000) {
                cashback = subtotal * 0.02; 
            }

            // 4. HITUNG GRAND TOTAL AKHIR BERSIH
            var grand_total = (subtotal - diskon_kupon + Math.round(biaya_admin)) + ongkir;

            // 5. UPDATE ELEMENT VALUE KE HIDDEN FIELD FORM AGAR DATA YANG MASUK DB VALID
            jQuery("#total_harga").val(grand_total);

            // 6. UPDATE TAMPILAN TEXT DI LAYAR
            jQuery("#v_diskon_kupon").text("-IDR " + Math.round(diskon_kupon).toLocaleString('id-ID'));
            jQuery("#v_biaya_admin").text("+IDR " + Math.round(biaya_admin).toLocaleString('id-ID'));
            jQuery("#v_cashback").text("IDR " + Math.round(cashback).toLocaleString('id-ID'));
            jQuery("#v_grand_total").text("IDR " + grand_total.toLocaleString('id-ID'));
        }

        // Jalankan fungsi hitung setiap kali kolom kupon diketik
        jQuery("#kupon_code").on('input', function() {
            hitungTotal();
        });

        // Fitur pencarian AJAX Kelurahan
        if (jQuery('#kelurahan').hasClass("select2-hidden-accessible")) {
            jQuery('#kelurahan').select2('destroy');
        }

        jQuery('#kelurahan').select2({
            placeholder: 'Cari daerah tujuan',
            minimumInputLength: 3,
            ajax: {
                url: '<?= base_url('ajax/destinations') ?>',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { q: params.term };
                },
                processResults: function (data) {
                    return { results: data.results };
                },
                cache: true
            }
        });
        
        jQuery("#kelurahan").on('change', function () {
            let id_kelurahan = jQuery(this).val();

            jQuery("#layanan").empty();
            jQuery("#layanan").append($('<option>', { value: 0, text: '-- Pilih Layanan --' }));
            jQuery("#ongkir").val(0);
            hitungTotal(); 

            jQuery.ajax({
                url: "<?= site_url('ajax/costs') ?>", 
                dataType: "json",
                data: { destination: id_kelurahan },
                success: function (data) { 
                    data.forEach(function (item) {
                        jQuery("#layanan").append(
                            jQuery('<option>', {
                                value: item.cost,
                                text: `${item.description} (${item.service}) : estimasi ${item.etd}`
                            })
                        );
                    });
                }
            });
        });
    }
});
</script>
<?= $this->endSection() ?>