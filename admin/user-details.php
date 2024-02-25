<?php
include 'connect.php';

// Check if the user ID is provided in the URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Fetch user details from the database based on the user ID
    $sql = "SELECT u.*, j.job_title, ja.status
            FROM users u
            LEFT JOIN job_applications ja ON u.id_user = ja.user_id
            LEFT JOIN jobs j ON ja.job_id = j.job_id
            WHERE u.id_user = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the user is found
    if ($user) {
        // Display user details
        $id = $user['id_user'];
        $name = $user['name'];
        $username = $user['username'];
        $email = $user['email'];
        $password = $user['password'];
        $phone = $user['phone'];
        $bio = $user['bio'];
        $chosenJob = $user['job_title'];
        $status = $user['status'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>User Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
            font-family: Arial, sans-serif;
            padding: 20px;
            color: #ffffff;
        }

        .user-details {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-top: 50px;
            box-shadow: 0px 0px 15px 0px rgba(0, 0, 0, 0.8);
        }
    </style>
</head>

<body>
    <h2>User Details</h2>

    <div class="user-details">
        <p><strong>ID:</strong>
            <?php echo $id; ?>
        </p>
        <p><strong>Name:</strong>
            <?php echo $name; ?>
        </p>
        <p><strong>Username:</strong>
            <?php echo $username; ?>
        </p>
        <p><strong>Email:</strong>
            <?php echo $email; ?>
        </p>
        <p><strong>Password:</strong>
            <?php echo $password; ?>
        </p>
        <p><strong>Phone:</strong>
            <?php echo $phone; ?>
        </p>
        <p><strong>Bio:</strong>
            <?php echo $bio; ?>
        </p>
        <p><strong>Chosen Job:</strong>
            <?php echo $chosenJob; ?>
        </p>
        <form action="update_status.php" method="post" class="status-form">
            <p><strong>Status:</strong>
                <?php echo ($status)?>
            </p>
            <label for="status">Change Status:</label>
            <input type="text" name="status" id="status" placeholder="Enter custom status">
            <input type="hidden" name="user_id" value="<?php echo $id; ?>">
            <input type="submit" value="Update Status">
        </form>

        <a href="users-admin-panel.php">Back to Users List</a>
    </div>
</body>

</html>