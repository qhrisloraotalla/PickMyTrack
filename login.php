<?php
// login.php

$conn = new mysqli("localhost", "root", "", "pickmytrack");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Admin login check
    if ($email === "admin" && $password === "adminpass") {
        header("Location: admindb.php");
        exit();
    }

    // Regular user login
   // Prepare the stored procedure call
    $stmt = $conn->prepare("CALL GetUserByEmail(?)");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if ($password === $user['password']) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            header("Location: nhomepage.html");
            exit();
        } else {
            echo "<script>alert('❌ Incorrect password. Please try again.'); window.location.href='index.html';</script>";
        }
    } else {
        echo "<script>alert('❌ No account found with that email. Please try again.'); window.location.href='index.html';</script>";
    }

    $stmt->close();

}

$conn->close();
?>