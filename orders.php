<?php

use App\Components\Connect;
use App\Components\OrderDisplay;

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Your Orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php use App\Components\UserHeader; ?>
<!-- header section ends -->

<div class="heading">
   <h3>Your Orders</h3>
   <p><a href="html.php">Home</a> <span> / Orders</span></p>
</div>

<section class="orders">

   <h1 class="title">your orders</h1>

   <div class="box-container">

   <?php
      if($user_id == ''){
         echo '<p class="empty">Please login to see your orders</p>';
      }else{
         $orderRepo = new OrderRepository($conn);
         $orders = $orderRepo->getUserOrders($user_id);

         foreach ($orders as $order) {
             echo OrderDisplay::renderOrder($order);
         }
      }
   ?>

   </div>

</section>










<!-- footer section starts  -->
<?php use App\Components\Footer; ?>
<!-- footer section ends -->






<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
