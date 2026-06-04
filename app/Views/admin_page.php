<!-- Admin Page with Edit Modal -->
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">User Management</h1>
        <table class="table table-dark mt-3">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Is Admin?</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= esc($user['user_id']); ?></td>
                        <td><?= esc($user['name']); ?></td>
                        <td><?= esc($user['email']); ?></td>
                        <td><?= esc($user['status']); ?></td>
                        <td><?= esc($user['isAdmin'] ? 'Yes' : 'No'); ?></td>
                        <td>
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal" onclick="setupEdit('<?= $user['user_id']; ?>', '<?= esc($user['name']); ?>')">Edit Name</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User Name</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        <input type="hidden" id="editUserId" name="userId">
                        <div class="mb-3">
                            <label for="editUserName" class="form-label">User Name</label>
                            <input type="text" class="form-control" id="editUserName" name="userName">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Name</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function setupEdit(userId, userName) {
            document.getElementById('editUserId').value = userId;
            document.getElementById('editUserName').value = userName;
        }

        document.getElementById('editUserForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const userId = document.getElementById('editUserId').value;
            const userName = document.getElementById('editUserName').value;
            fetch(`<?= base_url("users/update/") ?>${userId}`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ name: userName })
            })
            .then(response => response.json())
            .then(data => {
                alert('User name updated successfully!');
                window.location.reload(); // Reload to see the changes
            })
            .catch(error => {
                console.error('Error updating user:', error);
                alert('Failed to update user name.');
            });
        });

        document.getElementById('editUserForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const userId = document.getElementById('editUserId').value;
    const userName = document.getElementById('editUserName').value;

    fetch(`<?= base_url("users/update/") ?>${userId}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ userId: userId, userName: userName })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('User name updated successfully!');
            window.location.reload(); // Reload to see the changes
        } else {
            alert(data.message); // Show error message from server
        }
    })
    .catch(error => {
        console.error('Error updating user:', error);
        alert('Failed to update user name.');
    });
});
    </script>
</body>
</html>