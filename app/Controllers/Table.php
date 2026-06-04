<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\TableModel;
use App\Models\RestaurantModel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class Table extends ResourceController
{
    use ResponseTrait;

    /**
     * Handle GET requests to list education entries or filter by user_id.
     */
public function index()
{
    $model = new TableModel();

    // Retrieve 'user_id' from query parameters if provided.
    $userId = $this->request->getGet('user_id');

    // Filter the data by user_id if provided, otherwise retrieve all entries.
    $tables = $userId ? $model->where('user_id', $userId)->findAll() : $model->findAll();

    // Loop through each table and generate a QR code.
    foreach ($tables as &$table) {
        $qrCodeURL = "https://infs3202-0408bf45.uqcloud.net/MenuScanOrder/user_menu/{$table['tables_id']}";
        $qrCodeImage = $this->generateQRCode($qrCodeURL);
        // Append the base64-encoded QR code image data to each table's data.
        $table['qrCode'] = base64_encode($qrCodeImage);
    }
    unset($table); // Break the reference with the last element.

    // Use HTTP 200 to return data.
    return $this->respond($tables);
}

    /**
     * Handle GET requests to retrieve a single education entry by its ID.
     */
    public function show($id = null)
    {
        $model = new TableModel();

        // Attempt to retrieve the specific education entry by ID.

        // Filter the data by user_id if provided, otherwise retrieve all entries.
        $tables = $model->where('restaurant_id', $id)->findAll();
        foreach ($tables as &$table) {
            $qrCodeURL = "https://infs3202-0408bf45.uqcloud.net/MenuScanOrder/user_menu/{$table['tables_id']}";
            $qrCodeImage = $this->generateQRCode($qrCodeURL);
            // Append the base64-encoded QR code image data to each table's data.
            $table['qrCode'] = base64_encode($qrCodeImage);
        }
        unset($table); 

        // Check if data was found.
        if ($tables) {
            return $this->respond($tables);
        } else {
            // Return a 404 error if no data is found.
            return $this->failNotFound("No restaurant entry found with ID: {$id}");
        }
    }

    /**
     * Handle POST requests to create a new education entry.
     */
    public function create()
{
    $model = new TableModel();
    $data = $this->request->getJSON(true);  // Ensure the received data is an array.

    $restaurantModel = new RestaurantModel();
    $restaurantData = $restaurantModel->where('user_id', $data['userId'])->first();

    if (empty($restaurantData)) {
        return $this->failValidationErrors('No valid restaurant data found for the given user.');
    }

    $data['restaurant_id'] = $restaurantData['restaurant_id'];
    unset($data['userId']);

    // Insert data and check for success.
    $insertedId = $model->insert($data);
    if ($insertedId) {
        // Generate QR code after successful table creation
        $qrCodeURL = "https://infs3202-0408bf45.uqcloud.net/user_menu/{$insertedId}";
        $qrCodeImage = $this->generateQRCode($qrCodeURL);
        
        // Return success response with QR code image data
        return $this->respondCreated([
            'message' => 'Table created successfully.',
            'tableId' => $insertedId,
            'qrCode' => base64_encode($qrCodeImage)
        ]);
    } else {
        return $this->failServerError('Failed to create table.');
    }
}

// QR code generation method
public function generateQRCode($url)
{
    $qrCode = QrCode::create($url);
    $writer = new PngWriter();
    $result = $writer->write($qrCode);
    
    // Return image as string
    return $result->getString();
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