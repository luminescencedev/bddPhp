<?php include_once "header.php"; ?>
<div id="main">
<?php include_once "fonctions/fonctions.php"; ?>

<?php
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $produitId = $_GET['id'];
    $produit = getProduitById($mysqlclient, $produitId);
    if ($produit) {
        if (isset($_POST['update_produit'])) {
            $titre = $_POST['titre'];
            $description = $_POST['description'];
            $prix = $_POST['prix'];
            $categorie = $_POST['categorie'];

            updateProduit($mysqlclient, $produitId, $titre, $description, $prix, $categorie);
            echo "<p>Produit mis à jour avec succès!</p>";
        }
    } else {
        echo "<p>Produit non trouvé.</p>";
    }
} else {
    echo "<p>ID de produit invalide.</p>";
}
?>

<?php if ($produit): ?>
<form action="edit_produit.php?id=<?=$produitId?>" method="POST">
  <input type="text" name="titre" placeholder="Titre du produit" value="<?=$produit['titre']?>" required>
  <input type="text" name="description" placeholder="Description du produit" value="<?=$produit['description']?>" required>
  <input type="number" step="0.01" name="prix" placeholder="Prix du produit" value="<?=$produit['prix']?>" required>
  <input type="text" name="categorie" placeholder="Catégorie du produit" value="<?=$produit['categorie']?>" required>
  <input type="submit" name="update_produit" value="Mettre à jour">
</form>
<?php endif; ?>
</div>
<?php include_once "footer.php"; ?>