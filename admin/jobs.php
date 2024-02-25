<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rename_job']) && isset($_POST['new_job_name'])) {
    $jobId = $_POST['rename_job'];
    $newJobName = $_POST['new_job_name'];

    $updateQuery = "UPDATE jobs SET job_title = :new_job_name WHERE job_id = :job_id";
    $updateStatement = $pdo->prepare($updateQuery);
    $updateStatement->bindParam(':new_job_name', $newJobName, PDO::PARAM_STR);
    $updateStatement->bindParam(':job_id', $jobId, PDO::PARAM_INT);
    $updateStatement->execute();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_job']) && isset($_POST['new_job_title'])) {
    $newJobTitle = $_POST['new_job_title'];

    $insertQuery = "INSERT INTO jobs (job_title) VALUES (:job_title)";
    $insertStatement = $pdo->prepare($insertQuery);
    $insertStatement->bindParam(':job_title', $newJobTitle, PDO::PARAM_STR);
    $insertStatement->execute();
    header("Location: " . $_SERVER['PHP_SELF']);

}
$sql = "SELECT * FROM jobs";
$stmt = $pdo->query($sql);
$jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
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

        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            padding: 20px 0;
            background-color: #242939;
            border-right: 1px solid #dee2e6;
        }

        .sidebar-sticky {
            position: -webkit-sticky;
            position: sticky;
            top: 20px;
        }

        .nav-link {
            color: white;
            text-decoration: none;
        }

        .nav-link:hover {
            color: #007bff;
        }

        .nav-link.active {
            color: #007bff;
            font-weight: bold;
        }

        .nav-item {
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            color: #000000;
            font-size: 25px;
            text-align: left;
        }

        th {
            background-color: #588c7e;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .action-icons {
            display: flex;
            align-items: center;
        }

        .delete-icon,
        .rename-icon {
            margin-right: 10px;
            cursor: pointer;
            font-size: 20px;
        }

        .delete-icon {
            color: red;
        }

        .rename-icon {
            color: green;
        }


        .rename-input {
            display: none;
        }

        .listjob {
            color: black;
            font-weight: bold;
        }

        .add-job-container {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            margin-bottom: 20px;
            /* Adjust as needed */
        }

        #add-job-form {
            display: flex;
            gap: 10px;
            /* Adjust as needed */
        }

        .add-job-button {
            background-color: #588C7E;
            /* Green color, adjust as needed */
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .add-job-input {
            padding: 10px;
            border: 1px solid #588C7E;
            border-radius: 5px;
            font-size: 16px;
        }
        .save-icon {
            background-color: #588C7E;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <nav class="col-md-2 d-none d-md-block sidebar">
        <div class="sidebar-sticky">
            <h2>
                Admin Panel's Dashboard
            </h2>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link " href="users-admin-panel.php">
                        Users
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="jobs.php">
                        Jobs
                    </a>
                </li>
            </ul>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link " href="application-admin-panel.php">
                        Application Forms
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reservation-admin-panel.php">
                        Reunion Room Reservation Forms
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <main class="col-md-10 ms-sm-auto content">
        <h2 class="listjob">Jobs List</h2>
        <div class="add-job-container">
        <button type="button" class="add-job-button" onclick="toggleAddJobForm()">+</button>
        <form action="" method="post" id="add-job-form" style="display: none;">
            <input type="hidden" name="new_job" value="1">
            <input type="text" name="new_job_title" class="add-job-input" placeholder="Enter new job title" required>
            <button type="button" class="save-icon" onclick="submitAddJobForm()">Save</button>
        </form>
    </div>
        <?php if (!empty($jobs)): ?>
            <table>
                <tr>
                    <th>Job Name</th>
                    <th>Actions</th> <!-- Added a column for actions -->
                </tr>
                <?php foreach ($jobs as $job): ?>
                    <tr>
                        <td>
                            <?php if (isset($job['job_title'])): ?>
                                <?php echo $job['job_title']; ?>
                            <?php else: ?>
                                <span style="color: red;">Job name not available</span>
                            <?php endif; ?>
                        </td>
                        <td class="action-icons">
                            <form action="" method="post" id="rename-form-<?php echo $job['job_id']; ?>">
                                <input type="hidden" name="rename_job" value="<?php echo $job['job_id']; ?>">
                                <input type="text" name="new_job_name" id="rename-input-<?php echo $job['job_id']; ?>"
                                    class="rename-input" placeholder="Enter new name" required>
                                <button type="button" class="rename-icon"
                                    onclick="toggleRenameInput(<?php echo $job['job_id']; ?>)">&#x270E;</button>
                                <button type="button" class="rename-icon" id="save-button-<?php echo $job['job_id']; ?>"
                                    style="display: none;"
                                    onclick="submitRenameForm(<?php echo $job['job_id']; ?>)">Save</button>
                            </form>
                            <form action="delete_job.php" method="post">
                                <input type="hidden" name="delete_job" value="<?php echo $job['job_id']; ?>">
                                <button type="submit" class="delete-icon"
                                    onclick="return confirm('Are you sure you want to delete this job?')">&#x2716;</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No jobs found.</p>
        <?php endif; ?>

    </main>
    <script>
        function toggleRenameInput(jobId) {
            const inputField = document.getElementById('rename-input-' + jobId);
            const saveButton = document.getElementById('save-button-' + jobId);

            if (inputField.style.display === 'none' || inputField.style.display === '') {
                inputField.style.display = 'inline-block';
                inputField.focus(); // Focus on the input field when shown
                saveButton.style.display = 'inline-block'; // Show the Save button
            } else {
                inputField.style.display = 'none';
                saveButton.style.display = 'none'; // Hide the Save button
            }
        }

        function submitRenameForm(jobId) {
            const form = document.getElementById('rename-form-' + jobId);
            form.submit();
        }
        function toggleAddJobForm() {
            const addJobForm = document.getElementById('add-job-form');

            if (addJobForm.style.display === 'none' || addJobForm.style.display === '') {
                addJobForm.style.display = 'block';
            } else {
                addJobForm.style.display = 'none';
            }
        }

        function submitAddJobForm() {
            const addJobForm = document.getElementById('add-job-form');
            addJobForm.submit();
        }
    </script>
</body>

</html>