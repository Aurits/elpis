<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo isset($page_title) ? $page_title . ' | Elpis Initiative Uganda' : 'Elpis Initiative Uganda - Empowering Youth Through Art & Advocacy'; ?></title>
    <meta
      name="description"
      content="<?php echo isset($page_description) ? $page_description : 'Youth-led nonprofit empowering Ugandan youth through innovative, arts-based solutions addressing HIV/AIDS, mental health, and gender equality across six regions.'; ?>"
    />
    <meta
      name="keywords"
      content="Uganda, youth empowerment, HIV/AIDS awareness, mental health, gender equality, arts advocacy, nonprofit"
    />
    <meta name="author" content="Elpis Initiative Uganda" />

    <!-- Open Graph Meta Tags -->
    <meta
      property="og:title"
      content="<?php echo isset($page_title) ? $page_title . ' | Elpis Initiative Uganda' : 'Elpis Initiative Uganda - Empowering Youth Through Art & Advocacy'; ?>"
    />
    <meta
      property="og:description"
      content="<?php echo isset($page_description) ? $page_description : 'Youth-led nonprofit empowering Ugandan youth through innovative, arts-based solutions.'; ?>"
    />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://elpisuganda.org<?php echo isset($page_url) ? $page_url : ''; ?>" />
    <meta property="og:image" content="docs/EIU Black Slogan.png" />

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta
      name="twitter:title"
      content="<?php echo isset($page_title) ? $page_title . ' | Elpis Initiative Uganda' : 'Elpis Initiative Uganda'; ?>"
    />
    <meta
      name="twitter:description"
      content="<?php echo isset($page_description) ? $page_description : 'Youth-led nonprofit empowering Ugandan youth.'; ?>"
    />
    <meta name="twitter:image" content="docs/EIU White Slogan.png" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="images/EUI Black Logo.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="images/EUI Black Logo.png" />

    <!-- Stylesheets -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="styles.css" />

    <!-- Structured Data -->
    <script type="application/ld+json">
      {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "Elpis Initiative Uganda",
        "description": "Youth-led nonprofit empowering Ugandan youth through innovative, arts-based solutions addressing HIV/AIDS, mental health, and gender equality.",
        "url": "https://elpisuganda.org",
        "logo": "images/EUI Black Logo.png",
        "contactPoint": {
          "@type": "ContactPoint",
          "email": "officialeu@elpisuganda.org",
          "contactType": "General Inquiries"
        },
        "areaServed": ["Kampala", "Gulu", "Kotido", "Luuka", "Arua", "Mbarara"],
        "foundingDate": "2022",
        "founders": [
          {
            "@type": "Person",
            "name": "Nkuutu Brian Moses"
          },
          {
            "@type": "Person",
            "name": "Feni Desmond"
          }
        ]
      }
    </script>
  </head>
  <body>
    <!-- Skip to main content for accessibility -->
    <a href="#main-content" class="sr-only">Skip to main content</a>

    <!-- Header -->
    <header class="header" role="banner">
      <nav class="nav" role="navigation" aria-label="Main navigation">
        <div class="container">
          <div class="nav-container">
            <a
              href="index.php"
              class="nav-logo"
              aria-label="Elpis Initiative Uganda Homepage"
            >
              <img
                src="images/EUI Black Logo.png"
                alt="Elpis Initiative Uganda"
                class="logo"
                width="64"
                height="64"
              />
            </a>

            <ul class="nav-menu" role="menubar">
              <li role="none">
                <a href="index.php" class="nav-link <?php echo ($current_page == 'index') ? 'active' : ''; ?>" role="menuitem">Home</a>
              </li>
              <li role="none">
                <a href="about.php" class="nav-link <?php echo ($current_page == 'about') ? 'active' : ''; ?>" role="menuitem">About</a>
              </li>
              <li role="none">
                <a href="programs.php" class="nav-link <?php echo ($current_page == 'programs') ? 'active' : ''; ?>" role="menuitem">What We Do</a>
              </li>
              <li role="none">
                <a href="gallery.php" class="nav-link <?php echo ($current_page == 'gallery') ? 'active' : ''; ?>" role="menuitem">Gallery</a>
              </li>
              <li role="none">
                <a href="careers.php" class="nav-link <?php echo ($current_page == 'careers') ? 'active' : ''; ?>" role="menuitem">Careers</a>
              </li>
              <li role="none">
                <a href="assist.php" class="nav-link <?php echo ($current_page == 'assist') ? 'active' : ''; ?>" role="menuitem">Assist Me</a>
              </li>
              <li role="none">
                <a href="donate.php" class="nav-link btn-primary <?php echo ($current_page == 'donate') ? 'active' : ''; ?>" role="menuitem">Donate</a>
              </li>
            </ul>

            <button
              class="hamburger"
              type="button"
              aria-label="Toggle navigation menu"
              aria-expanded="false"
              aria-controls="nav-menu"
            >
              <span></span>
              <span></span>
              <span></span>
            </button>
          </div>
        </div>
      </nav>
    </header>

    <!-- Main Content -->
    <main id="main-content" role="main">

