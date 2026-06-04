<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - MenuScanOrder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <style>
        body{
    background-color: #2a3238;
    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

html{
    height:100%;
    margin: 0;
}

main {
    flex: 1;
}


.input-dark {
    background-color: #555555;
    border: 1px solid #6c757d;
    color: rgb(255, 0, 0);
}

.input-dark::placeholder {
    color: #838383;
}

.input-dark:focus {
    background-color: #ffffff;
    border-color: #4a4b4c;
    box-shadow: 0 0 0 0.25rem rgba(130, 138, 145, 0.25);
}


    </style>
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">MenuScanOrder</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#dashboardNav" aria-controls="dashboardNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="dashboardNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/MenuScanOrder/restaurant_page/<?= $userId?>">Restaurant</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="/MenuScanOrder/menu_page/<?= $userId?>">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/MenuScanOrder/create_table/<?= $userId?>">Table Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/MenuScanOrder/order_management/<?= $userId?>">Order Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/MenuScanOrder/logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main class="mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="mb-4 text-white">Menu Management</h2>

                <!-- Restaurant Display Section -->
                <div class="card bg-dark text-white mb-4" id="restaurantInfo" style="display: none;">
                    <div class="card-header">Your Restaurant</div>
                    <div class="card-body">
                        <h5 id="restaurantNameDisplay"></h5>
                
                    </div>
                </div>

                <!-- Registration Form -->
                <div class="card bg-dark text-white mb-4" id="registerRestaurantForm">
                    <div class="card-header">Register Restaurant</div>
                    <div class="card-body">
                        <form id="menuForm">
                            <div class="mb-3">
                                <input type="hidden" id="userId" name="userId" value="<?php echo session()->get('userId'); ?>">
                                <label for="menuItemName" class="form-label">Restaurant Name</label>
                                <input type="text" class="form-control input-dark" id="menuItemName" name="menuItemName" placeholder="Enter restaurant name">
                            </div>
                            <button type="submit" class="btn btn-light">Save</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

<footer class="bg-dark text-light py-4 mt-5">
    <!-- Existing footer -->
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
document.getElementById('menuForm').addEventListener('submit', handleFormSubmit);

function handleFormSubmit(event) {
    event.preventDefault(); // Prevent the form from submitting the traditional way
    const formData = new FormData(event.target);
    const restaurantName = formData.get('menuItemName');
    const userId = formData.get('userId');
    const data = {
        name: restaurantName,
        user_id: userId
    };

    fetch(`<?= base_url("restaurant"); ?>`, {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
        alert('Restaurant added successfully!');
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error adding restaurant.');
    });
}

window.onload = function() {
    const userId = document.getElementById('userId').value;

    // Construct the URL with a query parameter for user ID
    fetch(`<?= base_url("restaurant?user_id="); ?>${userId}`, {
        method: 'GET'
    })
    .then(response => {
        if (response.status === 404) {
            // Handle 404 errors: No restaurant found for this user ID
            console.log('No restaurant found for this user ID.');
            document.getElementById('restaurantInfo').style.display = 'none';
            document.getElementById('registerRestaurantForm').style.display = '';
        } else if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.length > 0) {
            // Assuming the data is an array of restaurants
            console.log('Restaurant data retrieved:', data);
            document.getElementById('restaurantNameDisplay').textContent = data[0].name;  // Display first restaurant's name as an example
            document.getElementById('restaurantInfo').style.display = '';
            document.getElementById('registerRestaurantForm').style.display = 'none';
        } else {
            // No data returned
            console.log('Data retrieved but no restaurants found.');
            document.getElementById('restaurantInfo').style.display = 'none';
            document.getElementById('registerRestaurantForm').style.display = '';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('restaurantInfo').style.display = 'none';
        document.getElementById('registerRestaurantForm').style.display = '';
    });
}
</script>
</body>
</html>

