<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'db_connect.php';

if (!isset($_GET['id'])) die("Contact ID is required.");

$contact_id = intval($_GET['id']);

$sql = "SELECT contacts.*, categories.category_name
        FROM contacts
        LEFT JOIN categories ON contacts.category_id = categories.category_id
        WHERE contacts.id = $contact_id";

$result = mysqli_query($conn, $sql);
if (!$result) die("SQL Error: " . mysqli_error($conn));

if (mysqli_num_rows($result) == 0) die("Contact not found.");

$contact = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Details</title>
    <style>
        .container { width: 400px; margin: 50px auto; text-align: center; }
        img { max-width: 200px; border-radius: 10px; margin-bottom: 20px; }
        .info { text-align: left; margin-top: 10px; }
        .info p { margin: 5px 0; font-size: 16px; }
        a { display: inline-block; margin-top: 20px; text-decoration: none; color: blue; }
    </style>
</head>
<body>

<div class="container">
    <h2>Contact Details</h2>

    <?php if(!empty($contact['image_path'])): ?>
        <img src="<?= $contact['image_path'] ?>" alt="Contact Image">
    <?php endif; ?>

    <div class="info">
        <p><strong>Name:</strong> <?= $contact['name'] ?></p>
        <p><strong>Email:</strong> <?= $contact['email'] ?></p>
        <p><strong>Phone:</strong> <?= $contact['phone'] ?></p>
        <p><strong>Category:</strong> <?= $contact['category_name'] ?></p>
    </div>

    <a href="index.php">Back to Contacts List</a>
</div>

</body>
</html>
