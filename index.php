<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>DisasterLink | Emergency Portal</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    :root {
      --dl-accent: #00d2ff;
      --dl-primary: #0081a7;
      --dl-bg: #fdfdfd;
      --dl-card-bg: #ffffff;
      --dl-dark: #0f172a;
      --dl-danger: #ef4444;
    }

    body {
      font-family: 'Inter', sans-serif;
      background-color: var(--dl-bg);
      color: var(--dl-dark);
      overflow-x: hidden;
    }

    h1, h2, .navbar-brand {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 800;
      letter-spacing: -0.02em;
    }

    /* Modern Minimal Navbar */
    .navbar {
      background: rgba(253, 253, 253, 0.8);
      backdrop-filter: blur(20px);
      border-bottom: 1px solid rgba(0,0,0,0.05);
      padding: 1rem 0;
    }

    /* Hero Section - Clean & High Impact */
    .hero-section {
      padding: 160px 0 60px;
      background: radial-gradient(circle at top right, rgba(0, 210, 255, 0.05), transparent);
    }

    .emergency-card {
      background: white;
      border-radius: 24px;
      padding: 2rem;
      box-shadow: 0 20px 50px rgba(0,0,0,0.05);
      border: 1px solid rgba(0,0,0,0.03);
      transition: all 0.3s ease;
    }

    /* Quick Action Buttons - UX Focused */
    .action-card {
      text-decoration: none;
      color: inherit;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 1.5rem;
      border-radius: 20px;
      background: #f8fafc;
      border: 1px solid transparent;
      transition: all 0.2s ease;
    }

    .action-card:hover {
      background: white;
      border-color: var(--dl-accent);
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 210, 255, 0.1);
      color: var(--dl-primary);
    }

    .action-icon {
      font-size: 2rem;
      margin-bottom: 1rem;
      color: var(--dl-primary);
    }

    /* The Main CTA Button */
    .btn-emergency {
      background: var(--dl-danger);
      color: white;
      border: none;
      padding: 1.2rem 2.5rem;
      border-radius: 16px;
      font-weight: 700;
      font-size: 1.1rem;
      box-shadow: 0 10px 25px rgba(239, 68, 68, 0.3);
      transition: all 0.3s ease;
    }

    .btn-emergency:hover {
      background: #dc2626;
      color: white;
      transform: scale(1.02);
      box-shadow: 0 15px 30px rgba(239, 68, 68, 0.4);
    }

    footer {
      background: var(--dl-dark);
      color: white;
      padding: 60px 0;
      margin-top: 80px;
    }

    .status-badge {
      display: inline-block;
      padding: 0.5rem 1rem;
      background: rgba(0, 210, 255, 0.1);
      color: var(--dl-primary);
      border-radius: 50px;
      font-size: 0.85rem;
      font-weight: 600;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="index.php">
      <div class="bg-info rounded-3 p-1 me-2 d-flex">
        <i class="bi bi-lightning-charge-fill text-white fs-5"></i>
      </div>
      <span>DisasterLink</span>
    </a>
    <div class="ms-auto">
      <a href="includes/admin_login.php" class="text-decoration-none text-muted small fw-bold">ADMIN ACCESS</a>
    </div>
  </div>
</nav>

<section class="hero-section">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <span class="status-badge">Live Relief Network</span>
        <h1 class="display-4 mb-3">Help is one <br><span class="text-info">tap away.</span></h1>
        <p class="lead text-secondary mb-5">Connect instantly with shelters, food banks, and emergency responders in your local area.</p>
        
        <div class="d-grid d-md-block gap-3">
          <a href="user/submit_report.php" class="btn btn-emergency me-md-3">
            <i class="bi bi-exclamation-octagon me-2"></i>REPORT EMERGENCY
          </a>
        </div>
      </div>
      
      <div class="col-lg-6">
        <div class="emergency-card">
          <div class="row g-3">
            <div class="col-6">
              <a href="user/resources.php" class="action-card">
                <i class="bi bi-house-heart action-icon"></i>
                <span class="fw-bold">Shelters</span>
              </a>
            </div>
            <div class="col-6">
              <a href="user/resources.php" class="action-card">
                <i class="bi bi-droplets action-icon"></i>
                <span class="fw-bold">Supplies</span>
              </a>
            </div>
            <div class="col-6">
              <a href="user/resources.php" class="action-card">
                <i class="bi bi-telephone-outbound action-icon"></i>
                <span class="fw-bold">Hotlines</span>
              </a>
            </div>
            <div class="col-6">
              <a href="user/submit_report.php" class="action-card">
                <i class="bi bi-camera-fill action-icon"></i>
                <span class="fw-bold">Upload Info</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-6 text-center text-md-start">
        <h4 class="fw-bold text-info">DisasterLink</h4>
        <p class="text-white-50">Providing a vital digital link during Mangalore's critical moments.</p>
      </div>
      <div class="col-md-6 text-center text-md-end mt-4 mt-md-0">
        <p class="mb-0 small text-white-50">A Project by</p>
        <p class="fw-bold">Varun, Varsha, Shlaghana & Sujan</p>
        <p class="small text-white-50">AJIET, Mangalore</p>
      </div>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>