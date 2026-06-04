<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'tables_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'order_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);
        $this->forge->addKey('order_id', TRUE);
        $this->forge->addForeignKey('tables_id', 'Tables', 'tables_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Order');
    }

    public function down()
    {
        $this->forge->dropTable('Order');
    }
}
