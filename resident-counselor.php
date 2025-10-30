<?php
// Page configuration
$current_page = 'resident-counselor';
$page_title = 'Resident Counselor Services';
$page_description = 'Access professional counseling services for HIV-related mental health support.';
$page_url = '/resident-counselor.php';

// Include header
include 'includes/header.php';
?>

<!-- Hero Section -->
      <section class="hero" id="hero" aria-labelledby="hero-title">
        <div class="container">
          <div class="hero-content">
            <h1 id="hero-title" class="hero-title">Professional Mental Health Support</h1>
            <p class="hero-subtitle">
              Our resident counselor provides confidential, compassionate support for your wellbeing journey.
              Understanding the connection between HIV diagnosis and mental health.
            </p>
            <div class="hero-buttons">
              <a href="#hiv-mental-health" class="btn btn-primary btn-lg">
                Learn More
              </a>
              <a href="#contact" class="btn btn-secondary btn-lg">
                Get Support
              </a>
            </div>
          </div>
        </div>
      </section>

      <!-- HIV Mental Health Impact Section -->
      <section class="section" id="hiv-mental-health" aria-labelledby="impact-title">
        <div class="container">
          <div class="section-header">
            <h2 id="impact-title">How Does HIV Diagnosis Affect One's Mental Health?</h2>
            <p>
              An HIV diagnosis can have a significant impact on mental health, often triggering 
              a range of emotional and psychological challenges including shock, fear, depression, 
              anxiety, and concerns about stigma and discrimination. Professional support and 
              understanding can help navigate these challenges effectively.
            </p>
          </div>

          <div class="glass-card p-8">
            <div class="counselor-unified-layout">
              <div class="counselor-image-featured">
                <img
                  src="images/resident.png"
                  alt="Akech Tiridri Anna Thakkar - Resident Counselor, Registered Nurse / Counselor"
                  loading="lazy"
                />
              </div>
              
              <div class="counselor-content-sections">
                <div class="counselor-section">
                  <div class="section-icon" style="background: linear-gradient(135deg, var(--primary-pink), #ff1493);">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                  </div>
                  <div class="section-content">
                    <h3 class="text-xl font-bold text-primary mb-3">Emotional Impact</h3>
                    <p>
                      Initial reactions often include shock, fear, sadness, or disbelief. Anxiety about the future, 
                      relationships, and health is common and completely normal.
                    </p>
                  </div>
                </div>

                <div class="counselor-divider"></div>

                <div class="counselor-section">
                  <div class="section-icon" style="background: linear-gradient(135deg, var(--primary-blue), #0080cc);">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <circle cx="12" cy="12" r="10"></circle>
                      <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                      <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                  </div>
                  <div class="section-content">
                    <h3 class="text-xl font-bold text-secondary mb-3">Mental Health Effects</h3>
                    <p>
                      Depression, anxiety, and feelings of isolation may develop due to stigma and misconceptions. 
                      Some may experience persistent sadness or withdrawal from social connections.
                    </p>
                  </div>
                </div>

                <div class="counselor-divider"></div>

                <div class="counselor-section">
                  <div class="section-icon" style="background: linear-gradient(135deg, var(--primary-pink), #ff1493);">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                      <circle cx="9" cy="7" r="4"></circle>
                      <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                      <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                  </div>
                  <div class="section-content">
                    <h3 class="text-xl font-bold text-primary mb-3">Professional Support</h3>
                    <p>
                      Mental health challenges can affect treatment adherence and daily life. Professional counseling, 
                      support groups, and proper care help manage both physical and mental wellbeing.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="max-w-4xl mx-auto mt-12">
            <div class="bg-primary-pink bg-opacity-10 p-8 rounded-lg text-center">
              <h3 class="text-xl font-bold text-primary mb-4">Remember: You Are Not Alone</h3>
              <p class="text-lg">
                With proper support, treatment, and care, people living with HIV can lead full, healthy, 
                and meaningful lives. Mental health support is a crucial part of comprehensive HIV care, 
                and our resident counselor is here to provide confidential, professional guidance.
              </p>
            </div>
          </div>
        </div>
      </section>



      <!-- Contact Section -->
      <section
        class="section"
        style="background: rgba(255, 255, 255, 0.05)"
        id="contact"
        aria-labelledby="contact-title"
      >
        <div class="container">
          <div class="max-w-3xl mx-auto">
            <div class="glass-card p-8 text-center">
              <h2 id="contact-title" class="text-2xl font-bold mb-6">
                Ready to Take the First Step?
              </h2>
              <p class="text-lg mb-8">
                Taking care of your mental health is a sign of strength. Our resident counselor 
                provides confidential, professional support in a safe and non-judgmental environment.
              </p>
              
              <div class="bg-primary-blue bg-opacity-10 p-6 rounded-lg mb-8">
                <h3 class="font-bold text-secondary mb-3">Confidential Support Available</h3>
                <p class="mb-4">
                  All counseling sessions are completely confidential. You can share your concerns 
                  and challenges in a safe space designed for healing and growth.
                </p>
              </div>

              <div class="flex gap-4 justify-center flex-wrap">
                <a href="assist.php" class="btn btn-primary btn-lg">
                  Request Appointment
                </a>
                <a href="mailto:officialeu@elpisuganda.org" class="btn btn-secondary btn-lg">
                  Email Us
                </a>
              </div>

              <div class="mt-8 text-center">
                <p class="text-sm text-gray-600">
                  <strong>Emergency Support:</strong> If you're experiencing a mental health crisis, 
                  please reach out immediately through our assistance form or contact local emergency services.
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>

<?php
// Include footer
include 'includes/footer.php';
?>
