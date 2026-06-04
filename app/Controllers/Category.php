<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\CategoryModel;
use App\Models\RestaurantModel;

class Category extends ResourceController
{
    use ResponseTrait;

    /**
     * Handle GET requests to list education entries or filter by user_id.
     */
    public function index()
    {
        $model = new CategoryModel();

        // Retrieve 'user_id' from query parameters if provided.
        $userId = $this->request->getGet('user_id');

        // Filter the data by user_id if provided, otherwise retrieve all entries.
        $data = $userId ? $model->where('user_id', $userId)->findAll() : $model->findAll();

        // Use HTTP 200 to return data.
        return $this->respond($data);
    }

    /**
     * Handle GET requests to retrieve a single education entry by its ID.
     */
    public function show($id = null)
    {


        // Check if the ID is provided
        if (is_null($id)) {
            return $this->failNotFound("No user ID provided.");
        }
    
        $restaurantModel = new RestaurantModel();
        $categoryModel = new CategoryModel();
    
        // Fetch the restaurant by user ID
        $restaurant = $restaurantModel->where('user_id', $id)->first();
    
        // Check if the restaurant exists
        if (!$restaurant) {
            return $this->failNotFound("No restaurant found for user ID: {$id}");
        }
    
        // Fetch categories for the given restaurant
        $categories = $categoryModel->where('restaurant_id', $restaurant['restaurant_id'])->findAll();
        
        // Return the items found
        return $this->respond($categories);
    }

    /**
     * Handle POST requests to create a new education entry.
     */
    public function create()
    {
        $model = new CategoryModel();
        $data = $this->request->getJSON(true);  // Ensure the received data is an array.

        $model1 = new RestaurantModel();

        $data2 = $model1->where('user_id',$data['userId'])->first();

        $data['restaurant_id'] = $data2['restaurant_id'];

        unset($data['userId']);

        // Validate input data before insertion.
        if (empty($data2)) {
            return $this->failValidationErrors('No data provided.');
        }

        // Insert data and check for success.
        $inserted = $model->insert($data);
        if ($inserted) {
            return $this->respondCreated($data, 'Education data created successfully.');
        } else {
            return $this->failServerError('Failed to create education data.');
        }
    }
    
    /**
     * Handle DELETE requests to remove an existing education entry by its ID.
     */
    public function delete($id = null)
    {
        $model = new EducationModel();

        // Check if the record exists before attempting deletion.
        if (!$model->find($id)) {
            return $this->failNotFound("No Education entry found with ID: {$id}");
        }

        // Attempt to delete the record.
        if ($model->delete($id)) {
            return $this->respondDeleted(['id' => $id, 'message' => 'Education data deleted successfully.']);
        } else {
            return $this->failServerError('Failed to delete education data.');
        }
    }
}