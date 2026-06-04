<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ItemsModel;
use App\Models\CategoryModel;
use App\Models\RestaurantModel;

class Items extends ResourceController
{
    use ResponseTrait;

    /**
     * Handle GET requests to list items or filter by restaurant_id.
     */
    public function index()
    {
        $restaurantModel = new RestaurantModel();

        $restaurant = $restaurantModel->where('user_id', $userId)->first();
        $restaurantId = $restaurant['restaurant_id'];
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->where('restaurant_id', $restaurantId)->findAll();

        $itemModel = new ItemsModel();
        $items = [];
        foreach ($categories as $category) {
            $categoryItems = $itemModel->where('category_id', $category['id'])->findAll();
            $items = array_merge($items, $categoryItems);
        }

        return $this->respond($items);
    }

    /**
     * Handle GET requests to retrieve a single item entry by its ID.
     */
    public function show($id = null)
    {
        $itemModel = new ItemsModel();




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
    
        $allItems = [];
        // Fetch items for each category
        foreach ($categories as $category) {
            $items = $itemModel->where('category_id', $category['category_id'])->findAll();
            foreach ($items as $item) {
                $allItems[] = $item;
            }
        }
    
        // Check if items exist
        if (empty($allItems)) {
            return $this->failNotFound("No items found for restaurant ID: {$restaurant['restaurant_id']}");
        }
    
        // Return the items found
        return $this->respond($allItems);
    }

    /**
     * Handle POST requests to create a new item entry.
     */
    public function create()
    {
        $model = new ItemsModel();
        $data = $this->request->getJSON(true);

        if (empty($data)) {
            return $this->failValidationErrors('No data provided.');
        }

        $inserted = $model->insert($data);

        if ($inserted) {
            return $this->respondCreated($data, 'Item created successfully.');
        } else {
            return $this->failServerError('Failed to create item.');
        }
    }

    public function update($id = null)
{
    $model = new ItemsModel();
    $data = $this->request->getJSON(true);

    if (!$id || !$model->find($id)) {
        return $this->failNotFound("No item found with ID: $id");
    }

    $updateSuccess = $model->update($id, $data);

    if ($updateSuccess) {
        return $this->respondUpdated($data, 'Item updated successfully.');
    } else {
        return $this->failServerError('Failed to update item.');
    }
}

public function delete($id = null)
    {
        $model = new ItemsModel();

        $data = $this->request->getJSON(true);

        $model->delete($id);
        
        return $this->respondDeleted("deleted");
    }
}