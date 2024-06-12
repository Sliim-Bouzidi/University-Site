<?php
// include the database connection code
include("db.php");

// get the topics from the database
$sql = "SELECT * FROM topics ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while ($row = $result->fetch_assoc()) {
    echo "<div class='topic'>";
    echo "<h2><a href='topic.php?id=" . $row["id"] . "'>" . $row["title"] . "</a></h2>";
    echo "<p>" . $row["description"] . "</p>";
    echo "<p>Created by: " . $row["created_by"] . " on " . $row["created_at"] . "</p>";
    echo "</div>";
  }
} else {
  echo "<p>No topics found.</p>";
}
?>