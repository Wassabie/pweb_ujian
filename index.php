<?php
// Connection configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "crud_example";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $id = $_POST['id'] ?? '';

    if ($action === 'create') {
        $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $email);
        $stmt->execute();
    } elseif ($action === 'update') {
        $stmt = $conn->prepare("UPDATE users SET name=?, email=? WHERE id=?");
        $stmt->bind_param("ssi", $name, $email, $id);
        $stmt->execute();
    } elseif ($action === 'delete') {
        $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Reset IDs to be sequential
        $conn->query("SET @count = 0;");
        $conn->query("UPDATE users SET id = (@count := @count + 1);");
        $conn->query("ALTER TABLE users AUTO_INCREMENT = 1;");
    }
}

// Fetch users
$result = $conn->query("SELECT * FROM users");
$users = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP MySQL CRUD</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 py-10">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow overflow-x-auto">
        <h1 class="text-2xl font-bold mb-4">PHP MySQL CRUD</h1>

        <h2 class="text-xl font-semibold mb-2">Add User</h2>
        <form method="POST" class="mb-6">
            <input type="hidden" name="action" value="create">
            <div class="mb-4">
                <input type="text" name="name" placeholder="Name" required class="w-full p-2 border rounded">
            </div>
            <div class="mb-4">
                <input type="email" name="email" placeholder="Email" required class="w-full p-2 border rounded">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add</button>
        </form>

        <h2 class="text-xl font-semibold mb-2">Users List</h2>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2">ID</th>
                    <th class="border border-gray-300 px-4 py-2">Name</th>
                    <th class="border border-gray-300 px-4 py-2">Email</th>
                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr class="odd:bg-white even:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2 text-center whitespace-nowrap"><?= $user['id'] ?></td>
                        <td class="border border-gray-300 px-4 py-2 whitespace-nowrap truncate max-w-xs"><?= $user['name'] ?></td>
                        <td class="border border-gray-300 px-4 py-2 whitespace-nowrap truncate max-w-xs"><?= $user['email'] ?></td>
                        <td class="border border-gray-300 px-4 py-2 text-center whitespace-nowrap">
                            <form method="POST" style="display:inline-block;">
                                <input type="hidden" name="action" value="update">
                                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                <input type="text" name="name" value="<?= $user['name'] ?>" required class="p-1 border rounded">
                                <input type="email" name="email" value="<?= $user['email'] ?>" required class="p-1 border rounded">
                                <button type="submit" class="bg-yellow-500 text-white px-2 py-1 rounded">Update</button>
                            </form>
                            <form method="POST" style="display:inline-block;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                <button type="submit" onclick="return confirm('Are you sure?')" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
