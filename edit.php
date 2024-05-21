<?php

// $db_name = "mysql:host=localhost;dbname=pdotutorial";
// $username = "root";
// $password="";
// $con = new PDO($db_name,$username="root",$password="");

// if($con){
//     echo "Connection is successful";
// }

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=pdotutorial', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = $_GET['id'] ?? null;

if(!$id){
    header("Location:index.php");
    exit;
}
   
$statement = $pdo->prepare("SELECT * FROM products WHERE id = :id");
$statement->bindValue(':id', $id);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);

   $title =$product['title'];
   $price = $product['price'];
   $description = $product['description'];

   $errors = [];

   

if($_SERVER['REQUEST_METHOD'] === "POST"){
      // $image = $_POST['image'];
      $title = $_POST['title'];
      $price = $_POST['price'];
      $description = $_POST['description'];
    

      if(!$title){
        $errors[] = 'Please enter product title';
      }
      if(!$price){
        $errors[] = 'Please enter product price';
      }
      if(!$description){
        $errors[] = 'Please enter product description';
      }
      
      if(!is_dir('images')){
        mkdir('images');
      }

      if(empty($errors)){
      
        $image = $_FILES['image'] ?? null;
        $imagePath = $product['image'];

        

        if($image && $image['tmp_name']){

            if($product['image']){
                unlink($product['image']);
                $dirPath = dirname($product['image']);
                if (is_dir($dirPath) && count(glob("$dirPath/*")) === 0) {
                    rmdir($dirPath);
                }
            }
          $imagePath = 'images/'.randomstring(8).'/'.$image['name'];
          mkdir(dirname($imagePath));

          move_uploaded_file($image['tmp_name'], $imagePath);
          
         
        }
        
      





      $statement =  $pdo->prepare("UPDATE products SET image = :image, title = :title, price = :price, description = :description WHERE id = :id");
      $statement->bindValue(':image', $imagePath);
      $statement->bindValue(':title', $title);
      $statement->bindValue(':price', $price);
      $statement->bindValue(':description', $description);
      $statement->bindValue(':id', $id);
      $statement->execute();
      header('Location: index.php');
    }


    
}


function randomstring($n){
  $character = "0123456789abscdefgijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $str = "";
  for($i = 0; $i < $n; $i++){
       $index = rand(0, strlen($character) -1);
       $str .= $character[$index];
  }
  return $str;
}


?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet" />
  </head>
  <body>
    <!-- navbar -->

<nav class="navbar navbar-expand-lg  bg-dark border-bottom border-body" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" aria-disabled="true">Disabled</a>
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
    <!-- navbar end -->
    <div class="">
        <div class="row">
            <div class="col-md-3">
                <a href="index.php" class="btn btn-secondary mt-4">Back to Product</a>
            </div>
            <div class="col-md-6">
                <h1 class="my-4 bg-primary text-white text-center">Update product</h1>
                <h4>Update <?=$product['title']  ?></h4>
                
                    <?php if(!empty($errors)): ?>
                        <?php foreach ($errors as $error ):  ?>
                          <div class="alert alert-danger">
                            <div><?=$error ?></div>
                          </div>

                        <?php endforeach;  ?>
                        <?php endif; ?>
                 <form action="" method="POST" enctype="multipart/form-data">
                 
                    <?php if($product['image']): ?>
                    <img  src="<?=$product['image']  ?>" class="update-img"  />
                    <?php endif;  ?>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Title</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="title" value="<?=$title ?>">
                       
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Price</label>
                        <input type="number" step="0.01" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="price" value="<?=$price ?>">
                       
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Description</label>
                        <textarea type="password" class="form-control" id="exampleInputPassword1" name="description" value=""><?=$description ?></textarea>
                    </div>
                    <div class="mb-3">
                        <input type="file" name="image">
                    </div>
                   
                    <button type="submit" class="btn btn-success">Update Product</button>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
  
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>