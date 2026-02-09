<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name        = mysqli_real_escape_string($conn, $_POST['name']);
    $email       = mysqli_real_escape_string($conn, $_POST['email']);
    $phone       = mysqli_real_escape_string($conn, $_POST['phone']);
    $category_id = intval($_POST['category_id']);

    // رفع الصورة
    $imagePath = NULL;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = basename($_FILES['image']['name']);
        $imagePath = "images/" . $imageName;
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            die("فشل رفع الصورة! تأكدي من صلاحيات مجلد images.");
        }
    }

    $sql = "INSERT INTO contacts (name, email, phone, category_id, image_path)
            VALUES ('$name', '$email', '$phone', '$category_id', " . ($imagePath ? "'$imagePath'" : "NULL") . ")";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        die("Error: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Contact</title>
    <style>
        form { width: 300px; margin: 50px auto; }
        label { display: block; margin-top: 10px; }
        input, select { width: 100%; padding: 5px; }
        button { margin-top: 15px; padding: 5px 10px; }
    </style>
</head>
<body>

<h2 style="text-align:center;">Add New Contact</h2>

<form method="POST" enctype="multipart/form-data">

    <label>Name:</label>
    <input type="text" name="name" required>

    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Phone:</label>
    <input type="text" name="phone" required>

    <label>Category:</label>
    <select name="category_id" required>
        <option value="">Select Category</option>
        <?php
        $categories = $conn->query("SELECT * FROM categories");
        while ($row = $categories->fetch_assoc()) {
            echo "<option value='{$row['category_id']}'>{$row['category_name']}</option>";
        }
        ?>
    </select>

    <label>Contact Image:</label>
    <input type="file" name="image" accept="image/*">

    <button type="submit">Save Contact</button>
</form>

<div style="text-align:center; margin-top:20px;">
    <a href="index.php">Back to Contacts List</a>
</div>

</body>
</html>
