<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_connect.php';

// جلب كل جهات الاتصال مع اسم التصنيف
$sql = "SELECT contacts.*, categories.category_name
        FROM contacts
        LEFT JOIN categories ON contacts.category_id = categories.category_id";
$result = mysqli_query($conn, $sql);
if (!$result) die("SQL Error: " . mysqli_error($conn));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Manager</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        a { text-decoration: none; color: blue; }
        img { border-radius: 5px; }
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
        <th>Category</th>
        <th>Image</th>
        <th>Action</th>
    </tr>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['phone'] ?></td>
            <td><?= $row['category_name'] ?></td>
            <td>
                <?php if(!empty($row['image_path'])): ?>
                    <img src="<?= $row['image_path'] ?>" width="50" height="50">
                <?php endif; ?>
            </td>
            <td>
                <a href="contact_details.php?id=<?= $row['id'] ?>">View</a> |
                <a href="edit_contact.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="delete_contact.php?id=<?= $row['id'] ?>">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="7" style="text-align:center;">No contacts found</td>
        </tr>
    <?php endif; ?>
</table>

</body>
</html>
