<?php

namespace App\Models; // Declares the namespace for this file which helps in organizing and grouping the classes.

use CodeIgniter\Model; // Imports the base Model class from the CodeIgniter framework.

class MenuModel extends Model // Defines a new class UserModel that extends CodeIgniter's Model class.
{
    protected $table = 'Menu'; // Specifies the database table that this model should interact with.
    protected $primaryKey = 'menu_id'; // Defines the primary key field of the table for CRUD operations.
    // Lists the fields that are allowed to be set using the model. This is for security and prevents mass assignment vulnerabilities.
    protected $allowedFields = ['restaurant_id']; 
    protected $returnType = 'array'; // Sets the default return type of the results. This model will return results as arrays.
}