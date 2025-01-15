<?php

use App\Components\Connect;

session_start();

use App\Comoponents\SessionHelpers;
use App\Components\ProductHelpers;

$user_id = getUserId();

use App\Components\AddCart;


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Menu</title>

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
   <h3>our menu</h3>
   <p><a href="home.php">Home</a> <span> / Menu</span></p>
</div>

<!-- menu section starts  -->

<section class="products">

   <h1 class="title">latest dishes</h1>

   <div class="box-container">

      <?php
         $select_products = $conn->prepare("SELECT * FROM `products`");
         $select_products->execute();
         if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
      ?>
      <?php displayProductForm($fetch_products); ?>

         <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"> View Details </a>
         <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
         <?php displayProductImage($fetch_products['image']); ?>
         <a href="category.php?category=<?= $fetch_products['category']; ?>" class="cat"><?= $fetch_products['category']; ?></a>
         <div class="name"><?= $fetch_products['name']; ?></div>
         <div class="flex">
            <div class="price"><span>$</span><?= $fetch_products['price']; ?></div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
         </div>

      <?php
            }
         }else{
            echo '<p class="empty">No products added yet!</p>';
         }
      ?>

   </div>

</section>


<!-- menu section ends -->
























<!-- footer section starts  -->
<?php use App\Components\Footer; ?>
<!-- footer section ends -->








<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
