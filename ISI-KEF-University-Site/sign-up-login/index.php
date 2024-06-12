<?php
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

if (isset($_POST['login'])) {
  $cin = $_POST['cin'];
  $password = $_POST['password'];

  // Query the database for the entered CIN and password;
  $sql = "SELECT * FROM Etudiant JOIN Etudiant_about ON Etudiant.CIN = Etudiant_about.CIN WHERE Etudiant.CIN = '$cin' AND Etudiant.Password = '$password'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) == 0) { // No record found for the user in Etudiant_about
    $error_message = "Invalid CIN or password. Please try again.";
  } else {
    // Fetch the row from the result set
    $row = mysqli_fetch_assoc($result);

    // Save all the attributes in session variables
    $_SESSION['cin'] = $row['CIN'];
    $_SESSION['nom'] = $row['Nom'];
    $_SESSION['prenom'] = $row['Prenom'];
    $_SESSION['email'] = $row['Email'];
    $_SESSION['classe'] = $row['Classe'];
    $_SESSION['image'] = $row['Image'];
    $_SESSION['pass'] = $row['Password'];
    $_SESSION['aboutme'] = $row['aboutme'];
    $_SESSION["user_type"] = "student";

    // Redirect to the home page
    header('Location: http://localhost/gptestt/Gp/Etudiant.php');
    exit();
  }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <script src="formulaire.js">
  </script>
  <link rel="stylesheet" href="style.css" />
  <title>Sign in & Sign up Form</title>
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="sign-in-form" method="POST">
          <h2 class="title">Login</h2>
          <br>



          <?php

          if (isset($error_message)) { ?>
          <p><?php echo $error_message; ?></p>
          <?php } ?>



          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Votre CIN" name="cin" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name="password" required />
          </div>
          <input type="submit" value="Login" class="btn solid" name="login" />
          <p class="social-text">Or Sign in with social platforms</p>
          <div class="social-media">
            <a href="#" class="social-icon">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-google"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
        </form>
        <form action="signup_etudiant.php" class="sign-up-form" method="POST" onsubmit="return test()"
          enctype="multipart/form-data">
          <h2 class="title">Sign up</h2>

          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Votre CIN" name="cin" id="cin" />
          </div>


          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Votre Nom" name="nom" required />
          </div>


          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Votre Prenom" name="prenom" required />
          </div>



          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" placeholder="Email" name="email" id="email" />
          </div>


          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name="pass" id="pass" />
          </div>


          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Vtore Classe" name="classe" required />
          </div>
          <br>


          <div>
            <input type="file" name="image" required />
          </div>
          <br>



          <input type="submit" id="signup-button" class="btn" value="Sign up" />
          <p class="social-text">Or Sign up with social platforms</p>
          <div class="social-media">
            <a href="#" class="social-icon">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-google"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>New here ?</h3>
          <p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit.
            Debitis,
            ex ratione. Aliquid!
          </p>
          <button class="btn transparent" id="sign-up-btn">
            Sign up
          </button>
        </div>
        <img src="img/log.svg" class="image" alt="" />
      </div>
      <div class="panel right-panel">
        <div class="content">
          <h3>One of us ?</h3>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
            Nostrum
            laboriosam ad deleniti.
          </p>
          <button class="btn transparent" id="sign-in-btn">
            Sign in
          </button>
        </div>
        <img src="img/register.svg" class="image" alt="" />
      </div>
    </div>
  </div>

  <script src="app.js"></script>

  <!--
 /* <style>
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
  <div id="dialog" class="dialog" style="display: none;">
    <i class="fas fa-times close-icon" onclick="closeDialog();"></i>
    <h2>Error</h2>
    <p id="errorMessage"></p>
    <button onclick="closeDialog();">OK</button>
  </div>
  <script>
  function showErrorDialog(message) {
    var dialog = document.getElementById("dialog");
    var errorMessage = document.getElementById("errorMessage");
    errorMessage.innerText = message;
    dialog.style.display = "block";
  }

  function closeDialog() {
    var dialog = document.getElementById("dialog");
    dialog.style.display = "none";
  }

  document.getElementById("signup-button").addEventListener("click", function(event) {
    // Check if user already exists (replace this with your own logic)
    var userAlreadyExists = true;
    if (userAlreadyExists) {
      showErrorDialog("User already exists.");
      event.preventDefault();
    }
  });
  </script>-->

</body>

</html>