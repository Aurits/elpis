<?php
// Page configuration
$current_page = 'careers';
$page_title = 'Join Our Team - Career Opportunities';
$page_description = 'Explore career opportunities at Elpis Initiative Uganda. Join our youth-led movement making a positive impact.';
$page_url = '/careers.php';

// Include header
include 'includes/header.php';
?>

<!-- Hero Section -->
      <section class="hero" id="hero" aria-labelledby="hero-title">
        <div class="container">
          <div class="hero-content">
            <h1 id="hero-title" class="hero-title">Join Our Team</h1>
            <p class="hero-subtitle">
              Join the Elpis Initiative Uganda team and be part of a movement
              that's dedicated to making a positive impact in the lives of
              Ugandans affected by HIV and mental health issues through Art.
            </p>
            <div class="hero-buttons">
              <a href="#current-openings" class="btn btn-primary btn-lg">
                View Open Positions
              </a>
              <a href="#why-join" class="btn btn-secondary btn-lg">
                Why Work With Us?
              </a>
            </div>
          </div>
        </div>
      </section>

      <!-- Overview Section -->
      <section class="section" id="overview" aria-labelledby="overview-title">
        <div class="container">
          <div class="section-header">
            <h2 id="overview-title">Current Opportunities</h2>
            <p>
              We are currently hiring for <strong>23 positions</strong> across
              various departments in Kampala, Luuka, Mbarara, Arua, Gulu and
              Kotido.
            </p>
          </div>

          <div class="glass-card p-8 max-w-4xl mx-auto">
            <div class="grid grid-1 gap-6 text-lg">
              <p>
                We're a passionate and driven organization that brings together
                youth who are committed to creating a brighter future for all.
                With a presence in multiple districts across Uganda, we're able
                to reach and empower individuals and communities in diverse
                settings.
              </p>

              <p>
                Our focus on youth is deliberate - we believe that young people
                are the catalysts for change in their own communities, and we're
                committed to providing them with the opportunities and resources
                they need to take charge of their own development.
              </p>

              <div
                class="bg-primary-blue bg-opacity-10 p-6 rounded-lg border-l-4 border-primary-blue"
              >
                <p class="font-medium">
                  Elpis Uganda encourages
                  <strong>young professionals aged 25–35</strong> and
                  <strong>persons with special needs</strong> to apply.
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Job Listings Section -->
      <section
        class="section"
        style="background: rgba(255, 255, 255, 0.05)"
        id="current-openings"
        aria-labelledby="jobs-title"
      >
        <div class="container">
          <div class="section-header">
            <h2 id="jobs-title">Current Job Openings</h2>
            <p>We have <span id="total-jobs">23</span> positions available across our six regions</p>
          </div>


          <!-- Job Listings Container -->
          <div id="job-listings">
            <!-- Jobs will be loaded dynamically here -->
          </div>

          <!-- Loading State -->
          <div id="loading-jobs" class="text-center py-8">
            <div class="glass-card p-8">
              <p class="text-lg">Loading job opportunities...</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Why Work With Us Section -->
      <section class="section" id="why-join" aria-labelledby="why-title">
        <div class="container">
          <div class="section-header">
            <h2 id="why-title">Why Work with Us?</h2>
            <p>
              Be part of a dynamic, youth-led team that's changing lives across
              Uganda.
            </p>
          </div>

          <div class="grid grid-2 gap-8">
            <div class="glass-card p-6">
              <h4 class="text-primary mb-4">Dynamic, Youth-Led Team</h4>
              <p>
                Be part of a dynamic, youth-led team that's changing lives and
                making a real difference in communities across Uganda.
              </p>
            </div>

            <div class="glass-card p-6">
              <h4 class="text-secondary mb-4">Passionate Collaboration</h4>
              <p>
                Collaborate with passionate individuals across Uganda who are
                committed to creating positive change and building a brighter
                future.
              </p>
            </div>

            <div class="glass-card p-6">
              <h4 class="text-primary mb-4">Mission-Driven Experience</h4>
              <p>
                Gain experience in a mission-driven organization that focuses on
                meaningful impact rather than just profit.
              </p>
            </div>

            <div class="glass-card p-6">
              <h4 class="text-secondary mb-4">
                Contribute to Important Causes
              </h4>
              <p>
                Contribute to causes that impact HIV awareness and mental health
                education, making a lasting difference in people's lives.
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- Application Process Section -->
      <section
        class="section"
        style="background: rgba(255, 255, 255, 0.05)"
        id="application"
        aria-labelledby="application-title"
      >
        <div class="container">
          <div class="section-header">
            <h2 id="application-title">How to Apply</h2>
            <p>
              Ready to join our team? Follow these simple steps to submit your
              application.
            </p>
          </div>

          <div class="max-w-4xl mx-auto">
            <div class="glass-card p-8">
              <div class="grid grid-1 gap-8">
                <div class="flex items-start gap-6">
                  <div
                    class="w-12 h-12 bg-primary-pink rounded-full flex items-center justify-center flex-shrink-0"
                  >
                    <span class="text-white font-bold text-lg">1</span>
                  </div>
                  <div>
                    <h4 class="text-lg font-semibold mb-2">
                      Prepare Your Documents
                    </h4>
                    <p>
                      Send your <strong>CV and a cover letter</strong> that
                      clearly demonstrates your qualifications and passion for
                      our mission.
                    </p>
                  </div>
                </div>

                <div class="flex items-start gap-6">
                  <div
                    class="w-12 h-12 bg-primary-blue rounded-full flex items-center justify-center flex-shrink-0"
                  >
                    <span class="text-white font-bold text-lg">2</span>
                  </div>
                  <div>
                    <h4 class="text-lg font-semibold mb-2">
                      Email Your Application
                    </h4>
                    <p>
                      Send to:
                      <a
                        href="mailto:officialeu@elpisuganda.org"
                        class="text-primary underline font-semibold"
                        >officialeu@elpisuganda.org</a
                      >
                    </p>
                  </div>
                </div>

                <div class="flex items-start gap-6">
                  <div
                    class="w-12 h-12 bg-primary-pink rounded-full flex items-center justify-center flex-shrink-0"
                  >
                    <span class="text-white font-bold text-lg">3</span>
                  </div>
                  <div>
                    <h4 class="text-lg font-semibold mb-2">
                      Subject Line Requirements
                    </h4>
                    <p>
                      Please <strong>clearly state the position</strong> you are
                      applying for in the subject line.
                    </p>
                  </div>
                </div>

                <div
                  class="bg-primary-blue bg-opacity-10 p-6 rounded-lg border-l-4 border-primary-blue"
                >
                  <p class="font-semibold mb-2">Application Deadline:</p>
                  <p class="text-lg">20th December 2024</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

<?php
// Include footer
include 'includes/footer.php';
?>
