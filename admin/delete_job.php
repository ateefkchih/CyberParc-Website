<?php
include 'connect.php';

// Check if the 'delete_job' parameter is set in the POST data
if (isset($_POST['delete_job'])) {
    $job_id = $_POST['delete_job'];

    // Check if the job_id is a valid integer
    if (ctype_digit($job_id)) {
        try {
            // Prepare and execute the SQL query to delete the job
            $deleteQuery = "DELETE FROM jobs WHERE job_id = :job_id";
            $deleteStatement = $pdo->prepare($deleteQuery);
            $deleteStatement->bindParam(':job_id', $job_id, PDO::PARAM_INT);            
            $deleteStatement->execute();

            // Redirect back to the jobs.php page after deletion
            header("Location: jobs.php");
            exit();
        } catch (PDOException $e) {
            // Handle any errors that occur during the deletion process
            echo "Error: " . $e->getMessage();
        }
    }
}

// Redirect to the jobs.php page if 'delete_job' parameter is not valid or not set
header("Location: jobs.php");
exit();
?>
