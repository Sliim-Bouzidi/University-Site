<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "isikef";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get the topic id from the URL parameter
$topic_id = $_GET["topic_id"];

if (!isset($_GET["topic_id"])) {
  echo "Error: Topic ID not found";
  exit();
}

// Fetch the topic record from the database
$sql = "SELECT * FROM topics WHERE id = '$topic_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();

  // Check if the user is allowed to edit the topic
  session_start();
  $cin = $_SESSION["cin"];
  if ($row["CIN"] != $cin) {
    include 'errorEdit.html';
    exit();
    //header("Location: forum2.php");
  }

  $title = $row["title"];
  $description = $row["description"];
} else {
  // Topic not found
  $title = "";
  $description = "";
}

// Update the topic record in the database if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the new title and description from the form submission
  $new_title = $_POST["title"];
  $new_description = $_POST["description"];

  // Update the topic record in the database
  $update_sql = "UPDATE topics SET title='$new_title', description='$new_description' WHERE id='$topic_id'";
  if ($conn->query($update_sql) === TRUE) {
    echo "Topic updated successfully";
    // Redirect back to the forum page
    header("Location: forum2.php");
    exit();
  } else {
    echo "Error updating topic: " . $conn->error;
  }
}

// Close the database connection
$conn->close();

?>

<!DOCTYPE html>
<html>

<head>
  <title>Discussion Forum</title>
  <link rel="stylesheet" href="forum_style.css">
</head>

<body>
  <h1>Discussion Forum</h1>

  <form action="<?php echo $_SERVER['PHP_SELF'] . '?topic_id=' . $topic_id; ?>" method="POST">
    <input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">


    <label for="title">Title:</label>
    <input type="text" id="title" name="title" value="<?php echo $title; ?>" required>

    <label for="description">Topic:</label>
    <textarea id="description" name="description" required><?php echo $description; ?></textarea>

    <button type="submit" class="btn-primary">Update</button>
    <a href="forum.html" class="forum-link">Submit New Forum</a>

  </form>
</body>

</html>