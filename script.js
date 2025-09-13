// Elpis Initiative Uganda - Enhanced JavaScript Functionality

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
    this.initAnimations()
    this.initAccessibility()
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

  // Animations
  initAnimations() {
    this.initScrollAnimations()
    this.initCounterAnimations()
  }

  initScrollAnimations() {
    const animatedElements = document.querySelectorAll('.card, .stat-card, .program-card, .glass-card')
    
    if ('IntersectionObserver' in window) {
      const animationObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.style.opacity = '1'
            entry.target.style.transform = 'translateY(0)'
            entry.target.style.transition = 'all 0.6s ease-out'
            animationObserver.unobserve(entry.target)
          }
        })
      }, { 
        threshold: 0.2,
        rootMargin: '50px 0px -50px 0px'
      })

      animatedElements.forEach(el => {
        el.style.opacity = '0'
        el.style.transform = 'translateY(30px)'
        el.style.transition = 'all 0.6s ease-out'
        animationObserver.observe(el)
      })
    } else {
      // Fallback for browsers without IntersectionObserver
      animatedElements.forEach(el => {
        el.style.opacity = '1'
        el.style.transform = 'translateY(0)'
      })
    }
  }
  }

  initCounterAnimations() {
    const counters = document.querySelectorAll('.stat-number')
    
    if ('IntersectionObserver' in window) {
      const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            this.animateCounter(entry.target)
            counterObserver.unobserve(entry.target)
          }
        })
      }, { 
        threshold: 0.3,
        rootMargin: '0px 0px -100px 0px'
      })

      counters.forEach(counter => counterObserver.observe(counter))
    }
  }

  animateCounter(element) {
    const target = parseInt(element.textContent.replace(/[^\d]/g, ''))
    const duration = 2000
    const step = target / (duration / 16)
    let current = 0

    const timer = setInterval(() => {
      current += step
      if (current >= target) {
        current = target
        clearInterval(timer)
      }
      
      element.textContent = element.textContent.replace(/\d+/, Math.floor(current).toLocaleString())
    }, 16)
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
}

// Enhanced CSS animations
const style = document.createElement('style')
style.textContent = `
  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }
  
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  .loading {
    position: relative;
    overflow: hidden;
  }
  
  .loading::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    animation: loading 1.5s infinite;
  }
  
  @keyframes loading {
    0% { left: -100%; }
    100% { left: 100%; }
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
  window.elpis = new ElpisWebsite()
})

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
  module.exports = ElpisWebsite
}