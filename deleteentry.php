<?php
@include('db_connection.php');
session_start();

if (!isset($_SESSION['login_user1'])) {
    header('Location: manageadmin.php');
    exit();
}

if (isset($_GET['R_ID'])) {
    $restaurantID = $_GET['R_ID'];

    // Check if there are associated records in the food table
    $checkFoodQuery = "SELECT * FROM food WHERE R_ID = $restaurantID";
    $checkFoodResult = mysqli_query($conn, $checkFoodQuery);

    if ($checkFoodResult->num_rows > 0) {
        // Delete associated records in the food table
        $deleteFoodQuery = "DELETE FROM food WHERE R_ID = $restaurantID";
        $deleteFoodResult = mysqli_query($conn, $deleteFoodQuery);

        if (!$deleteFoodResult) {
            $_SESSION['delete'] = "Error deleting associated food records. Please try again.";
            header('Location: manageadmin.php');
            exit();
        }
    }

    // Delete the restaurant record
    $deleteQuery = "DELETE FROM restaurants WHERE R_ID = $restaurantID";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        $_SESSION['delete'] = "Restaurant deleted successfully";
    } else {
        $_SESSION['delete'] = "Error deleting restaurant. Please try again.";
    }
}

header('Location: manageadmin.php'); // Redirect back to the admin page
exit();
?>
