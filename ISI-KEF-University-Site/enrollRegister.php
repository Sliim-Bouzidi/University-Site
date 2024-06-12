<?php
session_start();

// make sure to include your database connection configuration here
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "isikef";

// create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// check if the connection was successful
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// check if the enrollment key and class were submitted in the form
if (isset($_POST['enrollment_key']) && isset($_POST['classLevel'])) {
  // retrieve the values from the form
  $enrollment_key = $_POST['enrollment_key'];
  $class_level = $_POST['classLevel'];

  // retrieve the student's CIN from the session variable
  $cin = $_SESSION['cin'];

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

  $stmt = $conn->prepare("SELECT * FROM courses WHERE EnrollmentKey = ? AND Classe = ?");
  $stmt_check->bind_param("ss", $enrollment_key, $class_level);
  $stmt_check->execute();
  $result = $stmt_check->get_result();

  // prepare the SQL statement to check if the enrollment information already exists in the database
  $stmt_check = $conn->prepare("SELECT * FROM enrollment WHERE CIN = ? AND Course_id = ?");

  // prepare the SQL statement to insert the enrollment information into the database
  $stmt_insert = $conn->prepare("INSERT INTO enrollment (CIN, Course_id, EnrollmentKey, Classe) VALUES (?, ?, ?, ?)");

  while ($row = $result->fetch_assoc()) {
    $course_id = $row["Course_id"];

    // bind the parameters and execute the SQL statement to check if the enrollment information already exists
    $stmt_check->bind_param("si", $cin, $course_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    // if the enrollment information does not exist, bind the parameters and execute the SQL statement to insert the enrollment information
    if ($result_check->num_rows === 0) {
      $stmt_insert->bind_param("siss", $cin, $course_id, $enrollment_key, $class_level);

      // execute the SQL statement and check if it was successful
      if ($stmt_insert->execute() === TRUE) {
        // continue to the next course
        continue;
      } else {
        // handle the error
        echo "Error: " . $stmt_insert->error;
        exit();
      }
    }
  }

  // close the prepared statements and database connection
  $stmt_check->close();
  $stmt_insert->close();
  $stmt->close();
  $conn->close();

  // redirect the user to courses_view3.php
  header("Location: courses_view3.php");
  exit();
}
?>