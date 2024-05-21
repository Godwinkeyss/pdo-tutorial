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



 $statement = $pdo->prepare("SELECT * FROM products ORDER BY date_created DESC");
 $statement->execute();
 $products = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
    <div class="container-fluid">
            <h1 class="my-4">Crud Application</h1>
            <a href="create.php" class="btn btn-success">Create Product</a>
            
          <table class="table">
          <thead>
            <tr>
              
              <th scope="col">Id</th>
              <th scope="col">Image</th>
              <th scope="col">Title</th>
              <th scope="col">Price</th>
              <th scope="col">Date Created</th>
              <th scope="col">Edit</th>
              <th scope="col">Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php  foreach($products as $i=> $product):  ?>
            <tr>
              <th scope="row"><?=$i + 1 ?></th>
              <td><img src="<?=$product['image'] ?>" class="img-thumb"/> </td>
              <td><?=$product['title'] ?></td>
              <td><?=$product['price'] ?></td>
              <td><?=$product['date_created'] ?></td>
              <td><a href="edit.php?id=<?=$product['id'] ?>" class="btn btn-sm btn-outline-info">Edit</a></td>
              <td>
                <form action="delete.php" method="post">
                  <input type="hidden" name ="id" value="<?=$product['id']  ?>">
                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
                
              </td>
              
            </tr>
            <?php endforeach;  ?>
          
          </tbody>
        </table>
        </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
          </body>
</html>