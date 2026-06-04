<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMenuCategoryTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'category_id' => [
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
            'menu_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);
        $this->forge->addKey('category_id', TRUE);
        $this->forge->addForeignKey('restaurant_id', 'Restaurant', 'restaurant_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('menu_id', 'Menu', 'menu_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Category');
    }

    public function down()
    {
        $this->forge->dropTable('Category');
    }
}
