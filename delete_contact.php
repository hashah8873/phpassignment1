<?php
include 'db.php'; // Connect to the database

// Get the contact ID from URL
$id = $_GET['id'];

// Delete contact from database
mysqli_query($conn, "DELETE FROM contacts WHERE id=$id");

// Redirect to index page
header("Location: index.php");
exit();
?>
