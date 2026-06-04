<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Admin extends Controller
{
    public function index()
    {
        $model = new UserModel();
        $data['users'] = $model->getAllUsers(); // Fetch all users

        echo view('admin_page', $data);
    }
}