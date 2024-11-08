<?php
// Database configuration
$host = 'localhost';
$db_name = 'editor';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch only the latest submitted content
    $stmt = $conn->prepare("SELECT * FROM data ORDER BY created_at DESC LIMIT 1");
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo "<div>";
        echo "<h3>Entry ID: " . htmlspecialchars($result['id']) . "</h3>";
        echo "<p>" . nl2br(htmlspecialchars($result['content'])) . "</p>";
        echo "<p><em>Submitted on: " . htmlspecialchars($result['created_at']) . "</em></p>";
        echo "</div>";
    } else {
        echo "No entries found.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>
