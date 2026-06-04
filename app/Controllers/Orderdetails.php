<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\OrderDetailsModel;
use App\Models\OrdersModel;

class Orderdetails extends ResourceController
{
    use ResponseTrait;

    /**
     * Handle POST requests to create a new order entry.
     */
    public function create()
{
    $json = $this->request->getJSON();  // Ensures this returns stdClass objects

    if (!isset($json->order_id) || !isset($json->items)) {
        return $this->failValidationError('Missing required fields: order_id or items');
    }

    $orderDetailsModel = new OrderDetailsModel();

    // Create order details
    foreach ($json->items as $item) {
        if (!isset($item->item_id) || !isset($item->quantity) || !isset($item->price)) {
            continue; // Skip improperly defined items
        }
        $orderDetailsModel->insert([
            'order_id' => $json->order_id,
            'item_id' => $item->item_id,
            'quantity' => $item->quantity,
            'price' => $item->price
        ]);
    }

    return $this->respondCreated('Order details created successfully for Order ID: ' . $json->order_id);
}

    public function show($id = null)
    {
        $orderDetailsModel = new OrderDetailsModel();
        $ordersModel = new OrdersModel();
    
        // Check if an order with the specified ID exists.
        $order = $ordersModel->find($id);
        if (!$order) {
            // Return a 404 error if no such order is found.
            return $this->failNotFound("No order found with ID: {$id}");
        }
    
        // Retrieve all order details.
        $orderDetails = $orderDetailsModel->select('Order_Details.*, Items.name as item_name, Items.price as item_price')
                                      ->join('Items', 'Items.item_id = Order_Details.item_id')
                                      ->where('Order_Details.order_id', $id)
                                      ->findAll();
    
        // Check if any order details were found.
        if (!empty($orderDetails)) {
            return $this->respond($orderDetails);
        } else {
            // Return a 404 error if no order details are found for the given order ID.
            return $this->failNotFound("No details found for order ID: {$id}");
        }
    }
}