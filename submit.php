<?php
include 'databasecon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form values and sanitize
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $dob = $_POST['dob'];
    $contact_number = trim($_POST['contact_number']);
    $food = isset($_POST['food']) ? implode(",", $_POST['food']) : "";
    $watch_movies = $_POST['watch_movies'] ?? null;
    $listen_radio = $_POST['listen_radio'] ?? null;
    $eat_out = $_POST['eat_out'] ?? null;
    $watch_tv = $_POST['watch_tv'] ?? null;

    // Basic validation
    $errors = [];

    if (empty($full_name)) $errors[] = "Full name is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (empty($dob)) $errors[] = "Date of birth is required.";
    if (empty($contact_number)) $errors[] = "Contact number is required.";
    if (empty($food)) $errors[] = "At least one food option must be selected.";
    if (!$watch_movies || !$listen_radio || !$eat_out || !$watch_tv) $errors[] = "All ratings must be selected.";

    if (count($errors) > 0) {
        // Display errors
        foreach ($errors as $e) {
            echo "<p style='color:red;'>$e</p>";
        }
        echo "<p><a href='index.html'>Go Back</a></p>";
        exit();
    }

    // Prepare insert query
    $stmt = $conn->prepare("INSERT INTO tbsurvey (
        full_name, email, dob, contact_number, food,
        watch_movies, listen_radio, eat_out, watch_tv
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssiiii", 
        $full_name, $email, $dob, $contact_number, $food,
        $watch_movies, $listen_radio, $eat_out, $watch_tv
    );

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Survey submitted successfully!</p>";
        echo "<p><a href='index.html'>Submit Another</a> | <a href='results.html'>View Results</a></p>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
