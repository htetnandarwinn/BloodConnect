<!doctype html>
<?php
$basePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
if ($basePath === '/' || $basePath === '\\') {
  $basePath = '';
}
?>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>BloodConnect — Hero</title>
  <!-- <h1>Welcome to BloodConnect</h1> -->


  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Inter:wght@400;500;600&display=swap"
    rel="stylesheet" />
  <style>
    :root {
      --crimson: #c8102e;
      --crimson-dark: #a30e27;
      --pink-bg: #fce9ee;
      --pink-bg-2: #fbe0e7;
      --pink-soft: #f6b9c5;
      --pink-soft-2: #f3a8bc;
      --ink: #1b1b1f;
      --gray: #6b6b76;
      --white: #ffffff;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: "Inter", sans-serif;
      color: var(--ink);
      background: var(--white);
    }

    h1,
    h2,
    h3 {
      font-family: "Poppins", sans-serif;
    }

    /* ---------- NAVBAR ---------- */
    .navbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 18px 60px;
      background: var(--white);
      border-bottom: 1px solid #f2f2f4;
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .logo svg {
      width: 28px;
      height: 34px;
      flex-shrink: 0;
    }

    .logo .brand-name {
      font-size: 20px;
      font-weight: 700;
      line-height: 1.1;
    }

    .logo .brand-tagline {
      font-size: 11px;
      color: var(--gray);
      font-weight: 400;
    }

    .nav-links {
      display: flex;
      gap: 42px;
      list-style: none;
    }

    .nav-links a {
      text-decoration: none;
      color: var(--ink);
      font-weight: 600;
      font-size: 15px;
      padding-bottom: 8px;
      position: relative;
    }

    .nav-links a.active {
      color: var(--crimson);
      border-bottom: 2.5px solid var(--crimson);
    }

    .nav-actions {
      display: flex;
      gap: 14px;
    }

    .btn {
      font-family: "Inter", sans-serif;
      font-weight: 600;
      font-size: 14.5px;
      border-radius: 8px;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      border: none;
      transition:
        transform 0.15s ease,
        box-shadow 0.15s ease;
    }

    .btn:hover {
      transform: translateY(-1px);
    }

    .btn-outline {
      background: var(--white);
      color: var(--crimson);
      border: 1.5px solid var(--crimson);
      padding: 9px 18px;
    }

    .btn-filled {
      background: var(--crimson);
      color: var(--white);
      padding: 9px 18px;
      box-shadow: 0 4px 10px rgba(200, 16, 46, 0.25);
    }

    /* ---------- HERO ---------- */
    .hero {
      position: relative;
      background: var(--pink-bg);
      overflow: hidden;
      padding: 90px 60px 140px;
    }

    .hero-inner {
      display: grid;
      grid-template-columns: 1fr 1fr;
      align-items: center;
      gap: 40px;
      max-width: 1280px;
      margin: 0 auto;
      position: relative;
      z-index: 2;
    }

    .hero-content h2 {
      font-size: 50px;
      font-weight: 800;
      line-height: 1.15;
      margin-bottom: 22px;
    }

    .hero-content h2 .accent {
      color: var(--crimson);
      display: block;
    }

    .hero-content p {
      font-size: 16px;
      color: var(--gray);
      line-height: 1.7;
      max-width: 430px;
      margin-bottom: 34px;
    }

    .hero-buttons {
      display: flex;
      gap: 16px;
    }

    .hero-buttons .btn {
      padding: 15px 28px;
      font-size: 15px;
    }

    .hero-visual {
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .hero-visual svg {
      width: 100%;
      max-width: 480px;
      height: auto;
      position: relative;
      z-index: 2;
    }

    .wave-bottom {
      position: absolute;
      left: 0;
      bottom: 0;
      width: 100%;
      line-height: 0;
      z-index: 1;
    }

    .wave-bottom svg {
      width: 100%;
      height: 90px;
      display: block;
    }

    /* ---------- HOW IT WORKS ---------- */
    .how-it-works {
      background: var(--white);
      padding: 64px 60px 50px;
    }

    .section-inner {
      max-width: 1280px;
      margin: 0 auto;
    }

    .section-heading {
      text-align: center;
      margin-bottom: 50px;
    }

    .section-heading h3 {
      font-size: 30px;
      font-weight: 800;
      margin-bottom: 12px;
    }

    .heading-underline {
      display: inline-block;
      width: 54px;
      height: 4px;
      border-radius: 2px;
      background: var(--crimson);
    }

    .steps-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 32px;
    }

    .step-item {
      display: flex;
      align-items: flex-start;
      gap: 14px;
    }

    .step-icon {
      width: 56px;
      height: 56px;
      border-radius: 50%;
      background: #fdeaf0;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .step-icon svg {
      width: 23px;
      height: 23px;
    }

    .step-text h4 {
      font-size: 16px;
      font-weight: 700;
      margin-bottom: 6px;
    }

    .step-text p {
      font-size: 13.5px;
      color: var(--gray);
      line-height: 1.6;
    }

    /* ---------- FEATURE STRIP ---------- */
    .features-wrap {
      background: var(--white);
      padding: 0 60px 90px;
    }

    .features-box {
      max-width: 1280px;
      margin: 0 auto;
      background: var(--pink-bg-2);
      border-radius: 22px;
      padding: 42px 50px;
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 30px;
    }

    .feature-item {
      display: flex;
      align-items: flex-start;
      gap: 14px;
    }

    .feature-icon {
      flex-shrink: 0;
      padding-top: 2px;
    }

    .feature-icon svg {
      width: 25px;
      height: 25px;
    }

    .feature-text h4 {
      font-size: 15.5px;
      font-weight: 700;
      margin-bottom: 6px;
    }

    .feature-text p {
      font-size: 13px;
      color: var(--gray);
      line-height: 1.6;
    }

    /* ---------- RESPONSIVE ---------- */
    @media (max-width: 900px) {
      .navbar {
        flex-wrap: wrap;
        gap: 16px;
        padding: 16px 24px;
      }

      .nav-links {
        order: 3;
        width: 100%;
        justify-content: center;
        gap: 24px;
      }

      .hero {
        padding: 50px 24px 120px;
      }

      .hero-inner {
        grid-template-columns: 1fr;
        text-align: center;
      }

      .hero-content p {
        margin: 0 auto 30px;
      }

      .hero-buttons {
        justify-content: center;
      }

      .hero-content h2 {
        font-size: 38px;
      }

      .how-it-works {
        padding: 44px 24px 20px;
      }

      .steps-grid {
        grid-template-columns: 1fr;
        gap: 30px;
      }

      .features-wrap {
        padding: 0 24px 60px;
      }

      .features-box {
        grid-template-columns: 1fr;
        gap: 26px;
        padding: 32px;
      }
    }
  </style>
