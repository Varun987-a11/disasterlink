<?php
// 1. Load centralized config
require_once 'config.php';

// 2. Admin credentials
$username = "admin";
$email = "admin@mail";
$password = "123"; // 💡 Tip: Change this to something stronger for hosting!

// 3. Hash the password (using modern BCRYPT)
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// 4. Check if admin already exists to avoid duplicates
$check = $conn->prepare("SELECT id FROM admins WHERE username = ? OR email = ?");
$check->bind_param("ss", $username, $email);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo "⚠️ Error: An admin with that username or email already exists.";
} else {
    // 5. Insert into DB
    $stmt = $conn->prepare("INSERT INTO admins (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "✅ Admin user created successfully.";
    } else {
        echo "❌ Error: " . $stmt->error;
    }
    $stmt->close();
}

$check->close();
$conn->close();
?>