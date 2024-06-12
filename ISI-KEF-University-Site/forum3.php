 <?php
 // Check if user is logged in, otherwise redirect to login page
 session_start();
 if (!isset($_SESSION['cin'])) {
   header('Location: login.php');
   exit();
 }

 // Set up the database connection using PDO
 $host = 'localhost';
 $dbname = 'isikef';
 $username = 'root';
 $password = '';
 $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
 $options = [
   PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
   PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
   PDO::ATTR_EMULATE_PREPARES => false,
 ];

 try {
   $pdo = new PDO($dsn, $username, $password);
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 } catch (PDOException $e) {
   echo "Connection failed: " . $e->getMessage();
 }

 // Check if topic_id is set
 if (isset($_GET['topic_id'])) {
   $topic_id = $_GET['topic_id'];
 } else {
   $topic_id = ''; // set default value  
 }

 // Query to retrieve the description and created_at of the topic
 $stmt = $pdo->prepare("SELECT * FROM topics WHERE id = ?");
 $stmt->execute([$topic_id]);
 $topic = $stmt->fetch(PDO::FETCH_ASSOC);

 // Get the image data from the database and convert it to base64 for display
 $imageData = $topic['image'];
 $imageBase64 = base64_encode($imageData);
 $imageSrc = 'data:image/jpeg;base64,' . $imageBase64;

 // Get the user information for display
 $username = $_SESSION['prenom'] . ' ' . $_SESSION['nom'];
 $user_type = $_SESSION["user_type"];

 if ($_SESSION['user_type'] === 'teacher') {
   $stmt = $pdo->prepare("SELECT image FROM enseignant WHERE CIN = ?");
   $stmt->execute([$_SESSION['cin']]);
   $user = $stmt->fetch(PDO::FETCH_ASSOC);
   $imageData = $user['image'];
   $imageBase64 = base64_encode($imageData);
   $userImage = 'data:image/jpeg;base64,' . $imageBase64;
 } else if ($_SESSION['user_type'] === 'student') {
   $stmt = $pdo->prepare("SELECT image FROM etudiant WHERE CIN = ?");
   $stmt->execute([$_SESSION['cin']]);
   $user = $stmt->fetch(PDO::FETCH_ASSOC);
   $imageData = $user['image'];
   $imageBase64 = base64_encode($imageData);
   $userImage = 'data:image/jpeg;base64,' . $imageBase64;
 }


 // Handle form submission
 if (isset($_POST['submit'])) {
   $user = $_SESSION['prenom'] . " " . $_SESSION["nom"];
   $reply_text = $_POST['reply_text'];
   $type = $_SESSION['user_type'];

   $topic_id = $topic['id'];

   // prepare the statement
   $stmt = $pdo->prepare("INSERT INTO replies (topic_id, user, reply_text, type, image) VALUES (?, ?, ?, ?, ?)");

   // bind parameters to the statement
   $stmt->bindParam(1, $topic_id, PDO::PARAM_INT);
   $stmt->bindParam(2, $user, PDO::PARAM_STR);
   $stmt->bindParam(3, $reply_text, PDO::PARAM_STR);
   $stmt->bindParam(4, $type, PDO::PARAM_STR);
   $stmt->bindParam(5, $imageData, PDO::PARAM_LOB);
   if ($stmt->execute()) {
     // Insertion successful
     $topic_id2 = $pdo->lastInsertId();
     header("Location: forum3.php?topic_id=$topic_id");
   } else {
     echo "Error: " . $stmt->errorInfo()[2];
   }
 }

 // Display the topic and reply form
 ?>


 <!DOCTYPE html>
 <html lang="en">

 <head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Reply to Topic</title>
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
   <link rel="stylesheet" href="css/emojionearea.css">
   <script src="https://code.jquery.com/jquery-3.6.4.min.js" popular_courses
     integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
   <script src="js/emojionearea.js"></script>

   <style>
   html {
     box-sizing: border-box;
   }

   *,
   *::before,
   *::after {
     box-sizing: inherit;
   }

   /* Remove margin and padding from the page */
   /*body {}*/

   /* Set default font size and line height */
   html,
   body {
     font-size: 16px;
     line-height: 1.5;
     background-color: #F7F7F7;

   }

   /* Set some default styles for headings */
   h1,
   h2,
   h3,
   h4,
   h5,
   h6 {
     margin: 0;
     font-weight: bold;
   }

   h1 {
     font-family: "Montserrat", sans-serif;
     font-size: 3rem;
     font-weight: 700;
     color: #333;
     text-transform: uppercase;
     letter-spacing: 0.1em;
     position: relative;
   }

   h1::before {
     content: "";
     position: absolute;
     width: 100%;
     height: 2px;
     bottom: 0;
     left: 0;
     background-color: #333;
     visibility: hidden;
     transform: scaleX(0);
     transition: all 0.3s ease-in-out 0s;
   }

   h1:hover::before {
     visibility: visible;
     transform: scaleX(1);
   }



   h2 {
     font-size: 2rem;
   }

   h3 {
     font-size: 1.75rem;
   }

   /* Set some default styles for links */
   a {
     color: inherit;
     text-decoration: none;
   }

   /* Set up the container for the page content */
   .container {
     max-width: 1200px;
     margin: 0 auto;
     padding: 2rem;
   }

   /* Set up the header for the page */
   .header {
     text-align: center;
     margin-bottom: 2rem;
   }

   /* Set up the profile container */
   .profile-container {
     display: flex;
     position: relative;
     background-color: #FFE6E6;
     padding: 1rem;
     border-radius: 1rem;
     margin: 40px;
     align-items: flex-start;
   }

   .profile-container .type {
     position: absolute;
     bottom: -15px;
     left: 95%;
     transform: translateX(-50%);
     background-color: #fff;
     padding: 5px 10px;
     border-radius: 20px;
     box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
     font-size: 14px;
     font-weight: bold;
     text-transform: uppercase;
   }


   .profile-image-container {
     width: 5rem;
     height: 5rem;
     border-radius: 50%;
     overflow: hidden;
     margin-right: 1.5rem;
     flex-shrink: 0;
   }

   .profile-image {
     width: 100%;
     height: 100%;
     object-fit: cover;
     border-radius: 50%;
   }

   .user-info {
     display: flex;
     flex-direction: column;
     justify-content: center;
     text-align: left;
   }

   .username {
     font-size: 1.25rem;
     font-weight: bold;
     margin-bottom: 0.1rem;
   }

   .type {
     font-size: 1.125rem;
     margin-bottom: 0.5rem;

   }

   .topic {
     font-family: "Open Sans", sans-serif;
     font-size: 1.25rem;
     font-weight: 600;
     letter-spacing: 0.05em;
     color: #444;
     padding: 0.5rem 0;
     transition: all 0.3s ease;
   }

   .topic:hover {
     color: #f44336;
     cursor: pointer;
   }

   /* Set up the reply form */
   .reply-form {
     margin: 0 auto;
     max-width: 700px;
   }

   label {
     display: block;
     font-size: 1.5rem;
     margin-bottom: 1rem;
   }

   .my-textarea {
     width: 100%;
     height: auto;
     padding: 1rem;
     font-size: 1.125rem;
     font-family: 'Open Sans', sans-serif;
     border-radius: 0.75rem;
     border: 1px solid #ccc;
     margin-bottom: 2rem;
     resize: vertical;
     background-color: #f9f9f9;
     box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
   }

   .my-textarea:hover {
     box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
   }


   button[type="submit"] {
     background-color: #4f46e5;
     color: #fff;
     border: none;
     padding: 0.75rem 1.5rem;
     border-radius: 0.5rem;
     font-size: 1.125rem;
     font-weight: 400;
     font-style: normal;
     font-family: "Inter", sans-serif;
     text-align: center;
     transition: background-color 0.3s ease;
   }

   button[type="submit"]:hover {
     background-color: #3b329f;
     cursor: pointer;
   }

   .action {
     position: fixed;
     top: 30px;
     right: 35px;
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
           <li><a class="nav-link scrollto active" href="#hero">Forum Space</a></li>
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
               <a href="etudiant.php">My profile</a>
             <?php } else if ($_SESSION['user_type'] == 'teacher') { ?>
                 <a href="enseignant.php">My profile</a>
             <?php } ?>
           </li>
           <li>
             <img src="./assets2/icons/edit.png" /><a href="edit/edit.php">Edit profile</a>
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

   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>

   <!-- Display the reply form -->
   <div class="container">
     <div class="header">

       <h1>Reply to Topic</h1>
     </div>
     <div class="profile-container">
       <div class="profile-image-container">
         <img src="<?php echo 'data:image/jpeg;base64,' . base64_encode($topic['image']); ?>" alt="Profile Picture"
           class="profile-image">
       </div>
       <div class="user-info">
         <div class="username"><?php echo $topic['user']; ?></div>
         <div class="type"><?php echo $topic['type']; ?></div>
       </div>
     </div>
     <div class="topic">
       <?php echo $topic['description']; ?>
     </div>
     <hr>
     <form class="reply-form" method="post" enctype="multipart/form-data">
       <label for="reply">Reply:</label>
       <textarea class="my-textarea" id="reply" name="reply_text" placeholder="Enter your message here..."
         required></textarea>
       <button type="submit" name="submit">Reply</button>
     </form>
   </div>

   <?php
   // Check if the form is submitted
   if (isset($_POST['submit'])) {
     $reply = $_POST['reply'];



     try {
       // Insert reply into the database
       $stmt = $pdo->prepare("INSERT INTO replies (user_id, topic_id, reply, filename, filetype, filesize, content) VALUES (?, ?, ?, ?, ?, ?, ?)");
       $stmt->execute([$user_id, $topic_id, $reply, $filename, $filetype, $filesize, $content]);
       echo "<div class='success'>Reply submitted successfully!</div>";
     } catch (PDOException $e) {
       echo "<div class='error'>Error: " . $e->getMessage() . "</div>";
     }
   }
   ?>

   <div class="container">
     <div class="header">
       <h1>New Replies</h1>
     </div>
     <?php
     // Fetch all the replies for the topic
     $stmt = $pdo->prepare("SELECT * FROM replies WHERE topic_id = ?");
     $stmt->execute([$topic_id]);
     $replies = $stmt->fetchAll(PDO::FETCH_ASSOC);

     // Display the replies
     foreach ($replies as $reply) {
       echo "<div class='reply-container'>";
       echo "<div class='profile-container' >";
       echo "<div class='profile-image-container'>";
       echo "<img src='" . 'data:image/jpeg;base64,' . base64_encode($reply['image']) . "' alt='Profile Picture' class='profile-image'>";
       echo "</div>";
       echo "<div class='user-info'>";

       echo "<div class='username'>" . $reply['user'] . "</div>";
       echo "<div class='reply' style='font-family: Arial, sans-serif; font-size: 18px; overflow-wrap: break-word; word-break: break-all;'>";
       echo $reply['reply_text'];
       echo "<br>";
       echo "</div>";
       echo "<div class='type'>" . $reply['type'] . "</div>";
       echo "</div>";

       echo "<br>";
       echo "<br>";
       echo "<br>";
       echo "</div>";

     }
     ?>
   </div>

   <br>
   <a href="logout.php" class="logout">Logout</a>



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
   <!-- <script src="emojiPicker.js"></script>
   <script>
   (() => {
     new EmojiPicker()
   })()
   </script>-->
   <script>
   $(document).ready(function() {
     $("#reply").emojioneArea({
       pickerPosition: "bottom"
     });
   })
   </script>
 </body>

 </html>