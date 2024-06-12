<?php
session_start();

// check if user is logged in and is an admin
if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== "admin") {
    header("Location: /admin/admin.php"); // redirect to error page
    exit();
}

require 'database_connection.php';

$event_name = $_POST['event_name'];
$event_start_date = date("y-m-d", strtotime($_POST['event_start_date']));
$event_end_date = date("y-m-d", strtotime($_POST['event_end_date']));

$insert_query = "INSERT INTO `calendar_event_master`(`event_name`,`event_start_date`,`event_end_date`) VALUES ('" . $event_name . "','" . $event_start_date . "','" . $event_end_date . "')";

if (mysqli_query($con, $insert_query)) {
    $data = array(
        'status' => true,
        'msg' => 'Event added successfully!'
    );
} else {
    $data = array(
        'status' => false,
        'msg' => 'Sorry, Event not added.'
    );
}
echo json_encode($data);
?>