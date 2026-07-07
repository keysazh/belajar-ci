<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUasFieldsToTransaction extends Migration
{
    public function up()
    {
        // Menambahkan 4 field baru sesuai soal UAS halaman 2
        $this->forge->addColumn('transaction', [
            'biaya_admin' => [
                'type'       => 'DOUBLE',
                'null'       => true,
                'after'      => 'ongkir'
            ],
            'kupon_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'biaya_admin'
            ],
            'diskon_kupon' => [
                'type'       => 'DOUBLE',
                'null'       => true,
                'after'      => 'kupon_code'
            ],
            'cashback' => [
                'type'       => 'DOUBLE',
                'null'       => true,
                'after'      => 'diskon_kupon'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('transaction', ['biaya_admin', 'kupon_code', 'diskon_kupon', 'cashback']);
    }
}