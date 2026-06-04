<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboar - MenuScanOrder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <style>
        table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 30px;
}

  .quantity-controls {
    display: flex;
    align-items: center;
  }
  .quantity-controls input {
    width: 50px;
    margin: 0 5px;
    text-align: center;
  }
  .submit-order {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
  }

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

header .navbar {
    justify-content: center;
}
main h1 {
    margin-top: 10px;;
    text-align: center;
}

#orderForm {
    flex-direction: column;
    align-items: center;
}

#submitOrder {
    width: 100%;
    max-width: 300px; 
    align-items: center;
}


.quantity-controls button {
    border: none;
    background-color: rgba(255, 255, 255, 0.5);
    color: black;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
}


.quantity-controls input[type="number"] {
    width: 50px;
    border: none;
    text-align: center;
    background-color: transparent; 
    color: white;
    margin: 0 10px; 
}

.quantity-controls input[type="number"]::-webkit-inner-spin-button,
.quantity-controls input[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.card {
    margin-bottom: 20px;
}
    </style>
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">MenuScanOrder</a>
        </div>
    </nav>
</header>

<main>
    <h1 class="mb-4 text-white">Place Your Order</h1>
    <div class="d-flex justify-content-center">
        <form id="orderForm" class="w-100" style="max-width: 800px;">
    <form id="orderForm">

      <div class="card bg-dark text-white">
        <div class="card-header">Mains</div>
        <div class="card-body">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                    <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Price</th>
            <th scope="col">Category</th>
            <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody id="menuItemsContainer">
                   
                </tbody>
            </table>
        </div>
    </div>
    </div>
  
      <div class="d-flex justify-content-center mt-4">
        <button id="generateQRCode" class="btn btn-primary" type="submit">Submit Order</button>
    </div>
  
    </form>
            </div>
        </div>
    </div>
  </main>
  <script>
    function changeQuantity(action, itemId) {
      var inputField = document.getElementById(itemId);
      var currentValue = parseInt(inputField.value, 10);
      if (action === 'plus') {
        inputField.value = currentValue + 1;
      } else if (action === 'minus' && currentValue > 0) {
        inputField.value = currentValue - 1;
      }
    }
  </script>

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
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('orderForm');
    form.addEventListener('submit', handleFormSubmit);
    fetchMenuItems();
});

async function handleFormSubmit(event) {
    event.preventDefault(); // Prevent the form from submitting traditionally
    document.getElementById('generateQRCode').disabled = true; // Disable the button to prevent multiple submissions

    const items = [];
    document.querySelectorAll('.quantity-controls input').forEach(input => {
        const itemId = input.id;
        const quantity = parseInt(input.value, 10);
        if (quantity > 0) {
            const priceElement = document.getElementById(`price-${itemId}`);
            const price = parseFloat(priceElement.textContent.replace(/^\$/, ''));
            items.push({
                item_id: itemId,
                quantity: quantity,
                price: price
            });
        }
    });

    if (items.length === 0) {
        alert("Please add at least one item to your order.");
        document.getElementById('generateQRCode').disabled = false;
        return;
    }

    const orderData = {
        tables_id: <?= json_encode($tableId); ?>,
    };

    // Create Order
    try {
        const orderResponse = await fetch(`<?= base_url("orders/create"); ?>`, {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(orderData)
        });
        const orderResult = await orderResponse.json();
        if (orderResponse.ok) {
            console.log('Order Created:', orderResult);

            // Using the returned order_id to create order details
            const orderDetailsData = {
                order_id: orderResult.order_id,
                items: items
            };

            const detailsResponse = await fetch(`<?= base_url("orderdetails"); ?>`, {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(orderDetailsData)
            });
            const detailsResult = await detailsResponse.json();
            if (detailsResponse.ok) {
                console.log('Order Details Submitted:', detailsResult);
                alert('Order and details submitted successfully!');
            } else {
                throw new Error('Failed to submit order details.');
            }
        } else {
            throw new Error('Failed to create order.');
        }
    } catch (error) {
        console.error('Error submitting order and details:', error);
        alert('Error creating order and details: ' + error.message);
    } finally {
        document.getElementById('generateQRCode').disabled = false; // Re-enable the button after processing
    }
}

function fetchCategories() {
    return fetch(`<?= base_url("category"); ?>`, {
        method: 'GET',
        headers: {'Content-Type': 'application/json'}
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to fetch categories');
        }
        return response.json();
    });
}

function fetchMenuItems() {
    const userId = <?= json_encode($userId); ?>;
    const url = `<?= base_url("items/") ?>${userId}`; // Use the userId in the URL
            console.log("Fetching items from:", url);
        
            fetch(url, {
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

function updateMenuItemsTable(menuItems) {
    const contentArea = document.getElementById('orderForm');
    contentArea.innerHTML = ''; // Clear existing content

    // Group items by category
    const categories = menuItems.reduce((acc, item) => {
        acc[item.category_name] = acc[item.category_name] || [];
        acc[item.category_name].push(item);
        return acc;
    }, {});

    // Create a card for each category
    Object.keys(categories).forEach(categoryName => {
        const card = document.createElement('div');
        card.className = 'card bg-dark text-white';
        card.innerHTML = `
            <div class="card-header">${categoryName}</div>
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
                    <tbody>
                    ${categories[categoryName].map((item, index) => `
                        <tr>
                            <th scope="row">${index + 1}</th>
                            <td>${item.name}</td>
                            <td id="price-${item.item_id}">$${parseFloat(item.price).toFixed(2)}</td>
                            <td class="quantity-controls">
                                <button type="button" onclick="changeQuantity('minus', '${item.item_id}')">-</button>
                                <input type="number" id="${item.item_id}" name="${item.item_id}" value="0" min="0">
                                <button type="button" onclick="changeQuantity('plus', '${item.item_id}')">+</button>
                            </td>
                        </tr>
                    `).join('')}
                </tbody>
                </table>
            </div>
        `;
        contentArea.appendChild(card);
    });
}
</script>
</body>
</html>