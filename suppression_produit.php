<?php include_once "header.php"; ?>
<div id="main">
<?php include_once "fonctions/fonctions.php"; ?>

<?php
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $produitId = $_GET['id'];
    deleteProduit($mysqlclient, $produitId);
    echo "<p>Produit supprimé avec succès!</p>";
} else {
    echo "<p>ID de produit invalide.</p>";
}
?>
</div>
<?php include_once "footer.php"; ?>