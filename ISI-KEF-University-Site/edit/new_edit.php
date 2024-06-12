<?php
// Start a session to access user data across pages
session_start();

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "isikef";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the user's information from the session
  $cin = $_SESSION['cin'];


  // Retrieve the form data
  $new_nom = $_POST["nom"];
  $new_prenom = $_POST["prenom"];
  $new_email = $_POST["email"];
  $new_password = $_POST["pass"];
  $new_classe = $_POST["classe"];
  $new_aboutme = $_POST["aboutme"];


  // Update the user's information in the database
  $stmt = mysqli_prepare($conn, "UPDATE Etudiant SET Nom=?, Prenom=?, Email=?, Password=?, Classe=? WHERE CIN=?");
  mysqli_stmt_bind_param($stmt, "ssssss", $new_nom, $new_prenom, $new_email, $new_password, $new_classe, $cin);
  mysqli_stmt_execute($stmt);


  // Update the user's 'aboutme' information in the database
  $stmt = mysqli_prepare($conn, "SELECT * FROM Etudiant_about WHERE CIN = ?");
  mysqli_stmt_bind_param($stmt, "s", $cin);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  // If a row exists, update it with the new 'aboutme' value
  if (mysqli_num_rows($result) > 0) {
    $stmt = mysqli_prepare($conn, "UPDATE Etudiant_about SET aboutme = ? WHERE CIN = ?");
    mysqli_stmt_bind_param($stmt, "ss", $new_aboutme, $cin);
    mysqli_stmt_execute($stmt);
    echo "Row updated successfully";
  } else {
    // If a row doesn't exist, insert a new row with the 'cin' and 'aboutme' values
    $stmt = mysqli_prepare($conn, "INSERT INTO Etudiant_about (CIN, aboutme) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $cin, $new_aboutme);
    mysqli_stmt_execute($stmt);
    echo "New row inserted successfully";
  }

  // Set the session variables to the updated values
  $_SESSION['nom'] = $new_nom;
  $_SESSION['prenom'] = $new_prenom;
  $_SESSION['email'] = $new_email;
  $_SESSION['classe'] = $new_classe;
  $_SESSION['pass'] = $new_password;
  $_SESSION['aboutme'] = $new_aboutme;

  // Redirect the user to their profile page
  header('Location: http://localhost/gptestt/Gp/etudiant.php');
  exit();
}

// Close the database connection
mysqli_close($conn);
?>