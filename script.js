// Elpis Initiative Uganda - Enhanced JavaScript Functionality

class CustomCarousel {
  constructor(element, options = {}) {
    this.carousel = element;
    this.options = {
      autoplay: options.autoplay || false,
      interval: options.interval || 5000,
      ...options
    };

    // Find the carousel container
    this.container = this.carousel.querySelector('.carousel-container');
    if (!this.container) {
      console.error('Carousel container not found');
      return;
    }

    this.slides = Array.from(this.container.querySelectorAll('.carousel-slide'));
    this.totalSlides = this.slides.length;
    this.currentSlide = 0;

    if (this.totalSlides === 0) {
      console.error('No slides found in carousel');
      return;
    }

    this.init();
  }

  init() {
    // Set container height based on tallest slide
    this.setContainerHeight();

    // Create prev/next buttons inside carousel
    this.createButtons();

    // Create navigation dots outside carousel
    this.createNavigation();

    // Find which slide should be active initially
    let initialSlide = 0;
    this.slides.forEach((slide, index) => {
      if (slide.classList.contains('active')) {
        initialSlide = index;
      }
    });

    // Set initial state
    this.showSlide(initialSlide);

    // Start autoplay if enabled
    if (this.options.autoplay) {
      this.startAutoplay();
    }

    // Add keyboard navigation
    this.addKeyboardNavigation();

    // Add touch navigation
    this.addTouchNavigation();

    // Pause autoplay on hover
    if (this.options.autoplay) {
      this.carousel.addEventListener('mouseenter', () => this.stopAutoplay());
      this.carousel.addEventListener('mouseleave', () => this.startAutoplay());
    }
  }

  setContainerHeight() {
    // Use requestAnimationFrame to ensure DOM is ready
    requestAnimationFrame(() => {
      // Calculate the height of the tallest slide
      let maxHeight = 0;

      this.slides.forEach((slide, index) => {
        // Store original styles
        const originalPosition = slide.style.position;

        // Temporarily make slide visible and positioned relatively to measure it
        slide.style.position = 'relative';
        slide.style.visibility = 'visible';
        slide.style.opacity = '1';

        const height = slide.offsetHeight;
        if (height > maxHeight) {
          maxHeight = height;
        }

        // Restore position, but let CSS handle visibility/opacity
        slide.style.position = originalPosition || 'absolute';
        slide.style.visibility = '';
        slide.style.opacity = '';
      });

      if (maxHeight > 0) {
        this.container.style.minHeight = `${maxHeight}px`;
      }
    });
  }

  createNavigation() {
    const nav = document.createElement('div');
    nav.className = 'carousel-nav';

    this.slides.forEach((_, index) => {
      const dot = document.createElement('button');
      dot.className = 'carousel-dot';
      dot.setAttribute('aria-label', `Go to slide ${index + 1}`);
      dot.addEventListener('click', () => this.showSlide(index));
      nav.appendChild(dot);
    });

    // Insert navigation after the carousel element
    this.carousel.parentNode.insertBefore(nav, this.carousel.nextSibling);
    this.dots = nav.querySelectorAll('.carousel-dot');
  }

  createButtons() {
    const prevButton = document.createElement('button');
    prevButton.className = 'carousel-button prev';
    prevButton.innerHTML = '‹';
    prevButton.setAttribute('aria-label', 'Previous slide');
    prevButton.setAttribute('type', 'button');

    const nextButton = document.createElement('button');
    nextButton.className = 'carousel-button next';
    nextButton.innerHTML = '›';
    nextButton.setAttribute('aria-label', 'Next slide');
    nextButton.setAttribute('type', 'button');

    prevButton.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      console.log('Previous button clicked');
      this.prevSlide();
    });

    nextButton.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      console.log('Next button clicked');
      this.nextSlide();
    });

    this.carousel.appendChild(prevButton);
    this.carousel.appendChild(nextButton);
  }

  showSlide(index) {
    // Handle index bounds
    if (index < 0) index = this.totalSlides - 1;
    if (index >= this.totalSlides) index = 0;

    console.log(`Showing slide ${index} of ${this.totalSlides}`);

    // Update slides with smooth transition
    this.slides.forEach((slide, i) => {
      if (i === index) {
        slide.classList.add('active');
        // Remove inline styles that might override CSS
        slide.style.opacity = '';
        slide.style.visibility = '';
      } else {
        slide.classList.remove('active');
        // Remove inline styles that might override CSS
        slide.style.opacity = '';
        slide.style.visibility = '';
      }
    });

    // Update dots
    if (this.dots) {
      this.dots.forEach((dot, i) => {
        if (i === index) {
          dot.classList.add('active');
        } else {
          dot.classList.remove('active');
        }
      });
    }

    this.currentSlide = index;

    // Announce slide change to screen readers
    this.announceSlideChange(index);
  }

  nextSlide() {
    this.showSlide(this.currentSlide + 1);
  }

  prevSlide() {
    this.showSlide(this.currentSlide - 1);
  }

  startAutoplay() {
    this.stopAutoplay(); // Clear any existing interval
    this.autoplayInterval = setInterval(() => {
      this.nextSlide();
    }, this.options.interval);
  }

  stopAutoplay() {
    if (this.autoplayInterval) {
      clearInterval(this.autoplayInterval);
      this.autoplayInterval = null;
    }
  }

  addKeyboardNavigation() {
    this.carousel.setAttribute('tabindex', '0');
    this.carousel.addEventListener('keydown', (e) => {
      switch (e.key) {
        case 'ArrowLeft':
          e.preventDefault();
          this.prevSlide();
          break;
        case 'ArrowRight':
          e.preventDefault();
          this.nextSlide();
          break;
      }
    });
  }

  addTouchNavigation() {
    let touchStartX = 0;
    let touchEndX = 0;

    this.carousel.addEventListener('touchstart', (e) => {
      touchStartX = e.touches[0].clientX;
    }, { passive: true });

    this.carousel.addEventListener('touchend', (e) => {
      touchEndX = e.changedTouches[0].clientX;
      this.handleSwipe();
    }, { passive: true });

    this.handleSwipe = () => {
      const swipeThreshold = 50;
      const diff = touchStartX - touchEndX;

      if (Math.abs(diff) > swipeThreshold) {
        if (diff > 0) {
          this.nextSlide();
        } else {
          this.prevSlide();
        }
      }
    };
  }

  announceSlideChange(index) {
    // Create or update aria-live region
    let liveRegion = this.carousel.querySelector('.carousel-live-region');
    if (!liveRegion) {
      liveRegion = document.createElement('div');
      liveRegion.className = 'carousel-live-region sr-only';
      liveRegion.setAttribute('aria-live', 'polite');
      this.carousel.appendChild(liveRegion);
    }

    const currentSlide = this.slides[index];
    const slideTitle = currentSlide.querySelector('h3, h4')?.textContent || `Slide ${index + 1} of ${this.totalSlides}`;
    liveRegion.textContent = slideTitle;
  }
}

class ElpisWebsite {
  constructor() {
    this.init()
  }

  init() {
    this.initNavigation()
    this.initSmoothScrolling()
    this.initActiveNavHighlighting()
    this.initFormValidation()
    this.initDonationFunctionality()
    this.initGalleryFunctionality()
    // this.initAnimations() - Disabled to prevent fade-out effects
    this.initAccessibility()
    this.initCopyrightYear()
    this.initJobListings()
    this.initJobApplicationForm()
    this.initCustomCarousels()
  }

