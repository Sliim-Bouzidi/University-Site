<?php
// Start session to access user data
session_start();

// Connect to the database
$db_host = 'localhost';
$db_name = 'isikef';
$db_user = 'root';
$db_pass = '';
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
  die('Connection failed: ' . $conn->connect_error);
}

// Get the topic ID to delete
$user_id = $_SESSION['cin'];
$topic_id = $_GET['topic_id'];
$user = $_SESSION['prenom'] . ' ' . $_SESSION['nom'];

// Query the database to get the topic's user and type
$topic_query = "SELECT user, type, CIN FROM topics WHERE id = '$topic_id'";
$topic_result = $conn->query($topic_query);
if ($topic_result->num_rows > 0) {
  $topic_row = $topic_result->fetch_assoc();
  $topic_user = $topic_row['user'];
  $topic_type = $topic_row['type'];
  $usertopic_id = $topic_row['CIN'];
} else {
  echo 'Topic not found.';
  exit();
}

// Check if the current user is authorized to delete the topic
if ($user_id !== $usertopic_id) {

  include 'error.html';
  exit();
}

// Delete the related replies from the database
$delete_replies_query = "DELETE FROM replies WHERE topic_id = '$topic_id'";
if ($conn->query($delete_replies_query) === TRUE) {
  ?>
  <script>
  alert("Replies related to the topic deleted successfully.");
  window.location.href = "forum2.php";
  </script>
  <?php
} else {
  ?>
  <script>
  alert("Error deleting replies related to the topic: <?php echo $conn->error ?>");
  window.location.href = "forum2.php";
  </script>
  <?php
}

// Delete the topic from the database
$delete_topic_query = "DELETE FROM topics WHERE id = '$topic_id'";

if ($conn->query($delete_topic_query) === TRUE) {
  ?>
  <script>
  alert("Topic deleted successfully.");
  window.location.href = "forum2.php";
  </script>
  <?php
} else {
  ?>
  <script>
  alert("Error deleting topic: <?php echo $conn->error ?>");
  window.location.href = "forum2.php";
  </script>
  <?php
}

$conn->close();
?>