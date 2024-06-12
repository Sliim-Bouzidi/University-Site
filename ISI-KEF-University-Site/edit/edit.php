<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['cin'])) {
  header('Location: http://localhost/gptestt/Gp/sign-up-login/index.php');
  exit;
}

// Get the user's information from the session
$cin = $_SESSION['cin'];
$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
$email = $_SESSION['email'];
$classe = $_SESSION['classe'];
$pass = $_SESSION['pass'];
$new_aboutme = $_SESSION['aboutme'];

// Check if the image data was updated
if (isset($_SESSION['updated_image_data'])) {
  $imageData = base64_decode($_SESSION['updated_image_data']);
  $_SESSION['image'] = $imageData;
  $imageBase64 = base64_encode($imageData);
  $imageSrc = 'data:image/jpeg;base64,' . $imageBase64;
} else {
  // Generate the image source for display
  $imageData = isset($_SESSION['temp_image']) ? $_SESSION['temp_image'] : $_SESSION['image'];
  $imageBase64 = base64_encode($imageData);
  $imageSrc = 'data:image/jpeg;base64,' . $imageBase64;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <div class="main-content">
    <!-- Top navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
      <div class="container-fluid">
        <!-- Brand -->
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block"
          href="http://localhost/gptestt/Gp/etudiant.php">User
          profile</a>

        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="http://localhost/gptestt/Gp/etudiant.php" role="button"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                  <img src="<?php echo $imageSrc ?>" alt="Profile Picture" style="object-fit: cover;">
                </span>
                <div class="media-body ml-2 d-none d-lg-block">

                  <span class="mb-0 text-sm font-weight-bold"><?php echo $prenom . ' ' . $nom ?></span>
                </div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-arrow
                dropdown-menu-right">
              <div class=" dropdown-header noti-title">
                <h6 class="text-overflow m-0">Welcome!</h6>
              </div>
              <a href="../examples/profile.html" class="dropdown-item">
                <i class="ni ni-single-02"></i>
                <span>My profile</span>
                <div class="dropdown-divider"></div>
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-user-run"></i>
                  <span>Logout</span>
                </a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    <!-- Header -->
    <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center" style="min-height: 600px; background-image:
        url(wallpaper.jpg);
        background-size: cover; ">
      <!-- Mask -->
      <span class="mask bg-gradient-default opacity-8"></span>
      <!-- Header container -->
      <div class="container-fluid d-flex align-items-center">
        <div class="row">
          <div class="col-lg-7 col-md-10">
            <h1 class="display-2 text-white"><?php echo "Hello " . $_SESSION['prenom'] . " " . $_SESSION['nom']; ?>
            </h1>
            <p class="text-white mt-0 mb-5">This is your profile page. You can
              see the progress you've made with your work and manage your
              projects or assigned tasks</p>

          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <form action="edit_image.php" method="POST" enctype="multipart/form-data">
      <div class="container-fluid mt--7">
        <div class="row">
          <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
            <div class="card card-profile shadow">
              <div class="row justify-content-center">
                <div class="col-lg-3 order-lg-2">
                  <div class="card-profile-image">
                    <a href="#">
                      <img src="<?php echo $imageSrc ?>" alt="Profile Picture" class="rounded-circle">
                    </a>
                  </div>
                </div>
              </div>
              <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0
                pb-md-4">

              </div>
              <div class="card-body pt-0 pt-md-4">
                <div class="row">
                  <div class="col">
                    <div class="card-profile-stats d-flex justify-content-center
                      mt-md-5">
                    </div>
                  </div>
                </div>

                <center><input type="file" type="submit" class="btn btn-info" name="image"></center>
                <br>
                <center><button type="submit" class="btn btn-info">Update Profile Picture</button>
                  <br>
                  <br>

                  <div class="text-center">
                    <h3>
                      <?php echo $prenom . ' ' . $nom ?><span class="font-weight-light">, <?php echo $classe ?></span>

                    </h3>

                    <br>



                    <div class="h5 mt-4">
                      <i class="ni business_briefcase-24 mr-2"></i>5 نهج صـــالح عياش, El Kef 7100

                    </div>
                    <div>
                      <i class="ni education_hat mr-2"></i>Institut Supérieur d'Informatique du Kef
                    </div>
                    <hr class="my-4">
                    <p><?php echo $new_aboutme ?></p>
                    <a href="#">Show more</a>
                  </div>
              </div>
            </div>
          </div>
          <div class="col-xl-8 order-xl-1">
            <div class="card bg-secondary shadow">
              <div class="card-header bg-white border-0">
                <div class="row align-items-center">
                  <div class="col-8">
                    <h3 class="mb-0">My account</h3>
                  </div>
                  <div class="col-4 text-right">
                    <a href="#!" class="btn btn-sm btn-primary">Settings</a>
                  </div>
                </div>
              </div>
    </form>
    <div class="card-body">
      <form action="new_edit.php" method="POST" enctype="multipart/form-data">
        <h6 class="heading-small text-muted mb-4">User information</h6>
        <div class="pl-lg-4">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group focused">
                <label class="form-control-label" for="input-username">Nom</label>
                <input type="text" id="input-username" class="form-control form-control-alternative"
                  placeholder="Votre Nom" name="nom" value="<?php echo $nom ?>">
              </div>
              <div class="form-group focused">
                <label class="form-control-label" for="input-username">Prenom</label>
                <input type="text" id="input-username" class="form-control form-control-alternative"
                  placeholder="Votre Prenom" name="prenom" value="<?php echo $prenom ?>">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group focused">
                <label class="form-control-label" for="input-first-name">Password</label>
                <input type="password" id="input-first-name" class="form-control form-control-alternative"
                  placeholder="Password" value="<?php echo $pass ?>" name="pass">
              </div>

              <div class="form-group focused">
                <label class="form-control-label" for="input-first-name">Classe</label>
                <input type="text" id="input-first-name" class="form-control form-control-alternative"
                  placeholder="Votre Classe" name="classe" value="<?php echo $classe ?>">
              </div>

            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">



              <div class="form-group">
                <label class="form-control-label" for="input-email">Email
                  address</label>
                <input type="email" id="input-email" class="form-control
                            form-control-alternative" placeholder="@isikef.u-jendouba.tn" value="<?php echo $email ?>"
                  name="email">
              </div>

            </div>
          </div>
        </div>
        <hr class="my-4">


        <!-- Description -->
        <h6 class="heading-small text-muted mb-4">About me</h6>
        <div class="pl-lg-4">
          <div class="form-group focused">
            <label>About Me</label>
            <textarea rows="4" class="form-control
                        form-control-alternative" placeholder="A Few Words About You.."
              name="aboutme"><?php echo $new_aboutme ?></textarea>
          </div>
        </div>
        <button type="submit" class="btn btn-info">Save Changes</button>
      </form>
    </div>
  </div>
  </div>
  </div>
  </div>
  </div>
  <footer class="footer">
    <div class="row align-items-center justify-content-xl-between">
      <div class="col-xl-6 m-auto text-center">
        <div class="copyright">
          <p>Espace Etudiant</p>
        </div>
      </div>
    </div>
  </footer>

</body>

</html>