  // Navigation functionality
  initNavigation() {
    const hamburger = document.querySelector('.hamburger')
    const navMenu = document.querySelector('.nav-menu')

    if (hamburger && navMenu) {
      // Toggle mobile menu
      hamburger.addEventListener('click', (e) => {
        e.stopPropagation()
        this.toggleMobileMenu()
      })

      // Close mobile menu when clicking on a link
      document.querySelectorAll('.nav-menu a').forEach(link => {
        link.addEventListener('click', () => {
          this.closeMobileMenu()
        })
      })

      // Close mobile menu when clicking outside
      document.addEventListener('click', (e) => {
        if (!hamburger.contains(e.target) && !navMenu.contains(e.target)) {
          this.closeMobileMenu()
        }
      })

      // Close mobile menu on escape key
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
          this.closeMobileMenu()
        }
      })
    }

    // Header scroll behavior
    this.initHeaderScroll()
  }

  toggleMobileMenu() {
    const hamburger = document.querySelector('.hamburger')
    const navMenu = document.querySelector('.nav-menu')

    hamburger.classList.toggle('active')
    navMenu.classList.toggle('active')

    // Prevent body scroll when menu is open
    document.body.style.overflow = navMenu.classList.contains('active') ? 'hidden' : ''

    // Update ARIA attributes
    const isOpen = navMenu.classList.contains('active')
    hamburger.setAttribute('aria-expanded', isOpen)
    navMenu.setAttribute('aria-hidden', !isOpen)
  }

  closeMobileMenu() {
    const hamburger = document.querySelector('.hamburger')
    const navMenu = document.querySelector('.nav-menu')

    if (hamburger && navMenu) {
      hamburger.classList.remove('active')
      navMenu.classList.remove('active')
      document.body.style.overflow = ''

      // Update ARIA attributes
      hamburger.setAttribute('aria-expanded', 'false')
      navMenu.setAttribute('aria-hidden', 'true')
    }
  }

  initHeaderScroll() {
    const header = document.querySelector('.header')
    let lastScrollY = window.scrollY

    window.addEventListener('scroll', () => {
      const currentScrollY = window.scrollY

      if (header) {
        if (currentScrollY > 100) {
          header.style.background = 'rgba(255, 255, 255, 0.95)'
          header.style.backdropFilter = 'blur(10px)'
        } else {
          header.style.background = 'var(--white)'
          header.style.backdropFilter = 'none'
        }
      }

      lastScrollY = currentScrollY
    })
  }

  // Smooth scrolling for anchor links
  initSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', (e) => {
        e.preventDefault()
        const target = document.querySelector(anchor.getAttribute('href'))

        if (target) {
          const headerHeight = document.querySelector('.header')?.offsetHeight || 0
          const targetPosition = target.offsetTop - headerHeight - 20

          window.scrollTo({
            top: targetPosition,
            behavior: 'smooth'
          })
        }
      })
    })
  }

  // Active navigation link highlighting
  initActiveNavHighlighting() {
    const currentPage = window.location.pathname.split('/').pop() || 'index.html'

    document.querySelectorAll('.nav-menu a').forEach(link => {
      link.classList.remove('active')

      if (link.getAttribute('href') === currentPage) {
        link.classList.add('active')
      }
    })

    // Intersection Observer for section highlighting
    const sections = document.querySelectorAll('section[id]')
    const navLinks = document.querySelectorAll('.nav-menu a[href^="#"]')

    if (sections.length > 0 && navLinks.length > 0) {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            navLinks.forEach(link => {
              link.classList.remove('active')
              if (link.getAttribute('href') === `#${entry.target.id}`) {
                link.classList.add('active')
              }
            })
          }
        })
      }, { threshold: 0.3 })

      sections.forEach(section => observer.observe(section))
    }
  }

  // Form validation
  initFormValidation() {
    const forms = document.querySelectorAll('form')

    forms.forEach(form => {
      form.addEventListener('submit', (e) => {
        if (!this.validateForm(form)) {
          e.preventDefault()
        }
      })

      // Real-time validation
      const inputs = form.querySelectorAll('input, select, textarea')
      inputs.forEach(input => {
        input.addEventListener('blur', () => this.validateField(input))
        input.addEventListener('input', () => this.clearFieldError(input))
      })
    })
  }

  validateForm(form) {
    let isValid = true
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]')

    inputs.forEach(input => {
      if (!this.validateField(input)) {
        isValid = false
      }
    })

    // Specific validation for different forms
    const formType = form.dataset.formType

    if (formType === 'donation') {
      isValid = this.validateDonationForm(form) && isValid
    } else if (formType === 'assist') {
      isValid = this.validateAssistForm(form) && isValid
    }

    return isValid
  }

  validateField(field) {
    const value = field.value.trim()
    const fieldType = field.type
    const fieldName = field.name
    let isValid = true
    let errorMessage = ''

    // Clear previous errors
    this.clearFieldError(field)

    // Required field validation
    if (field.hasAttribute('required') && !value) {
      errorMessage = `${this.getFieldLabel(field)} is required`
      isValid = false
    }

    // Type-specific validation
    if (value && isValid) {
      switch (fieldType) {
        case 'email':
          const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
          if (!emailRegex.test(value)) {
            errorMessage = 'Please enter a valid email address'
            isValid = false
          }
          break

        case 'tel':
          const phoneRegex = /^[\d\s\-\+\(\)]+$/
          if (!phoneRegex.test(value) || value.length < 10) {
            errorMessage = 'Please enter a valid phone number'
            isValid = false
          }
          break

        case 'number':
          if (fieldName === 'custom-amount' && parseFloat(value) < 20000) {
            errorMessage = 'Minimum donation amount is UGX 20,000'
            isValid = false
          }
          break
      }
    }

    // Partner ID validation
    if (fieldName === 'partner-id' && value) {
      if (!/^EP\d{6}$/.test(value)) {
        errorMessage = 'Partner ID must be in format EP123456'
        isValid = false
      }
    }

    if (!isValid) {
      this.showFieldError(field, errorMessage)
    }

    return isValid
  }

  validateDonationForm(form) {
    const selectedAmount = form.querySelector('.amount-option.selected')
    const customAmount = form.querySelector('input[name="custom-amount"]')

    if (!selectedAmount && (!customAmount || !customAmount.value)) {
      this.showFormError(form, 'Please select or enter a donation amount')
      return false
    }

    const selectedPayment = form.querySelector('.payment-method.selected')
    if (!selectedPayment) {
      this.showFormError(form, 'Please select a payment method')
      return false
    }

    return true
  }

  validateAssistForm(form) {
    const message = form.querySelector('textarea[name="message"]')
    if (message && message.value.trim().length < 20) {
      this.showFieldError(message, 'Please provide more details about your need (minimum 20 characters)')
      return false
    }
    return true
  }

  getFieldLabel(field) {
    const label = document.querySelector(`label[for="${field.id}"]`)
    return label ? label.textContent.replace('*', '').trim() : field.name
  }

  showFieldError(field, message) {
    const errorElement = document.createElement('div')
    errorElement.className = 'form-error'
    errorElement.textContent = message
    errorElement.setAttribute('role', 'alert')

    field.parentNode.appendChild(errorElement)
    field.classList.add('error')
    field.setAttribute('aria-invalid', 'true')
    field.setAttribute('aria-describedby', errorElement.id = `error-${field.name}`)
  }

  clearFieldError(field) {
    const existingError = field.parentNode.querySelector('.form-error')
    if (existingError) {
      existingError.remove()
    }
    field.classList.remove('error')
    field.removeAttribute('aria-invalid')
    field.removeAttribute('aria-describedby')
  }

  showFormError(form, message) {
    const existingError = form.querySelector('.form-error')
    if (existingError) existingError.remove()

    const errorElement = document.createElement('div')
    errorElement.className = 'form-error'
    errorElement.textContent = message
    errorElement.setAttribute('role', 'alert')

    form.insertBefore(errorElement, form.firstChild)
  }

  // Donation functionality
  initDonationFunctionality() {
    this.initAmountSelection()
    this.initPaymentMethodSelection()
    this.initDonationSubmission()
  }

  initAmountSelection() {
    const amountOptions = document.querySelectorAll('.amount-option')
    const customAmountInput = document.querySelector('input[name="custom-amount"]')

    amountOptions.forEach(option => {
      option.addEventListener('click', () => {
        // Clear other selections
        amountOptions.forEach(opt => opt.classList.remove('selected'))
        option.classList.add('selected')

        // Clear custom amount
        if (customAmountInput) {
          customAmountInput.value = ''
        }

        // Update form data
        this.updateDonationAmount(option.dataset.amount)
      })
    })

    if (customAmountInput) {
      customAmountInput.addEventListener('input', () => {
        // Clear preset selections
        amountOptions.forEach(opt => opt.classList.remove('selected'))

        // Update form data
        this.updateDonationAmount(customAmountInput.value)
      })
    }
  }

  initPaymentMethodSelection() {
    const paymentMethods = document.querySelectorAll('.payment-method')

    paymentMethods.forEach(method => {
      method.addEventListener('click', () => {
        paymentMethods.forEach(m => m.classList.remove('selected'))
        method.classList.add('selected')

        // Update payment form fields
        this.updatePaymentMethod(method.dataset.method)
      })
    })
  }

  updateDonationAmount(amount) {
    const form = document.querySelector('form[data-form-type="donation"]')
    if (!form) return

    // Store amount in hidden input or data attribute
    let amountInput = form.querySelector('input[name="amount"]')
    if (!amountInput) {
      amountInput = document.createElement('input')
      amountInput.type = 'hidden'
      amountInput.name = 'amount'
      form.appendChild(amountInput)
    }
    amountInput.value = amount
  }

  updatePaymentMethod(method) {
    const form = document.querySelector('form[data-form-type="donation"]')
    if (!form) return

    // Store payment method
    let methodInput = form.querySelector('input[name="payment-method"]')
    if (!methodInput) {
      methodInput = document.createElement('input')
      methodInput.type = 'hidden'
      methodInput.name = 'payment-method'
      form.appendChild(methodInput)
    }
    methodInput.value = method

    // Show/hide payment-specific fields
    this.togglePaymentFields(method)
  }

  togglePaymentFields(method) {
    const mtnFields = document.querySelectorAll('.mtn-fields')
    const airtelFields = document.querySelectorAll('.airtel-fields')

    mtnFields.forEach(field => {
      field.style.display = method === 'mtn' ? 'block' : 'none'
    })

    airtelFields.forEach(field => {
      field.style.display = method === 'airtel' ? 'block' : 'none'
    })
  }

  initDonationSubmission() {
    const donationForm = document.querySelector('form[data-form-type="donation"]')

    if (donationForm) {
      donationForm.addEventListener('submit', (e) => {
        e.preventDefault()
        this.processDonation(donationForm)
      })
    }
  }

  processDonation(form) {
    const formData = new FormData(form)
    const donationData = {
      amount: formData.get('amount') || form.querySelector('.amount-option.selected')?.dataset.amount,
      paymentMethod: formData.get('payment-method'),
      donorName: formData.get('donor-name'),
      email: formData.get('email'),
      phone: formData.get('phone')
    }

    // Show loading state
    this.showLoadingState(form)

    // Simulate API call
    setTimeout(() => {
      this.showDonationSuccess(donationData)
      this.hideLoadingState(form)
    }, 2000)
  }

  showLoadingState(form) {
    const submitBtn = form.querySelector('button[type="submit"]')
    if (submitBtn) {
      submitBtn.disabled = true
      submitBtn.innerHTML = '<span>Processing...</span>'
      submitBtn.classList.add('loading')
    }
  }

  hideLoadingState(form) {
    const submitBtn = form.querySelector('button[type="submit"]')
    if (submitBtn) {
      submitBtn.disabled = false
      submitBtn.innerHTML = 'Complete Donation'
      submitBtn.classList.remove('loading')
    }
  }

  showDonationSuccess(data) {
    const modal = this.createModal(`
      <div class="text-center p-8">
        <div class="mb-4">
          <div class="success-icon">✓</div>
        </div>
        <h3 class="mb-4">Thank You for Your Donation!</h3>
        <p class="mb-6">Your contribution of UGX ${Number(data.amount).toLocaleString()} will help us empower more youth across Uganda.</p>
        <p class="mb-6 text-sm">You are now an <strong>Elpis Partner</strong>! Your partner ID will be sent to your email.</p>
        <button class="btn btn-primary" onclick="this.closest('.modal').remove()">Continue</button>
      </div>
    `)
    document.body.appendChild(modal)

    // Reset form
    setTimeout(() => {
      location.reload()
    }, 5000)
  }

  // Gallery functionality
  initGalleryFunctionality() {
    this.initGalleryFilters()
    this.initGalleryModal()
    this.initGalleryLazyLoading()
    this.initModernGallery()
    this.initCarousel()
  }

  initGalleryFilters() {
    const filterButtons = document.querySelectorAll('.filter-btn')
    const galleryItems = document.querySelectorAll('.gallery-item')

    filterButtons.forEach(button => {
      button.addEventListener('click', () => {
        const filter = button.dataset.filter

        // Update active button
        filterButtons.forEach(btn => btn.classList.remove('active'))
        button.classList.add('active')

        // Filter items
        galleryItems.forEach(item => {
          const itemCategory = item.dataset.category

          if (filter === 'all' || itemCategory === filter) {
            item.style.display = 'block'
            item.style.animation = 'fadeIn 0.5s ease-in-out'
          } else {
            item.style.display = 'none'
          }
        })
      })
    })
  }

  initGalleryModal() {
    const galleryItems = document.querySelectorAll('.gallery-item')

    galleryItems.forEach(item => {
      item.addEventListener('click', () => {
        const imgSrc = item.querySelector('img').src
        const imgAlt = item.querySelector('img').alt
        const caption = item.querySelector('.gallery-overlay')?.textContent || imgAlt

        this.showImageModal(imgSrc, caption)
      })
    })
  }

  showImageModal(src, caption) {
    const modal = this.createModal(`
      <div class="modal-content">
        <button class="modal-close" onclick="this.closest('.modal').remove()">&times;</button>
        <img src="${src}" alt="${caption}">
        <div class="p-4">
          <p class="text-center">${caption}</p>
        </div>
      </div>
    `)

    document.body.appendChild(modal)

    // Close on background click
    modal.addEventListener('click', (e) => {
      if (e.target === modal) {
        modal.remove()
      }
    })

    // Close on escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        modal.remove()
      }
    })
  }

  initGalleryLazyLoading() {
    const images = document.querySelectorAll('.gallery-item img')

    if ('IntersectionObserver' in window) {
      const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const img = entry.target
            img.src = img.dataset.src || img.src
            img.classList.remove('lazy')
            imageObserver.unobserve(img)
          }
        })
      })

      images.forEach(img => imageObserver.observe(img))
    }
  }

  // Modern Gallery Functionality
  initModernGallery() {
    // Gallery image sources array - can accommodate 100+ images
    this.galleryImages = [
      'images/image (1).jpg',
      'images/image (7).jpg',
      'images/image (12).jpg',
      'images/image (15).jpg',
      'images/image (19).jpg',
      'images/image (23).jpg',
      'images/image (28).jpg',
      'images/image (31).jpg',
      'images/image (35).jpeg',
      'images/image (38).jpeg',
      'images/image (41).jpeg',
      'images/image (45).jpeg',
      'images/image (50).jpeg',
      'images/image (56).jpeg',
      'images/image (64).jpeg',
      'images/image (72).jpeg',
      'images/image (2).jpg',
      'images/image (3).jpg',
      'images/image (4).jpg',
      'images/image (5).jpg',
      'images/image (6).jpg',
      'images/image (8).jpg',
      'images/image (9).jpg',
      'images/image (10).jpg',
      'images/image (11).jpg',
      'images/image (13).jpg',
      'images/image (14).jpg',
      'images/image (16).jpg',
      'images/image (17).jpg',
      'images/image (18).jpg',
      'images/image (20).jpg',
      'images/image (21).jpg',
      'images/image (22).jpg',
      'images/image (24).jpg',
      'images/image (25).jpg',
      'images/image (26).jpg',
      'images/image (27).jpg',
      'images/image (29).jpg',
      'images/image (30).jpg',
      'images/image (32).jpg',
      'images/image (33).jpg',
      'images/image (34).jpeg',
      'images/image (36).jpeg',
      'images/image (37).jpeg',
      'images/image (39).jpeg',
      'images/image (40).jpeg',
      'images/image (42).jpeg',
      'images/image (43).jpeg',
      'images/image (44).jpeg',
      'images/image (46).jpeg',
      'images/image (47).jpeg',
      'images/image (48).jpeg',
      'images/image (49).jpeg',
      'images/image (51).jpeg',
      'images/image (52).jpeg',
      'images/image (53).jpeg',
      'images/image (54).jpeg',
      'images/image (55).jpeg',
      'images/image (57).jpeg',
      'images/image (58).jpeg',
      'images/image (59).jpeg',
      'images/image (60).jpeg',
      'images/image (61).jpeg',
      'images/image (62).jpeg',
      'images/image (63).jpeg',
      'images/image (65).jpeg',
      'images/image (66).jpeg',
      'images/image (67).jpeg',
      'images/image (68).jpeg',
      'images/image (69).jpeg',
      'images/image (70).jpeg',
      'images/image (71).jpeg',
      'images/image (73).jpeg',
      'images/image (74).jpeg',
      'images/image (75).jpeg',
      'images/bottom-view-women-protesting-outdoors.jpg',
      'images/dark-businesswoman-shaking-hands-with-male-colleague.jpg',
      'images/student.jpg'
      // Add more images here as needed - can easily scale to 100+ images
    ]

    this.currentImageIndex = 0
    this.imagesPerLoad = 15 // Load 15 images at a time

    // Initialize gallery if on gallery page
    const galleryGrid = document.getElementById('gallery-grid')
    if (galleryGrid) {
      this.addGalleryStyles()
      this.loadInitialImages()
      this.initLoadMoreButton()
      this.initGalleryImageModal()
    }
  }

  addGalleryStyles() {
    // Add modern gallery CSS styles
    const style = document.createElement('style')
    style.textContent = `
      .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
        margin-top: 2rem;
      }
      
      .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
      }
      
      .gallery-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        border-color: rgba(236, 0, 140, 0.5);
      }
      
      .gallery-item img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        transition: transform 0.3s ease;
      }
      
      .gallery-item:hover img {
        transform: scale(1.05);
      }
      
      .gallery-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(236, 0, 140, 0.1), rgba(0, 174, 239, 0.1));
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
      }
      
      .gallery-item:hover::before {
        opacity: 1;
      }
      
      @media (max-width: 768px) {
        .gallery-grid {
          grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
          gap: 15px;
        }
        
        .gallery-item img {
          height: 200px;
        }
      }
      
      @media (max-width: 480px) {
        .gallery-grid {
          grid-template-columns: 1fr 1fr;
          gap: 10px;
        }
        
        .gallery-item img {
          height: 150px;
        }
      }
    `
    document.head.appendChild(style)
  }

  loadInitialImages() {
    this.loadMoreImages()
  }

  loadMoreImages() {
    const galleryGrid = document.getElementById('gallery-grid')
    const endIndex = Math.min(this.currentImageIndex + this.imagesPerLoad, this.galleryImages.length)

    for (let i = this.currentImageIndex; i < endIndex; i++) {
      const imageItem = this.createGalleryImageItem(this.galleryImages[i], i)
      galleryGrid.appendChild(imageItem)
    }

    this.currentImageIndex = endIndex
    this.updateLoadMoreButton()
  }

  createGalleryImageItem(imageSrc, index) {
    const item = document.createElement('div')
    item.className = 'gallery-item'
    item.innerHTML = `
      <img src="${imageSrc}" alt="Gallery image ${index + 1}" loading="lazy" />
    `

    // Add click handler for modal
    item.addEventListener('click', () => {
      this.showGalleryImageModal(imageSrc, `Gallery image ${index + 1}`)
    })

    return item
  }

  initLoadMoreButton() {
    const loadMoreBtn = document.getElementById('load-more-btn')
    if (loadMoreBtn) {
      loadMoreBtn.addEventListener('click', () => {
        this.loadMoreImages()
      })
    }
  }

  updateLoadMoreButton() {
    const loadMoreBtn = document.getElementById('load-more-btn')
    if (loadMoreBtn) {
      if (this.currentImageIndex < this.galleryImages.length) {
        loadMoreBtn.style.display = 'inline-block'
        loadMoreBtn.textContent = `Load More Images (${this.galleryImages.length - this.currentImageIndex} remaining)`
      } else {
        loadMoreBtn.style.display = 'none'
      }
    }
  }

  initGalleryImageModal() {
    // Modal functionality is handled in createGalleryImageItem
  }

  showGalleryImageModal(src, caption) {
    const modal = this.createModal(`
      <div class="modal-content" style="max-width: 90vw; max-height: 90vh;">
        <button class="modal-close" onclick="this.closest('.modal').remove()" 
                style="position: absolute; top: 20px; right: 20px; z-index: 1001; 
                       background: rgba(0,0,0,0.7); color: white; border: none; 
                       width: 40px; height: 40px; border-radius: 50%; cursor: pointer; 
                       font-size: 24px; display: flex; align-items: center; justify-content: center;">&times;</button>
        <img src="${src}" alt="${caption}" style="width: 100%; height: auto; max-height: 80vh; object-fit: contain;" />
        <div style="padding: 20px; text-align: center; background: rgba(255,255,255,0.9);">
          <p style="margin: 0; color: #333;">${caption}</p>
        </div>
      </div>
    `)

    document.body.appendChild(modal)

    // Close on background click
    modal.addEventListener('click', (e) => {
      if (e.target === modal) {
        modal.remove()
      }
    })

    // Close on escape key
    const escapeHandler = (e) => {
      if (e.key === 'Escape') {
        modal.remove()
        document.removeEventListener('keydown', escapeHandler)
      }
    }
    document.addEventListener('keydown', escapeHandler)
  }

  // Carousel Functionality
  initCarousel() {
    // Bootstrap carousels are now handled automatically by Bootstrap JS
    // No custom carousel initialization needed
  }




  // Animations
  initAnimations() {
    // Animations disabled for better performance and visibility
    this.initCounterAnimations()
  }

  initScrollAnimations() {
    // Scroll animations disabled - all elements visible immediately
    const animatedElements = document.querySelectorAll('.card, .stat-card, .program-card, .glass-card')

    animatedElements.forEach(el => {
      el.style.opacity = '1'
      el.style.transform = 'none'
      el.style.transition = 'none'
    })
  }

  initCounterAnimations() {
    // Counter animations disabled - numbers show immediately
  }

  animateCounter(element) {
    // Counter animation disabled
  }

  // Accessibility features
  initAccessibility() {
    this.initKeyboardNavigation()
    this.initFocusManagement()
    this.initARIAUpdates()
  }

  initKeyboardNavigation() {
    // Tab navigation for custom components
    const interactiveElements = document.querySelectorAll('.amount-option, .payment-method, .filter-btn')

    interactiveElements.forEach(element => {
      if (!element.hasAttribute('tabindex')) {
        element.setAttribute('tabindex', '0')
      }

      element.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault()
          element.click()
        }
      })
    })
  }

  initFocusManagement() {
    // Focus management for modals
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Tab') {
        const modal = document.querySelector('.modal.active')
        if (modal) {
          this.trapFocus(e, modal)
        }
      }
    })
  }

  trapFocus(e, container) {
    const focusableElements = container.querySelectorAll(
      'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
    )
    const firstElement = focusableElements[0]
    const lastElement = focusableElements[focusableElements.length - 1]

    if (e.shiftKey) {
      if (document.activeElement === firstElement) {
        e.preventDefault()
        lastElement.focus()
      }
    } else {
      if (document.activeElement === lastElement) {
        e.preventDefault()
        firstElement.focus()
      }
    }
  }

  initARIAUpdates() {
    // Update ARIA labels dynamically
    const hamburger = document.querySelector('.hamburger')
    if (hamburger) {
      hamburger.setAttribute('aria-label', 'Toggle navigation menu')
      hamburger.setAttribute('aria-expanded', 'false')
    }

    const navMenu = document.querySelector('.nav-menu')
    if (navMenu) {
      navMenu.setAttribute('aria-hidden', 'true')
    }
  }

  // Utility methods
  createModal(content) {
    const modal = document.createElement('div')
    modal.className = 'modal active'
    modal.innerHTML = content
    modal.setAttribute('role', 'dialog')
    modal.setAttribute('aria-modal', 'true')

    return modal
  }

  debounce(func, wait) {
    let timeout
    return function executedFunction(...args) {
      const later = () => {
        clearTimeout(timeout)
        func(...args)
      }
      clearTimeout(timeout)
      timeout = setTimeout(later, wait)
    }
  }

  // Public API methods
  showNotification(message, type = 'info') {
    const notification = document.createElement('div')
    notification.className = `notification notification-${type}`
    notification.innerHTML = `
      <span>${message}</span>
      <button onclick="this.parentElement.remove()">&times;</button>
    `

    document.body.appendChild(notification)

    setTimeout(() => {
      notification.remove()
    }, 5000)
  }

  updatePartnerStatus(isPartner, partnerId = null) {
    const partnerElements = document.querySelectorAll('.partner-only')

    partnerElements.forEach(element => {
      element.style.display = isPartner ? 'block' : 'none'
    })

    if (isPartner && partnerId) {
      const partnerIdInputs = document.querySelectorAll('input[name="partner-id"]')
      partnerIdInputs.forEach(input => {
        input.value = partnerId
        input.readOnly = true
      })
    }
  }

  // Dynamic copyright year
  initCopyrightYear() {
    const copyrightYear = document.getElementById('copyright-year')
    if (copyrightYear) {
      const currentYear = new Date().getFullYear()
      copyrightYear.textContent = currentYear
    }
  }

  // Job listings functionality
  initJobListings() {
    this.currentPage = 1
    this.jobsPerPage = 6
    this.initPagination() // Initialize pagination first
    this.loadJobs()
    this.initJobFilters()
  }

  loadJobs() {
    // Load embedded job data directly
    this.loadEmbeddedJobs()
  }

  loadEmbeddedJobs() {
    // Embedded job data as fallback
    this.jobs = [
      {
        "id": 1,
        "title": "Regional Finance Officer",
        "department": "Finance & Admin",
        "location": "Kampala",
        "type": "partner-only",
        "description": "Manage daily financial operations and budget support across regional offices.",
        "qualifications": "Degree in finance/accounting, CPA preferred",
        "experience": "3-5 years",
        "salary_range": "UGX 2,800,000 - 3,800,000"
      },
      {
        "id": 2,
        "title": "Accountant",
        "department": "Finance & Admin",
        "location": "Arua",
        "type": "partner-only",
        "description": "Handle financial records, reporting, and compliance.",
        "qualifications": "Degree in accounting, professional certification",
        "experience": "2-4 years",
        "salary_range": "UGX 2,200,000 - 3,000,000"
      },
      {
        "id": 3,
        "title": "HR Assistant",
        "department": "Finance & Admin",
        "location": "Kampala",
        "type": "partner-only",
        "description": "Support HR operations, recruitment, and employee relations.",
        "qualifications": "Diploma in HR, CIPD certification preferred",
        "experience": "1-3 years",
        "salary_range": "UGX 1,500,000 - 2,200,000"
      },
      {
        "id": 4,
        "title": "Procurement Officer",
        "department": "Finance & Admin",
        "location": "Kampala",
        "type": "partner-only",
        "description": "Manage procurement processes and ensure compliance with regulations.",
        "qualifications": "Degree in procurement, CIPS certification preferred",
        "experience": "2-4 years",
        "salary_range": "UGX 2,000,000 - 2,800,000"
      },
      {
        "id": 5,
        "title": "Logistics Officer",
        "department": "Finance & Admin",
        "location": "Gulu",
        "type": "partner-only",
        "description": "Oversee logistics operations and supply chain management.",
        "qualifications": "Degree in logistics or supply chain management",
        "experience": "2-4 years",
        "salary_range": "UGX 2,000,000 - 2,800,000"
      },
      {
        "id": 6,
        "title": "Office Manager",
        "department": "Finance & Admin",
        "location": "Kotido",
        "type": "partner-only",
        "description": "Supervise office operations, administration, and staff coordination.",
        "qualifications": "Degree in administration or business management",
        "experience": "3-5 years",
        "salary_range": "UGX 2,500,000 - 3,500,000"
      },
      {
        "id": 7,
        "title": "Front Desk Manager",
        "department": "Finance & Admin",
        "location": "Kampala",
        "type": "open",
        "description": "Ensure excellent customer service and manage front desk operations.",
        "qualifications": "Good English, Smart and Presentable, customer service experience",
        "experience": "1-2 years",
        "salary_range": "UGX 1,200,000 - 1,800,000"
      },
      {
        "id": 8,
        "title": "Regional Manager M&E",
        "department": "Monitoring & Evaluation",
        "location": "Kampala",
        "type": "partner-only",
        "description": "Oversee monitoring and evaluation across regional offices, ensuring data quality.",
        "qualifications": "Degree in M&E, statistics, or social sciences",
        "experience": "3-5 years",
        "salary_range": "UGX 2,500,000 - 3,500,000"
      },
      {
        "id": 9,
        "title": "M&E Assistant",
        "department": "Monitoring & Evaluation",
        "location": "Gulu",
        "type": "partner-only",
        "description": "Support M&E processes, data collection, and reporting activities.",
        "qualifications": "Diploma in relevant field, data collection experience",
        "experience": "1-2 years",
        "salary_range": "UGX 1,200,000 - 1,800,000"
      },
      {
        "id": 10,
        "title": "Data Entry Clerk",
        "department": "Monitoring & Evaluation",
        "location": "Mbarara",
        "type": "partner-only",
        "description": "Enter and manage data with accuracy and attention to detail.",
        "qualifications": "Certificate in data entry, computer literacy",
        "experience": "0-1 years",
        "salary_range": "UGX 800,000 - 1,200,000"
      },
      {
        "id": 11,
        "title": "Data Analyst",
        "department": "Monitoring & Evaluation",
        "location": "Kampala",
        "type": "partner-only",
        "description": "Analyze program data, identify trends, and support evaluation processes.",
        "qualifications": "Degree in statistics/analytics, data analysis experience",
        "experience": "2-4 years",
        "salary_range": "UGX 2,000,000 - 2,800,000"
      },
      {
        "id": 12,
        "title": "Programs Officer",
        "department": "Programs & Operations",
        "location": "Luuka",
        "type": "partner-only",
        "description": "Support implementation of HIV and mental health programs.",
        "qualifications": "Degree in relevant field, program management experience",
        "experience": "2-4 years",
        "salary_range": "UGX 2,200,000 - 3,000,000"
      },
      {
        "id": 13,
        "title": "Project Coordinator",
        "department": "Programs & Operations",
        "location": "Mbarara",
        "type": "partner-only",
        "description": "Manage specific program projects and ensure timely delivery.",
        "qualifications": "Degree and project management certification preferred",
        "experience": "3-5 years",
        "salary_range": "UGX 2,800,000 - 3,800,000"
      },
      {
        "id": 14,
        "title": "Community Development Officers",
        "department": "Programs & Operations",
        "location": "Arua",
        "type": "partner-only",
        "description": "Engage communities in HIV and mental health awareness programs.",
        "qualifications": "Degree in community development or social work",
        "experience": "2-4 years",
        "salary_range": "UGX 2,000,000 - 2,800,000"
      },
      {
        "id": 15,
        "title": "Training & Capacity Building Officer",
        "department": "Programs & Operations",
        "location": "Kampala",
        "type": "partner-only",
        "description": "Conduct training sessions for staff and community members.",
        "qualifications": "Degree in education or relevant field, training experience",
        "experience": "2-4 years",
        "salary_range": "UGX 2,200,000 - 3,000,000"
      },
      {
        "id": 16,
        "title": "Counsellors",
        "department": "Programs & Operations",
        "location": "Gulu",
        "type": "partner-only",
        "description": "Provide mental health counseling and support services to youth.",
        "qualifications": "Degree in psychology or counseling, professional certification",
        "experience": "2-4 years",
        "salary_range": "UGX 2,500,000 - 3,500,000"
      },
      {
        "id": 17,
        "title": "Drivers",
        "department": "Programs & Operations",
        "location": "Gulu",
        "type": "open",
        "description": "Provide safe transportation services for staff and program activities.",
        "qualifications": "Valid driving license, clean record, defensive driving certificate",
        "experience": "2-3 years",
        "salary_range": "UGX 1,200,000 - 1,800,000"
      },
      {
        "id": 18,
        "title": "Public Relations Officer",
        "department": "Communications & Advocacy",
        "location": "Kampala",
        "type": "partner-only",
        "description": "Manage public image, media relations, and organizational communications.",
        "qualifications": "Degree in PR/communications, media relations experience",
        "experience": "2-4 years",
        "salary_range": "UGX 2,200,000 - 3,000,000"
      },
      {
        "id": 19,
        "title": "Digital Content Manager",
        "department": "Communications & Advocacy",
        "location": "Kampala",
        "type": "partner-only",
        "description": "Oversee website content, social media strategy, and digital marketing.",
        "qualifications": "Degree in digital media, content management experience",
        "experience": "2-4 years",
        "salary_range": "UGX 2,200,000 - 3,000,000"
      },
      {
        "id": 20,
        "title": "Social Media Assistants",
        "department": "Communications & Advocacy",
        "location": "Mbarara",
        "type": "open",
        "description": "Create engaging content and manage social media platforms.",
        "qualifications": "Diploma in digital media, social media management skills",
        "experience": "1-2 years",
        "salary_range": "UGX 1,200,000 - 1,800,000"
      },
      {
        "id": 21,
        "title": "Media & Outreach Coordinator",
        "department": "Communications & Advocacy",
        "location": "Gulu",
        "type": "partner-only",
        "description": "Coordinate with media partners and drive outreach campaigns.",
        "qualifications": "Degree in communications, media relations experience",
        "experience": "2-4 years",
        "salary_range": "UGX 2,000,000 - 2,800,000"
      },
      {
        "id": 22,
        "title": "Videographer",
        "department": "Communications & Advocacy",
        "location": "Kampala",
        "type": "partner-only",
        "description": "Capture high-quality videos for program documentation and marketing.",
        "qualifications": "Diploma in videography, portfolio required",
        "experience": "1-3 years",
        "salary_range": "UGX 1,800,000 - 2,500,000"
      },
      {
        "id": 23,
        "title": "Graphic Designers",
        "department": "Communications & Advocacy",
        "location": "Kampala",
        "type": "partner-only",
        "description": "Design graphics, publications, and marketing materials for campaigns.",
        "qualifications": "Degree in graphic design, portfolio required",
        "experience": "1-3 years",
        "salary_range": "UGX 1,800,000 - 2,500,000"
      }
    ]

    this.displayCurrentPage()
    this.updateJobCounts()
    this.populateDepartmentFilter()
    this.hideLoadingState()
  }

  displayJobs(jobs) {
    const container = document.getElementById('job-listings')
    if (!container) return

    if (jobs.length === 0) {
      container.innerHTML = `
        <div class="glass-card p-8 text-center">
          <p class="text-lg">No jobs found matching your criteria.</p>
        </div>
      `
      this.hidePagination()
      return
    }

    // Calculate pagination
    const startIndex = (this.currentPage - 1) * this.jobsPerPage
    const endIndex = startIndex + this.jobsPerPage
    const paginatedJobs = jobs.slice(startIndex, endIndex)

    // Group jobs by type
    const partnerJobs = paginatedJobs.filter(job => job.type === 'partner-only')
    const openJobs = paginatedJobs.filter(job => job.type === 'open')

    let html = ''

    // Partner-only jobs section
    if (partnerJobs.length > 0) {
      html += `
        <div class="mb-16 mt-16">
          <h3 class="text-2xl font-bold mb-8 text-center">
            🌐 Positions Open to All Candidates
          </h3>
          <div class="grid grid-1 gap-6" id="partner-jobs">
      `

      partnerJobs.forEach(job => {
        html += this.createJobCard(job)
      })

      html += `
          </div>
        </div>
      `
    }

    // Open jobs section
    if (openJobs.length > 0) {
      html += `
        <div class="mb-16">
        <div class="grid grid-1 gap-6" id="open-jobs">
      `

      openJobs.forEach(job => {
        html += this.createJobCard(job)
      })

      html += `
          </div>
        </div>
      `
    }

    // Add page info
    const totalPages = Math.ceil(jobs.length / this.jobsPerPage)
    const startJob = (this.currentPage - 1) * this.jobsPerPage + 1
    const endJob = Math.min(this.currentPage * this.jobsPerPage, jobs.length)

    html += `
      <div class="text-center mt-6 mb-4">
        <p class="text-sm text-gray-600">
          Showing ${startJob}-${endJob} of ${jobs.length} positions
        </p>
      </div>
    `

    container.innerHTML = html
    this.updatePagination(jobs)
  }

  createJobCard(job) {
    const typeColor = job.type === 'partner-only' ? 'text-primary' : 'text-secondary'
    const typeBg = job.type === 'partner-only' ? 'bg-primary-pink' : 'bg-primary-blue'

    return `
      <div class="glass-card job-card" data-job-id="${job.id}" data-type="${job.type}" data-location="${job.location}" data-department="${job.department}">
        <div class="p-6">
          <div class="flex justify-between items-start mb-4">
            <h4 class="${typeColor} font-semibold text-lg mb-2">
              ${job.title}
            </h4>
            <span class="px-3 py-1 rounded-full text-xs font-semibold ${typeBg} text-white">
              ${job.type === 'partner-only' ? 'Partner Only' : 'Open to All'}
            </span>
          </div>
          
          <div class="mb-4">
            <p class="text-sm text-gray-600 mb-2">
              <strong>Department:</strong> ${job.department}
            </p>
          </div>
          
          <p class="mb-4 text-gray-700">
            ${job.description}
          </p>
          
          <div class="border-t pt-4 mb-4">
            <p class="text-sm">
              <strong>Qualifications:</strong> ${job.qualifications}
            </p>
          </div>

          <div class="text-center">
            <a href="apply.html?position=${encodeURIComponent(job.title)}" class="btn btn-${job.type === 'partner-only' ? 'primary' : 'secondary'} btn-sm">
              Apply Now
            </a>
          </div>
        </div>
      </div>
    `
  }

  updateJobCounts() {
    if (!this.jobs) return

    const partnerCount = this.jobs.filter(job => job.type === 'partner-only').length
    const openCount = this.jobs.filter(job => job.type === 'open').length

    const partnerCountEl = document.getElementById('partner-jobs-count')
    const openCountEl = document.getElementById('open-jobs-count')
    const totalJobsEl = document.getElementById('total-jobs')

    if (partnerCountEl) partnerCountEl.textContent = partnerCount
    if (openCountEl) openCountEl.textContent = openCount
    if (totalJobsEl) totalJobsEl.textContent = this.jobs.length
  }

  populateDepartmentFilter() {
    if (!this.jobs) return

    const departments = [...new Set(this.jobs.map(job => job.department))].sort()
    const departmentFilter = document.getElementById('department-filter')

    if (departmentFilter) {
      // Clear existing options except "All Departments"
      departmentFilter.innerHTML = '<option value="all">All Departments</option>'

      departments.forEach(dept => {
        const option = document.createElement('option')
        option.value = dept
        option.textContent = dept
        departmentFilter.appendChild(option)
      })
    }
  }

  initJobFilters() {
    const jobFilter = document.getElementById('job-filter')
    const locationFilter = document.getElementById('location-filter')
    const departmentFilter = document.getElementById('department-filter')

    if (jobFilter) {
      jobFilter.addEventListener('change', () => this.filterJobs())
    }
    if (locationFilter) {
      locationFilter.addEventListener('change', () => this.filterJobs())
    }
    if (departmentFilter) {
      departmentFilter.addEventListener('change', () => this.filterJobs())
    }
  }

  filterJobs() {
    if (!this.jobs) return

    // Reset to first page when filtering
    this.currentPage = 1
    this.displayCurrentPage()
  }

  // Pagination functionality
  initPagination() {
    // Create pagination container
    const jobListings = document.getElementById('job-listings')
    if (!jobListings) return

    // Check if pagination container already exists
    let paginationContainer = document.getElementById('pagination-container')
    if (!paginationContainer) {
      const paginationHTML = `
        <div id="pagination-container" class="mt-8 flex justify-center" style="display: none;">
          <div class="glass-card p-4">
            <div id="pagination" class="flex items-center gap-2">
              <!-- Pagination buttons will be inserted here -->
            </div>
          </div>
        </div>
      `

      jobListings.insertAdjacentHTML('afterend', paginationHTML)
    }
  }

  updatePagination(jobs) {
    const totalPages = Math.ceil(jobs.length / this.jobsPerPage)
    const pagination = document.getElementById('pagination')

    console.log('Updating pagination:', {
      totalJobs: jobs.length,
      totalPages: totalPages,
      currentPage: this.currentPage,
      jobsPerPage: this.jobsPerPage,
      paginationElement: pagination
    })

    if (!pagination) {
      console.error('Pagination element not found!')
      return
    }

    // Always show pagination for debugging (remove this later)
    if (totalPages <= 1) {
      // Show test pagination
      pagination.innerHTML = `
        <button onclick="window.elpisWebsite.goToPage(1)" 
                class="px-3 py-2 rounded-lg bg-primary-pink text-white">
          Test Page 1
        </button>
        <button onclick="window.elpisWebsite.goToPage(2)" 
                class="px-3 py-2 rounded-lg bg-gray-200 text-gray-700">
          Test Page 2
        </button>
      `
      this.showPagination()
      return
    }

    let paginationHTML = ''

    // Previous button
    if (this.currentPage > 1) {
      paginationHTML += `
        <button onclick="window.elpisWebsite.goToPage(${this.currentPage - 1})" 
                class="px-3 py-2 rounded-lg bg-primary-blue text-white hover:bg-opacity-80 transition-all">
          Previous
        </button>
      `
    }

    // Page numbers
    const startPage = Math.max(1, this.currentPage - 2)
    const endPage = Math.min(totalPages, this.currentPage + 2)

    if (startPage > 1) {
      paginationHTML += `
        <button onclick="window.elpisWebsite.goToPage(1)" 
                class="px-3 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition-all">
          1
        </button>
      `
      if (startPage > 2) {
        paginationHTML += `<span class="px-2 text-gray-500">...</span>`
      }
    }

    for (let i = startPage; i <= endPage; i++) {
      const isActive = i === this.currentPage
      paginationHTML += `
        <button onclick="window.elpisWebsite.goToPage(${i})" 
                class="px-3 py-2 rounded-lg ${isActive ? 'bg-primary-pink text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'} transition-all">
          ${i}
        </button>
      `
    }

    if (endPage < totalPages) {
      if (endPage < totalPages - 1) {
        paginationHTML += `<span class="px-2 text-gray-500">...</span>`
      }
      paginationHTML += `
        <button onclick="window.elpisWebsite.goToPage(${totalPages})" 
                class="px-3 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition-all">
          ${totalPages}
        </button>
      `
    }

    // Next button
    if (this.currentPage < totalPages) {
      paginationHTML += `
        <button onclick="window.elpisWebsite.goToPage(${this.currentPage + 1})" 
                class="px-3 py-2 rounded-lg bg-primary-blue text-white hover:bg-opacity-80 transition-all">
          Next
        </button>
      `
    }

    pagination.innerHTML = paginationHTML
    this.showPagination()

    // Force show pagination for debugging
    console.log('Pagination HTML:', paginationHTML)
    console.log('Pagination container:', document.getElementById('pagination-container'))
  }

  goToPage(page) {
    console.log('Going to page:', page)
    this.currentPage = page
    this.displayCurrentPage()
  }

  displayCurrentPage() {
    if (!this.jobs) return

    const typeFilter = document.getElementById('job-filter')?.value || 'all'
    const locationFilter = document.getElementById('location-filter')?.value || 'all'
    const departmentFilter = document.getElementById('department-filter')?.value || 'all'

    let filteredJobs = this.jobs

    if (typeFilter !== 'all') {
      filteredJobs = filteredJobs.filter(job => job.type === typeFilter)
    }

    if (locationFilter !== 'all') {
      filteredJobs = filteredJobs.filter(job => job.location === locationFilter)
    }

    if (departmentFilter !== 'all') {
      filteredJobs = filteredJobs.filter(job => job.department === departmentFilter)
    }

    // Ensure current page doesn't exceed total pages
    const totalPages = Math.ceil(filteredJobs.length / this.jobsPerPage)
    if (this.currentPage > totalPages && totalPages > 0) {
      this.currentPage = totalPages
    }

    this.displayJobs(filteredJobs)
  }

  showPagination() {
    const container = document.getElementById('pagination-container')
    if (container) {
      container.style.display = 'flex'
      console.log('Showing pagination')
    }
  }

  hidePagination() {
    const container = document.getElementById('pagination-container')
    if (container) {
      container.style.display = 'none'
      console.log('Hiding pagination')
    }
  }

  hideLoadingState() {
    const loadingEl = document.getElementById('loading-jobs')
    if (loadingEl) {
      loadingEl.style.display = 'none'
    }
  }

  showJobError() {
    const container = document.getElementById('job-listings')
    if (container) {
      container.innerHTML = `
        <div class="glass-card p-8 text-center">
          <p class="text-lg text-red-600">Error loading job opportunities. Please try again later.</p>
        </div>
      `
    }
    this.hideLoadingState()
  }

  // Job Application Form functionality
  initCustomCarousels() {
    // Initialize Impact Stories Carousel (Gallery Page)
    const impactCarousel = document.getElementById('impactCarousel');
    if (impactCarousel) {
      new CustomCarousel(impactCarousel, {
        autoplay: true,
        interval: 6000
      });
    }

    // Initialize Payment Methods Carousel (Donate Page)
    const paymentCarousel = document.getElementById('paymentCarousel');
    if (paymentCarousel) {
      new CustomCarousel(paymentCarousel, {
        autoplay: false // Payment info should not auto-advance
      });
    }
  }

  initJobApplicationForm() {
    const form = document.getElementById('job-application-form')
    if (!form) return

    // Pre-populate position from URL parameter
    const urlParams = new URLSearchParams(window.location.search)
    const position = urlParams.get('position')
    const positionSelect = document.getElementById('position')

    if (position && positionSelect) {
      // Set the selected position
      const options = positionSelect.options
      for (let i = 0; i < options.length; i++) {
        if (options[i].value === position) {
          positionSelect.selectedIndex = i
          break
        }
      }
    }

    // Show/hide partner ID field based on partner status
    const partnerRadios = document.getElementsByName('partner-status')
    const partnerIdGroup = document.getElementById('partner-id-group')

    partnerRadios.forEach(radio => {
      radio.addEventListener('change', (e) => {
        if (e.target.value === 'yes') {
          partnerIdGroup.style.display = 'block'
        } else {
          partnerIdGroup.style.display = 'none'
        }
      })
    })

    // Form submission
    form.addEventListener('submit', (e) => {
      e.preventDefault()

      if (this.validateJobApplicationForm(form)) {
        this.submitJobApplication(form)
      }
    })

    // File upload validation
    const cvUpload = document.getElementById('cv-upload')
    const coverLetterUpload = document.getElementById('cover-letter-upload')

    if (cvUpload) {
      cvUpload.addEventListener('change', (e) => {
        this.validateFileUpload(e.target, 'cv-upload-error')
      })
    }

    if (coverLetterUpload) {
      coverLetterUpload.addEventListener('change', (e) => {
        this.validateFileUpload(e.target, 'cover-letter-upload-error')
      })
    }
  }

  validateJobApplicationForm(form) {
    let isValid = true
    const formData = new FormData(form)

    // Clear previous errors
    document.querySelectorAll('.error-message').forEach(el => {
      el.textContent = ''
      el.style.display = 'none'
    })

    // Validate required text fields
    const requiredFields = ['first-name', 'last-name', 'email', 'phone', 'position', 'education', 'experience', 'cover-letter']

    requiredFields.forEach(fieldId => {
      const field = document.getElementById(fieldId)
      if (field && !field.value.trim()) {
        this.showError(fieldId, 'This field is required')
        isValid = false
      }
    })

    // Validate email
    const email = document.getElementById('email')
    if (email && email.value) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
      if (!emailRegex.test(email.value)) {
        this.showError('email', 'Please enter a valid email address')
        isValid = false
      }
    }

    // Validate phone
    const phone = document.getElementById('phone')
    if (phone && phone.value) {
      const phoneRegex = /^(\+256|0)[0-9]{9}$/
      if (!phoneRegex.test(phone.value.replace(/\s/g, ''))) {
        this.showError('phone', 'Please enter a valid Ugandan phone number')
        isValid = false
      }
    }

    // Validate partner status
    const partnerStatus = document.querySelector('input[name="partner-status"]:checked')
    if (!partnerStatus) {
      this.showError('partner-status', 'Please select your partner status')
      isValid = false
    }

    // Validate CV upload
    const cvUpload = document.getElementById('cv-upload')
    if (cvUpload && !cvUpload.files.length) {
      this.showError('cv-upload', 'Please upload your CV')
      isValid = false
    }

    // Validate declaration
    const declaration = document.getElementById('declaration')
    if (declaration && !declaration.checked) {
      this.showError('declaration', 'You must accept the declaration to proceed')
      isValid = false
    }

    return isValid
  }

  validateFileUpload(input, errorId) {
    const file = input.files[0]
    const maxSize = 5 * 1024 * 1024 // 5MB
    const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']

    if (file) {
      if (file.size > maxSize) {
        this.showError(errorId, 'File size must be less than 5MB')
        input.value = ''
        return false
      }

      if (!allowedTypes.includes(file.type)) {
        this.showError(errorId, 'Only PDF, DOC, and DOCX files are allowed')
        input.value = ''
        return false
      }
    }

    return true
  }

  showError(fieldId, message) {
    const errorElement = document.getElementById(`${fieldId}-error`)
    if (errorElement) {
      errorElement.textContent = message
      errorElement.style.display = 'block'
    }
  }

  submitJobApplication(form) {
    // Show loading state
    const submitButton = form.querySelector('button[type="submit"]')
    const originalText = submitButton.textContent
    submitButton.textContent = 'Submitting...'
    submitButton.disabled = true

    // Simulate form submission (replace with actual API call)
    setTimeout(() => {
      // Show success message
      this.showSuccessModal('Application Submitted Successfully',
        'Thank you for your application! We have received your submission and will review it carefully. Only shortlisted candidates will be contacted for interviews.')

      // Reset form
      form.reset()
      document.getElementById('partner-id-group').style.display = 'none'

      // Reset button
      submitButton.textContent = originalText
      submitButton.disabled = false

      // Scroll to top
      window.scrollTo({ top: 0, behavior: 'smooth' })
    }, 2000)
  }

  showSuccessModal(title, message) {
    // Create modal
    const modal = document.createElement('div')
    modal.className = 'modal-overlay'
    modal.innerHTML = `
      <div class="modal-content">
        <h3 class="text-2xl font-bold mb-4 text-primary">${title}</h3>
        <p class="mb-6">${message}</p>
        <button class="btn btn-primary" onclick="this.closest('.modal-overlay').remove()">Close</button>
      </div>
    `

    document.body.appendChild(modal)

    // Auto-remove after 5 seconds
    setTimeout(() => {
      if (modal.parentElement) {
        modal.remove()
      }
    }, 5000)
  }
}

