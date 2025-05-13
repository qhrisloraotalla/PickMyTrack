<?php
// Connect to DB
$conn = new mysqli("localhost", "root", "", "pickmytrack");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch students grouped by specialization using stored procedure
$tracks = ['BA', 'SM', 'NT'];
$results = [];

foreach ($tracks as $track) {
  $stmt = $conn->prepare("CALL GetStudentsByTrack(?)");
  $stmt->bind_param("s", $track);
  $stmt->execute();
  $result = $stmt->get_result();
  $results[$track] = $result->fetch_all(MYSQLI_ASSOC);
  $stmt->close();

  // Clear remaining results (required when using CALL in multi-query environments)
  while ($conn->more_results() && $conn->next_result()) {
    $conn->use_result();
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      margin: 40px;
    }
    h1 {
      text-align: center;
    }
    .track-section {
      margin-bottom: 40px;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 12px;
      text-align: left;
    }
    th {
      background-color: #eee;
    }

    #dropdownMenu {
    display: none;
    }

    #dropdownMenu.show {
      display: block;
    }


  </style>
</head>
<body>
<div class="top-border">
        <div class="header-container">
            <div class="left-section">
                <div class="logo">
                    <a href="homepage.html"><img src="PMTLOGO.png" alt="PickMyTrack Logo"></a>
                </div>
                <div class="title">Pick My Track</div>

            </div>

            <!-- User Dropdown -->
            <div class="user-dropdown" id="userDropdown">
                <div class="dropdown-header" id="dropdownHeader">
                 <div class="user-icon">
                 <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                 </svg>
                 </div>
                 <span class="username" id="usernameDisplay"></span>
                 <svg class="chevron" id="chevron" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                     <path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z" fill="currentColor"/>
                  </svg>
                 </div>
                   <div class="dropdown-menu" id="dropdownMenu">
                    <div class="dropdown-item" onclick="handleLogout()">LOG OUT</div>
                     </div>
                  </div>
        </div>
    </div>

    
<h1>Student Specialization Dashboard</h1>

<?php foreach ($results as $track => $students): ?>
  <div class="track-section">
    <h2><?= $track === 'BA' ? 'Business Analytics' : ($track === 'SM' ? 'Service Management' : 'Network Technology') ?></h2>
    <?php if (count($students) > 0): ?>
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($students as $student): ?>
            <tr>
              <td><?= htmlspecialchars($student['name']) ?></td>
              <td><?= htmlspecialchars($student['email']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No students assigned to this track yet.</p>
    <?php endif; ?>
  </div>
<?php endforeach; ?>

<script>
  document.addEventListener('DOMContentLoaded', function () {
      const userIcon = document.querySelector('.user-icon');
      const dropdownMenu = document.getElementById('dropdownMenu');
      const logoutButton = document.querySelector('.dropdown-item');

      // Toggle dropdown visibility when the user icon is clicked
      userIcon.addEventListener('click', function (event) {
          event.stopPropagation(); // Prevent click propagation
          dropdownMenu.classList.toggle('show');
      });

      // Close dropdown if clicked outside
      document.addEventListener('click', function (event) {
          if (!userIcon.contains(event.target) && !dropdownMenu.contains(event.target)) {
              dropdownMenu.classList.remove('show');
          }
      });

      // Handle logout
      logoutButton.addEventListener('click', function () {
          localStorage.removeItem("isLoggedIn");
          localStorage.removeItem("username");
          localStorage.removeItem("email");
          window.location.href = "index.html"; // Redirect to login page
      });
  });
</script>

</body>
</html>
