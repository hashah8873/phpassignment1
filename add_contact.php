<?php
include 'db.php'; // Connect to the database

// Check if form is submitted
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Insert contact into database
    mysqli_query($conn, "INSERT INTO contacts (name, email, phone) VALUES ('$name', '$email', '$phone')");

    // Redirect to index page
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Contact</title>
</head>
<body>

<h2 style="text-align:center;">Add New Contact</h2>

<form method="post" style="width:300px; margin:auto;">
    Name:<br>
    <input type="text" name="name" required><br><br>
    Email:<br>
    <input type="email" name="email" required><br><br>
    Phone:<br>
    <input type="text" name="phone" required><br><br>
    <input type="submit" name="submit" value="Add Contact">
</form>

</body>
</html>
