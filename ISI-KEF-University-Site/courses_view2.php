 <?php
 // Check if user is logged in, otherwise redirect to login page
 session_start();
 if (!isset($_SESSION['cin'])) {
   header('Location: sign-up-login/index.php');
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

 // Check if enrollment key and class level were submitted
 if (isset($_POST['enrollment_key']) && isset($_POST['classLevel'])) {
   // Retrieve input values from form submission and store in session variables
   $enrollment_key = mysqli_real_escape_string($conn, $_POST['enrollment_key']);
   $class_level = mysqli_real_escape_string($conn, $_POST['classLevel']);
   // check if the enrollment key and class level exist in the courses table
   $stmt_check = $conn->prepare("SELECT * FROM courses WHERE EnrollmentKey = ? AND Classe = ?");
   $stmt_check->bind_param("ss", $enrollment_key, $class_level);
   $stmt_check->execute();
   $result_check = $stmt_check->get_result();

   // if the enrollment key and class level do not exist, display an error message and redirect back to enrollment page
   if ($result_check->num_rows === 0) {
     echo "Incorrect enrollment key or class level.";
     header("Refresh: 2; url=enrollCourse.php");
     exit();
   }

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

         // Check if enrollment key and class level were submitted
         if (isset($_POST['enrollment_key']) && isset($_POST['classLevel'])) {
           // Retrieve input values from form submission and store in session variables
           $enrollment_key = mysqli_real_escape_string($conn, $_POST['enrollment_key']);
           $class_level = mysqli_real_escape_string($conn, $_POST['classLevel']);
           $_SESSION['enrollment_key'] = $enrollment_key;
           $_SESSION['class_level'] = $class_level;
         } else {
           // Check if session variables are set
           if (!isset($_SESSION['enrollment_key']) || !isset($_SESSION['class_level'])) {
             // Redirect to enrollment page if session variables are not set
             header('Location:http://localhost/gptestt/Gp/enrollCourse.php');
             exit();
           }

           // Retrieve enrollment key and class level from session variables
           $enrollment_key = $_SESSION['enrollment_key'];
           $class_level = $_SESSION['class_level'];
         }

         // Select the data from the courses table
         $sql = "SELECT CourseTitle, CourseDescription, Classe, CourseFile, CourseImage, Price, Nom, Prenom, Image, EnrollmentKey
  FROM courses
  INNER JOIN enseignant ON courses.CIN = enseignant.CIN
  WHERE courses.EnrollmentKey = '$enrollment_key' AND courses.Classe = '$class_level'";

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