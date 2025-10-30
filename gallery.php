<?php
// Page configuration
$current_page = 'gallery';
$page_title = 'Gallery - Our Impact';
$page_description = 'View photos and videos from our programs and events across Uganda.';
$page_url = '/gallery.php';

// Include header
include 'includes/header.php';
?>

<!-- Hero Section -->
      <section class="hero" id="hero" aria-labelledby="hero-title">
        <div class="container">
          <div class="hero-content">
            <h1 id="hero-title" class="hero-title">Our Journey in Pictures</h1>
            <p class="hero-subtitle">
              Since 2022, we've been documenting the transformative power of art
              in addressing youth health challenges. These images tell the story
              of hope, creativity, and community impact across Uganda.
            </p>
            <div class="hero-buttons">
              <a href="#main-gallery" class="btn btn-primary btn-lg">
                View Our Gallery
              </a>
              <a href="#community-impact" class="btn btn-secondary btn-lg">
                See Community Impact
              </a>
            </div>
          </div>
        </div>
      </section>

      <!-- Gallery Stats Section -->
      <section class="section" id="gallery-stats" aria-labelledby="stats-title">
        <div class="container">
          <div class="section-header">
            <h2 id="stats-title">A Movement Captured</h2>
            <p>Two years of transformative work documented across Uganda</p>
          </div>

          <div class="grid grid-4 gap-6">
            <div class="glass-card text-center p-6">
              <div
                class="w-16 h-16 bg-primary-pink rounded-full flex items-center justify-center mx-auto mb-4"
              >
                <span class="text-white font-bold text-lg">6</span>
              </div>
              <h4 class="text-primary mb-2">Regions</h4>
              <p class="text-sm">Kampala, Gulu, Kotido, Luuka, Arua, Mbarara</p>
            </div>

            <div class="glass-card text-center p-6">
              <div
                class="w-16 h-16 bg-primary-blue rounded-full flex items-center justify-center mx-auto mb-4"
              >
                <span class="text-white font-bold text-lg">50+</span>
              </div>
              <h4 class="text-secondary mb-2">Events</h4>
              <p class="text-sm">
                Workshops, performances, and community programs
              </p>
            </div>

            <div class="glass-card text-center p-6">
              <div
                class="w-16 h-16 bg-primary-pink rounded-full flex items-center justify-center mx-auto mb-4"
              >
                <span class="text-white font-bold text-lg">8</span>
              </div>
              <h4 class="text-primary mb-2">Art Exhibitions</h4>
              <p class="text-sm">Permanent community murals and displays</p>
            </div>

            <div class="glass-card text-center p-6">
              <div
                class="w-16 h-16 bg-primary-blue rounded-full flex items-center justify-center mx-auto mb-4"
              >
                <span class="text-white font-bold text-lg">1,200+</span>
              </div>
              <h4 class="text-secondary mb-2">Youth Reached</h4>
              <p class="text-sm">Direct participants in our programs</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Gallery Section -->
      <section
        class="section"
        style="background: rgba(255, 255, 255, 0.05)"
        id="main-gallery"
        aria-labelledby="gallery-title"
      >
        <div class="container">
          <div class="section-header">
            <h2 id="gallery-title">Our Journey Through Art & Impact</h2>
            <p>
              Capturing moments of transformation, creativity, and community impact across Uganda
            </p>
          </div>

          <!-- Modern Image Grid -->
          <div id="gallery-grid" class="gallery-grid">
            <!-- Images will be dynamically loaded here by JavaScript -->
          </div>

          <!-- Load More Button -->
          <div class="text-center mt-12">
            <button id="load-more-btn" class="btn btn-primary btn-lg" style="display: none;">
              Load More Images
            </button>
          </div>
        </div>
      </section>



      <!-- Community Impact Stories Carousel -->
      <section
        class="section"
        id="community-impact"
        aria-labelledby="impact-title"
      >
        <div class="container">
          <div class="section-header">
            <h2 id="impact-title">Community Impact Stories</h2>
            <p>Real stories of transformation from the communities we serve</p>
          </div>

          <!-- Custom Carousel -->
          <div id="impactCarousel" class="custom-carousel">
            <!-- Carousel Container -->
            <div class="carousel-container">
              
              <!-- Impact Story 1 -->
              <div class="carousel-slide active">
                <div class="glass-card p-8">
                  <div class="impact-story-grid grid grid-2 gap-8 items-center">
                    <div class="impact-image-container image-container">
                      <img
                        src="images/sarah-hiv-stigma-art.jpg"
                        alt="Sarah, young artist who overcame HIV stigma through art therapy"
                        loading="lazy"
                      />
                    </div>
                    <div class="impact-story-content">
                      <h4 class="text-xl font-bold text-primary mb-4">
                        Sarah's Story - From Stigma to Strength
                      </h4>
                      <p class="mb-4">
                        "Before joining Elpis, I was afraid to speak about my HIV
                        status. Through art therapy and community support, I found
                        my voice. Now I lead workshops helping other young women
                        break free from stigma."
                      </p>
                      <div class="bg-primary-pink bg-opacity-10 p-4 rounded-lg">
                        <p class="text-sm font-medium">
                          Sarah, 21 • Kampala Program Participant & Peer Educator
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Impact Story 2 -->
              <div class="carousel-slide">
                <div class="glass-card p-8">
                  <div class="impact-story-grid grid grid-2 gap-8 items-center">
                    <div style="order: 2;">
                      <div class="image-container">
                        <img
                          src="images/david-creative-healing.jpeg"
                          alt="David, community leader who transformed trauma through creative healing"
                          loading="lazy"
                          class="w-full object-cover rounded-lg"
                          style="width: 100%; object-fit: cover; border-radius: 0.5rem;"
                        />
                      </div>
                    </div>
                    <div style="order: 1;">
                      <h4 class="text-xl font-bold text-secondary mb-4">
                        David's Journey - Healing Through Art
                      </h4>
                      <p class="mb-4">
                        "Growing up in post-conflict Gulu, I carried trauma that I
                        couldn't express. Elpis taught me that art could be
                        medicine. Today, I facilitate healing circles and help
                        others transform pain into purpose."
                      </p>
                      <div class="bg-primary-blue bg-opacity-10 p-4 rounded-lg">
                        <p class="text-sm font-medium">
                          David, 24 • Community Art Therapist & Program Alumni
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Impact Story 3 -->
              <div class="carousel-slide">
                <div class="glass-card p-8">
                  <div class="impact-story-grid grid grid-2 gap-8 items-center">
                    <div class="image-container">
                      <img
                        src="images/learn-more.jpg"
                        alt="Local community leader speaking about the impact of Elpis programs"
                        loading="lazy"
                      />
                    </div>
                    <div>
                      <h4 class="text-xl font-bold text-primary mb-4">
                        Community Leader Perspective
                      </h4>
                      <p class="mb-4">
                        "Elpis didn't just bring programs to our community - they
                        brought hope. The murals our youth created are daily
                        reminders that health challenges don't define us. They
                        inspire us to keep fighting stigma."
                      </p>
                      <div class="bg-primary-pink bg-opacity-10 p-4 rounded-lg">
                        <p class="text-sm font-medium">
                          Margaret Akello • LC3 Chairperson, Kamwokya
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Impact Story 4 -->
              <div class="carousel-slide">
                <div class="glass-card p-8">
                  <div class="impact-story-grid grid grid-2 gap-8 items-center">
                    <div style="order: 2;">
                      <div class="image-container">
                        <img
                          src="images/mental-health-counseling.jpeg"
                          alt="Grace, youth mentor empowering others through peer education"
                          loading="lazy"
                          class="w-full object-cover rounded-lg"
                          style="width: 100%; object-fit: cover; border-radius: 0.5rem;"
                        />
                      </div>
                    </div>
                    <div style="order: 1;">
                      <h4 class="text-xl font-bold text-secondary mb-4">
                        Grace's Impact - Empowering Others
                      </h4>
                      <p class="mb-4">
                        "When I first came to Elpis, I was struggling with my identity and purpose. 
                        Through mentorship and leadership training, I discovered my passion for 
                        peer education. Now I coordinate programs across three districts."
                      </p>
                      <div class="bg-primary-blue bg-opacity-10 p-4 rounded-lg">
                        <p class="text-sm font-medium">
                          Grace, 23 • Regional Program Coordinator & Youth Leader
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Impact Story 5 -->
              <div class="carousel-slide">
                <div class="glass-card p-8">
                  <div class="impact-story-grid grid grid-2 gap-8 items-center">
                    <div class="image-container">
                      <img
                        src="images/james-community-advocate.jpeg"
                        alt="James, former street youth now community advocate"
                        loading="lazy"
                      />
                    </div>
                    <div>
                      <h4 class="text-xl font-bold text-primary mb-4">
                        James' Transformation - From Streets to Strength
                      </h4>
                      <p class="mb-4">
                        "I was living on the streets when Elpis found me. They didn't just give me 
                        shelter - they gave me hope and skills. Through their vocational training 
                        and arts programs, I built a new life and now help other street youth."
                      </p>
                      <div class="bg-primary-pink bg-opacity-10 p-4 rounded-lg">
                        <p class="text-sm font-medium">
                          James, 20 • Youth Advocate & Street Outreach Coordinator
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </section>


      <!-- Call to Action Section -->
      <section
        class="section"
        id="get-involved"
        aria-labelledby="involve-title"
      >
        <div class="container">
          <div class="section-header">
            <h2 id="involve-title">Become Part of Our Visual Story</h2>
            <p>Help us create more moments of transformation across Uganda</p>
          </div>

          <div class="max-w-3xl mx-auto">
            <div class="glass-card p-8 text-center">
              <h3 class="text-2xl font-bold mb-6">
                Every Photo Tells a Story of Hope
              </h3>
              <p class="text-lg mb-8">
                The images you see here represent just the beginning. With your
                support, we can capture thousands more stories of young Ugandans
                finding healing, strength, and purpose through art.
              </p>

              <div class="grid grid-1 gap-6 mb-8">
                <div class="bg-primary-pink bg-opacity-10 p-6 rounded-lg">
                  <h4 class="font-bold text-primary mb-3">Share Your Story</h4>
                  <p>
                    Have you been part of our programs? Share your photos and
                    experiences with us for inclusion in our community gallery.
                  </p>
                </div>

                <div class="bg-primary-blue bg-opacity-10 p-6 rounded-lg">
                  <h4 class="font-bold text-secondary mb-3">
                    Support Our Work
                  </h4>
                  <p>
                    Help us reach more young people and document more
                    transformative moments through the 10 Million Hearts
                    campaign.
                  </p>
                </div>
              </div>

              <div class="flex gap-4 justify-center">
                <a href="donate.php" class="btn btn-primary btn-lg"
                  >Support Our Mission</a
                >
                <a href="careers.php" class="btn btn-secondary btn-lg"
                  >Join Our Team</a
                >
              </div>

              <div class="mt-8 text-center">
                <p class="text-lg font-medium">
                  <strong>Follow our journey:</strong>
                  <a
                    href="mailto:officialeu@elpisuganda.org"
                    class="text-primary hover:underline"
                    >officialeu@elpisuganda.org</a
                  >
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
