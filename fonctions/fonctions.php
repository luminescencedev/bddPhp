<?php
try {
    $mysqlclient = new PDO('mysql:host=localhost;dbname=b2dev2;charset=utf8', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Selectionner un utilisateur
function userSelect($mysqlclient, $id) {
    $sqlQuery = 'SELECT * FROM users WHERE id = :id';
    $user = $mysqlclient->prepare($sqlQuery);
    $user->execute(['id' => $id]);
    return $user->fetch(PDO::FETCH_ASSOC);
}

// Modification d'un user
function userUpdate($mysqlclient, $userUpdate) {
    $sqlQuery = 'UPDATE users SET nom = :nom, prenom = :prenom, age = :age WHERE id = :id';
    $updateUser = $mysqlclient->prepare($sqlQuery);
    $updateUser->execute([
        'id' => $userUpdate['id'],
        'nom' => $userUpdate['nom'],
        'prenom' => $userUpdate['prenom'],
        'age' => $userUpdate['age']
    ]);
}

// Suppression user
function userSuppr($mysqlclient, $id) {
    $sqlQuery = 'DELETE FROM users WHERE id = :id';
    $user = $mysqlclient->prepare($sqlQuery);
    $user->execute(['id' => $id]);
}

// Suppression produit
function deleteProduit($mysqlclient, $id) {
    $sqlQuery = 'DELETE FROM produits WHERE id = :id';
    $stmt = $mysqlclient->prepare($sqlQuery);
    $stmt->execute(['id' => $id]);
}

// Mise à jour produit
function updateProduit($mysqlclient, $id, $titre, $description, $prix, $categorie) {
    $sqlQuery = 'UPDATE produits SET titre = :titre, description = :description, prix = :prix, categorie = :categorie WHERE id = :id';
    $stmt = $mysqlclient->prepare($sqlQuery);
    $stmt->execute([
        'id' => $id,
        'titre' => $titre,
        'description' => $description,
        'prix' => $prix,
        'categorie' => $categorie
    ]);
}

// Sélectionner un produit par ID
function getProduitById($mysqlclient, $id) {
    $sqlQuery = 'SELECT * FROM produits WHERE id = :id';
    $stmt = $mysqlclient->prepare($sqlQuery);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Vérification des données transmises dans l'url
if (isset($_GET['id']) && is_numeric($_GET['id']) && !empty($_GET['id'])) {
    $userSelect = userSelect($mysqlclient, $_GET['id']);
}

// Vérification des données transmises par le formulaire utilisateur
if (isset($_POST) && !empty($_POST)) {
    // On vérifie si l'id est envoyé
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // On vérifie si la suppression est possible ou non
        if (isset($_POST['suppr']) && !empty($_POST['suppr'])) {
            $id = $_POST['id'];
            userSuppr($mysqlclient, $id);
        } else {
            $userUpdate = $_POST;
            userUpdate($mysqlclient, $userUpdate);
        }
    } else {
        if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['age'])) {
            $userNew = $_POST;
            ajoutUser($mysqlclient, $userNew);
        }
    }
}

// Créer un menu qui est accessible sur toutes les pages header, footer
// base de donnée : créer une table produits
// id : PK, 
// titre: varchar(255), 
// description TEXT, 
// prix NUMERIC, 
// categorie INT

// base de donnée : créer une table categories
// id : PK, 
// titre: varchar(255), 

// FAIRE la CRUD de produits et categorie
// Quand je sélectionne une categorie ça doit lister tous les produits de cette catégorie

function getAllCategories($mysqlclient) {
    $stmt = $mysqlclient->query("SELECT * FROM categories");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllProduits($mysqlclient) {
    $stmt = $mysqlclient->query("SELECT * FROM produits");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getProduitsByCategorie($mysqlclient, $categorieId) {
    $stmt = $mysqlclient->prepare("SELECT * FROM produits WHERE categorie = :categorie");
    $stmt->execute(['categorie' => $categorieId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getCategorieByTitre($mysqlclient, $titre) {
    $stmt = $mysqlclient->prepare("SELECT * FROM categories WHERE titre = :titre");
    $stmt->execute(['titre' => $titre]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function insertCategorie($mysqlclient, $titre) {
    $stmt = $mysqlclient->prepare("INSERT INTO categories (titre) VALUES (:titre)");
    $stmt->execute(['titre' => $titre]);
    return $mysqlclient->lastInsertId();
}

function insertProduit($mysqlclient, $titre, $description, $prix, $categorieId) {
    $stmt = $mysqlclient->prepare("INSERT INTO produits (titre, description, prix, categorie) VALUES (:titre, :description, :prix, :categorie)");
    $stmt->execute([
        'titre' => $titre,
        'description' => $description,
        'prix' => $prix,
        'categorie' => $categorieId
    ]);
}

function ajoutUser($mysqlclient, $userNew) {
    $stmt = $mysqlclient->prepare("INSERT INTO users (nom, prenom, age) VALUES (:nom, :prenom, :age)");
    $stmt->execute([
        'nom' => $userNew['nom'],
        'prenom' => $userNew['prenom'],
        'age' => $userNew['age']
    ]);
}

function userAll($mysqlclient) {
    $stmt = $mysqlclient->query("SELECT * FROM users");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>