<?php
session_start();

// DB connection
$conn = new mysqli("localhost", "root", "", "pickmytrack");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Make sure user is logged in
if (!isset($_SESSION['user_id'])) {
  die("User not logged in.");
}

$user_id = $_SESSION['user_id'];

// Score initialization
$scores = ["BA" => 0, "SM" => 0, "NT" => 0];
$neutral_count = 0;

// Count responses (same logic)
for ($i = 1; $i <= 75; $i++) {
  // BA Questions
  if (isset($_POST["ba$i"])) {
    $response = (int)$_POST["ba$i"];
    $inverted = 6 - $response; // Inversion logic to score answers
    $scores["BA"] += $inverted;
    if ($response === 3) $neutral_count++; // Count neutrals
  }
  // NT Questions
  elseif (isset($_POST["nt$i"])) {
    $response = (int)$_POST["nt$i"];
    $inverted = 6 - $response;
    $scores["NT"] += $inverted;
    if ($response === 3) $neutral_count++;
  }
  // SM Questions
  elseif (isset($_POST["sm$i"])) {
    $response = (int)$_POST["sm$i"];
    $inverted = 6 - $response;
    $scores["SM"] += $inverted;
    if ($response === 3) $neutral_count++;
  }
}

// Adjust the logic to ensure that if there are many neutrals, it doesn't skew the results unfairly.
if ($neutral_count > 15) {
  $scores["SM"] += 5;
}

// Sort and determine the best match
arsort($scores);
$best_match = array_key_first($scores);

// Check if user already has a result in the database
$query = "CALL CheckUserResult(?)"; // procedure is stored in the database
$stmt = $conn->prepare($query);
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->store_result(); // Store the result to check the number of rows

// If any rows exist, free the result and move to the next query
$stmt->free_result(); // Ensure no hanging results exist

// Move to the next result set (to avoid "Commands out of sync" error)
while ($conn->more_results()) {
    $conn->next_result(); // Move to the next result set, clearing any hanging results
}

// Delete any previous result for the user before inserting a new one
$delete_stmt = $conn->prepare("CALL DeleteUserResult(?)"); // procedure is stored in the database
if ($delete_stmt === false) {
    die("Error preparing statement for DeleteUserResult: " . $conn->error);
}
$delete_stmt->bind_param("i", $user_id);
$delete_stmt->execute();
$delete_stmt->close();

// Insert new record (most recent result)
$insert_stmt = $conn->prepare("CALL InsertResult(?, ?)"); // procedure is stored in the database
if ($insert_stmt === false) {
    die("Error preparing statement for InsertResult: " . $conn->error);
}
$insert_stmt->bind_param("is", $user_id, $best_match);
$insert_stmt->execute();
$insert_stmt->close();

// Close the connection
$stmt->close();
$conn->close();

// Redirect to the result page based on the highest score
header("Location: " . $best_match . ".html");
exit();
?>
