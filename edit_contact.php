<?php
include 'db_connect.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM contacts WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    die("Contact not found");
}

$contact = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name        = mysqli_real_escape_string($conn, $_POST['name']);
    $email       = mysqli_real_escape_string($conn, $_POST['email']);
    $phone       = mysqli_real_escape_string($conn, $_POST['phone']);
    $category_id = intval($_POST['category_id']);

    $imagePath = $contact['image_path']; // الصورة القديمة
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = basename($_FILES['image']['name']);
        $imagePath = "images/" . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    $update_sql = "UPDATE contacts SET
                   name='$name',
                   email='$email',
                   phone='$phone',
                   category_id='$category_id',
                   image_path=" . ($imagePath ? "'$imagePath'" : "NULL") . "
                   WHERE id=$id";

    if (mysqli_query($conn, $update_sql)) {
        header("Location: index.php");
        exit();
    } else {
        die("Error: " . mysqli_error($conn));
    }
}

$categories = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Contact</title>
    <style>
        form { width: 300px; margin: 50px auto; }
        label { display: block; margin-top: 10px; }
        input, select { width: 100%; padding: 5px; }
        button { margin-top: 15px; padding: 5px 10px; }
        img { margin-top: 10px; border-radius: 5px; }
    </style>
</head>
<body>

<h2 style="text-align:center;">Edit Contact</h2>

<form method="post" enctype="multipart/form-data">
    <label>Name:</label>
    <input type="text" name="name" value="<?= $contact['name'] ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?= $contact['email'] ?>" required>

    <label>Phone:</label>
    <input type="text" name="phone" value="<?= $contact['phone'] ?>" required>

    <label>Category:</label>
    <select name="category_id" required>
        <?php while ($row = $categories->fetch_assoc()): ?>
            <option value="<?= $row['category_id'] ?>" <?= ($row['category_id'] == $contact['category_id']) ? "selected" : "" ?>>
                <?= $row['category_name'] ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label>Contact Image (اختياري لتغيير الصورة):</label>
    <input type="file" name="image" accept="image/*">
    <?php if(!empty($contact['image_path'])): ?>
        <img src="<?= $contact['image_path'] ?>" width="50" height="50">
    <?php endif; ?>

    <button type="submit">Save Changes</button>
</form>

<div style="text-align:center; margin-top:20px;">
    <a href="index.php">Back to Contacts List</a>
</div>

</body>
</html>
