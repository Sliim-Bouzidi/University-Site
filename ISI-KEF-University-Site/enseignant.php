<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['cin'])) {
  header('Location: http://localhost/gptestt/Gp/sign-up-login/index2.php');
  exit;
}


// Get the user's information from the session
$cin = $_SESSION['cin'];
$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
$grade = $_SESSION['grade'];
$imageData = $_SESSION['image'];

// Convert the image data to a base64-encoded string
$imageBase64 = base64_encode($imageData);
$imageSrc = 'data:image/jpeg;base64,' . $imageBase64;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Gp Bootstrap Template - Index</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <style>
  * {
    margin: 0;
    padding: 0;
    font-family: "Poppins", sans-serif;
  }

  body {
    background: #ffccbc;
  }

  .action {
    position: fixed;
    top: 20px;
    right: 40px;
  }

  .action .profile {
    position: relative;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    overflow: hidden;
    cursor: pointer;
  }

  .action .profile img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .action .menu {
    position: absolute;
    top: 120px;
    right: -10px;
    padding: 10px 20px;
    background: #fff;
    width: 300px;
    box-sizing: 0 5px 25px rgba(0, 0, 0, 0.1);
    border-radius: 15px;
    transition: 0.5s;
    visibility: hidden;
    opacity: 0;
  }

  .action .menu.active {
    top: 80px;
    visibility: visible;
    opacity: 1;
  }

  .action .menu::before {
    content: "";
    position: absolute;
    top: -5px;
    right: 28px;
    width: 20px;
    height: 20px;
    background: #fff;
    transform: rotate(45deg);
  }

  .action .menu h2 {
    width: 100%;
    text-align: center;
    font-size: 18px;
    padding: 20px 0;
    font-weight: 500;
    color: #555;
    line-height: 1.5em;
  }

  .action .menu h2 span {
    font-size: 14px;
    color: #666666;
    font-weight: 300;
  }

  .action .menu ul li {
    list-style: none;
    padding: 16px 0;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
    display: flex;
    align-items: center;
  }

  .action .menu ul li img {
    max-width: 20px;
    margin-right: 10px;
    opacity: 0.5;
    transition: 0.5s;
  }

  .action .menu ul li:hover img {
    opacity: 1;
  }

  .action .menu ul li a {
    display: inline-block;
    text-decoration: none;
    color: #555;
    font-weight: 500;
    transition: 0.5s;
  }

  .action .menu ul li:hover a {
    color: #ff5d94;
  }

  #container {
    display: inline-block;
  }

  #text_type {
    letter-spacing: 8px;
    font-family: monospace;
    border-right: 1px solid;
    width: 100%;
    white-space: nowrap;
    overflow: hidden;
    animation: typing 3.2s steps(20), blink .5s step-end infinite;
  }

  @keyframes blink {
    0% {
      opacity: 1;
    }

    50% {
      opacity: 0;
    }

    100% {
      opacity: 1;
    }
  }

  @keyframes typing {
    from {
      width: 0;
    }

    to {
      width: 100%;
    }
  }

  #text_type:last-child {
    animation-delay: 0.3s;
    animation-iteration-count: 1;
    animation-fill-mode: forwards;
  }

  #text_type::after {
    content: "";
    display: inline-block;
    border-right: 2px solid;
    font-family: monospace;
    width: 100%;
    height: 1.4em;
    vertical-align: middle;
    background-color: white;
    animation: blink .6s step-end infinite;
  }
  </style>

  <!-- =======================================================
  * Template Name: Gp
  * Updated: Mar 10 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/gp-free-multipurpose-html-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center
        justify-content-lg-between">

      <h1 class="logo me-auto me-lg-0"><a href="index.html">ISI KEF<span>.</span></a></h1>

      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Espace Enseignant</a></li>
          <li><a class="nav-link scrollto" href="chat_forum.php">About</a></li>
          <li><a class="nav-link scrollto" href="#services">Services</a></li>
          <li><a class="nav-link scrollto " href="#portfolio">Portfolio</a></li>
          <li class="dropdown"><a href="course.php"><span>Courses</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="courses_view.php">My Courses</a></li>
            </ul>
          </li>
          <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
          <li><a class="nav-link scrollto" href="chat.php">Chat With Others</a></li>
          <li><a class="nav-link scrollto" href="forum.html">Discussion Forum</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>






    <div class="action">
      <div class="profile" onclick="menuToggle();">
        <img src="<?php echo $imageSrc ?>" alt="Profile Picture">
      </div>
      <div class="menu">
        <h2>
          <?php echo $_SESSION['prenom'] . " " . $_SESSION['nom']; ?><br />
          <span><?php echo $_SESSION['grade']; ?></span>
        </h2>
        <ul>
          <li>
            <img src="./assets2/icons/user.png" /><a href="enseignant.php">My profile</a>
          </li>
          <li>
            <img src="./assets2/icons/edit.png" /><a href="edit/edit2.php">Edit profile</a>
          </li>
          <li>
            <img src="./assets2/icons/log-out.png" /><a href="logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
    <script>
    function menuToggle() {
      const toggleMenu = document.querySelector(".menu");
      toggleMenu.classList.toggle("active");
    }
    </script>



  </header><!-- End Header -->


  <section id="hero" class="d-flex align-items-center justify-content-center">
    <div class="container" data-aos="fade-up">

      <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="150">
        <div class="col-xl-6 col-lg-8">
          <div id="container">
            <h1 id="text_type">Welcome As Teacher<span>.</span></h1>
          </div>
          <h2> <?php echo "Bonjour " . $_SESSION['prenom'] . " " . $_SESSION['nom']; ?></h2>
        </div>
      </div>
  </section>




  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center
        justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>