<?php
include 'db.php'; // Connect to the database

// Fetch all contacts
$result = mysqli_query($conn, "SELECT * FROM contacts");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Manager</title>
    <style>
        table { border-collapse: collapse; width: 70%; margin: 20px auto; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        a { text-decoration: none; color: blue; }
    </style>
</head>
<body>

<h2 style="text-align:center;">My Contacts</h2>

<div style="text-align:center; margin-bottom:20px;">
    <a href="add_contact.php">Add New Contact</a>
</div>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Action</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['phone']; ?></td>
        <td>
            <a href="delete_contact.php?id=<?php echo $row['id']; ?>">Delete</a>
        </td>
    </tr>
    <?php } ?>

</table>

</body>
</html>
