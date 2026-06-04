<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderDetailsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'order_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'item_id' => [
                'type' => 'INT',
            ],
            'order_details_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            
            ],
            'quantity' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'price' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
        ]);

        $this->forge->addKey('order_details_id', TRUE);
        $this->forge->addForeignKey('order_id', 'Order', 'order_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('item_id', 'Items', 'item_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Order_Details');
    }

    public function down()
    {
        $this->forge->dropTable('Order_Details');
    }
}