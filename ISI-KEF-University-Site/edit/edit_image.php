<?php
session_start();
// Connect to database
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'isikef';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die('Connection failed: ' . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the user's information from the session
  $cin = $_SESSION['cin'];

  // Check if file was uploaded successfully
  if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    // Get file details
    $image_name = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_type = $_FILES['image']['type'];

    // Check if file is an image
    if (strpos($image_type, 'image') === false) {
      echo 'Error: File is not an image';
    } else {
      // Update image attribute in database
      $cin = $_SESSION['cin'];
      $image_data = file_get_contents($image_tmp);
      $image_data = mysqli_real_escape_string($conn, $image_data);
      $sql = "UPDATE Etudiant SET Image='$image_data' WHERE CIN=$cin";
      if ($conn->query($sql) === true) {
        // Retrieve image data from the database
        $sql = "SELECT Image FROM Etudiant WHERE CIN=$cin";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $image_data = $row['Image'];

        // Create temporary file for image data
        $temp_file = tempnam(sys_get_temp_dir(), 'img');
        file_put_contents($temp_file, $image_data);

        // Update session variable with temporary file path
        $_SESSION['profile_picture'] = $temp_file;

        // Pass updated image data back to edit.php
        $updated_image_data = base64_encode($image_data);
        $_SESSION['updated_image_data'] = $updated_image_data;
        header("Location: http://localhost/gptestt/Gp/edit/edit.php");

        exit();
      } else {
        echo 'Error updating profile picture: ' . $conn->error;
      }

      $conn->close();
    }
  } else {
    header("Location: http://localhost/gptestt/Gp/edit/edit.php");
  }
}
?>