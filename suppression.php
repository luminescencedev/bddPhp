<?php include_once "header.php"; ?>
<div id="main">
  <?php include_once "fonctions/fonctions.php"; ?>
  <h1>Formulaire de suppression</h1>
  <?php
  if ($userSelect) { ?>
  <form action="index.php" method="POST">
    <input type="hidden" name="id" value="<?=$userSelect['id']?>">
    <input type="hidden" name="suppr" value="1">
    <input type="submit" value="La suppression est définitive">
  </form>
  <?php
  }
  ?>
</div>
<?php include_once "footer.php"; ?>

