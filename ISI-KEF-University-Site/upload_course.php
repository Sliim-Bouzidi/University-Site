<?php
// Start the session
session_start();

// Establish a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "isikef";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the form data and escape special characters
  $courseTitle = mysqli_real_escape_string($conn, $_POST["course_title"]);
  $courseLicence = mysqli_real_escape_string($conn, $_POST["course_Licence"]);
  $courseDescription = mysqli_real_escape_string($conn, $_POST["course_description"]);
  $price = mysqli_real_escape_string($conn, $_POST["price"]);
  if (isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] != '') {
    $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
  } else {
    $image = NULL;
  }

  // Set the target directory for file upload
  $targetDir = "uploads/";

  // Get the file name and type
  $fileName = basename($_FILES["file"]["name"]);
  $fileType = pathinfo($targetDir . $fileName, PATHINFO_EXTENSION);

  // Allow certain file formats
  $allowedTypes = array("jpg", "jpeg", "png", "gif", "svg", "bmp", "webp", "ico", "mp3", "wav", "aac", "mp4", "avi", "mkv", "mov", "wmv", "flv", "pdf", "txt", "doc", "docx", "xls", "xlsx", "ppt", "pptx");


  if (in_array(strtolower($fileType), $allowedTypes)) {

    // Generate a unique EnrollmentKey for this course
    $enrollmentKey = substr(uniqid(), -7);
    // Get the CIN of the teacher from the session
    $teacherCIN = $_SESSION['cin'];


    // Check if the teacher already has a EnrollmentKey in the database
    $sql = "SELECT EnrollmentKey FROM courses WHERE CIN = '$teacherCIN' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // Teacher already has a EnrollmentKey in the database, use it
      $row = $result->fetch_assoc();
      $enrollmentKey = $row["EnrollmentKey"];
    } else {
      // Teacher does not have a EnrollmentKey in the database, use the newly generated one
      $sql = "UPDATE courses SET EnrollmentKey = '$enrollmentKey' WHERE CIN = '$teacherCIN'";
      $conn->query($sql);
    }
    // Generate a unique file name
    $uniqueFileName = uniqid() . "_" . $fileName;

    // Set the target file path
    $targetFilePath = $targetDir . $uniqueFileName;

    // Move the file to the target directory
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {

      // Get the CIN of the teacher from the session
      $teacherCIN = $_SESSION['cin'];

      // Prepare the SQL statement
      $sql = "INSERT INTO courses (CourseTitle, CourseDescription, Classe, CourseFile, CIN, CourseImage, Price, EnrollmentKey)
            VALUES ('$courseTitle', '$courseDescription', '$courseLicence', '$uniqueFileName', '$teacherCIN', '$image', '$price', '$enrollmentKey')";

      // Execute the SQL statement
      if ($conn->query($sql) === TRUE) {
        // Course uploaded successfully
        $_SESSION['success'] = 'Course uploaded successfully';
        header('Location: courses_view.php');
        exit();
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }

      // Close the database connection
      $conn->close();
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  } else {
    echo "Sorry, only PDF, DOC, DOCX, and TXT files are allowed.";
  }
}
?>