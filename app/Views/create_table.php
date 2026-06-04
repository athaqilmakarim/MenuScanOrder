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
                        <a class="nav-link" href="/MenuScanOrder/restaurant_page/<?= $userId?>">Restaurant</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="/MenuScanOrder/menu_page/<?= $userId?>">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/MenuScanOrder/create_table/<?= $userId?>">Table Management</a>
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
                <div class="card bg-dark text-white mb-4" id="tableInfo" style="display: none;">
                    <div class="card-header">Your Restaurant</div>
                    <div class="card-body">
                        <h5 id="restaurantNameDisplay"></h5>
                    </div>
                </div>

                <!-- Registration Form -->
                <div class="card bg-dark text-white mb-4">
    <div class="card-header">Create Table</div>
    <div class="card-body">
        <form id="tableForm">
            <div class="mb-3">
                <input type="hidden" id="userId" name="userId" value="<?php echo session()->get('userId'); ?>">
                <label for="tableNumber" class="form-label">Table Number</label>
                <input type="text" class="form-control input-dark" id="tableNumber" name="tableNumber" placeholder="Enter table number">
            </div>
            <button type="submit" class="btn btn-light">Save</button>
        </form>
    </div>
<div id="qrCodeContainer">
    <img id="qrCodeImage" src="" alt="QR Code" style="display:none;">
</div>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="mb-4 text-white">All Tables</h2>
            <div id="tablesContainer">
                <!-- Tables and QR codes will be added here dynamically -->
            </div>
        </div>
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
    document.addEventListener('DOMContentLoaded', function() {
    fetchTables();
});

function fetchTables() {
    const restoId = <?= json_encode($restoId); ?>;
    const url = `<?= base_url("table/") ?>${restoId}`; // Construct the URL with userId
    console.log("Fetching items from:", url);

    fetch(url, { // Corrected fetch call
        method: 'GET',
        headers: {'Content-Type': 'application/json'}
    })
        .then(response => response.json())
        .then(tables => {
            const container = document.getElementById('tablesContainer');
            container.innerHTML = ''; // Clear existing content
            tables.forEach(table => {
                const card = document.createElement('div');
                card.className = 'card bg-dark text-white mb-3';
                const body = document.createElement('div');
                body.className = 'card-body';
                const title = document.createElement('h5');
                title.innerText = `Table ${table.tables_number}`;
                const img = document.createElement('img');
                img.src = 'data:image/png;base64,' + table.qrCode;
                img.alt = 'QR Code';
                img.className = 'mb-3';

                body.appendChild(title);
                body.appendChild(img);
                card.appendChild(body);
                container.appendChild(card);
            });
        })
        .catch(error => {
            console.error('Failed to fetch tables:', error);
            alert('Error fetching table data');
        });
}
document.getElementById('tableForm').addEventListener('submit', (event) => {
    event.preventDefault(); // Prevent the form from submitting in the traditional way

    const form = document.getElementById('tableForm');
    const formData = new FormData(form);
    const tableNumber = formData.get('tableNumber');
    console.log("INI",tableNumber)
    const userId = formData.get('userId');
    const data = {
    tables_number: tableNumber,
    userId: userId
};
console.log(data)
    fetch(`<?= base_url("table/create"); ?>`, {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify(data)
})
.then(response => {
    // First, convert the response to JSON, but also keep the response object available
    return response.json().then(data => {
        return {ok: response.ok, data}; // Return both status and data
    });
})
.then(result => {
    if (result.ok) {
        console.log('Success:', result.data);
        alert('Table created successfully!');

        // Display QR Code
        const qrCodeImage = document.getElementById('qrCodeImage');
        qrCodeImage.src = 'data:image/png;base64,' + result.data.qrCode;
        qrCodeImage.style.display = 'block'; // Ensure the QR code is visible


    } else {
        throw new Error(result.data.message || 'Unknown error occurred');
    }
})
.catch(error => {
    console.error('Error:', error);
    alert('Error adding table: ' + error.message);
});
});
</script>
</body>
</html>

