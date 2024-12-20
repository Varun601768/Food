<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'demo');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['background_image'])) {
        $targetDir = "uploads/";
        $fileName = basename($_FILES["background_image"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        // Upload file to server
        if (move_uploaded_file($_FILES["background_image"]["tmp_name"], $targetFilePath)) {
            // Insert file path into database
            $stmt = $conn->prepare("INSERT INTO background_images (image_path) VALUES (?)");
            $stmt->bind_param("s", $targetFilePath);
            $stmt->execute();
            echo "Image uploaded successfully!";
        } else {
            echo "Failed to upload image.";
        }
    }

    // Handle delete request
    if (isset($_POST['delete_image'])) {
        $id = $_POST['delete_image'];
        $stmt = $conn->prepare("SELECT image_path FROM background_images WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $image = $result->fetch_assoc();

        if ($image) {
            // Delete file from server
            unlink($image['image_path']);

            // Delete record from database
            $stmt = $conn->prepare("DELETE FROM background_images WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            echo "Image deleted successfully!";
        }
    }
}

// Fetch all images
$result = $conn->query("SELECT * FROM background_images");
$images = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Admin Panel</h1>
    <form method="POST" enctype="multipart/form-data">
        <label for="background_image">Add Background Image:</label>
        <input type="file" name="background_image" id="background_image" required>
        <button type="submit">Upload</button>
    </form>
    <h2>Existing Background Images</h2>
    <ul>
        <?php foreach ($images as $image): ?>
            <li>
                <img src="<?php echo $image['image_path']; ?>" alt="Background" style="width: 100px; height: auto;">
                <form method="POST" style="display: inline;">
                    <button type="submit" name="delete_image" value="<?php echo $image['id']; ?>">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