</head>

<body>
  <!-- ============ NAVBAR ============ -->
  <header class="navbar">
    <div class="logo">
      <svg viewBox="0 0 28 34" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
          d="M14 0C14 0 2 15.5 2 22.5C2 28.85 7.373 34 14 34C20.627 34 26 28.85 26 22.5C26 15.5 14 0 14 0Z"
          fill="#C8102E" />
        <path
          d="M9.5 22.5C9.5 22.5 11 26.5 14 26.5"
          stroke="#FBE0E7"
          stroke-width="2"
          stroke-linecap="round" />
      </svg>
      <div>
        <div class="brand-name">BloodConnect</div>
        <div class="brand-tagline">Donate Blood, Save Lives</div>
      </div>
    </div>

    <ul class="nav-links">
      <li><a href="<?= $basePath ?>/" class="active">Home</a></li>
      <li><a href="<?= $basePath ?>/register">Search Donor</a></li>
      <li><a href="<?= $basePath ?>/register">Blood Requests</a></li>
      <li><a href="<?= $basePath ?>/donor/register">Donors</a></li>
      <li><a href="<?= $basePath ?>/contact">Contact</a></li>
      <li><a href="<?= $basePath ?>/about">About</a></li>
    </ul>

    <div class="nav-actions">
      <a href="<?= $basePath ?>/login" class="btn btn-outline">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
          <path
            d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5Zm0 2c-3.31 0-10 1.66-10 5v3h20v-3c0-3.34-6.69-5-10-5Z"
            fill="currentColor" />
        </svg>
        Login
      </a>
      <a href="<?= $basePath ?>/register" class="btn btn-filled">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
          <path
            d="M15 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5Zm-6 2c-3.31 0-10 1.66-10 5v3h13.55c-.34-.91-.55-1.95-.55-3 0-2.06.78-3.93 2.05-5.36C13.13 13.61 11.6 14 10 14H9Zm12 1v3h3v-3h-3Zm0 5v3h-3v-3h3Zm3-5h-3v3h3v-3Z"
            fill="currentColor" />
        </svg>
        Register
      </a>
    </div>
  </header>

  <!-- ============ HERO ============ -->
  <section class="hero">
    <div class="hero-inner">
      <div class="hero-content">
        <h2>Donate Blood,<span class="accent">Save a Life</span></h2>
        <p>
          BloodConnect is a platform that connects blood donors with people in
          need. Find donors by blood group and location or submit a request in
          emergencies.
        </p>
        <div class="hero-buttons">
          <button class="btn btn-filled" id="searchDonorBtn">
            Search Donor
          </button>
          <button class="btn btn-outline" id="requestBloodBtn">
            Blood Requests
          </button>
        </div>
      </div>

      <div class="hero-visual">
        <svg viewBox="0 0 500 460" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <linearGradient
              id="bagGradient"
              x1="0%"
              y1="0%"
              x2="100%"
              y2="100%">
              <stop offset="0%" stop-color="#E63B53" />
              <stop offset="100%" stop-color="#7A0E22" />
            </linearGradient>
            <linearGradient
              id="dropGradient"
              x1="0%"
              y1="0%"
              x2="0%"
              y2="100%">
              <stop offset="0%" stop-color="#C2273F" />
              <stop offset="100%" stop-color="#8E1530" />
            </linearGradient>
            <filter
              id="softShadow"
              x="-40%"
              y="-40%"
              width="180%"
              height="180%">
              <feDropShadow
                dx="0"
                dy="14"
                stdDeviation="16"
                flood-color="#C8102E"
                flood-opacity="0.18" />
            </filter>
          </defs>

          <!-- decorative backdrop circle -->
          <circle cx="270" cy="230" r="205" fill="#F8D7DE" opacity="0.55" />

          <!-- motion lines -->
          <path
            d="M40,165 Q72,180 47,202"
            stroke="#F6B9C5"
            stroke-width="7"
            fill="none"
            stroke-linecap="round" />
          <path
            d="M55,198 Q88,213 60,236"
            stroke="#F6B9C5"
            stroke-width="7"
            fill="none"
            stroke-linecap="round" />
          <path
            d="M65,231 Q92,244 70,264"
            stroke="#F6B9C5"
            stroke-width="7"
            fill="none"
            stroke-linecap="round" />

          <!-- tube -->
          <path
            d="M236,330 C 254,358 296,378 336,382 C 386,387 424,358 422,326 C 420,298 388,288 368,304 C 354,315 362,334 378,330"
            stroke="#EC5C78"
            stroke-width="9"
            fill="none"
            stroke-linecap="round" />

          <!-- blood drop -->
          <path
            d="M398,82 C420,116 448,148 448,180 C448,208 426,226 398,226 C370,226 348,208 348,180 C348,148 376,116 398,82 Z"
            fill="url(#dropGradient)" />

          <!-- outer bag frame -->
          <g filter="url(#softShadow)">
            <rect
              x="128"
              y="58"
              width="206"
              height="266"
              rx="36"
              fill="#FFFFFF"
              stroke="#F4D6DD"
              stroke-width="2" />
          </g>
          <circle
            cx="231"
            cy="84"
            r="6"
            fill="#FFFFFF"
            stroke="#EFC4CF"
            stroke-width="2" />

          <!-- bottom connectors -->
          <rect
            x="193"
            y="306"
            width="20"
            height="24"
            rx="5"
            fill="#F3A8BC" />
          <rect
            x="227"
            y="306"
            width="20"
            height="24"
            rx="5"
            fill="#F3A8BC" />

          <!-- inner blood bag -->
          <rect
            x="153"
            y="98"
            width="156"
            height="166"
            rx="26"
            fill="url(#bagGradient)" />

          <!-- plus sign -->
          <rect
            x="217"
            y="132"
            width="28"
            height="98"
            rx="9"
            fill="#FFFFFF" />
          <rect
            x="182"
            y="167"
            width="98"
            height="28"
            rx="9"
            fill="#FFFFFF" />
        </svg>
      </div>
    </div>

    <!-- bottom wave divider -->
    <div class="wave-bottom">
      <svg
        viewBox="0 0 1440 90"
        preserveAspectRatio="none"
        xmlns="http://www.w3.org/2000/svg">
        <path
          d="M0,55 C220,5 460,90 760,60 C1040,32 1240,5 1440,40 L1440,90 L0,90 Z"
          fill="#FFFFFF" />
      </svg>
    </div>
  </section>

  <!-- ============ HOW IT WORKS ============ -->
  <section class="how-it-works">
    <div class="section-inner">
      <div class="section-heading">
        <h3>How It Works</h3>
        <span class="heading-underline"></span>
      </div>

      <div class="steps-grid">
        <div class="step-item">
          <div class="step-icon">
            <svg
              viewBox="0 0 24 24"
              fill="none"
              stroke="#C8102E"
              stroke-width="1.8"
              stroke-linecap="round"
              stroke-linejoin="round">
              <circle cx="9" cy="7" r="3.2" />
              <path d="M3.5 19c0-3 2.5-5 5.5-5s5.5 2 5.5 5" />
              <path d="M18 8v4M16 10h4" />
            </svg>
          </div>
          <div class="step-text">
            <h4>1. Register</h4>
            <p>Sign up as a donor or register to request blood.</p>
          </div>
        </div>

        <div class="step-item">
          <div class="step-icon">
            <svg
              viewBox="0 0 24 24"
              fill="none"
              stroke="#C8102E"
              stroke-width="1.8"
              stroke-linecap="round"
              stroke-linejoin="round">
              <circle cx="10.5" cy="10.5" r="6" />
              <path d="M19 19l-4.3-4.3" />
            </svg>
          </div>
          <div class="step-text">
            <h4>2. Search / Request</h4>
            <p>Search donors or submit a blood request easily.</p>
          </div>
        </div>

        <div class="step-item">
          <div class="step-icon">
            <svg
              viewBox="0 0 24 24"
              fill="none"
              stroke="#C8102E"
              stroke-width="1.8"
              stroke-linecap="round"
              stroke-linejoin="round">
              <path
                d="M6 9a6 6 0 1 1 12 0c0 4 1.5 5.5 1.5 5.5H4.5S6 13 6 9Z" />
              <path d="M10 18.5a2 2 0 0 0 4 0" />
            </svg>
          </div>
          <div class="step-text">
            <h4>3. Get Notified</h4>
            <p>Donors receive alerts and respond to help you.</p>
          </div>
        </div>

        <div class="step-item">
          <div class="step-icon">
            <svg
              viewBox="0 0 24 24"
              fill="none"
              stroke="#C8102E"
              stroke-width="1.8"
              stroke-linecap="round"
              stroke-linejoin="round">
              <path
                d="M12 20.5S3.5 15 3.5 9a4.5 4.5 0 0 1 8.5-2 4.5 4.5 0 0 1 8.5 2c0 6-8.5 11.5-8.5 11.5Z" />
            </svg>
          </div>
          <div class="step-text">
            <h4>4. Save Lives</h4>
            <p>Connect, donate and save precious lives.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============ FEATURE STRIP ============ -->
  <section class="features-wrap">
    <div class="features-box">
      <div class="feature-item">
        <div class="feature-icon">
          <svg
            viewBox="0 0 24 24"
            fill="none"
            stroke="#C8102E"
            stroke-width="1.8"
            stroke-linecap="round"
            stroke-linejoin="round">
            <path d="M12 3l7 3v5c0 5-3 8-7 10-4-2-7-5-7-10V6l7-3Z" />
            <path d="M9 12l2 2 4-4" />
          </svg>
        </div>
        <div class="feature-text">
          <h4>100% Safe &amp; Secure</h4>
          <p>Your information is always protected.</p>
        </div>
      </div>

      <div class="feature-item">
        <div class="feature-icon">
          <svg
            viewBox="0 0 24 24"
            fill="none"
            stroke="#C8102E"
            stroke-width="1.8"
            stroke-linecap="round"
            stroke-linejoin="round">
            <circle cx="9" cy="7" r="3.2" />
            <path d="M3.5 19c0-3 2.5-5 5.5-5s5.5 2 5.5 5" />
            <path d="M16 11.5l1.5 1.5 3-3.5" />
          </svg>
        </div>
        <div class="feature-text">
          <h4>Verified Donors</h4>
          <p>All donors are verified for your safety.</p>
        </div>
      </div>

      <div class="feature-item">
        <div class="feature-icon">
          <svg
            viewBox="0 0 24 24"
            fill="none"
            stroke="#C8102E"
            stroke-width="1.8"
            stroke-linecap="round"
            stroke-linejoin="round">
            <circle cx="12" cy="12" r="8.5" />
            <path d="M12 7.5V12l3.2 2" />
          </svg>
        </div>
        <div class="feature-text">
          <h4>24/7 Support</h4>
          <p>We're here to help you anytime.</p>
        </div>
      </div>

      <div class="feature-item">
        <div class="feature-icon">
          <svg
            viewBox="0 0 24 24"
            fill="none"
            stroke="#C8102E"
            stroke-width="1.8"
            stroke-linecap="round"
            stroke-linejoin="round">
            <path
              d="M12 21s-6.5-5.7-6.5-11A6.5 6.5 0 0 1 18.5 10c0 5.3-6.5 11-6.5 11Z" />
            <circle cx="12" cy="10" r="2.2" />
          </svg>
        </div>
        <div class="feature-text">
          <h4>Wide Network</h4>
          <p>Find donors and hospitals near you.</p>
        </div>
      </div>
    </div>
  </section>

  <script>
    // Nav link active state — allow normal navigation for real routes
    const navLinks = document.querySelectorAll(".nav-links a");
    navLinks.forEach((link) => {
      const href = link.getAttribute('href') || '';
      link.addEventListener("click", (e) => {
        // only intercept anchor links that are placeholders
        if (href.startsWith('#') || href === '') {
          e.preventDefault();
          document.querySelector('.nav-links a.active')?.classList.remove('active');
          link.classList.add('active');
        }
        // otherwise allow navigation to proceed
      });
    });

    // Set active link based on current path
    const url = new URL(window.location.href);
    const path = url.pathname.replace(/\/index\.php$/, '');
    const source = url.searchParams.get('source');

    navLinks.forEach((link) => {
      const href = link.getAttribute('href');
      if (!href || href === '#') {
        return;
      }
      const linkUrl = new URL(href, window.location.origin);
      const linkPath = linkUrl.pathname.replace(/\/index\.php$/, '');

      if (path === linkPath) {
        document.querySelector('.nav-links a.active')?.classList.remove('active');
        link.classList.add('active');
      }
    });

    // Hero buttons navigate to actual routes
    document.getElementById('searchDonorBtn').addEventListener('click', () => {
      window.location.href = '<?= $basePath ?>/register';
    });
    document.getElementById('requestBloodBtn').addEventListener('click', () => {
      window.location.href = '<?= $basePath ?>/register';
    });
  </script>
</body>

</html>