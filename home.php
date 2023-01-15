<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};


if(isset($_POST['add_to_cart'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);

   $p_qty = $_POST['p_qty'];
   $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

  
      

      $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity) VALUES(?,?,?,?,?)");
      $insert_cart->execute([$user_id, $pid, $p_name, $p_price, $p_qty]);
      $message[] = 'added to cart!';
   }



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="home-bg">

   <section class="home">

      <div class="content">
         <span>discover the best quality things here</span>
         <h3>Reach For A Healthier You With Best quality Products</h3>
         <p>We deliver best and fresh quality products at your doorstep.</p>
         <a href="about.php" class="btn">about us</a>
         
      </div>

   </section>

</div>

<section class="home-category">

   <h1 class="title">shop by category</h1>

   <div class="box-container">



      <div class="box">
         <img src="https://cafeburp.com/wp-content/uploads/2020/11/special-ice-cream.jpg" alt="">
         <h3>Ice-cream</h3>
         <p>A sweet, creamy frozen food made from variously flavored cream and milk products often containing fruits, nuts, etc.</p>
         <a href="category.php?category=Ice-cream " class="btn">Ice-cream</a>
      </div>

      <div class="box">
         <img src="https://img.krishijagran.com/media/54278/value-added-milk.jpg" alt="">
         <h3>Dairy</h3>
         <p>Milk is essentially an emulsion of fat and protein in water, along with dissolved sugar, minerals, and vitamins.</p>
         <a href="category.php?category=Dairy " class="btn">Dairy </a>
      </div>

      <div class="box">
         <img src="https://images.unsplash.com/photo-1608198093002-ad4e005484ec?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8YmFrZXJ5JTIwcHJvZHVjdHN8ZW58MHx8MHx8&w=1000&q=80" alt="">
         <h3>Bakery</h3>
         <p>It is variety of breads, usually shaped by the tin in which it is baked a sweetened bread, often rich or delicate</p>
         <a href="category.php?category=Bakery" class="btn">Bakery</a>
      </div>

      <div class="box">
         <img src="https://globalfinx.in/wp-content/uploads/2021/03/whole-grain.jpg" alt="">
         <h3>Food and Grains</h3>
         <p>Grain is the harvested grasses such as wheat, oats, rice, and corn. It contains high proteins.</p>
         <a href="category.php?category=Food" class="btn">Food and Grains</a>
      </div>

      <div class="box">
         <img src="https://www.fodors.com/wp-content/uploads/2021/10/shutterstock_2049300533.jpg" alt="">
         <h3>Chocolates</h3>
         <p>Chocolate is a food made from cacao beans. It is sweet and used in many desserts like candy. </p>
         <a href="category.php?category=Chocolates" class="btn">Chocolates</a>
      </div>
      <div class="box">
         <img src="https://www.msc.com/-/media/images/msc-cargo/sectors/agriculture/vegetables/msc21008136/msc21008136/msc21008136_s.jpg?w=1920&hash=4F7A45F7D8E97A1735462E3E3FDA80AC">
         <h3>Vegetables</h3>
         <p>vegetables are essential for humans. We provide Fresh, healthy and chemical free vegetables at your door step. </p>
         <a href="category.php?category=Vegetables" class="btn">Vegetables</a>
      </div>


   </div>

</section>

<section class="products">

   <h1 class="title">featured products</h1>

   <div class="box-container">

   <?php
      $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
      $select_products->execute();
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" class="box" method="POST">
      <div class="price">Rs.<span><?= $fetch_products['price']; ?></span>/-</div>
      <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <div class="name"><?= $fetch_products['name']; ?></div>
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
      <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
     <!-- <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">-->
      <input type="number" min="1" value="1" name="p_qty" class="qty">
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

   </div>

</section>



<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>