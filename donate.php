<?php
// Page configuration
$current_page = 'donate';
$page_title = 'Donate - 10 Million Hearts, One Cause';
$page_description = 'Support our mission. Join Uganda\'s first youth-led philanthropic movement and make a difference.';
$page_url = '/donate.php';

// Include header
include 'includes/header.php';
?>

<!-- Hero Section -->
      <section class="hero" id="hero" aria-labelledby="hero-title">
        <div class="container">
          <div class="hero-content text-center">
            <div class="donate-hero-image-container mb-6">
              <img
                src="images/hearts.png"
                alt="10 Million Hearts campaign"
                class="donate-hero-image"
                loading="eager"
              />
            </div>
            <h1 id="hero-title" class="hero-title">10 Million Hearts, One Cause</h1>
            <p class="hero-subtitle max-w-3xl mx-auto">
              Join Uganda's first youth-led philanthropic movement. Your contribution directly 
              supports HIV/AIDS awareness, mental health programs, and emergency medical assistance 
              for young people across Uganda.
            </p>
            <div class="hero-buttons">
              <a href="#payment-methods" class="btn btn-primary btn-lg">
                Donate Now
              </a>
              <a href="#impact" class="btn btn-secondary btn-lg">
                See Your Impact
              </a>
            </div>
          </div>
        </div>
      </section>

      <!-- Impact Section -->
      <section class="section" id="impact" aria-labelledby="impact-title">
        <div class="container">
          <div class="section-header text-center">
            <h2 id="impact-title">Your Impact</h2>
            <p>Every donation creates ripples of positive change across Uganda</p>
          </div>

          <div class="max-w-4xl mx-auto">
            <div class="glass-card p-8">
              <div class="donate-impact-grid grid grid-2 gap-8 items-center">
                <div class="donate-image-container image-container">
                  <img
                    src="images/donate-support.jpg"
                    alt="Supporting communities through donations"
                    loading="lazy"
                  />
                </div>
                <div class="donate-impact-content">
                  <h3 class="text-2xl font-bold text-primary mb-6">
                    Every Contribution Counts
                  </h3>
                  <div class="space-y-4">
                    <div class="bg-primary-pink bg-opacity-10 p-4 rounded-lg">
                      <div class="flex items-center gap-3">
                  
                        <div>
                          <h4 class="font-bold text-primary">UGX 20,000</h4>
                          <p class="text-sm">Funds one youth workshop session</p>
                        </div>
                      </div>
                    </div>
                    <div class="bg-primary-blue bg-opacity-10 p-4 rounded-lg">
                      <div class="flex items-center gap-3">
                       
                        <div>
                          <h4 class="font-bold text-secondary">UGX 50,000</h4>
                          <p class="text-sm">Mental health counseling for 5 people</p>
                        </div>
                      </div>
                    </div>
                    <div class="bg-primary-pink bg-opacity-10 p-4 rounded-lg">
                      <div class="flex items-center gap-3">
                   
                        <div>
                          <h4 class="font-bold text-primary">UGX 100,000</h4>
                          <p class="text-sm">Emergency medical support for 1 person</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Payment Methods Section -->
      <section
        class="section"
        style="background: rgba(255, 255, 255, 0.05)"
        id="payment-methods"
        aria-labelledby="payment-title"
      >
        <div class="container">
          <div class="section-header text-center">
            <h2 id="payment-title">Choose Your Payment Method</h2>
            <p>Minimum donation: UGX 20,000 • All methods are secure and reliable</p>
          </div>

          <!-- Custom Payment Options Carousel -->
          <div class="max-w-4xl mx-auto">
            <div id="paymentCarousel" class="custom-carousel">
              <!-- Carousel Container -->
              <div class="carousel-container">
                
                <!-- MTN Mobile Money Slide -->
                <div class="carousel-slide active">
                  <div class="payment-card glass-card" style="padding: 2rem; min-height: 380px;">
                    <!-- Header with Logo -->
                    <div class="d-flex align-items-center mb-4">
                      <div class="me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #FFCB05, #FFA500); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(255, 203, 5, 0.3);">
                        <img
                          src="images/mtn.png"
                          alt="MTN"
                          style="width: 40px; height: 40px; object-fit: contain;"
                        />
                      </div>
                      <div>
                        <h3 class="text-xl font-bold text-primary mb-1" style="font-size: 1.5rem; margin-bottom: 0.25rem;">MTN Mobile Money</h3>
                        <p class="text-gray-600 mb-0" style="font-size: 0.9rem; margin-bottom: 0;">Uganda's largest mobile money network</p>
                      </div>
                    </div>
                    
                    <!-- Content in Two Columns -->
                    <div class="row g-3">
                      <div class="col-md-6">
                        <div class="bg-white bg-opacity-10 p-3 rounded" style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 8px;">
                          <h5 class="fw-bold text-primary mb-2 d-flex align-items-center" style="font-size: 1rem; margin-bottom: 0.5rem;">
                            Payment Details
                          </h5>
                          <div style="font-size: 0.9rem; line-height: 1.4;">
                            <p class="mb-1"><strong>Name:</strong> Elpis Initiative Uganda</p>
                            <p class="mb-1"><strong>Number:</strong> <span class="font-monospace fw-bold">+256 700 123 456</span></p>
                            <p class="mb-0"><strong>Reference:</strong> 10MILLIONHEARTS</p>
                          </div>
                        </div>
                      </div>
                      
                      <div class="col-md-6">
                        <div class="bg-white bg-opacity-10 p-3 rounded" style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 8px;">
                          <h5 class="fw-bold text-primary mb-2 d-flex align-items-center" style="font-size: 1rem; margin-bottom: 0.5rem;">
                            How to Send
                          </h5>
                          <ol class="mb-0" style="font-size: 0.85rem; line-height: 1.3; padding-left: 1.2rem;">
                            <li>Dial <strong>*165#</strong></li>
                            <li>Select "Send Money"</li>
                            <li>Enter: <strong>+256 700 123 456</strong></li>
                            <li>Enter amount (Min: UGX 20,000)</li>
                            <li>Reference: <strong>10MILLIONHEARTS</strong></li>
                            <li>Confirm with PIN</li>
                          </ol>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Airtel Money Slide -->
                <div class="carousel-slide">
                  <div class="payment-card glass-card" style="padding: 2rem; min-height: 380px;">
                    <!-- Header with Logo -->
                    <div class="d-flex align-items-center mb-4">
                      <div class="me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #FF0000, #CC0000); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(255, 0, 0, 0.3);">
                        <img
                          src="images/airtel.png"
                          alt="Airtel"
                          style="width: 40px; height: 40px; object-fit: contain;"
                        />
                      </div>
                      <div>
                        <h3 class="text-xl font-bold text-secondary mb-1" style="font-size: 1.5rem; margin-bottom: 0.25rem;">Airtel Money</h3>
                        <p class="text-gray-600 mb-0" style="font-size: 0.9rem; margin-bottom: 0;">Reliable and widely accessible</p>
                      </div>
                    </div>
                    
                    <!-- Content in Two Columns -->
                    <div class="row g-3">
                      <div class="col-md-6">
                        <div class="bg-white bg-opacity-10 p-3 rounded" style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 8px;">
                          <h5 class="fw-bold text-secondary mb-2 d-flex align-items-center" style="font-size: 1rem; margin-bottom: 0.5rem;">
                            Payment Details
                          </h5>
                          <div style="font-size: 0.9rem; line-height: 1.4;">
                            <p class="mb-1"><strong>Name:</strong> Elpis Initiative Uganda</p>
                            <p class="mb-1"><strong>Number:</strong> <span class="font-monospace fw-bold">+256 750 987 654</span></p>
                            <p class="mb-0"><strong>Reference:</strong> 10MILLIONHEARTS</p>
                          </div>
                        </div>
                      </div>
                      
                      <div class="col-md-6">
                        <div class="bg-white bg-opacity-10 p-3 rounded" style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 8px;">
                          <h5 class="fw-bold text-secondary mb-2 d-flex align-items-center" style="font-size: 1rem; margin-bottom: 0.5rem;">
                            How to Send
                          </h5>
                          <ol class="mb-0" style="font-size: 0.85rem; line-height: 1.3; padding-left: 1.2rem;">
                            <li>Dial <strong>*185#</strong></li>
                            <li>Select "Send Money"</li>
                            <li>Enter: <strong>+256 750 987 654</strong></li>
                            <li>Enter amount (Min: UGX 20,000)</li>
                            <li>Reference: <strong>10MILLIONHEARTS</strong></li>
                            <li>Confirm with PIN</li>
                          </ol>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Stanbic Bank Slide -->
                <div class="carousel-slide">
                  <div class="payment-card glass-card" style="padding: 2rem; min-height: 380px;">
                    <!-- Header with Logo -->
                    <div class="d-flex align-items-center mb-4">
                      <div class="me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #0066CC, #004499); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(0, 102, 204, 0.3);">
                        <img
                          src="images/stanbic.png"
                          alt="Stanbic"
                          style="width: 40px; height: 40px; object-fit: contain;"
                        />
                      </div>
                      <div>
                        <h3 class="text-xl font-bold text-primary mb-1" style="font-size: 1.5rem; margin-bottom: 0.25rem;">Stanbic Bank</h3>
                        <p class="text-gray-600 mb-0" style="font-size: 0.9rem; margin-bottom: 0;">Primary organizational account</p>
                      </div>
                    </div>
                    
                    <!-- Content in Two Columns -->
                    <div class="row g-3">
                      <div class="col-md-6">
                        <div class="bg-white bg-opacity-10 p-3 rounded" style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 8px;">
                          <h5 class="fw-bold text-primary mb-2 d-flex align-items-center" style="font-size: 1rem; margin-bottom: 0.5rem;">
                            Bank Details
                          </h5>
                          <div style="font-size: 0.85rem; line-height: 1.4;">
                            <p class="mb-1"><strong>Account Name:</strong> Elpis Initiative Uganda</p>
                            <p class="mb-1"><strong>Account Number:</strong> <span class="font-monospace fw-bold">9030010123456</span></p>
                            <p class="mb-1"><strong>Bank:</strong> Stanbic Bank Uganda</p>
                            <p class="mb-1"><strong>Branch:</strong> Kampala Main Branch</p>
                            <p class="mb-0"><strong>Swift Code:</strong> SBICUGKX</p>
                          </div>
                        </div>
                      </div>
                      
                      <div class="col-md-6">
                        <div class="bg-white bg-opacity-10 p-3 rounded" style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 8px;">
                          <h5 class="fw-bold text-primary mb-2 d-flex align-items-center" style="font-size: 1rem; margin-bottom: 0.5rem;">
                            Transfer Reference
                          </h5>
                          <div style="font-size: 0.9rem; line-height: 1.4;">
                            <p class="mb-2">Please use: <strong>10MILLIONHEARTS-[YourName]</strong></p>
                            <p class="text-muted mb-0" style="font-size: 0.8rem; opacity: 0.75;">This helps us track your donation</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Centenary Bank Slide -->
                <div class="carousel-slide">
                  <div class="payment-card glass-card" style="padding: 2rem; min-height: 380px;">
                    <!-- Header with Logo -->
                    <div class="d-flex align-items-center mb-4">
                      <div class="me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #228B22, #006400); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(34, 139, 34, 0.3);">
                        <img
                          src="images/centenary.png"
                          alt="Centenary"
                          style="width: 40px; height: 40px; object-fit: contain;"
                        />
                      </div>
                      <div>
                        <h3 class="text-xl font-bold text-secondary mb-1" style="font-size: 1.5rem; margin-bottom: 0.25rem;">Centenary Bank</h3>
                        <p class="text-gray-600 mb-0" style="font-size: 0.9rem; margin-bottom: 0;">Alternative banking option</p>
                      </div>
                    </div>
                    
                    <!-- Content in Two Columns -->
                    <div class="row g-3">
                      <div class="col-md-6">
                        <div class="bg-white bg-opacity-10 p-3 rounded" style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 8px;">
                          <h5 class="fw-bold text-secondary mb-2 d-flex align-items-center" style="font-size: 1rem; margin-bottom: 0.5rem;">
                            Bank Details
                          </h5>
                          <div style="font-size: 0.85rem; line-height: 1.4;">
                            <p class="mb-1"><strong>Account Name:</strong> Elpis Initiative Uganda</p>
                            <p class="mb-1"><strong>Account Number:</strong> <span class="font-monospace fw-bold">3100987654321</span></p>
                            <p class="mb-1"><strong>Bank:</strong> Centenary Bank</p>
                            <p class="mb-1"><strong>Branch:</strong> Wandegeya Branch</p>
                            <p class="mb-0"><strong>Swift Code:</strong> CENTUGAS</p>
                          </div>
                        </div>
                      </div>
                      
                      <div class="col-md-6">
                        <div class="bg-white bg-opacity-10 p-3 rounded" style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 8px;">
                          <h5 class="fw-bold text-secondary mb-2 d-flex align-items-center" style="font-size: 1rem; margin-bottom: 0.5rem;">
                            Transfer Reference
                          </h5>
                          <div style="font-size: 0.9rem; line-height: 1.4;">
                            <p class="mb-2">Please use: <strong>10MILLIONHEARTS-[YourName]</strong></p>
                            <p class="text-muted mb-0" style="font-size: 0.8rem; opacity: 0.75;">This helps us track your donation</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Confirmation Section -->
      <section class="section" id="confirmation" aria-labelledby="confirm-title">
        <div class="container">
          <div class="max-w-4xl mx-auto">
            <div class="glass-card p-8 text-center">
              <h2 id="confirm-title" class="text-2xl font-bold text-primary mb-6">
                After Your Donation
              </h2>
              
              <div class="grid grid-2 gap-8">
                <div class="bg-primary-pink bg-opacity-10 p-6 rounded-lg">
                  <div class="w-16 h-16 bg-primary-pink rounded-full flex items-center justify-center text-white text-2xl mx-auto mb-4">
                    ✓
                  </div>
                  <h3 class="font-bold text-primary mb-3">1. Send Confirmation</h3>
                  <p>
                    Email us at <strong>officialeu@elpisuganda.org</strong> with your 
                    transaction reference and contact details.
                  </p>
                </div>
                
                <div class="bg-primary-blue bg-opacity-10 p-6 rounded-lg">
                  <div class="w-16 h-16 bg-primary-blue rounded-full flex items-center justify-center text-white text-2xl mx-auto mb-4">
                    #
                  </div>
                  <h3 class="font-bold text-secondary mb-3">2. Get Your Partner ID</h3>
                  <p>
                    Within 24 hours, receive your unique Elpis Partner ID and 
                    regular updates on your impact.
                  </p>
                </div>
              </div>

              <div class="mt-8">
                <a href="mailto:officialeu@elpisuganda.org" class="btn btn-primary btn-lg">
                  Send Confirmation Email
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>

<?php
// Include footer
include 'includes/footer.php';
?>