// Enhanced CSS animations
const style = document.createElement('style')
style.textContent = `
  /* Animations disabled */
  .loading {
    position: relative;
    overflow: hidden;
  }
  
  .success-icon {
    width: 60px;
    height: 60px;
    background: var(--success-green);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    font-weight: bold;
    margin: 0 auto;
  }
  
  .notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background: var(--white);
    border: 1px solid var(--border-gray);
    border-radius: var(--border-radius-md);
    padding: var(--space-4);
    box-shadow: var(--shadow-lg);
    z-index: 2000;
    display: flex;
    align-items: center;
    gap: var(--space-3);
    max-width: 400px;
  }
  
  .notification-success {
    border-left: 4px solid var(--success-green);
  }
  
  .notification-error {
    border-left: 4px solid var(--error-red);
  }
  
  .notification-warning {
    border-left: 4px solid var(--warning-orange);
  }
  
  .notification button {
    background: none;
    border: none;
    font-size: 1.2rem;
    cursor: pointer;
    opacity: 0.7;
  }
  
  .notification button:hover {
    opacity: 1;
  }
  
  .form-input.error,
  .form-select.error,
  .form-textarea.error {
    border-color: var(--error-red);
  }
`

document.head.appendChild(style)


// Initialize the website when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  window.elpisWebsite = new ElpisWebsite()
})

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
  module.exports = ElpisWebsite
}