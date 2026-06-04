<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMenuTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'menu_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'restaurant_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
        ]);
        $this->forge->addKey('menu_id', TRUE);
        $this->forge->addForeignKey('restaurant_id', 'Restaurant', 'restaurant_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Menu');
    }

    public function down()
    {
        $this->forge->dropTable('Menu');
    }
}
