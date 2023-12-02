<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}

include 'config.php';

if(isset($_SESSION['cart'])) {
  foreach($_SESSION['cart'] as $F_ID => $quantity) {
    $result = $mysqli->query("SELECT * FROM food WHERE F_ID = ".$F_ID);

    if($result){
      if($obj = $result->fetch_object()) {
        $cost = $obj->price * $quantity;
        $user = $_SESSION["username"];

        // Assuming your 'orders' table columns are named appropriately
        $query = $mysqli->query("INSERT INTO orders (F_ID, foodname, price, quantity, order_date, username, R_ID) VALUES ($obj->F_ID, '$obj->name', $obj->price, $quantity, NOW(), '$user', $obj->R_ID)");

        if($query){
          $newqty = $obj->quantity - $quantity;

          // Assuming your 'food' table has a column named 'quantity'
          if($mysqli->query("UPDATE food SET quantity = ".$newqty." WHERE F_ID = ".$F_ID)){
            // Successfully updated quantity
          } else {
            // Failed to update quantity
            echo "Error updating quantity: " . $mysqli->error;
          }
        } else {
          // Failed to insert into orders table
          echo "Error inserting into orders: " . $mysqli->error;
        }
      }
    } else {
      // Failed to fetch data from food table
      echo "Error fetching data from food table: " . $mysqli->error;
    }
  }
}

// Clear the cart after processing orders
unset($_SESSION['cart']);

header("location: bill.php");
?>
