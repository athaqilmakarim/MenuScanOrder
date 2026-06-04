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
                    <a class="nav-link active" href="/MenuScanOrder/menu_page/<?= $userId?>">Menu</a>
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
                
                <!-- Button to trigger modal -->
                <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                    Create Category
                </button>

                <!-- Modal -->
                <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content bg-dark text-white">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createCategoryModalLabel">Create Category</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="categoryForm">
                                    <div class="mb-3">
                                        <input type="hidden" id="userId" name="userId" value="<?php echo session()->get('userId'); ?>">
                                        <label for="categoryName" class="form-label">Category Name</label>
                                        <input type="text" class="form-control input-dark" id="categoryName" name="categoryName" placeholder="Enter category name">
                                    </div>
                                    <button type="submit" class="btn btn-light">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>     
                <!-- Edit Item Modal -->
<div class="modal fade" id="editItemModal" tabindex="-1" aria-labelledby="editItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title" id="editItemModalLabel">Edit Menu Item</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editMenuForm">
                    <input type="hidden" id="editItemId" name="itemId">
                    <div class="mb-3">
                        <label for="editItemName" class="form-label">Item Name</label>
                        <input type="text" class="form-control" id="editItemName" name="menuItemName">
                    </div>
                    <div class="mb-3">
                        <label for="editItemPrice" class="form-label">Price</label>
                        <input type="text" class="form-control" id="editItemPrice" name="menuItemPrice">
                    </div>
                    <div class="mb-3">
                        <label for="editItemCategory" class="form-label">Category</label>
                        <select class="form-control" id="editItemCategory" name="menuItemCategory">
                            <!-- Categories will be dynamically loaded -->
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Item</button>
                </form>
            </div>
        </div>
    </div>
</div> 

<div class="card bg-dark text-white mb-4">
    <div class="card-header">Create Menu Item</div>
    <div class="card-body">
    <form id="menuForm">
    <div class="mb-3">
        <label for="menuItemName" class="form-label">Item Name</label>
        <input type="text" class="form-control" id="menuItemName" name="menuItemName">
    </div>
    <div class="mb-3">
        <label for="menuItemPrice" class="form-label">Price</label>
        <input type="text" class="form-control" id="menuItemPrice" name="menuItemPrice">
    </div>
    <div class="mb-3">
        <label for="menuItemCategory" class="form-label">Category</label>
        <select class="form-control" id="menuItemCategory" name="menuItemCategory">
            <option value="">Select a category</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
    </div>
</div>

<div class="card bg-dark text-white">
    <div class="card-header">Menu Items</div>
    <div class="card-body">
    <table class="table table-dark table-striped">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Price</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody id="menuItemsContainer">
        <!-- Dynamic content will be loaded here -->
    </tbody>
</table>
    </div>
</div>
            </div>
        </div>
    </div>
</main>


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

