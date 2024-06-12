<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['cin'])) {
  header('Location: http://localhost/gptestt/Gp/sign-up-login/index.php');
  exit();
}

// Get user's CIN, prenom, nom, and image from session
$cin = $_SESSION['cin'];
$prenom = $_SESSION['prenom'];
$nom = $_SESSION['nom'];
$image = $_SESSION['image'];
$type = $_SESSION["user_type"];

// Connect to database
$host = "localhost";
$dbname = "isikef";
$username = "root";
$password = "";
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

try {
  $pdo = new PDO($dsn, $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Connection failed: " . $e->getMessage());
}

// Insert topic into database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $description = $_POST['description'];

  if ($type === 'teacher') {
    $stmt = $pdo->prepare("INSERT INTO topics (CIN, title, description, user, type, image) 
                           SELECT :cin, :title, :description, :user, :type, :image 
                           FROM enseignant WHERE CIN = :cin");
    $stmt->execute([
      'cin' => $cin,
      'title' => $title,
      'description' => $description,
      'user' => "$prenom $nom",
      'type' => $type,
      'image' => $image
    ]);
  } else {
    $stmt = $pdo->prepare("INSERT INTO topics (CIN, title, description, user, type, image) 
                           SELECT :cin, :title, :description, :user, :type, :image
                           FROM etudiant WHERE CIN = :cin");
    $stmt->execute([
      'cin' => $cin,
      'title' => $title,
      'description' => $description,
      'user' => "$prenom $nom",
      'type' => $type,
      'image' => $image
    ]);
  }

  header('Location: http://localhost/gptestt/Gp/forum2.php');
  exit();
}
?>