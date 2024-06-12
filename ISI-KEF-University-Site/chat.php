<!DOCTYPE html>
<!-- Coding By CodingNepal - youtube.com/codingnepal -->
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Chat App</title>
  <link href="../assets/img/chat.jpg" rel="icon">
  <link rel="stylesheet" href="Chatstyle.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
</head>

<body>




  <?php
  ob_start();
  // Start the session
  session_start();

  // Check if the user is logged in
  if (!isset($_SESSION["cin"])) {
    // Redirect to the login page
    header("Location: ../index.php");
    exit();
  }
  // Connect to the database
  $host = "localhost";
  $dbname = "isikef";
  $username = "root";
  $password = "";

  try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
  }
  if ($_SESSION["user_type"] == "student") {
    $url = '../espace_etu.php';
  } elseif ($_SESSION["user_type"] == "teacher") {
    $url = '../espace_ens.php';
  }

  // Retrieve and display messages
  $messages_query = $pdo->query("SELECT * FROM messages ORDER BY date ASC");
  $imageData = $_SESSION['image'];

  // Convert the image data to a base64-encoded string
  
  echo '<div class="wrapper">';
  echo '<section class="chat-area"></section>';
  echo '<div id="myDiv" class="chat-box">';
  while ($message = $messages_query->fetch()) {
    $imageBase64 = base64_encode($message["image"]);
    $imageSrc = 'data:image/jpeg;base64,' . $imageBase64; ?>
    <img style="height:50px;width:50px" src="<?php echo $imageSrc ?>"> <?php ;
       echo "<p style='word-wrap: break-word;width: 400px;'><strong>" . $message["fullname"] . "</strong>: " . $message["message"] . "</p><p style='font-size:14px'>" . $message['date'] . "</p><br>";
  }
  echo '</div>';
  // Allow users to post messages
  if (isset($_POST["submit"])) {
    $username = $_SESSION["prenom"] . " " . $_SESSION["nom"];
    $message = $_POST["message"];

    $insert_query = $pdo->prepare("INSERT INTO messages (fullname, message, date,image) VALUES (:username, :message, NOW(),:image)");
    $insert_query->bindParam(":username", $username);
    $insert_query->bindParam(":message", $message);
    $insert_query->bindParam(":image", $imageData);
    $insert_query->execute();

    // Refresh the page to display the latest messages
    header("Refresh:0");
    exit();
  }
  ob_end_flush();
  ?>

  <!-- HTML form for posting messages -->
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="typing-area">
    <a href=<?php echo $url; ?>><button type="button" style="height:43px ;border-radius: 10px;margin-right:10px;"><i
          class="fa fa-home" aria-hidden="true" title="home"></i></button></a>
    <input type="text" name="message" id="message" placeholder="entrez votre message..." required>
    <button type="submit" name="submit" title="submit"><i class=" fab fa-telegram-plane"></i></button>

    </div>
  </form>

  <script>
  // Wait for the page to finish loading
  window.onload = function() {
    // Get the height of the entire document
    var targetDiv = document.getElementById("myDiv");

    // Set the scrollTop property of the target div to the scrollHeight to scroll to the bottom of the div
    targetDiv.scrollTop = targetDiv.scrollHeight;
  }
  </script>

  <script src="js/chat.js"></script>

</body>

</html>