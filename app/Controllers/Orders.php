<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\OrdersModel;

class Orders extends ResourceController
{
    use ResponseTrait;

    /**
     * Handle POST requests to create a new order entry.
     */
    public function create()
    {
        // Initialize the model first
        $model = new OrdersModel();

        // Retrieve data from the POST request
        $data = $this->request->getJSON(true);

        // Basic validation
        if (empty($data)) {
            return $this->failValidationErrors('No data provided.');
        }

        // Ensure the order data contains 'tables_id'
        if (!isset($data['tables_id'])) {
            return $this->failValidationErrors('Missing required field: tables_id.');
        }

        // Optional status field; default to 'pending' if not provided
        $status = $data['status'] ?? 'pending';

        // Insert the order into the database
        $orderData = [
            'tables_id' => $data['tables_id'],
            'status' => $status
        ];

        $inserted = $model->insert($orderData);

        if ($inserted) {
            $orderData['order_id'] = $model->insertID();  // Get the newly created order ID
            return $this->respondCreated($orderData, 'Order created successfully.');
        } else {
            return $this->failServerError('Failed to create order.');
        }
    }
    
    public function show($id = null)
    {
        $model = new OrdersModel();

        // Attempt to retrieve the specific education entry by ID.
        $data = $model->find($id);
        $tableId = $this->request->getGet('tableId');

        // Filter the data by user_id if provided, otherwise retrieve all entries.
        $data = $tableId ? $model->where('tables_id', $tableId)->findAll() : $model->findAll();

        // Check if data was found.
        if ($data) {
            return $this->respond($data);
        } else {
            // Return a 404 error if no data is found.
            return $this->failNotFound("No restaurant entry found with ID: {$id}");
        }
    }

    public function delete($id = null)
    {
        $model = new OrdersModel();

        $data = $this->request->getJSON(true);

        $model->delete($id);
        
        return $this->respondDeleted("deleted");
    }



    // Other methods...
}