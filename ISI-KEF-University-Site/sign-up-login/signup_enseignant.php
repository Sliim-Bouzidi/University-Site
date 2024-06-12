<?php
// Get the form data
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$cin = $_POST['cin'];
$email = $_POST['email'];
$pass = $_POST['pass'];
$grade = $_POST['grade'];
$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "isikef");

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Check if the user already exists in the "Etudiant" table
$check_sql = "SELECT COUNT(*) as count FROM Enseignant WHERE CIN='$cin' OR Email='$email'";
$check_result = mysqli_query($conn, $check_sql);
$check_row = mysqli_fetch_assoc($check_result);

if ($check_row['count'] > 0) {
  // Display an error message and exit the script
  echo <<<EOT
    <html>
      <head>
        <title>Error</title>
        <style>
          /* CSS code for the dialog box */
          .dialog {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            padding: 20px;
            z-index: 999;
            width: 400px;
            max-width: 100%;
          }
          .dialog h2 {
            margin-top: 0;
            font-size: 24px;
            font-weight: bold;
          }
          .dialog p {
            margin: 20px 0;
            font-size: 18px;
          }
          .dialog button {
            margin-top: 20px;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            background-color: #e74c3c;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
          }
          .dialog button:hover {
            background-color: #c0392b;
          }
          .dialog .close-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
          }
        </style>
        <script src="https://kit.fontawesome.com/00891b6a34.js" crossorigin="anonymous"></script>
      </head>
      <body>
        <div class="dialog">
          <i class="fas fa-times close-icon" onclick="window.history.back();"></i>
          <h2>Error</h2>
          <p>User already exists.</p>
          <button onclick="window.history.back();">OK</button>
        </div>
      </body>
    </html>
EOT;
  exit();
}



// Insert the form data into the "enesignant" table
$sql = "INSERT INTO Enseignant (CIN, Nom, Prenom, Email, Password, Grade,Image) VALUES ('$cin', '$nom', '$prenom', '$email', '$pass', '$grade','$image')";

if (mysqli_query($conn, $sql)) {
  // Insert the CIN into the "Enseignat_about" table with a null "aboutme" field
  $aboutme = null;
  $insert_sql = "INSERT INTO Enseignant_about (CIN, aboutme) VALUES ('$cin', '$aboutme')";
  mysqli_query($conn, $insert_sql);

  header('Location: http://localhost/gptestt/Gp/enseignant.php');
} else {
  echo "Error adding record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>