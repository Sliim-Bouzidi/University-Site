<?php
session_start();
if (isset($_POST['login'])) {
  // Database connection
  $conn = mysqli_connect("localhost", "root", "", "isikef");

  // Get the user input
  $login = $_POST['login'];
  $password = $_POST['password'];

  // Query the database
  $query = "SELECT * FROM admin WHERE Login='$login' AND Password='$password'";
  $result = mysqli_query($conn, $query);

  // Check if the user exists
  if (mysqli_num_rows($result) == 1) {
    // Set the session variables
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $password;
    $_SESSION["user_type"] = "admin";
    $_SESSION["admin"] = "admin";

    // Redirect to the admin space
    header('Location: http://localhost/gptestt/Gp/espace_admin.php');
    exit();
  } else {
    echo "Invalid login credentials. Please try again.";
  }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <title>Login V2</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--===============================================================================================-->
  <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="css/util.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <!--===============================================================================================-->
</head>

<body>

  <div class="limiter">
    <div class="container-login100" style="background-color: #e4e4e9;">
      <div class="wrap-login100">
        <form class="login100-form validate-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          <span class="login100-form-title p-b-26">
            Welcome As Admin
          </span>
          <span class="login100-form-title p-b-48">
            <img src="isikef.png" alt="" style=" max-width: 150px;
                height: auto;
                ">
          </span>

          <div class="wrap-input100 validate-input" data-validate="Valid email is:
              a@b.c">
            <input class="input100" type="text" name="login">
            <span class="focus-input100" data-placeholder="Login" required></span>
          </div>

          <div class="wrap-input100 validate-input" data-validate="Enter password">
            <span class="btn-show-pass">
              <i class="zmdi zmdi-eye"></i>
            </span>
            <input class="input100" type="password" name="password" required>
            <span class="focus-input100" data-placeholder="Password"></span>
          </div>

          <div class="container-login100-form-btn">
            <div class="wrap-login100-form-btn">
              <div class="login100-form-bgbtn"></div>
              <button class="login100-form-btn" type="submit">
                Login
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>


  <div id="dropDownSelect1"></div>
  <!--===============================================================================================-->
  <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
  <!--===============================================================================================-->
  <script src="vendor/animsition/js/animsition.min.js"></script>
  <!--===============================================================================================-->
  <script src="vendor/bootstrap/js/popper.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <!--===============================================================================================-->
  <script src="vendor/select2/select2.min.js"></script>
  <!--===============================================================================================-->
  <script src="vendor/daterangepicker/moment.min.js"></script>
  <script src="vendor/daterangepicker/daterangepicker.js"></script>
  <!--===============================================================================================-->
  <script src="vendor/countdowntime/countdowntime.js"></script>
  <!--===============================================================================================-->
  <script src="js/main.js"></script>

</body>

</html>