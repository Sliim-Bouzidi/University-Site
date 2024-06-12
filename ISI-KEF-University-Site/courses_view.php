 <?php
 // Check if user is logged in, otherwise redirect to login page
 session_start();
 if (!isset($_SESSION['cin'])) {
   header('Location: sign-up-login/index2.php');
   exit();
 }

 // Establish a connection to the database
 $servername = "localhost";
 $username = "root";
 $password = "";
 $dbname = "isikef";

 $conn = mysqli_connect($servername, $username, $password, $dbname);

 if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
 }





 if ($_SESSION['user_type'] === 'teacher') {

   $conn = mysqli_connect($servername, $username, $password, $dbname);
   $cin = mysqli_real_escape_string($conn, $_SESSION['cin']);
   $query = "SELECT image FROM enseignant WHERE CIN = '$cin'";
   $result = mysqli_query($conn, $query);
   $user = mysqli_fetch_assoc($result);
   $imageData = $user['image'];
   $imageBase64 = base64_encode($imageData);
   $userImage = 'data:image/jpeg;base64,' . $imageBase64;
   mysqli_close($conn);
 } else if ($_SESSION['user_type'] === 'student') {
   $conn = mysqli_connect($servername, $username, $password, $dbname);
   $cin = mysqli_real_escape_string($conn, $_SESSION['cin']);
   $query = "SELECT image FROM etudiant WHERE CIN = '$cin'";
   $result = mysqli_query($conn, $query);
   $user = mysqli_fetch_assoc($result);
   $imageData = $user['image'];
   $imageBase64 = base64_encode($imageData);
   $userImage = 'data:image/jpeg;base64,' . $imageBase64;
   mysqli_close($conn);
 }



 ?>


 <!DOCTYPE html>
 <html lang="en">

 <head>
   <meta charset="utf-8">


   <title>owl carousel courses - Bootdey.com</title>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="courses_view.css">









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
   <link href="assets/css/style2.css" rel="stylesheet">





   <style>
   .success-message {
     background-color: green;
     color: white;
     padding: 10px;
     margin-top: 137px;
     margin-bottom: -137px;
   }
   </style>
 </head>

 <body>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
     integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
     crossorigin="anonymous"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
     integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
     crossorigin="anonymous" />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ti-icons@0.1.2/css/themify-icons.css">





   <!-- ======= Header ======= -->
   <header id="header" class="fixed-top ">
     <div class="container d-flex align-items-center
        justify-content-lg-between">

       <h1 class="logo me-auto me-lg-0"><a href="index.html">ISI KEF<span>.</span></a></h1>

       <!-- Uncomment below if you prefer to use an image logo -->
       <!-- <a href="index.html" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
       <nav id="navbar" class="navbar order-last order-lg-0">
         <ul>
           <li><a class="nav-link scrollto active" href="#hero">Courses Space</a></li>
           <li><a class="nav-link scrollto" href="#about">About</a></li>
           <li><a class="nav-link scrollto" href="#services">Services</a></li>
           <li><a class="nav-link scrollto " href="#portfolio">Portfolio</a></li>
           <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
           <li><a class="nav-link scrollto" href="chat.php">Chat With Others</a></li>
           <li><a class="nav-link scrollto" href="forum.html">Discussion Forum</a></li>
         </ul>
         <i class="bi bi-list mobile-nav-toggle"></i>
       </nav><!-- .navbar -->

     </div>






     <div class="action">
       <div class="profile" onclick="menuToggle();">
         <img src="<?php echo $userImage ?>" alt="Profile Picture">
       </div>
       <div class="menu">
         <h2>
           <?php echo $_SESSION['prenom'] . " " . $_SESSION['nom']; ?><br />

         </h2>
         <ul>
           <li>
             <img src="./assets2/icons/user.png" /><?php if ($_SESSION['user_type'] == 'student') { ?>
             <a href="enseignant.php">My profile</a>
             <?php } else if ($_SESSION['user_type'] == 'teacher') { ?>
             <a href="enseignant.php">My profile</a>
             <?php } ?>
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

   <?php

   if (isset($_SESSION['success'])) {
     echo '<div class="success-message">' . $_SESSION['success'] . '</div>';
     unset($_SESSION['success']);
   }
   ?>
   <script>
   // Find the success message element
   var successMessage = document.querySelector('.success-message');

   // If the success message element exists, add a timeout function to hide it after 3 seconds
   if (successMessage) {
     setTimeout(function() {
       successMessage.style.display = 'none';
     }, 1500);
   }
   </script>



   <div class="popular_courses">
     <div class="container">
       <div class="enrollment-key" onclick="copyToClipboard()">Click to copy Enrollment Key</div>
       <!-- new div for enrollment key -->
       <div class="row justify-content-center">
         <div class="col-lg-5">
           <div class="main_title">
             <h2 class="mb-3">Here's All of your Courses</h2>
             <p>ISI KEF Where Innovation Meets Education</p>

           </div>
         </div>
       </div>
       <div class="row">
         <?php
         // Establish a connection to the database
         $servername = "localhost";
         $username = "root";
         $password = "";
         $dbname = "isikef";

         $conn = mysqli_connect($servername, $username, $password, $dbname);

         if (!$conn) {
           die("Connection failed: " . mysqli_connect_error());
         }
         // Select the data from the courses table
         $cin = $_SESSION['cin'];
         $sql = "SELECT CourseTitle, CourseDescription, Classe, CourseFile, CourseImage, Price, Nom, Prenom, Image, EnrollmentKey FROM courses INNER JOIN enseignant ON courses.CIN = enseignant.CIN WHERE courses.CIN = '$cin'";

         $result = mysqli_query($conn, $sql);

         // Display the data in HTML
         if (mysqli_num_rows($result) > 0) {
           while ($row = mysqli_fetch_assoc($result)) {
             $course_title = $row["CourseTitle"];
             $course_desc = $row["CourseDescription"];
             $course_class = $row["Classe"];
             $course_file = $row["CourseFile"];
             $imageCourse = base64_encode($row['CourseImage']);
             $price = $row["Price"];
             $imageProfile = base64_encode($row['Image']);
             $enrollment_key = $row["EnrollmentKey"]; // retrieve enrollment key from database
             echo '<div class="owl-item active" style="width: 350px; margin-right: 30px;">';
             echo '<div class="col-lg-12">';
             echo '<div class="single_course">';
             echo '<div class="course_head">';
             $noImage = "No_Image_Available.jpg";
             if (empty($imageCourse)) {
               echo '<img class="img-fluid" src="' . $noImage . '" alt="" />';
             } else {
               echo '<img class="img-fluid" src="data:image/jpeg;base64,' . $imageCourse . '" alt="" />';
             }
             echo '</div>';
             echo '<div class="course_content">';
             echo '<span class="price">' . $price . '</span>';
             echo '<span class="tag mb-4 d-inline-block">' . $course_class . '</span>';
             echo '<h4 class="mb-3">';
             echo '<a href="#" style="word-wrap: break-word;">' . $course_title . '</a>';
             echo '</h4>';
             echo '<p>' . $course_desc . '</p>';
             echo '<div class="course_meta d-flex justify-content-lg-between align-items-lg-center flex-lg-row flex-column mt-4">';
             echo '<div class="authr_meta">';
             echo '<div class="profile">';
             echo '<img  src="data:image/jpeg;base64,' . $imageProfile . '" alt="" />';
             echo '</div>';
             echo '<br>';
             echo '<span class="author-name" style="white-space: nowrap;">' . $row["Prenom"] . ' ' . $row["Nom"] . '</span>';
             echo '</div>';
             echo '<div class="mt-lg-0 mt-3" style="position: absolute; right: 0; bottom: 30px;">';
             echo '<span class="meta_info mr-4">';
             echo '<a href="http://localhost/gptestt/Gp/uploads/' . $course_file . '" download> <i class="ti-download mr-2"></i>Download </a>';
             echo '</span>';
             echo '</div>';
             echo '</div>';
             echo '</div>';
             echo '</div>';
             echo '</div>';
             echo '</div>';

             // echo '</div>';
             echo "<script>document.querySelector('.enrollment-key').innerHTML = 'Enrollment Key: $enrollment_key';</script>"; // set content of enrollment-key div
           }
         } else {
           echo "No courses found in the database.";
         }

         // Close the database connection
         mysqli_close($conn);
         ?>
       </div>
     </div>
   </div>
   <script>
   function copyToClipboard() {
     var enrollmentKey = "<?php echo $enrollment_key ?>";
     var dummy = document.createElement("textarea");
     document.body.appendChild(dummy);
     dummy.value = enrollmentKey;
     dummy.select();
     document.execCommand("copy");
     document.body.removeChild(dummy);
     alert("Enrollment Key has been copied to your clipboard!");
   }
   </script>

   <style>
   .enrollment-key {
     position: relative;
     border-radius: 8px;
     border: 2px solid #ccc;
     padding: 10px;
     font-weight: bold;
     margin-top: 130px;
     width: 250px;
     font-family: 'Helvetica Neue', sans-serif;
     font-size: 16px;
     text-align: center;
     cursor: pointer;
     overflow: hidden;
     transition: all 0.3s ease;
     box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
   }

   .enrollment-key:hover {
     transform: translateY(-5px);
     box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.3);
   }

   .enrollment-key:before {
     content: "";
     position: absolute;
     top: 0;
     right: 100%;
     width: 0;
     height: 100%;
     background-color: #ccc;
     transition: all 0.3s ease-in-out;
   }

   .enrollment-key:hover:before {
     width: 100%;
     right: 0;
   }

   .enrollment-key:hover:after {
     content: "Click to Copy: "attr(data-enrollment-key);
     position: absolute;
     top: 0;
     right: 0;
     width: 100%;
     height: 100%;
     padding: 10px;
     color: #fff;
     font-size: 16px;
     font-family: 'Helvetica Neue', sans-serif;
     text-align: center;
     z-index: 1;
     background-color: #2196F3;
     border-radius: 8px;
     box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
     cursor: pointer;
   }
   </style>
   <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
   <script src="coursescript.js"></script>


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