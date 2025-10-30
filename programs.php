<?php
// Page configuration
$current_page = 'programs';
$page_title = 'What We Do - Our Programs';
$page_description = 'Discover our innovative programs addressing HIV/AIDS awareness, mental health, gender equality, and youth empowerment through art and advocacy.';
$page_url = '/programs.php';

// Include header
include 'includes/header.php';
?>

<!-- Hero Section -->
      <section class="hero" id="hero" aria-labelledby="hero-title">
        <div class="container">
          <div class="hero-content">
            <h1 id="hero-title" class="hero-title">
              What We Do at Elpis Initiative Uganda
            </h1>
            <p class="hero-subtitle">
              We're rewriting the narrative around youth health and empowerment
              through our innovative, arts-driven approach. Since our founding
              in 2022, we've pioneered a movement that transforms how Uganda's
              youth engage with critical issues.
            </p>
            <div class="hero-buttons">
              <a href="#core-programs" class="btn btn-primary btn-lg">
                Explore Our Programs
              </a>
              <a href="#impact" class="btn btn-secondary btn-lg">
                See Our Impact
              </a>
            </div>
          </div>
        </div>
      </section>

      <!-- Philosophy Section -->
      <section
        class="section"
        id="philosophy"
        aria-labelledby="philosophy-title"
      >
        <div class="container">
          <div class="section-header">
            <h2 id="philosophy-title">Our Philosophy: Youth at the Center</h2>
            <p>Solutions for young people must be created with young people</p>
          </div>

          <div class="grid grid-1 gap-8 max-w-4xl mx-auto">
            <div class="glass-card p-8">
              <div class="grid grid-1 gap-6 text-lg">
                <p>
                  We believe solutions for young people must be created with
                  young people. That's why every program we design puts
                  <strong>youth voices first</strong>, using creative expression
                  as our primary tool for education and advocacy.
                </p>

                <p>
                  Traditional methods often fail to resonate - we're changing
                  that by meeting youth where they are, speaking their language,
                  and addressing their real needs.
                </p>

                <div
                  class="bg-primary-pink bg-opacity-10 p-6 rounded-lg border-l-4 border-primary-pink"
                >
                  <p class="font-medium text-center text-lg">
                    <strong
                      >"When you combine art with activism, education with
                      expression, and policy with creativity, you create change
                      that sticks."</strong
                    >
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Core Programs Section -->
      <section
        class="section"
        style="background: rgba(255, 255, 255, 0.05)"
        id="core-programs"
        aria-labelledby="programs-title"
      >
        <div class="container">
          <div class="section-header">
            <h2 id="programs-title">Our Core Initiatives</h2>
            <p>Three strategic pillars driving transformation across Uganda</p>
          </div>

          <div class="programs-detail-grid grid grid-1 gap-12">
            <!-- Program 1: Advocacy Through Artistry -->
            <article class="program-detail-card glass-card p-8">
              <div class="program-content-grid grid grid-2 gap-8 items-start">
                <div class="program-image-wrapper">
                  <div class="program-image-container image-container mb-6">
                    <img
                      src="images/youth-art-advocacy.jpg"
                      alt="Youth creating art for advocacy and policy influence"
                      loading="lazy"
                    />
                  </div>
                </div>
                <div class="program-text-content">
                  <h3 class="text-2xl font-bold text-primary mb-4">
                    1. Advocacy Through Artistry
                  </h3>
                  <p class="text-lg mb-6">
                    We don't just talk about change, we create it through
                    powerful artistic expression. Our work has shifted national
                    conversations around HIV stigma and mental health.
                  </p>

                  <div class="grid grid-1 gap-4 mb-6">
                    <div class="flex items-start gap-3">
                      <div
                        class="w-2 h-2 bg-primary-pink rounded-full mt-3 flex-shrink-0"
                      ></div>
                      <p>
                        <strong>Training youth advocates</strong> who use
                        creative mediums to influence policy and drive social
                        change
                      </p>
                    </div>
                    <div class="flex items-start gap-3">
                      <div
                        class="w-2 h-2 bg-primary-pink rounded-full mt-3 flex-shrink-0"
                      ></div>
                      <p>
                        <strong>Producing award-winning short films</strong>
                        that challenge misconceptions and spark important
                        conversations
                      </p>
                    </div>
                    <div class="flex items-start gap-3">
                      <div
                        class="w-2 h-2 bg-primary-pink rounded-full mt-3 flex-shrink-0"
                      ></div>
                      <p>
                        <strong>Organizing nationwide exhibitions</strong> that
                        turn personal stories into public dialogue and policy
                        action
                      </p>
                    </div>
                    <div class="flex items-start gap-3">
                      <div
                        class="w-2 h-2 bg-primary-pink rounded-full mt-3 flex-shrink-0"
                      ></div>
                      <p>
                        <strong>Hosting viral X-Space discussions</strong>
                        engaging thousands digitally across Uganda and beyond
                      </p>
                    </div>
                  </div>

                  <a href="#advocacy-details" class="btn btn-outline btn-sm"
                    >Learn More</a
                  >
                </div>
              </div>
            </article>

            <!-- Program 2: Community Outreach -->
            <article class="program-detail-card glass-card p-8">
              <div class="program-content-grid grid grid-2 gap-8 items-start">
                <div class="program-image-wrapper order-2">
                  <div class="program-image-container image-container mb-6">
                    <img
                      src="images/community-outreach.jpg"
                      alt="Community engagement activities across six regions"
                      loading="lazy"
                    />
                  </div>
                </div>
                <div class="program-text-content order-1">
                  <h3 class="text-2xl font-bold text-secondary mb-4">
                    2. Community Outreach That Connects
                  </h3>
                  <p class="text-lg mb-6">
                    Our grassroots programs reach youth across six key regions
                    with tailored interventions designed for each community's
                    unique needs and challenges.
                  </p>

                  <div class="grid grid-1 gap-4 mb-6">
                    <div class="flex items-start gap-3">
                      <div
                        class="w-2 h-2 bg-primary-blue rounded-full mt-3 flex-shrink-0"
                      ></div>
                      <p>
                        <strong>Kampala:</strong> Urban youth engagement through
                        digital and performing arts programs
                      </p>
                    </div>
                    <div class="flex items-start gap-3">
                      <div
                        class="w-2 h-2 bg-primary-blue rounded-full mt-3 flex-shrink-0"
                      ></div>
                      <p>
                        <strong>Gulu:</strong> Post-conflict mental health
                        healing via creative therapies and community art
                      </p>
                    </div>
                    <div class="flex items-start gap-3">
                      <div
                        class="w-2 h-2 bg-primary-blue rounded-full mt-3 flex-shrink-0"
                      ></div>
                      <p>
                        <strong>Kotido:</strong> Culturally-sensitive programs
                        designed for pastoral communities
                      </p>
                    </div>
                    <div class="flex items-start gap-3">
                      <div
                        class="w-2 h-2 bg-primary-blue rounded-full mt-3 flex-shrink-0"
                      ></div>
                      <p>
                        <strong>Luuka:</strong> Rural SRHR education through
                        community murals and theater performances
                      </p>
                    </div>
                    <div class="flex items-start gap-3">
                      <div
                        class="w-2 h-2 bg-primary-blue rounded-full mt-3 flex-shrink-0"
                      ></div>
                      <p>
                        <strong>Arua:</strong> Border community health
                        initiatives addressing cross-border challenges
                      </p>
                    </div>
                    <div class="flex items-start gap-3">
                      <div
                        class="w-2 h-2 bg-primary-blue rounded-full mt-3 flex-shrink-0"
                      ></div>
                      <p>
                        <strong>Mbarara:</strong> University-focused creative
                        health education and peer-to-peer programs
                      </p>
                    </div>
                  </div>

                  <a href="#outreach-details" class="btn btn-outline btn-sm"
                    >Learn More</a
                  >
                </div>
              </div>
            </article>

            <!-- Program 3: Strategic Partnerships -->
            <article class="program-detail-card glass-card p-8">
              <div class="program-content-grid grid grid-2 gap-8 items-start">
                <div class="program-image-wrapper">
                  <div class="program-image-container image-container mb-6">
                    <img
                      src="images/partnership-collaboration.jpg"
                      alt="Partnership collaboration and sustainability programs"
                      loading="lazy"
                    />
                  </div>
                </div>
                <div class="program-text-content">
                  <h3 class="text-2xl font-bold text-primary mb-4">
                    3. Strategic Partnerships for Sustainability
                  </h3>
                  <p class="text-lg mb-6">
                    We're building an ecosystem of support that ensures
                    long-term impact and community ownership of health
                    initiatives across Uganda.
                  </p>

                  <div class="grid grid-1 gap-4 mb-6">
                    <div class="flex items-start gap-3">
                      <div
                        class="w-2 h-2 bg-primary-pink rounded-full mt-3 flex-shrink-0"
                      ></div>
                      <p>
                        <strong>The 10 Million Hearts Campaign</strong> -
                        Uganda's first youth-led philanthropic movement for
                        sustainable funding
                      </p>
                    </div>
                    <div class="flex items-start gap-3">
                      <div
                        class="w-2 h-2 bg-primary-pink rounded-full mt-3 flex-shrink-0"
                      ></div>
                      <p>
                        <strong>School collaborations</strong> integrating
                        arts-based health education into curricula nationwide
                      </p>
                    </div>
                    <div class="flex items-start gap-3">
                      <div
                        class="w-2 h-2 bg-primary-pink rounded-full mt-3 flex-shrink-0"
                      ></div>
                      <p>
                        <strong>Corporate partnerships</strong> funding
                        community art exhibitions and ongoing programs
                      </p>
                    </div>
                    <div class="flex items-start gap-3">
                      <div
                        class="w-2 h-2 bg-primary-pink rounded-full mt-3 flex-shrink-0"
                      ></div>
                      <p>
                        <strong>Government alliances</strong> scaling our proven
                        models nationally through policy integration
                      </p>
                    </div>
                  </div>

                  <a href="#partnership-details" class="btn btn-outline btn-sm"
                    >Learn More</a
                  >
                </div>
              </div>
            </article>
          </div>
        </div>
      </section>

      <!-- Key Strategies Section -->
      <section
        class="section"
        id="strategies"
        aria-labelledby="strategies-title"
      >
        <div class="container">
          <div class="section-header">
            <h2 id="strategies-title">
              5 Key Strategies to Achieve Our Objectives
            </h2>
            <p>
              Evidence-based approaches that leverage art as a tool for
              education, activism, and healing
            </p>
          </div>

          <div class="grid grid-1 gap-8">
            <!-- Strategy 1 -->
            <div class="glass-card p-6">
              <div class="flex items-start gap-4">
                <div
                  class="w-12 h-12 bg-primary-pink rounded-full flex items-center justify-center text-white font-bold text-lg flex-shrink-0"
                >
                  1
                </div>
                <div>
                  <h4 class="text-xl font-semibold text-primary mb-3">
                    Arts-Based Health Education
                  </h4>
                  <p class="mb-4">
                    Develop and scale creative workshops, performances, and
                    digital content (films, podcasts, murals) to make health
                    education engaging and relatable for youth.
                  </p>

                  <div class="bg-primary-pink bg-opacity-10 p-4 rounded-lg">
                    <h5 class="font-semibold mb-2">Action Steps:</h5>
                    <ul class="text-sm space-y-1">
                      <li>
                        • Train 50+ young artists as peer educators annually
                      </li>
                      <li>• Produce 2 short films/year tackling stigma</li>
                      <li>
                        • Host quarterly "Spoken Word for Health" competitions
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <!-- Strategy 2 -->
            <div class="glass-card p-6">
              <div class="flex items-start gap-4">
                <div
                  class="w-12 h-12 bg-primary-blue rounded-full flex items-center justify-center text-white font-bold text-lg flex-shrink-0"
                >
                  2
                </div>
                <div>
                  <h4 class="text-xl font-semibold text-secondary mb-3">
                    Community-Led Fundraising
                  </h4>
                  <p class="mb-4">
                    Strengthen local ownership through the 10 Million Hearts, 1
                    Cause Campaign, mobilizing Ugandans to fund youth health
                    initiatives.
                  </p>

                  <div class="bg-primary-blue bg-opacity-10 p-4 rounded-lg">
                    <h5 class="font-semibold mb-2">Action Steps:</h5>
                    <ul class="text-sm space-y-1">
                      <li>• Recruit 200,000 new youth donors by 2027</li>
                      <li>
                        • Launch mobile giving platform for small donations
                      </li>
                      <li>
                        • Partner with Ugandan businesses for matched funding
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <!-- Strategy 3 -->
            <div class="glass-card p-6">
              <div class="flex items-start gap-4">
                <div
                  class="w-12 h-12 bg-primary-pink rounded-full flex items-center justify-center text-white font-bold text-lg flex-shrink-0"
                >
                  3
                </div>
                <div>
                  <h4 class="text-xl font-semibold text-primary mb-3">
                    Youth Advocacy Networks
                  </h4>
                  <p class="mb-4">
                    Build a national movement of young leaders who influence
                    policies and programs at all levels of government.
                  </p>

                  <div class="bg-primary-pink bg-opacity-10 p-4 rounded-lg">
                    <h5 class="font-semibold mb-2">Action Steps:</h5>
                    <ul class="text-sm space-y-1">
                      <li>
                        • Establish youth councils in all 6 operational regions
                      </li>
                      <li>
                        • Conduct annual "Youth Health Summits" with
                        policymakers
                      </li>
                      <li>
                        • Create digital advocacy toolkit for grassroots
                        campaigns
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <!-- Strategy 4 -->
            <div class="glass-card p-6">
              <div class="flex items-start gap-4">
                <div
                  class="w-12 h-12 bg-primary-blue rounded-full flex items-center justify-center text-white font-bold text-lg flex-shrink-0"
                >
                  4
                </div>
                <div>
                  <h4 class="text-xl font-semibold text-secondary mb-3">
                    Safe Space Expansion
                  </h4>
                  <p class="mb-4">
                    Transform schools and community centers into hubs for
                    creative expression and health support.
                  </p>

                  <div class="bg-primary-blue bg-opacity-10 p-4 rounded-lg">
                    <h5 class="font-semibold mb-2">Action Steps:</h5>
                    <ul class="text-sm space-y-1">
                      <li>• Equip 10 new art hubs with resources by 2027</li>
                      <li>• Train teachers/staff in arts-based counseling</li>
                      <li>• Curate traveling exhibitions of youth artwork</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <!-- Strategy 5 -->
            <div class="glass-card p-6">
              <div class="flex items-start gap-4">
                <div
                  class="w-12 h-12 bg-primary-pink rounded-full flex items-center justify-center text-white font-bold text-lg flex-shrink-0"
                >
                  5
                </div>
                <div>
                  <h4 class="text-xl font-semibold text-primary mb-3">
                    Strategic Partnerships
                  </h4>
                  <p class="mb-4">
                    Collaborate with government, NGOs, and artists to amplify
                    impact across East Africa.
                  </p>

                  <div class="bg-primary-pink bg-opacity-10 p-4 rounded-lg">
                    <h5 class="font-semibold mb-2">Action Steps:</h5>
                    <ul class="text-sm space-y-1">
                      <li>
                        • Formalize partnerships with 3+ ministries (Health,
                        Education, Gender)
                      </li>
                      <li>• Co-design programs with youth-led organizations</li>
                      <li>
                        • Host annual East African Arts for Health forum by 2030
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Impact & Results Section -->
      <section
        class="section"
        style="background: rgba(255, 255, 255, 0.05)"
        id="impact"
        aria-labelledby="impact-title"
      >
        <div class="container">
          <div class="section-header">
            <h2 id="impact-title">Why Our Model Works</h2>
            <p>Proven results in just two years of operation</p>
          </div>

          <div class="grid grid-3 gap-8 mb-12">
            <div class="glass-card text-center p-6">
              <div
                class="w-16 h-16 bg-primary-pink rounded-full flex items-center justify-center mx-auto mb-4"
              >
                <span class="text-white font-bold text-lg">1,200+</span>
              </div>
              <h4 class="text-primary mb-4">Youth Directly Engaged</h4>
              <p>Through transformative programs that create lasting change</p>
            </div>

            <div class="glass-card text-center p-6">
              <div
                class="w-16 h-16 bg-primary-blue rounded-full flex items-center justify-center mx-auto mb-4"
              >
                <span class="text-white font-bold text-lg">8</span>
              </div>
              <h4 class="text-secondary mb-4">Permanent Art Exhibitions</h4>
              <p>Serving as ongoing education tools in communities</p>
            </div>

            <div class="glass-card text-center p-6">
              <div
                class="w-16 h-16 bg-primary-pink rounded-full flex items-center justify-center mx-auto mb-4"
              >
                <span class="text-white font-bold text-lg">6</span>
              </div>
              <h4 class="text-primary mb-4">Regions Served</h4>
              <p>Tailored programming across diverse communities</p>
            </div>
          </div>

          <div class="glass-card p-8 max-w-4xl mx-auto">
            <div class="text-center">
              <h3 class="text-2xl font-bold mb-6">Our 2030 Vision</h3>
              <p class="text-xl mb-6">
                By 2030, we aim to reach
                <strong>20% of Ugandan youth (ages 15-24)</strong> with our
                programs, ensuring health knowledge isn't just delivered, but
                experienced through art.
              </p>

              <div
                class="bg-primary-blue bg-opacity-10 p-6 rounded-lg border-l-4 border-primary-blue"
              >
                <p class="font-medium text-lg">
                  "Our success proves that when you combine art with activism,
                  education with expression, and policy with creativity, you
                  create change that sticks."
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Join the Movement Section -->
      <section class="section" id="join-movement" aria-labelledby="join-title">
        <div class="container">
          <div class="section-header">
            <h2 id="join-title">Join the Movement</h2>
            <p>
              This is more than a program, it's a revolution in how Uganda
              addresses youth health
            </p>
          </div>

          <div class="grid grid-1 gap-8 max-w-4xl mx-auto">
            <div class="glass-card p-8">
              <div class="text-center mb-8">
                <h3 class="text-xl font-bold mb-4">Support Our Work By:</h3>
              </div>

              <div class="grid grid-2 gap-8">
                <div class="flex items-start gap-4">
                  <div
                    class="w-8 h-8 bg-primary-pink rounded-full flex items-center justify-center flex-shrink-0"
                  >
                    <span class="text-white text-sm font-bold">1</span>
                  </div>
                  <div>
                    <h4 class="font-semibold mb-2">
                      Contributing to our 10 Million Hearts, 1 Cause Campaign
                    </h4>
                    <p class="text-sm">
                      Join Uganda's first youth-led philanthropic movement
                    </p>
                  </div>
                </div>

                <div class="flex items-start gap-4">
                  <div
                    class="w-8 h-8 bg-primary-blue rounded-full flex items-center justify-center flex-shrink-0"
                  >
                    <span class="text-white text-sm font-bold">2</span>
                  </div>
                  <div>
                    <h4 class="font-semibold mb-2">
                      Hosting an Elpis workshop in your community
                    </h4>
                    <p class="text-sm">
                      Bring our programs directly to your area
                    </p>
                  </div>
                </div>

                <div class="flex items-start gap-4">
                  <div
                    class="w-8 h-8 bg-primary-pink rounded-full flex items-center justify-center flex-shrink-0"
                  >
                    <span class="text-white text-sm font-bold">3</span>
                  </div>
                  <div>
                    <h4 class="font-semibold mb-2">
                      Sharing our youth-created content
                    </h4>
                    <p class="text-sm">
                      Amplify our message across social media
                    </p>
                  </div>
                </div>

                <div class="flex items-start gap-4">
                  <div
                    class="w-8 h-8 bg-primary-blue rounded-full flex items-center justify-center flex-shrink-0"
                  >
                    <span class="text-white text-sm font-bold">4</span>
                  </div>
                  <div>
                    <h4 class="font-semibold mb-2">Volunteering your skills</h4>
                    <p class="text-sm">
                      Use your talents to support our mission
                    </p>
                  </div>
                </div>
              </div>

              <div class="text-center mt-8">
                <p class="text-lg font-medium text-primary mb-6">
                  Together, we're painting a healthier future for Uganda, one
                  brushstroke, one story, one young person at a time.
                </p>
                <p class="text-xl font-bold">
                  The canvas is waiting. Will you join us?
                </p>

                <div class="flex gap-4 justify-center mt-8">
                  <a href="donate.php" class="btn btn-primary"
                    >Support Our Mission</a
                  >
                  <a href="careers.php" class="btn btn-secondary"
                    >Join Our Team</a
                  >
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
