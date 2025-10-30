<?php
// Page configuration
$current_page = 'about';
$page_title = 'About Us - Our Story';
$page_description = 'Learn about Elpis Initiative Uganda - a youth-led nonprofit founded in 2022, empowering Ugandan youth through innovative arts-based solutions.';
$page_url = '/about.php';

// Include header
include 'includes/header.php';
?>

<!-- Hero Section -->
      <section class="hero" id="hero" aria-labelledby="hero-title">
        <div class="container">
          <div class="hero-content">
            <h1 id="hero-title" class="hero-title">
              About Elpis Initiative Uganda
            </h1>
            <p class="hero-subtitle">A Movement for Youth Empowerment</p>
            <div class="hero-buttons">
              <a href="#our-story" class="btn btn-primary btn-lg">
                Our Story
              </a>
              <a href="#leadership" class="btn btn-secondary btn-lg">
                Meet Our Leaders
              </a>
            </div>
          </div>
        </div>
      </section>

      <!-- Our Story Section -->
      <section class="section" id="our-story" aria-labelledby="story-title">
        <div class="container">
          <div class="section-header">
            <h2 id="story-title">Our Story</h2>
            <p>From a local initiative to a nationwide movement</p>
          </div>

          <div class="grid grid-1 gap-8 max-w-4xl mx-auto">
            <div class="glass-card p-8">
              <div class="grid grid-1 gap-6 text-lg">
                <p>
                  <strong>Born in 2022</strong>, Elpis Initiative Uganda
                  represents a new vision for youth empowerment in Uganda.
                  Founders <strong>Nkuutu Brian Moses</strong> and
                  <strong>Feni Desmond</strong> witnessed firsthand how
                  traditional approaches to health education failed to truly
                  reach young people, inspiring them to pioneer an innovative
                  model that speaks to youth in their own language.
                </p>

                <p>
                  Our organization has rapidly evolved from a local initiative
                  to a nationwide movement with presence across six strategic
                  locations. Each region presents unique challenges that inform
                  our tailored programming - from urban health education in
                  Kampala to post-conflict mental health support in Gulu, from
                  rural outreach in Luuka to specialized interventions in
                  pastoral communities of Kotido.
                </p>

                <p>
                  This geographic diversity reflects our commitment to meeting
                  young people where they are, addressing their specific needs
                  through contextually relevant approaches.
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Core Philosophy Section -->
      <section
        class="section"
        style="background: rgba(255, 255, 255, 0.05)"
        id="philosophy"
        aria-labelledby="philosophy-title"
      >
        <div class="container">
          <div class="section-header">
            <h2 id="philosophy-title">Our Philosophy</h2>
            <p>What drives everything we do</p>
          </div>

          <div class="grid grid-1 gap-8 max-w-4xl mx-auto">
            <div class="glass-card p-8">
              <div class="grid grid-1 gap-6 text-lg">
                <p>
                  At the core of our work lies a simple but powerful truth:
                  <strong
                    >when young people engage creatively with important issues,
                    transformation happens</strong
                  >. We've seen how interactive programming creates safe spaces
                  for dialogue about topics often shrouded in silence and
                  stigma.
                </p>

                <p>
                  Our methods foster not just awareness but genuine
                  understanding, equipping participants with knowledge they
                  internalize and share within their communities.
                </p>

                <div
                  class="bg-primary-pink bg-opacity-10 p-6 rounded-lg border-l-4 border-primary-pink"
                >
                  <p class="font-medium">
                    What makes Elpis Initiative Uganda unique isn't just what we
                    do, but how we do it. Every program, every campaign, every
                    interaction is rooted in principles of
                    <strong
                      >youth participation, creative engagement, and community
                      ownership</strong
                    >. We don't just deliver messages, we create experiences
                    that transform perspectives and inspire action.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Impact & Recognition Section -->
      <section class="section" id="impact" aria-labelledby="impact-title">
        <div class="container">
          <div class="section-header">
            <h2 id="impact-title">Our Impact & Recognition</h2>
            <p>Measurable change in just two years</p>
          </div>

          <div class="grid grid-2 gap-8 mb-12">
            <div class="glass-card text-center p-6">
              <div
                class="w-16 h-16 bg-primary-pink rounded-full flex items-center justify-center mx-auto mb-4"
              >
                <span class="text-white font-bold text-xl">1,200+</span>
              </div>
              <h4 class="text-primary mb-4">Youth Directly Engaged</h4>
              <p>Through transformative programs across all six regions</p>
            </div>

            <div class="glass-card text-center p-6">
              <div
                class="w-16 h-16 bg-primary-blue rounded-full flex items-center justify-center mx-auto mb-4"
              >
                <span class="text-white font-bold text-xl">8</span>
              </div>
              <h4 class="text-secondary mb-4">Permanent Art Exhibitions</h4>
              <p>Serving as ongoing education tools in communities</p>
            </div>
          </div>

          <div class="glass-card p-8 max-w-4xl mx-auto">
            <div class="grid grid-1 gap-6 text-lg">
              <p>
                The impact of this approach has been both profound and
                measurable. In just two years, we've directly engaged over 1,200
                young Ugandans, establishing partnerships with educational
                institutions and community organizations across our operational
                areas.
              </p>

              <p>
                The recognition we've received validates what we've always
                believed - that innovative, youth-centered approaches can
                achieve what conventional methods cannot.
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- Leadership Section -->
      <section
        class="section leadership-section"
        style="background: rgba(255, 255, 255, 0.05)"
        id="leadership"
        aria-labelledby="leadership-title"
      >
        <div class="container">
          <div class="section-header">
            <h2 id="leadership-title">Meet Our Leadership</h2>
            <p>Visionary leaders driving change across Uganda</p>
          </div>

          <div class="leadership-grid">
            <!-- Co-Founder -->
            <article class="leadership-card leadership-card-1">
              <div class="leadership-image-wrapper">
                <div class="leadership-image">
                  <img
                    src="images/brian-moses-cofounder.jpg"
                    alt="Nkuutu Brian Moses, Co-Founder"
                    loading="lazy"
                  />
                  <div class="leadership-badge">
                    <span class="badge-role">Co-Founder</span>
                  </div>
                </div>
              </div>
              <div class="leadership-content">
                <div class="leadership-header">
                  <h3 class="leadership-name">Nkuutu Brian Moses</h3>
                  <div class="leadership-divider"></div>
                </div>
                <blockquote class="leadership-quote">
                  "At Elpis Initiative Uganda, we recognize that the fight
                  against HIV and mental health stigma cannot be won with
                  silence or complacency. It requires
                  <strong>bold action, innovation, and ownership</strong> from
                  us the youth."
                </blockquote>
                <p class="mt-6 text-base">
                  Co-founded Elpis Initiative Uganda in 2022 with a vision to
                  pioneer innovative approaches to youth health education.
                  Passionate about empowering young people to take charge of
                  their own development and community transformation.
                </p>
              </div>
            </article>

            <!-- Executive Director -->
            <article class="leadership-card leadership-card-2">
              <div class="leadership-image-wrapper">
                <div class="leadership-image">
                  <img
                    src="images/feni-desmond-executive-director.jpg"
                    alt="Feni Desmond, Executive Director"
                    loading="lazy"
                  />
                  <div class="leadership-badge">
                    <span class="badge-role">Executive Director</span>
                  </div>
                </div>
              </div>
              <div class="leadership-content">
                <div class="leadership-header">
                  <h3 class="leadership-name">Feni Desmond</h3>
                  <div class="leadership-divider"></div>
                </div>
                <blockquote class="leadership-quote">
                  "The time for waiting is over. The power to shape Uganda's
                  future lies in our hands, our voices, and our actions.
                  Together, let's build a nation where no young person suffers
                  in silence."
                </blockquote>
                <p class="mt-6 text-base">
                  Leads the organization's strategic direction with a focus on
                  sustainable, youth-led solutions. Advocates for economic
                  independence and local funding to ensure long-term impact and
                  community ownership.
                </p>
              </div>
            </article>
          </div>
        </div>
      </section>

      <!-- Executive Director's Message Section -->
      <section
        class="section"
        id="directors-message"
        aria-labelledby="message-title"
      >
        <div class="container">
          <div class="section-header">
            <h2 id="message-title">A Message from Our Executive Director</h2>
            <p>Mr. Feni Desmond addresses the youth of Uganda and beyond</p>
          </div>

          <div class="max-w-4xl mx-auto">
            <div class="glass-card p-8">
              <h3 class="text-xl font-bold mb-6 text-center">
                To the Youth of Uganda and Beyond
              </h3>

              <div class="grid grid-1 gap-6 text-lg">
                <p>
                  As young people, we face some of the greatest challenges of
                  our time: HIV/AIDS and mental health crises that
                  disproportionately affect our generation. These are not just
                  health issues; they are threats to our future, our dreams, and
                  our nation's progress. But I say with a firm belief:
                  <strong>we are not victims. We are the solution.</strong>
                </p>

                <p>
                  At Elpis Initiative Uganda, we recognize that the fight
                  against HIV and mental health stigma cannot be won with
                  silence or complacency. It requires
                  <strong>bold action, innovation, and ownership</strong> from
                  us the youth. Too often, we wait for others to solve our
                  problems, but the truth is, no one will care for our future
                  more than we do. That is why I call upon every young Ugandan
                  to stand up, speak out, and take charge of this fight.
                </p>

                <div
                  class="bg-primary-blue bg-opacity-10 p-6 rounded-lg border-l-4 border-primary-blue"
                >
                  <p class="font-medium">
                    Another harsh reality we must confront is dependency on
                    foreign funding. While international support has played a
                    role in development, history has shown us its fragility -
                    like when President Trump cut aid to USAID, leaving many
                    programs stranded. If we truly want sustainable change, we
                    must fund our own movements. That is why Elpis Initiative
                    Uganda champions initiatives like
                    <strong>10 Million Hearts, 1 Cause</strong> - because real
                    transformation begins when we take responsibility for our
                    own solutions.
                  </p>
                </div>

                <p>
                  Let's be honest: conventional methods are failing us. Lectures
                  and pamphlets are not enough to engage today's youth. At Elpis
                  Initiative Uganda, we break the mold by using creative,
                  relatable, and interactive approaches that truly resonate. Our
                  success reaching over 1,200 young lives in just two years
                  proves that when we meet youth where they are, real change
                  happens.
                </p>

                <p>
                  But we cannot do this alone. I call upon every Ugandan - young
                  and old, artist or activist, student or professional - to join
                  us. Support Elpis Initiative Uganda not just for our sake, but
                  for the future of our country. Whether through donations,
                  volunteering, or simply spreading our message, your
                  contribution matters.
                </p>

                <p class="font-bold text-primary text-xl text-center">
                  The time for waiting is over. The power to shape Uganda's
                  future lies in our hands, our voices, and our actions.
                  Together, let's build a nation where no young person suffers
                  in silence, where health is a right, not a privilege, and
                  where Ugandans fund Ugandan solutions.
                </p>

                <p class="text-center font-semibold">
                  Join us. The revolution starts now.
                </p>

                <div class="text-center mt-8">
                  <p class="font-semibold">With determination,</p>
                  <p class="text-lg font-bold text-primary">Feni Desmond</p>
                  <p class="text-sm">
                    Executive Director, Elpis Initiative Uganda
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Our Regions Section -->
      <section
        class="section"
        style="background: rgba(255, 255, 255, 0.05)"
        id="regions"
        aria-labelledby="regions-title"
      >
        <div class="container">
          <div class="section-header">
            <h2 id="regions-title">Our Operational Regions</h2>
            <p>Tailored programming across six strategic locations</p>
          </div>

          <div class="regions-grid grid grid-3 gap-6">
            <div class="glass-card text-center p-6">
              <div class="region-image-container image-container mb-4">
                <img
                  src="images/kampala.jpg"
                  alt="Kampala urban programs"
                  loading="lazy"
                />
              </div>
              <h4 class="text-primary mb-2">Kampala</h4>
              <p class="text-sm">
                Urban youth engagement through digital and performing arts
              </p>
            </div>

            <div class="glass-card text-center p-6">
              <div class="region-image-container image-container mb-4">
                <img
                  src="images/gulu.jpg"
                  alt="Gulu post-conflict programs"
                  loading="lazy"
                />
              </div>
              <h4 class="text-secondary mb-2">Gulu</h4>
              <p class="text-sm">
                Post-conflict mental health healing via creative therapies
              </p>
            </div>

            <div class="glass-card text-center p-6">
              <div class="region-image-container image-container mb-4">
                <img
                  src="images/kotido.jpg"
                  alt="Kotido pastoral community programs"
                  loading="lazy"
                />
              </div>
              <h4 class="text-primary mb-2">Kotido</h4>
              <p class="text-sm">
                Culturally-sensitive programs for pastoral communities
              </p>
            </div>

            <div class="glass-card text-center p-6">
              <div class="region-image-container image-container mb-4">
                <img
                  src="images/luuka.jpg"
                  alt="Luuka rural education programs"
                  loading="lazy"
                />
              </div>
              <h4 class="text-secondary mb-2">Luuka</h4>
              <p class="text-sm">
                Rural SRHR education through community murals and theater
              </p>
            </div>

            <div class="glass-card text-center p-6">
              <div class="region-image-container image-container mb-4">
                <img
                  src="images/arua.jpg"
                  alt="Arua border community programs"
                  loading="lazy"
                />
              </div>
              <h4 class="text-primary mb-2">Arua</h4>
              <p class="text-sm">Border community health initiatives</p>
            </div>

            <div class="glass-card text-center p-6">
              <div class="region-image-container image-container mb-4">
                <img
                  src="images/mbarara.jpg"
                  alt="Mbarara university programs"
                  loading="lazy"
                />
              </div>
              <h4 class="text-secondary mb-2">Mbarara</h4>
              <p class="text-sm">
                University-focused creative health education
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- Future Vision Section -->
      <section class="section" id="future" aria-labelledby="future-title">
        <div class="container">
          <div class="section-header">
            <h2 id="future-title">Our Vision for the Future</h2>
            <p>Building sustainable structures for lasting impact</p>
          </div>

          <div class="grid grid-1 gap-8 max-w-4xl mx-auto">
            <div class="glass-card p-8">
              <div class="grid grid-1 gap-6 text-lg">
                <p>
                  As we look ahead, Elpis Initiative Uganda remains committed to
                  expanding and deepening our impact. We're focused on building
                  sustainable structures, training facilitators, developing
                  replicable program models, and establishing youth leadership
                  councils.
                </p>

                <p>
                  Our vision includes creating platforms that amplify youth
                  voices nationally and forging partnerships that extend our
                  reach across East Africa.
                </p>

                <div
                  class="bg-primary-pink bg-opacity-10 p-6 rounded-lg border-l-4 border-primary-pink"
                >
                  <p class="font-medium">
                    This is more than an organization - it's a movement powered
                    by the energy, creativity and vision of Uganda's youth. From
                    the young participants who become peer educators to the
                    community members who champion our work, Elpis Initiative
                    Uganda represents a collective effort to build a healthier,
                    more equitable future.
                  </p>
                </div>

                <p class="text-center font-bold text-xl text-primary">
                  We invite you to join us in this journey of transformation -
                  as a participant, a partner, or a supporter. Together, we're
                  proving that when young people are truly engaged, meaningful
                  change is not just possible, but inevitable.
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Call to Action Section -->
      <section
        class="section"
        style="background: rgba(255, 255, 255, 0.05)"
        id="join-us"
        aria-labelledby="join-title"
      >
        <div class="container">
          <div class="section-header">
            <h2 id="join-title">Join Our Movement</h2>
            <p>Be part of the solution</p>
          </div>

          <div class="grid grid-3 gap-8">
            <div class="glass-card text-center p-6">
              <div class="image-container mb-6">
                <img
                  src="images/make-donation.jpg"
                  alt="Support our mission"
                  loading="lazy"
                />
              </div>
              <h4 class="mb-4">Support Our Mission</h4>
              <p class="mb-6">
                Join the 10 Million Hearts, One Cause campaign and become an
                Elpis Partner
              </p>
              <a href="donate.php" class="btn btn-primary">Donate Now</a>
            </div>

            <div class="glass-card text-center p-6">
              <div class="image-container mb-6">
                <img
                  src="images/join-team.jpg"
                  alt="Volunteer with us"
                  loading="lazy"
                />
              </div>
              <h4 class="mb-4">Work With Us</h4>
              <p class="mb-6">
                Explore career opportunities across our six operational regions
              </p>
              <a href="careers.php" class="btn btn-secondary"
                >View Positions</a
              >
            </div>

            <div class="glass-card text-center p-6">
              <div class="image-container mb-6">
                <img
                  src="images/partnership-collaboration.jpg"
                  alt="Learn about our programs"
                  loading="lazy"
                />
              </div>
              <h4 class="mb-4">Learn More</h4>
              <p class="mb-6">
                Discover our innovative programs and see how we're making a
                difference
              </p>
              <a href="programs.php" class="btn btn-outline">Our Programs</a>
            </div>
          </div>
        </div>
      </section>

<?php
// Include footer
include 'includes/footer.php';
?>
