<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $conn = new mysqli("localhost", "root", "", "hotel_booking");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get data from the form
    $hotelName = $_POST["hotelName"];
    $location = $_POST["location"];
    $pricePerNight = $_POST["price"];
    
    // Handle file upload
   // Handle file upload
$imagePath = "";
if (isset($_FILES["imageUpload"]) && $_FILES["imageUpload"]["error"] == 0) {
    // Specify the correct path to the "uploads" directory
    $imagePath = "uploads/" . $_FILES["imageUpload"]["name"];

    // Move the uploaded file to the destination directory
    if (move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $imagePath)) {
        echo "Hotel details added successfully.";
    } else {
        echo "Error moving the uploaded file.";
    }
}

    
    // Insert data into the database
    $sql = "INSERT INTO hotels (hotel_name, location, price_per_night, image_url) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssds", $hotelName, $location, $pricePerNight, $imagePath);
    
    if ($stmt->execute()) {
        echo "Hotel details added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>