document.getElementById('categoryForm').addEventListener('submit', (event) => {
    event.preventDefault();

    const form = document.getElementById('categoryForm');
    const formData = new FormData(form);
    const categoryName = formData.get('categoryName');
    const userId = formData.get('userId');
    const data = {
        name: categoryName,
        userId: userId 
    };

    fetch(`<?= base_url("category"); ?>`, {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();  // Parse JSON response into native JavaScript objects
    })
    .then(data => {
        console.log('Success:', data);
        alert('Category added successfully!');
        setTimeout(() => {
            window.location.href = `<?= base_url("menu_page/"); ?>${userId}`; // Corrected redirection
        }, 2000);
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error adding category.');
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('menuItemCategory');
    fetchMenuItems();

    fetchCategories()
        .then(categories => {
            categories.forEach(category => {
                const option = document.createElement('option');
                option.value = category.category_id;
                option.textContent = category.name;
                categorySelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Failed to fetch categories:', error);
            alert('Failed to load categories.');
        });
});

function fetchCategories() {
    const userId = <?php echo session()->get('userId'); ?>; // Get userId from PHP session
    const url = `<?= base_url("category/") ?>${userId}`;
    return fetch(url, {
        method: 'GET',
        headers: {'Content-Type': 'application/json'}
    })
    .then(response => {
        console.log(response);
        if (!response.ok) {
            throw new Error('Failed to fetch categories');
        }
        return response.json();
    });
}

function updateMenuItemsTable(menuItems) {
    const tableBody = document.getElementById('menuItemsContainer');
    tableBody.innerHTML = ''; // Clear existing entries

    menuItems.forEach((item, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <th scope="row">${index + 1}</th>
            <td>${item.name}</td>
            <td>$${item.price}</td>
            <td>
            <button class="btn btn-primary btn-edit" data-item-id="${item.item_id}" data-item-name="${item.name}" data-item-price="${item.price}" data-item-id="${item.item_id}" data-bs-toggle="modal" data-bs-target="#editItemModal">Edit</button>
            <button class="btn btn-danger btn-sm btn-delete" data-item-id="${item.item_id}">Delete</button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

function fetchMenuItems() {
    const userId = <?php echo session()->get('userId'); ?>; // Get userId from PHP session
    const url = `<?= base_url("items/") ?>${userId}`; // Construct the URL with userId
    console.log("Fetching items from:", url);

    fetch(url, { // Corrected fetch call
        method: 'GET',
        headers: {'Content-Type': 'application/json'}
    })
    .then(response => {
        console.log("API Response:", response);
        if (!response.ok) {
            throw new Error('Failed to fetch menu items');
        }
        return response.json();
    })
    .then(menuItems => {
        console.log("Menu Items Data:", menuItems);
        updateMenuItemsTable(menuItems);
    })
    .catch(error => {
        console.error('Failed to fetch menu items:', error);
        alert('Failed to load menu items.');
    });
}


document.getElementById('menuForm').addEventListener('submit', (event) => {
    event.preventDefault();
    const formData = new FormData(event.target);
    const itemId = formData.get('itemId'); // Hidden input that stores the ID of the item being edited

    const url = itemId ? `<?= base_url("items/") ?>${itemId}` : `<?= base_url("items"); ?>`;
    const method = itemId ? 'PUT' : 'POST';

    const data = {
        name: formData.get('menuItemName'),
        price: formData.get('menuItemPrice'),
        category_id: formData.get('menuItemCategory')
    };

    fetch(url, {
        method: method,
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Success:', data);
        alert(itemId ? 'Item updated successfully!' : 'Item added successfully!');
        window.location.reload(); // Reload the page to reflect changes
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error processing your request.');
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const menuItemsContainer = document.getElementById('menuItemsContainer');
    
    menuItemsContainer.addEventListener('click', function(event) {
        
        const target = event.target;
        if (target.classList.contains('btn-edit')) {
            const row = target.closest('button'); // Get the closest tr ancestor
            const itemId = row.getAttribute('data-item-id');
            const itemName = row.getAttribute('data-item-name');
            const itemPrice = row.getAttribute('data-item-price');
            const itemCategory = row.getAttribute('data-item-category');


            // Set the values in the modal form
            document.getElementById('editItemId').value = itemId;
            document.getElementById('editItemName').value = itemName;
            document.getElementById('editItemPrice').value = itemPrice;
            document.getElementById('editItemCategory').value = itemCategory;

            // Show the modal (Bootstrap 5)
            const editModal = new bootstrap.Modal(document.getElementById('editItemModal'));
            editModal.show();
        }
        if (event.target.classList.contains('btn-delete')) {
            const itemId = event.target.getAttribute('data-item-id');
            if (confirm('Are you sure you want to delete this item?')) {
                deleteMenuItem(itemId);
            }
        }
    });
});

function fetchAndShowEditModal(itemId) {
    fetch(`<?= base_url("items/") ?>${itemId}`, {
        method: 'GET',
        headers: {'Content-Type': 'application/json'}
    })
    .then(response => response.json())
    .then(item => {
        document.getElementById('editItemId').value = item.id;
        document.getElementById('editItemName').value = item.name;
        document.getElementById('editItemPrice').value = item.price;
        document.getElementById('editItemCategory').value = item.category_id;
        const editModal = new bootstrap.Modal(document.getElementById('editItemModal'));
        editModal.show();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error loading item data.');
    });
}

function deleteMenuItem(itemId) {
    fetch(`<?= base_url("items/") ?>${itemId}`, {
        method: 'DELETE',
        headers: {'Content-Type': 'application/json'}
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to delete item');
        }
        return response.json();
    })
    .then(() => {
        alert('Item deleted successfully');
        window.location.reload();
    })
    .catch(error => {
        console.error('Error deleting item:', error);
        alert('Error deleting item.');
    });
}

</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const editMenuForm = document.getElementById('editMenuForm');
    if (editMenuForm) {
        editMenuForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const itemId = document.getElementById('editItemId').value;
            const itemName = document.getElementById('editItemName').value;
            const itemPrice = document.getElementById('editItemPrice').value;
            const itemCategory = document.getElementById('editItemCategory').value;

            const data = {
                name: itemName,
                price: itemPrice,
            };

            console.log(data);
            fetch(`<?= base_url("items/") ?>${itemId}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to update item');
                }
                return response.json();
            })
            .then(updatedItem => {
                alert('Item updated successfully!');
                window.location.reload(); // Refresh the page to show the updated data
            })
            .catch(error => {
                console.error('Error updating item:', error);
                alert('Error updating item.');
            });
        });
    }
});
</script>
</body>
</html>