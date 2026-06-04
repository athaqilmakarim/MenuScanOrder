<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #2a3238; 
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
        .table_row {
            background-color: #ff0000 !important; 
            color: #341717;
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
                        <a class="nav-link" href="/MenuScanOrder/restaurant_page/<?= $userId?>">Restaurant</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="/MenuScanOrder/menu_page/<?= $userId?>">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/MenuScanOrder/create_table/<?= $userId?>">Table Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/MenuScanOrder/order_management/<?= $userId?>">Order Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/MenuScanOrder/logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<main class="py-5">
    <div class="container">
        <h2 class="mb-4 text-white">Order Management</h2>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Table Number</th>
                        <th scope="col">View Order</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr class="table_row">
                    
                    <th scope="row"><?= htmlspecialchars($order['tables_number']) ?></th>
                        <td><button onclick="fetchOrderDetails('<?= htmlspecialchars($order['order_id']) ?>')" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#orderDetailsModal">View</button></td>
                        <td><button type="button" class="btn btn-success" onclick="completeOrder('<?= htmlspecialchars($order['order_id']) ?>')">Complete Order</button></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<!-- Order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                
            </div>
            <div class="modal-body">
                <!-- Order details will be loaded here -->
                <div id="orderDetailsContent">Loading...</div>
            </div>
            <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>
        </div>
    </div>
</div>
<footer class="bg-dark text-light py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p>&copy; 2024 MenuScanOrder. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="#" class="text-light me-3">Privacy Policy</a>
                <a href="#" class="text-light">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
    var currentOrderId = null; // Global variable to store the current order ID
    function fetchOrderDetails(orderDetailsId) {
    currentOrderId = orderDetailsId; // Set the global current order ID
    const url = `/MenuScanOrder/orderdetails/${orderDetailsId}`;
    fetch(url)
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        const modalBody = document.getElementById('orderDetailsContent');
        if (data && data.length > 0) {
            let content = '<table class="table">';
            content += '<thead><tr><th>Item ID</th><th>Name</th><th>Price</th></tr></thead><tbody>';
            data.forEach(item => {
                content += `<tr>
                    <td>${item.item_id}</td>
                    <td>${item.item_name}</td>
                    <td>$${item.item_price}</td>
                </tr>`;
            });
            content += '</tbody></table>';
            modalBody.innerHTML = content;
        } else {
            modalBody.innerHTML = 'No items available for this order.';
        }
    })
    .catch(error => {
        console.error('Error fetching order details:', error);
        document.getElementById('orderDetailsContent').innerHTML = 'Failed to load data.';
    });
}

function completeOrder(orderId) {
    const url = `/MenuScanOrder/orders/${orderId}`;
    console.log(orderId);
    fetch(url, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Order completed:', data);
        document.querySelector('#orderDetailsModal .btn-close').click();
        location.reload();
    })
    .catch(error => {
        console.error('Failed to complete the order:', error);
        alert('Failed to complete the order.');
    });
}

</script>
</script>
</body>
</html>