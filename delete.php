<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=pdotutorial', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$id = $_POST['id'] ??  null;

if(!$id){
    header('Location: index.php');
    exit;
}
// Retrieve the product to get the image path
$statement = $pdo->prepare("SELECT * FROM products WHERE id = :id");
$statement->bindValue(':id', $id);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);

if ($product) {
    // Unlink the image file if it exists
    if ($product['image']) {
        unlink($product['image']);
        $dirPath = dirname($product['image']);
        // Remove the directory if it is empty
        if (is_dir($dirPath) && count(glob("$dirPath/*")) === 0) {
            rmdir($dirPath);
        }
    }
}

$statement = $pdo->prepare("DELETE FROM products WHERE id = :id");
$statement->bindValue(':id', $id);
$statement->execute();


header('Location:index.php')

?>