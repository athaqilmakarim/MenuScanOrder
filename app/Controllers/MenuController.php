<?php namespace App\Controllers;
use CodeIgniter\Models;
use CodeIgniter\Controller;
use App\Models\RestaurantModel;
use App\Models\TableModel;
use App\Models\OrdersModel;
use App\Models\UserModel;

class MenuController extends BaseController
{
    public function __construct()
    {
        // Load the URL helper, it will be useful in the next steps
        // Adding this within the __construct() function will make it 
        // available to all views in the ResumeController
        helper('url'); 
    }

    public function index()
    {
        return view('landing_page');
    }

    public function login_page()
    {
        return view('login_page');
    }

    public function menu_page($id)
    {
        $session = session();
        $userId = $session->get('userId');  // This retrieves the userId from the session
        return view('menu_page', ['userId' => $userId]);
    }
    
    public function order_management($id)
{
    $session = session();
    $userId = $session->get('userId');

    $restaurantModel = new \App\Models\RestaurantModel();
    $restaurantId = $restaurantModel->where('user_id', $id)->first();

    $tableModel = new TableModel();
    $tables = $tableModel->where('restaurant_id', $restaurantId['restaurant_id'])->findAll();

    // Extract table IDs and names
    $tableIds = [];
    $tableNames = [];
    foreach ($tables as $table) {
        $tableIds[] = $table['tables_id'];
        $tableNames[$table['tables_id']] = $table['tables_number']; // Store table names indexed by table ID
    }

    $orderModel = new OrdersModel();
    // Query orders by table IDs
    $orders = $orderModel->whereIn('tables_id', $tableIds)->findAll();

    // Attach table names to each order
    foreach ($orders as $key => $order) {
        if (isset($tableNames[$order['tables_id']])) {
            $orders[$key]['tables_number'] = $tableNames[$order['tables_id']];
        } else {
            $orders[$key]['tables_number'] = 'Unknown'; // Default in case there's no matching table name
        }
    }

    // Pass orders to the view
    return view('order_management', ['orders' => $orders, 'userId' => $userId]);
}

    public function user_menu($id)
    {
        $tableModel = new \App\Models\TableModel();
        $restaurant = $tableModel->where('tables_id',$id)->first();
        $restaurantModel = new \App\Models\RestaurantModel();
        $restaurantId = $restaurantModel->where('restaurant_id', $restaurant['restaurant_id'])->first();

    
        return view('user_menu',['userId' => $restaurantId['user_id'], 'tableId' => $id]);
    }

    public function restaurant_page($id)
    {
        $session = session();
        $userId = $session->get('userId');  // Correct way to get session data


        return view('restaurant_page', ['userId' => $userId , ]);
    }

    public function create_category($id)
    {
        $session = session();
        $userId = $session->get('userId');  // Correct way to get session data
        return view('create_category', ['userId' => $userId]);
    }

    public function create_table($id)
    {
        $session = session();
        $userId = $session->get('userId');
        $restaurantModel = new RestaurantModel;
        $restaurant = $restaurantModel->where('user_id',$userId)->first();  // Correct way to get session data
        return view('create_table', ['userId' => $userId, 'restoId' => $restaurant["restaurant_id"]]);
    }

    public function admin_page()
    {
        $model = new UserModel();
        $data['users'] = $model->getAllUsers();

        return view('admin_page', $data); // Use return instead of echo for better practice in CI4
    }

    public function updateUser()
{
    $session = session();
    if (!$session->get('isLoggedIn') || $session->get('userRole') != 'admin') {
        return redirect()->to('/login'); // Ensure only admins can perform this action
    }

    $userId = $this->request->getVar('userId');
    $userName = $this->request->getVar('userName');

    $userModel = new UserModel();
    if ($userModel->update($userId, ['name' => $userName])) {
        return $this->response->setJSON(['status' => 'success', 'message' => 'User name updated successfully']);
    } else {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to update user name']);
    }
}
}