<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'User';
    protected $primaryKey = 'user_id';
    protected $allowedFields = ['name', 'email', 'status', 'isAdmin'];
    protected $returnType = 'array';

    public function getAllUsers()
    {
        return $this->findAll();
    }
}