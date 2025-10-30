<?php
// Page configuration
$current_page = 'assist';
$page_title = 'Request Assistance';
$page_description = 'Need support? Request assistance from Elpis Initiative Uganda. We provide mental health support, HIV/AIDS resources, and more.';
$page_url = '/assist.php';

// Include header
include 'includes/header.php';
?>

<!-- Hero Section -->
      <section class="hero" id="hero" aria-labelledby="hero-title">
        <div class="container">
          <div class="hero-content">
            <div class="assist-banner-logos mb-8">
              <img
                src="images/image (1).png"
                alt="Elpis Student's Support Program"
                class="assist-banner-logo"
                loading="eager"
              />
            </div>
            <h1 id="hero-title" class="hero-title">We're Here to Help</h1>
            <p class="hero-subtitle">
              At Elpis Initiative Uganda, we believe that everyone deserves a
              helping hand in times of need. Our Assist Me program is dedicated
              to providing support to individuals facing difficult situations
              and emergencies.
            </p>
            <div class="hero-buttons">
              <a href="#assistance-form" class="btn btn-primary btn-lg">
                Request Assistance
              </a>
              <a href="#how-we-help" class="btn btn-secondary btn-lg">
                Learn More
              </a>
            </div>
          </div>
        </div>
      </section>

      <!-- How We Help Section -->
      <section class="section" id="how-we-help" aria-labelledby="help-title">
        <div class="container">
          <div class="section-header">
            <h2 id="help-title">How We Can Assist You</h2>
            <p>
              Through our partnership program, we're able to offer financial
              assistance to those who need it most.
            </p>
          </div>
          <div class="grid grid-3 gap-8">
            <div class="glass-card text-center p-6">
              <div class="image-container mb-6">
                <img
                  src="images/medical-emergency-support.jpg"
                  alt="Medical Emergency Support"
                  loading="lazy"
                />
              </div>
              <h4 class="text-primary mb-4">Medical Emergency Support</h4>
              <p>
                We provide critical financial support for young people aged
                15-40 facing medical emergencies, hospitalization, and other
                health-related expenses.
              </p>
            </div>

            <div class="glass-card text-center p-6">
              <div class="image-container mb-6">
                <img
                  src="images/mental-health-support.jpg"
                  alt="Mental Health Support"
                  loading="lazy"
                />
              </div>
              <h4 class="text-secondary mb-4">Mental Health Support</h4>
              <p>
                Access to counseling services, mental health resources, and
                connections to support networks in your region.
              </p>
            </div>

            <div class="glass-card text-center p-6">
              <div class="image-container mb-6">
                <img
                  src="images/dark-businesswoman-shaking-hands-with-male-colleague.jpg"
                  alt="Emergency Assistance"
                  loading="lazy"
                />
              </div>
              <h4 class="text-primary mb-4">Emergency Assistance</h4>
              <p>
                Immediate support for urgent situations, ensuring that
                individuals are not forced into desperate situations due to lack
                of support.
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- Our Commitment Section -->
      <section
        class="section"
        style="background: rgba(255, 255, 255, 0.05)"
        id="commitment"
        aria-labelledby="commitment-title"
      >
        <div class="container">
          <div class="section-header">
            <h2 id="commitment-title">Our Commitment to You</h2>
          </div>
          <div class="grid grid-1 gap-8 max-w-4xl mx-auto">
            <div class="glass-card p-8">
              <div class="grid grid-1 gap-6 text-lg">
                <p>
                  We recognize that emergencies can be overwhelming, and we want
                  to ensure that individuals are not forced into desperate
                  situations due to lack of support. Our goal is to empower
                  Ugandan youth and provide them with the resources they need to
                  thrive.
                </p>

                <p>
                  We may not have a lot of resources, but we're committed to
                  doing what we can to make a difference. By supporting our
                  initiative, you're helping to create a safety net for those
                  who need it most.
                </p>

                <p class="font-semibold text-primary">
                  Together, we can make a positive impact in the lives of
                  Ugandan youth.
                </p>

                <div
                  class="bg-primary-pink bg-opacity-10 p-6 rounded-lg border-l-4 border-primary-pink"
                >
                  <p class="font-medium">
                    If you're in need of assistance or want to support our
                    cause, we'd love to hear from you. Kindly fill in the form
                    below and we will contact you at the earliest opportunity.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Assistance Request Form Section -->
      <section
        class="section"
        id="assistance-form"
        aria-labelledby="form-title"
      >
        <div class="container">
          <div class="section-header">
            <h2 id="form-title">Request Assistance</h2>
            <p>
              Fill out the form below and we will contact you at the earliest
              opportunity to discuss how we can help.
            </p>
          </div>

          <div class="max-w-2xl mx-auto">
            <form
              class="glass-card p-8"
              data-form-type="assist"
              aria-labelledby="form-title"
            >
              <!-- Personal Information -->
              <div class="mb-8">
                <h3 class="text-lg font-semibold mb-4">Personal Information</h3>
                <div class="grid grid-1 gap-6">
                  <div>
                    <label for="full-name" class="form-label"
                      >Full Name *</label
                    >
                    <input
                      type="text"
                      id="full-name"
                      name="full-name"
                      class="form-input"
                      required
                    />
                  </div>

                  <div>
                    <label for="phone-number" class="form-label"
                      >Phone Number *</label
                    >
                    <input
                      type="tel"
                      id="phone-number"
                      name="phone-number"
                      class="form-input"
                      required
                    />
                  </div>

                  <div>
                    <label for="email" class="form-label"
                      >Email Address (Optional)</label
                    >
                    <input
                      type="email"
                      id="email"
                      name="email"
                      class="form-input"
                    />
                  </div>
                </div>
              </div>

              <!-- Location -->
              <div class="mb-8">
                <label for="location" class="form-label">Location *</label>
                <select
                  id="location"
                  name="location"
                  class="form-select"
                  required
                >
                  <option value="">Select your region</option>
                  <option value="Kampala">Kampala</option>
                  <option value="Gulu">Gulu</option>
                  <option value="Kotido">Kotido</option>
                  <option value="Luuka">Luuka</option>
                  <option value="Arua">Arua</option>
                  <option value="Mbarara">Mbarara</option>
                  <option value="Other">
                    Other (Please specify in message)
                  </option>
                </select>
              </div>

              <!-- Type of Assistance -->
              <div class="mb-8">
                <label class="form-label mb-4 block"
                  >Type of Assistance Needed</label
                >
                <div class="grid grid-1 gap-3">
                  <label class="flex items-center">
                    <input
                      type="checkbox"
                      name="assistance-type"
                      value="Medical Emergency"
                      class="mr-3"
                    />
                    <span>Medical Emergency</span>
                  </label>
                  <label class="flex items-center">
                    <input
                      type="checkbox"
                      name="assistance-type"
                      value="Mental Health Support"
                      class="mr-3"
                    />
                    <span>Mental Health Support</span>
                  </label>
                  <label class="flex items-center">
                    <input
                      type="checkbox"
                      name="assistance-type"
                      value="HIV/AIDS Support"
                      class="mr-3"
                    />
                    <span>HIV/AIDS Related Support</span>
                  </label>
                  <label class="flex items-center">
                    <input
                      type="checkbox"
                      name="assistance-type"
                      value="Financial Emergency"
                      class="mr-3"
                    />
                    <span>Financial Emergency</span>
                  </label>
                  <label class="flex items-center">
                    <input
                      type="checkbox"
                      name="assistance-type"
                      value="Other"
                      class="mr-3"
                    />
                    <span>Other (Please specify below)</span>
                  </label>
                </div>
              </div>

              <!-- Detailed Message -->
              <div class="mb-8">
                <label for="message" class="form-label"
                  >Describe Your Need *</label
                >
                <textarea
                  id="message"
                  name="message"
                  class="form-textarea"
                  rows="6"
                  placeholder="Please provide as much detail as possible about your situation and how we can help you. The more information you provide, the better we can assist you."
                  required
                ></textarea>
                <p class="text-sm text-gray-600 mt-2">
                  Minimum 20 characters required
                </p>
              </div>

              <!-- Elpis Partner ID -->
              <div class="mb-8">
                <label for="partner-number" class="form-label"
                  >Elpis Partner Number (Optional)</label
                >
                <input
                  type="text"
                  id="partner-number"
                  name="partner-number"
                  class="form-input"
                  placeholder="EP123456"
                />
                <p class="text-sm text-gray-600 mt-2">
                  If you're already an Elpis Partner, please enter your partner
                  number
                </p>
              </div>

              <!-- Privacy Notice -->
              <div class="mb-8">
                <div class="bg-gray-50 p-4 rounded-lg">
                  <h4 class="font-semibold mb-2">Privacy Notice</h4>
                  <p class="text-sm text-gray-700">
                    Your information will be kept confidential and used only to
                    assess and provide the assistance you've requested. We will
                    contact you within 48 hours of receiving your request.
                  </p>
                </div>
              </div>

              <button type="submit" class="btn btn-primary btn-lg w-full">
                Submit Request
              </button>
            </form>
          </div>
        </div>
      </section>

      <!-- Support Information -->
      <section
        class="section"
        id="support-info"
        aria-labelledby="support-title"
      >
        <div class="container">
          <div class="section-header">
            <h2 id="support-title">What Happens Next?</h2>
            <p>
              After submitting your request, here's what you can expect from our
              team.
            </p>
          </div>

          <div class="grid grid-3 gap-8">
            <div class="glass-card text-center p-6">
              <div
                class="w-16 h-16 bg-primary-pink rounded-full flex items-center justify-center mx-auto mb-4"
              >
                <span class="text-white font-bold text-xl">1</span>
              </div>
              <h4 class="mb-4">Review & Assessment</h4>
              <p>
                Our team will carefully review your request and assess how we
                can best support your specific situation within 24-48 hours.
              </p>
            </div>

            <div class="glass-card text-center p-6">
              <div
                class="w-16 h-16 bg-primary-blue rounded-full flex items-center justify-center mx-auto mb-4"
              >
                <span class="text-white font-bold text-xl">2</span>
              </div>
              <h4 class="mb-4">Personal Contact</h4>
              <p>
                We'll reach out to you directly via phone or email to discuss
                your needs and explain the support options available to you.
              </p>
            </div>

            <div class="glass-card text-center p-6">
              <div
                class="w-16 h-16 bg-primary-pink rounded-full flex items-center justify-center mx-auto mb-4"
              >
                <span class="text-white font-bold text-xl">3</span>
              </div>
              <h4 class="mb-4">Support & Follow-up</h4>
              <p>
                Once approved, we'll provide the assistance you need and follow
                up to ensure you're getting the support necessary to thrive.
              </p>
            </div>
          </div>

          <div class="text-center mt-12">
            <div class="glass-card p-8 max-w-2xl mx-auto">
              <h3 class="text-primary mb-4">Emergency Contact</h3>
              <p class="mb-4">
                If you're facing a life-threatening emergency, please contact
                emergency services immediately.
              </p>
              <p class="font-semibold">
                For urgent non-emergency support:
                <a
                  href="mailto:officialeu@elpisuganda.org"
                  class="text-primary underline"
                  >officialeu@elpisuganda.org</a
                >
              </p>
            </div>
          </div>
        </div>
      </section>

<?php
// Include footer
include 'includes/footer.php';
?>
