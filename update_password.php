<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $conn = new mysqli("localhost", "root", "", "pickmytrack");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST["email"];
    $new_password = $_POST["new_password"];

    // Update the password in the database
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $new_password, $email);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Password updated successfully!'); window.location.href='login.html';</script>";
    } else {
        echo "<script>alert('❌ Failed to update password. Please try again.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Update Password</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background: linear-gradient(to right, #ffc3a0, #ffafbd);
    }
    .update-card {
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      text-align: center;
      width: 100%;
      max-width: 400px;
    }
    .update-card input {
      display: block;
      width: calc(100% - 20px);
      padding: 10px;
      margin: 10px auto;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .update-card button {
      background: #3a0ca3;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .update-card button:hover {
      background: #4361ee;
    }
  </style>
</head>
<body>
  <div class="update-card">
    <h2>Update Password</h2>
    <p>Enter your email and new password to update your account.</p>
    <form action="update_password.php" method="POST">
      <input type="email" name="email" placeholder="Email Address" required>
      <input type="password" name="new_password" placeholder="New Password" required>
      <button type="submit">Update Password</button>
    </form>
  </div>
</body>
</html>