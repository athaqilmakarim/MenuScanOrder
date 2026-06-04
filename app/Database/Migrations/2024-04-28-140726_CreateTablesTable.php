<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTablesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'tables_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'tables_number' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'restaurant_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
        ]);
        $this->forge->addKey('tables_id', TRUE);
        $this->forge->addForeignKey('restaurant_id', 'Restaurant', 'restaurant_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Tables');
    }

    public function down()
    {
        $this->forge->dropTable('Tables');
    }
}
