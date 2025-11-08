<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Resources | DisasterLink</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

  <!-- Custom CSS -->
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f8f9fa;
    }
    footer {
      background-color: #343a40;
      color: #fff;
      padding: 30px 0;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="index.php">DisasterLink</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu"
      aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link active" href="resources.php">Resources</a></li>
        <li class="nav-item"><a class="nav-link" href="submit_report.php">Submit Report</a></li>
        <li class="nav-item"><a class="nav-link" href="view_reports.php">View Reports</a></li>
        <li class="nav-item"><a class="nav-link" href="dashboard.php">Admin Dashboard</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Main Content -->
<main class="container mt-5">
  <h2 class="mb-3 text-center">Emergency Resources</h2>
  <p class="text-center mb-4">Find essential resources and contact points to assist during a disaster.</p>

  <div class="row">
    <div class="col-md-4 mb-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Shelters</h5>
          <p class="card-text">Locate nearby relief shelters providing temporary housing and safety during emergencies.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Food & Water Points</h5>
          <p class="card-text">Find designated areas for food and water distribution managed by relief teams.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Emergency Services</h5>
          <p class="card-text">Quickly access information about nearby hospitals, police stations, and emergency contacts.</p>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- Footer -->
<footer class="text-center mt-5">
  <div class="container">
    <p class="mb-1">© 2025 DisasterLink. All rights reserved.</p>
    <p class="mb-1">Made by Varun, Varsha, Shlaghana & Sujan</p>
    <p class="mb-0">A J Institute of Engineering and Technology, Mangalore</p>
  </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

