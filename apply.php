<?php
// Page configuration
$current_page = 'apply';
$page_title = 'Job Application Form';
$page_description = 'Apply for a position at Elpis Initiative Uganda. Submit your application and join our team.';
$page_url = '/apply.php';

// Include header
include 'includes/header.php';
?>

<!-- Hero Section -->
      <section class="hero apply-hero-minimal" id="hero" aria-labelledby="hero-title">
        <div class="container">
          <div class="apply-hero-minimal-content">
            <h1 id="hero-title" class="hero-title">Job Application</h1>
            <p class="hero-subtitle">
              Complete the form below to apply for a position at Elpis Initiative Uganda.
            </p>
          </div>
        </div>
      </section>

      <!-- Application Form Section -->
      <section class="section" id="application-form" aria-labelledby="form-title">
        <div class="container">
          <div class="max-w-4xl mx-auto">
            <div class="glass-card p-6">
              <h2 id="form-title" class="application-form-title">
                Submit Your Application
              </h2>

              <!-- Progress Steps -->
              <div class="form-progress">
                <div class="progress-step active" data-step="1">
                  <div class="step-number">1</div>
                  <span class="step-label">Personal Info</span>
                </div>
                <div class="progress-step" data-step="2">
                  <div class="step-number">2</div>
                  <span class="step-label">Position</span>
                </div>
                <div class="progress-step" data-step="3">
                  <div class="step-number">3</div>
                  <span class="step-label">Qualifications</span>
                </div>
                <div class="progress-step" data-step="4">
                  <div class="step-number">4</div>
                  <span class="step-label">Partner Status</span>
                </div>
                <div class="progress-step" data-step="5">
                  <div class="step-number">5</div>
                  <span class="step-label">Cover Letter</span>
                </div>
                <div class="progress-step" data-step="6">
                  <div class="step-number">6</div>
                  <span class="step-label">Documents</span>
                </div>
                <div class="progress-step" data-step="7">
                  <div class="step-number">7</div>
                  <span class="step-label">Additional</span>
                </div>
              </div>

              <form id="job-application-form" class="form" novalidate>
                <!-- Step 1: Personal Information -->
                <div class="form-step active" data-step="1">
                <div class="form-section">
                  <h3 class="text-primary">
                    Personal Information
                  </h3>

                  <div class="grid grid-1 md:grid-2 gap-6">
                    <div class="form-group">
                      <label for="first-name" class="form-label required"
                        >First Name</label
                      >
                      <input
                        type="text"
                        id="first-name"
                        name="first-name"
                        class="form-input"
                        required
                        aria-required="true"
                      />
                      <span class="error-message" id="first-name-error"></span>
                    </div>

                    <div class="form-group">
                      <label for="last-name" class="form-label required"
                        >Last Name</label
                      >
                      <input
                        type="text"
                        id="last-name"
                        name="last-name"
                        class="form-input"
                        required
                        aria-required="true"
                      />
                      <span class="error-message" id="last-name-error"></span>
                    </div>
                  </div>

                  <div class="grid grid-1 md:grid-2 gap-6">
                    <div class="form-group">
                      <label for="email" class="form-label required">Email Address</label>
                      <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-input"
                        required
                        aria-required="true"
                      />
                      <span class="error-message" id="email-error"></span>
                    </div>

                    <div class="form-group">
                      <label for="phone" class="form-label required"
                        >Phone Number</label
                      >
                      <input
                        type="tel"
                        id="phone"
                        name="phone"
                        class="form-input"
                        placeholder="+256 XXX XXX XXX"
                        required
                        aria-required="true"
                      />
                      <span class="error-message" id="phone-error"></span>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="address" class="form-label">Current Address</label>
                    <input
                      type="text"
                      id="address"
                      name="address"
                      class="form-input"
                      placeholder="City, District"
                    />
                  </div>
                </div>
                </div>

                <!-- Step 2: Position Information -->
                <div class="form-step" data-step="2">
                <div class="form-section">
                  <h3 class="text-secondary">
                    Position Details
                  </h3>

                  <div class="grid grid-1 md:grid-2 gap-6">
                    <div class="form-group">
                      <label for="department" class="form-label required"
                        >Department</label
                      >
                      <select
                        id="department"
                        name="department"
                        class="form-select"
                        required
                        aria-required="true"
                      >
                        <option value="">-- Select Department --</option>
                        <option value="Finance & Admin">Finance & Admin</option>
                        <option value="Monitoring & Evaluation">Monitoring & Evaluation</option>
                        <option value="Programs & Operations">Programs & Operations</option>
                        <option value="Communications & Advocacy">Communications & Advocacy</option>
                      </select>
                      <span class="error-message" id="department-error"></span>
                    </div>

                    <div class="form-group">
                      <label for="region" class="form-label required"
                        >Preferred Region</label
                      >
                      <select
                        id="region"
                        name="region"
                        class="form-select"
                        required
                        aria-required="true"
                      >
                        <option value="">-- Select Region --</option>
                        <option value="Kampala">Kampala</option>
                        <option value="Gulu">Gulu</option>
                        <option value="Kotido">Kotido</option>
                        <option value="Luuka">Luuka</option>
                        <option value="Arua">Arua</option>
                        <option value="Mbarara">Mbarara</option>
                        <option value="Any">Any Region</option>
                      </select>
                      <span class="error-message" id="region-error"></span>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="position" class="form-label required"
                      >Position Applied For</label
                    >
                    <input
                      type="text"
                      id="position"
                      name="position"
                      class="form-input"
                      placeholder="e.g., Regional Finance Officer, Accountant, Programs Officer"
                      required
                      aria-required="true"
                    />
                    <span class="error-message" id="position-error"></span>
                    <p class="text-sm text-gray-600 mt-2">
                      Enter the exact position title you're applying for
                    </p>
                  </div>
                </div>
                </div>

                <!-- Step 3: Qualifications -->
                <div class="form-step" data-step="3">
                <div class="form-section">
                  <h3 class="text-primary">
                    Qualifications & Experience
                  </h3>

                  <div class="form-group">
                    <label for="education" class="form-label required"
                      >Highest Level of Education</label
                    >
                    <select
                      id="education"
                      name="education"
                      class="form-select"
                      required
                      aria-required="true"
                    >
                      <option value="">-- Select Education Level --</option>
                      <option value="Certificate">Certificate</option>
                      <option value="Diploma">Diploma</option>
                      <option value="Degree">Bachelor's Degree</option>
                      <option value="Masters">Master's Degree</option>
                      <option value="PhD">PhD/Doctorate</option>
                    </select>
                    <span class="error-message" id="education-error"></span>
                  </div>

                  <div class="form-group">
                    <label for="experience" class="form-label required"
                      >Years of Relevant Experience</label
                    >
                    <select
                      id="experience"
                      name="experience"
                      class="form-select"
                      required
                      aria-required="true"
                    >
                      <option value="">-- Select Experience --</option>
                      <option value="0-1">0-1 years</option>
                      <option value="1-2">1-2 years</option>
                      <option value="2-4">2-4 years</option>
                      <option value="3-5">3-5 years</option>
                      <option value="5+">5+ years</option>
                    </select>
                    <span class="error-message" id="experience-error"></span>
                  </div>

                  <div class="form-group">
                    <label for="skills" class="form-label"
                      >Key Skills & Competencies</label
                    >
                    <textarea
                      id="skills"
                      name="skills"
                      class="form-textarea"
                      rows="4"
                      placeholder="List your key skills relevant to this position..."
                    ></textarea>
                  </div>
                </div>
                </div>

                <!-- Step 4: Elpis Partner Status -->
                <div class="form-step" data-step="4">
                <div class="form-section">
                  <h3 class="text-secondary">
                    Elpis Partner Status
                  </h3>

                  <div class="form-group">
                    <label class="form-label required">Are you an Elpis Uganda Partner?</label>
                    <div class="flex gap-6">
                      <label class="flex items-center gap-2">
                        <input
                          type="radio"
                          name="partner-status"
                          value="yes"
                          required
                          aria-required="true"
                        />
                        <span>Yes</span>
                      </label>
                      <label class="flex items-center gap-2">
                        <input
                          type="radio"
                          name="partner-status"
                          value="no"
                          required
                          aria-required="true"
                        />
                        <span>No</span>
                      </label>
                    </div>
                    <span class="error-message" id="partner-status-error"></span>
                  </div>

                  <div class="form-group partner-id-hidden" id="partner-id-group">
                    <label for="partner-id" class="form-label">Partner ID</label>
                    <input
                      type="text"
                      id="partner-id"
                      name="partner-id"
                      class="form-input"
                      placeholder="Enter your Elpis Partner ID"
                    />
                  </div>
                </div>
                </div>

                <!-- Step 5: Cover Letter -->
                <div class="form-step" data-step="5">
                <div class="form-section">
                  <h3 class="text-primary">
                    Cover Letter
                  </h3>

                  <div class="form-group">
                    <label for="cover-letter" class="form-label required"
                      >Why do you want to work with Elpis Initiative Uganda?</label
                    >
                    <textarea
                      id="cover-letter"
                      name="cover-letter"
                      class="form-textarea"
                      rows="6"
                      placeholder="Tell us why you're interested in this position and what you can bring to our team..."
                      required
                      aria-required="true"
                    ></textarea>
                    <span class="error-message" id="cover-letter-error"></span>
                  </div>
                </div>
                </div>

                <!-- Step 6: File Uploads -->
                <div class="form-step" data-step="6">
                <div class="form-section">
                  <h3 class="text-secondary">
                    Required Documents
                  </h3>

                  <div class="form-group">
                    <label for="cv-upload" class="form-label required"
                      >Upload Your CV/Resume (PDF, DOC, DOCX - Max 5MB)</label
                    >
                    <input
                      type="file"
                      id="cv-upload"
                      name="cv-upload"
                      class="form-input"
                      accept=".pdf,.doc,.docx"
                      required
                      aria-required="true"
                    />
                    <span class="error-message" id="cv-upload-error"></span>
                    <p class="text-sm text-gray-600 mt-2">
                      Please upload your most recent CV
                    </p>
                  </div>

                  <div class="form-group">
                    <label for="cover-letter-upload" class="form-label"
                      >Upload Cover Letter (PDF, DOC, DOCX - Max 5MB) - Optional</label
                    >
                    <input
                      type="file"
                      id="cover-letter-upload"
                      name="cover-letter-upload"
                      class="form-input"
                      accept=".pdf,.doc,.docx"
                    />
                    <p class="text-sm text-gray-600 mt-2">
                      Optional: Upload a formal cover letter document
                    </p>
                  </div>
                </div>
                </div>

                <!-- Step 7: Additional Information -->
                <div class="form-step" data-step="7">
                <div class="form-section">
                  <h3 class="text-primary">
                    Additional Information
                  </h3>

                  <div class="form-group">
                    <label for="availability" class="form-label"
                      >When are you available to start?</label
                    >
                    <input
                      type="date"
                      id="availability"
                      name="availability"
                      class="form-input"
                    />
                  </div>

                  <div class="form-group">
                    <label for="references" class="form-label"
                      >References (Name, Position, Contact)</label
                    >
                    <textarea
                      id="references"
                      name="references"
                      class="form-textarea"
                      rows="4"
                      placeholder="Provide at least 2 professional references..."
                    ></textarea>
                  </div>

                  <div class="form-group">
                    <label for="additional-info" class="form-label"
                      >Additional Comments</label
                    >
                    <textarea
                      id="additional-info"
                      name="additional-info"
                      class="form-textarea"
                      rows="4"
                      placeholder="Any other information you'd like to share..."
                    ></textarea>
                  </div>
                </div>

                <!-- Declaration -->
                <div class="form-section mb-8">
                  <div class="bg-primary-blue bg-opacity-10 p-6 rounded-lg">
                    <label class="flex items-start gap-3">
                      <input
                        type="checkbox"
                        id="declaration"
                        name="declaration"
                        class="mt-1"
                        required
                        aria-required="true"
                      />
                      <span class="text-sm">
                        I declare that the information provided in this application is
                        true and accurate to the best of my knowledge. I understand
                        that any false information may result in disqualification from
                        the recruitment process.
                      </span>
                    </label>
                    <span class="error-message" id="declaration-error"></span>
                  </div>
                </div>
                </div>

                <!-- Form Navigation Buttons -->
                <div class="form-navigation">
                  <button type="button" class="btn btn-secondary" id="prevBtn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                    Previous
                  </button>
                  
                  <button type="button" class="btn btn-primary" id="nextBtn">
                    Next
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                  </button>
                  
                  <button type="submit" class="btn btn-primary" id="submitBtn" style="display: none;">
                    Submit Application
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>

      <!-- Important Notes Section - Marquee -->
      <section class="section" style="background: rgba(255, 255, 255, 0.05)">
        <div class="container">
          <div class="max-w-6xl mx-auto">
            <div class="glass-card p-8">
              <h3 class="text-2xl font-bold mb-6 text-center">Important Information</h3>

              <div class="marquee-container">
                <div class="marquee-content">
                  <!-- First set of cards -->
                  <div class="info-card-marquee">
                    <div class="info-icon bg-primary-pink">
                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                      </svg>
                    </div>
                    <h4 class="text-primary font-bold mb-1">Application Deadline</h4>
                    <p>All applications must be submitted by <strong>20th December 2024</strong>.</p>
                  </div>

                  <div class="info-card-marquee">
                    <div class="info-icon bg-primary-blue">
                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="12" y1="18" x2="12" y2="12"></line>
                        <line x1="9" y1="15" x2="15" y2="15"></line>
                      </svg>
                    </div>
                    <h4 class="text-secondary font-bold mb-1">Selection Process</h4>
                    <p>Only shortlisted candidates will be contacted for interviews. The selection process may take 2-4 weeks.</p>
                  </div>

                  <div class="info-card-marquee">
                    <div class="info-icon bg-primary-pink">
                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                      </svg>
                    </div>
                    <h4 class="text-primary font-bold mb-1">Contact Us</h4>
                    <p>For questions: <a href="mailto:officialeu@elpisuganda.org" class="text-primary underline font-semibold">officialeu@elpisuganda.org</a></p>
                  </div>

                  <div class="info-card-marquee">
                    <div class="info-icon bg-primary-blue">
                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                      </svg>
                    </div>
                    <h4 class="text-secondary font-bold mb-1">Equal Opportunity Employer</h4>
                    <p>We encourage young professionals aged 25-35 and persons with special needs to apply.</p>
                  </div>

                  <!-- Duplicate set for seamless loop -->
                  <div class="info-card-marquee">
                    <div class="info-icon bg-primary-pink">
                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                      </svg>
                    </div>
                    <h4 class="text-primary font-bold mb-1">Application Deadline</h4>
                    <p>All applications must be submitted by <strong>20th December 2024</strong>.</p>
                  </div>

                  <div class="info-card-marquee">
                    <div class="info-icon bg-primary-blue">
                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="12" y1="18" x2="12" y2="12"></line>
                        <line x1="9" y1="15" x2="15" y2="15"></line>
                      </svg>
                    </div>
                    <h4 class="text-secondary font-bold mb-1">Selection Process</h4>
                    <p>Only shortlisted candidates will be contacted for interviews. The selection process may take 2-4 weeks.</p>
                  </div>

                  <div class="info-card-marquee">
                    <div class="info-icon bg-primary-pink">
                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                      </svg>
                    </div>
                    <h4 class="text-primary font-bold mb-1">Contact Us</h4>
                    <p>For questions: <a href="mailto:officialeu@elpisuganda.org" class="text-primary underline font-semibold">officialeu@elpisuganda.org</a></p>
                  </div>

                  <div class="info-card-marquee">
                    <div class="info-icon bg-primary-blue">
                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                      </svg>
                    </div>
                    <h4 class="text-secondary font-bold mb-1">Equal Opportunity Employer</h4>
                    <p>We encourage young professionals aged 25-35 and persons with special needs to apply.</p>
                  </div>
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
