<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Resources | DisasterLink</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    :root {
      --dl-primary: #00bcd4;
      --dl-bg: #f8fafc;
      --dl-dark: #1e293b;
    }

    html, body {
      height: 100%;
      margin: 0;
      font-family: 'Inter', sans-serif;
      background-color: var(--dl-bg);
      display: flex;
      flex-direction: column;
    }

    h2, h4, .navbar-brand {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 700;
    }

    /* Navbar Glassmorphism */
    .navbar {
      background-color: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(12px);
      box-shadow: 0 2px 15px rgba(0,0,0,0.04);
      border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .navbar-brand {
      color: var(--dl-dark) !important;
    }

    .container-main {
      flex: 1 0 auto;
      padding-top: 100px;
      padding-bottom: 60px;
    }

    /* Resource Cards */
    .resource-card {
      background: white;
      border: none;
      border-radius: 20px;
      padding: 1.5rem;
      height: 100%;
      box-shadow: 0 10px 25px rgba(0,0,0,0.03);
      transition: transform 0.3s ease;
    }

    .resource-card:hover {
      transform: translateY(-5px);
    }

    .icon-box {
      width: 50px;
      height: 50px;
      background: rgba(0, 188, 212, 0.1);
      color: var(--dl-primary);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      margin-bottom: 1.25rem;
    }

    .emergency-list {
      list-style: none;
      padding: 0;
    }

    .emergency-list li {
      padding: 10px 0;
      border-bottom: 1px solid #f1f5f9;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .emergency-list li:last-child {
      border-bottom: none;
    }

    .btn-call {
      padding: 5px 15px;
      border-radius: 50px;
      font-size: 0.85rem;
      font-weight: 600;
    }

    footer {
      background-color: #0f172a;
      color: white;
      padding: 40px 0;
      margin-top: auto;
    }
  </style>
</head>
<body>

  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
      <a class="navbar-brand" href="../index.php">
        <i class="bi bi-broadcast text-info me-2"></i>DisasterLink
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="submit_report.php">Submit Report</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container container-main">
    <div class="row mb-5 text-center text-md-start">
      <div class="col-lg-8">
        <h2 class="display-5 mb-3">Emergency Resources</h2>
        <p class="lead text-secondary">Quick access to essential services and support systems in the Mangalore region.</p>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-md-4">
        <div class="resource-card">
          <div class="icon-box"><i class="bi bi-telephone-fill"></i></div>
          <h4>Helplines</h4>
          <p class="small text-muted mb-4">Immediate contact for rescue and medical aid.</p>
          <ul class="emergency-list">
            <li>
              <span>Emergency Response</span>
              <a href="tel:112" class="btn btn-outline-danger btn-call">112</a>
            </li>
            <li>
              <span>Fire Force</span>
              <a href="tel:101" class="btn btn-outline-danger btn-call">101</a>
            </li>
            <li>
              <span>Ambulance</span>
              <a href="tel:108" class="btn btn-outline-danger btn-call">108</a>
            </li>
          </ul>
        </div>
      </div>

      <div class="col-md-4">
        <div class="resource-card">
          <div class="icon-box"><i class="bi bi-house-heart-fill"></i></div>
          <h4>Safe Zones</h4>
          <p class="small text-muted mb-4">Verified locations for temporary housing.</p>
          <ul class="emergency-list">
            <li>
              <span>AJIET Campus</span>
              <span class="badge bg-success">Active</span>
            </li>
            <li>
              <span>Kottara Community Hall</span>
              <span class="badge bg-success">Active</span>
            </li>
            <li>
              <span>Town Hall Mangalore</span>
              <span class="badge bg-warning text-dark">Full</span>
            </li>
          </ul>
        </div>
      </div>

      <div class="col-md-4">
        <div class="resource-card">
          <div class="icon-box"><i class="bi bi-droplets-fill"></i></div>
          <h4>Supply Points</h4>
          <p class="small text-muted mb-4">Distribution centers for food and clean water.</p>
          <ul class="emergency-list">
            <li>
              <span>Central Railway Stn.</span>
              <span class="text-primary small">Water/Food</span>
            </li>
            <li>
              <span>Bejai Distribution Ctr.</span>
              <span class="text-primary small">Dry Rations</span>
            </li>
            <li>
              <span>Surathkal Aid Post</span>
              <span class="text-primary small">Medical/Food</span>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div class="mt-5 p-4 rounded-4 bg-white shadow-sm border">
        <h4 class="mb-4">How to use DisasterLink</h4>
        <div class="row g-4">
            <div class="col-md-4">
                <h6><i class="bi bi-1-circle-fill text-info me-2"></i>Submit Reports</h6>
                <p class="small text-muted">Use the map to pin exact locations of blocked roads or flooding to alert others.</p>
            </div>
            <div class="col-md-4">
                <h6><i class="bi bi-2-circle-fill text-info me-2"></i>Verify Information</h6>
                <p class="small text-muted">Check the reports page frequently for updates from your neighbors and local teams.</p>
            </div>
            <div class="col-md-4">
                <h6><i class="bi bi-3-circle-fill text-info me-2"></i>Access Aid</h6>
                <p class="small text-muted">Locate the nearest active supply point or shelter using the cards above.</p>
            </div>
        </div>
    </div>
  </div>

  <footer>
    <div class="container text-center">
      <p class="mb-1">© 2026 DisasterLink. All rights reserved.</p>
      <p class="mb-1">Made by <strong>Varun</strong></p>
      <p class="mb-0 small text-white-50">A J Institute of Engineering and Technology, Mangalore</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>