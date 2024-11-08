<?php
// Database configuration
$host = 'localhost';
$db_name = 'editor';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if content is set
    if (isset($_POST['content'])) {
        $content = $_POST['content'];

        // Check if content is not empty
        if (!empty($content)) {
            // Prepare and execute the insert query
            $stmt = $conn->prepare("INSERT INTO data (content) VALUES (:content)");
            $stmt->bindParam(':content', $content);
            $stmt->execute();

            echo "Content successfully submitted!";
        } else {
            echo "Content cannot be empty.";
        }
    } else {
        echo "No content was received.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>
