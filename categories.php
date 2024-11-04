<?php include_once "header.php"; ?>
<div id="main">
<?php include_once "fonctions/fonctions.php"; ?>
<h1>Categories</h1>
<ul>
<?php
$categories = getAllCategories($mysqlclient);
foreach ($categories as $category) {
    echo "<li><a href='produits.php?categorie={$category['id']}'>{$category['titre']}</a></li>";
}
?>
</ul>
</div>
<?php include_once "footer.php"; ?>