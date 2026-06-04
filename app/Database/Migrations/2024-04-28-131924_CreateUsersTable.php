<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserTable extends Migration
{
    public function up()
    {
        // Define the User table with an additional password field
        $this->forge->addField([
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'unique' => TRUE, // ensuring email is unique
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ]
        ]);
        
        $this->forge->addKey('user_id', TRUE); // Set user_id as the primary key
        $this->forge->createTable('User', TRUE); // Create the User table if it doesn't already exist
    }

    public function down()
    {
        // Drop the User table if needed
        $this->forge->dropTable('User');
    }
}