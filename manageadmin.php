<?php
@include('session_m.php');
@include('db_connection.php');

if (!isset($_SESSION['login_admin'])) {
    header('Location: loginadmin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Management</title>
    <link rel="stylesheet" href="css/admin.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .main-content {
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        table th {
            background-color: #5352ed;
            color: #fff;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            margin-right: 10px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #5352ed;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #70a1ff;
        }

        .btn-secondary {
            background-color: #2ed573;
            color: #fff;
        }

        .btn-secondary:hover {
            background-color: #7bed9f;
        }

        .btn-danger {
            background-color: #ff3838;
            color: #fff;
        }

        .btn-danger:hover {
            background-color: #ff6348;
        }
    </style>
</head>

<body>
    <div class="main-content">
        <h1>Manage Restaurant</h1>
        <br/><br/>
          <!-- Logout button -->
          <form method="post" action="">
            <button type="submit"class="btn-danger" name="logout">Logout</button>
        </form>
        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        if (isset($_SESSION['change-pwd'])) {
            echo $_SESSION['change-pwd'];
            unset($_SESSION['change-pwd']);
        }
        if (isset($_SESSION['pwd-not-match'])) {
            echo $_SESSION['pwd-not-match'];
            unset($_SESSION['pwd-not-match']);
        }
        if (isset($_SESSION['user-not-found'])) {
            echo $_SESSION['user-not-found'];
            unset($_SESSION['user-not-found']);
        }
        if (!isset($_SESSION['login_admin'])) {
            header('Location: loginadmin.php');
            exit();
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
            session_unset();
            session_destroy();
            header('Location: index.php');
            exit();
        }
        ?>

        <br>
        <br>

        <h2>Restaurant List</h2>
        <?php
        // Display delete message if available
        if (isset($_SESSION['delete_message'])) {
            echo "<p>{$_SESSION['delete_message']}</p>";
            unset($_SESSION['delete_message']);
        }
        ?>

        <table>
            <tr>
                <th>R_ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Address</th>
                <th>Manage</th>
            </tr>
            <?php
            $restaurantSql = "SELECT * FROM restaurants";
            $restaurantResult = mysqli_query($conn, $restaurantSql);

            if ($restaurantResult) {
                while ($restaurantRow = mysqli_fetch_assoc($restaurantResult)) {
                    echo "<tr>";
                    echo "<td>{$restaurantRow['R_ID']}</td>";
                    echo "<td>{$restaurantRow['name']}</td>";
                    echo "<td>{$restaurantRow['email']}</td>";
                    echo "<td>{$restaurantRow['contact']}</td>";
                    echo "<td>{$restaurantRow['address']}</td>";
                    echo "<td>
                            <a href='deleteentry.php?R_ID={$restaurantRow['R_ID']}' class='btn btn-danger' onclick=\"return confirm('Are you sure you want to delete this restaurant?')\">Delete</a>
                          </td>";
                    echo "</tr>";
                }
            }
            ?>
        </table>

        <br>
        <br>

        <h2>Customer Orders</h2>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Food Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Order Date</th>
                <th>Username</th>
                <th>R_ID</th>
            </tr>
            <?php
            $orderSql = "SELECT orders.*, restaurants.R_ID AS restaurant_id FROM orders JOIN restaurants ON orders.R_ID = restaurants.R_ID";
            $orderResult = mysqli_query($conn, $orderSql);

            if ($orderResult) {
                while ($orderRow = mysqli_fetch_assoc($orderResult)) 
                {
                    echo "<tr>";
                    echo "<td>{$orderRow['order_ID']}</td>";
                    echo "<td>{$orderRow['foodname']}</td>";
                    echo "<td>{$orderRow['price']}</td>";
                    echo "<td>{$orderRow['quantity']}</td>";
                    echo "<td>{$orderRow['order_date']}</td>";
                    echo "<td>{$orderRow['username']}</td>";
                    echo "<td>{$orderRow['restaurant_id']}</td>"; 
                    echo "</tr>";
                    
                }
            }
            ?>
        </table>
    </div>
</body>

</html>

<!--footer-->
<div class="footer">
    <div class="wrapper">
        <p class="text-center">All rights reserved.</p>
    </div>
</div>

</html>
