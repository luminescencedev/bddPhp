<?php include_once "header.php"; ?>

<div id="main">
<?php include_once "fonctions/fonctions.php"; ?>
  <h2>Formulaire pour les utilisateurs</h2>
  <form action="index.php" method="POST" onsubmit="disableSubmitButton(this)">
    <input type="text" name="nom" id="nom" placeholder="nom" required>
    <input type="text" name="prenom" id="prenom" placeholder="prenom" required>
    <input type="number" name="age" id="age" placeholder="age" required>
    <input type="submit" name="ajouter_user" value="envoyer">
  </form>

  <h2>Ajouter un produit</h2>
  <form action="index.php" method="POST">
    <input type="text" name="produit_titre" placeholder="Titre du produit" required>
    <input type="text" name="produit_description" placeholder="Description du produit" required>
    <input type="number" step="0.01" name="produit_prix" placeholder="Prix du produit" required>
    <input type="text" name="produit_categorie" placeholder="Catégorie du produit" required>
    <input type="submit" name="ajouter_produit" value="Ajouter le produit">
  </form>

  <?php
  if (isset($_POST['ajouter_user'])) {
      if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['age'])) {
          $userNew = [
              'nom' => $_POST['nom'],
              'prenom' => $_POST['prenom'],
              'age' => $_POST['age']
          ];
          ajoutUser($mysqlclient, $userNew);
      } else {
          echo "<p>Veuillez remplir tous les champs du formulaire utilisateur.</p>";
      }
  }

  if (isset($_POST['ajouter_produit'])) {
      if (!empty($_POST['produit_titre']) && !empty($_POST['produit_description']) && !empty($_POST['produit_prix']) && !empty($_POST['produit_categorie'])) {
          $produitTitre = $_POST['produit_titre'];
          $produitDescription = $_POST['produit_description'];
          $produitPrix = $_POST['produit_prix'];
          $produitCategorie = $_POST['produit_categorie'];

          // Check if category exists
          $categorie = getCategorieByTitre($mysqlclient, $produitCategorie);
          if (!$categorie) {
              // Insert new category
              $categorieId = insertCategorie($mysqlclient, $produitCategorie);
          } else {
              $categorieId = $categorie['id'];
          }

          // Insert product
          insertProduit($mysqlclient, $produitTitre, $produitDescription, $produitPrix, $categorieId);
          echo "<p>Produit ajouté avec succès!</p>";
      } else {
          echo "<p>Veuillez remplir tous les champs du formulaire produit.</p>";
      }
  }
  ?>

  <h2>Liste des users</h2>
  <?php 
    $users = userAll($mysqlclient);
    if (count($users) > 0) {
      foreach ($users as $key => $user) { ?>
          <p><?php echo $user['id'].' | '.$user['nom'].' | '.$user['prenom'].' | '.$user['age'].' ans ';  ?></p>
          <p><a href="edit.php?id=<?=$user['id']?>">Editer</a> | <a href="suppression.php?id=<?=$user['id']?>">Supprimer</a></p>
  <?php
      }
    } else {
      echo "<p>Pas d'utilisateurs inscrits</p>";
    }
  ?>

</div>
<?php include_once "footer.php"; ?>

<script>
function disableSubmitButton(form) {
    form.querySelector('input[type="submit"]').disabled = true;
}
</script>