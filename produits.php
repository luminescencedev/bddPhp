<?php include_once "header.php"; ?>
<div id="main">
<?php include_once "fonctions/fonctions.php"; ?>
<h1>Produits</h1>
<ul>
<?php
if (isset($_GET['categorie'])) {
    $produits = getProduitsByCategorie($mysqlclient, $_GET['categorie']);
    foreach ($produits as $produit) {
        echo "<li>{$produit['titre']} - {$produit['description']} - {$produit['prix']}€ 
              <a href='edit_produit.php?id={$produit['id']}'>Editer</a> | 
              <a href='suppression_produit.php?id={$produit['id']}'>Supprimer</a></li>";
    }
} else {
    echo "<p>Veuillez sélectionner une catégorie.</p>";
}
?>
</ul>
</div>
<?php include_once "footer.php"; ?>