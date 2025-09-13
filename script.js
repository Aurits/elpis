// Elpis Initiative Uganda - Main JavaScript File

document.addEventListener("DOMContentLoaded", () => {
  // Mobile Navigation Toggle
  const hamburger = document.querySelector(".hamburger")
  const navMenu = document.querySelector(".nav-menu")

  if (hamburger && navMenu) {
    hamburger.addEventListener("click", () => {
      navMenu.classList.toggle("active")
      hamburger.classList.toggle("active")
    })

    // Close mobile menu when clicking on a link
    document.querySelectorAll(".nav-menu a").forEach((link) => {
      link.addEventListener("click", () => {
        navMenu.classList.remove("active")
        hamburger.classList.remove("active")
      })
    })

    // Close mobile menu when clicking outside
    document.addEventListener("click", (e) => {
      if (!hamburger.contains(e.target) && !navMenu.contains(e.target)) {
        navMenu.classList.remove("active")
        hamburger.classList.remove("active")
      }
    })
  }

  // Smooth Scrolling for Anchor Links
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault()
      const target = document.querySelector(this.getAttribute("href"))
      if (target) {
        target.scrollIntoView({
          behavior: "smooth",
          block: "start",
        })
      }
    })
  })

  // Active Navigation Link Highlighting
  const currentPage = window.location.pathname.split("/").pop() || "index.html"
  document.querySelectorAll(".nav-menu a").forEach((link) => {
    if (link.getAttribute("href") === currentPage) {
      link.classList.add("active")
    }
  })

  // Donation Amount Selection
  const amountOptions = document.querySelectorAll(".amount-option")
  const customAmountInput = document.getElementById("customAmount")
  let selectedAmount = null

  amountOptions.forEach((option) => {
    option.addEventListener("click", function () {
      // Remove active class from all options
      amountOptions.forEach((opt) => opt.classList.remove("selected"))

      // Add active class to clicked option
      this.classList.add("selected")

      // Get the amount value
      selectedAmount = this.dataset.amount

      // Clear custom amount if preset amount is selected
      if (customAmountInput && selectedAmount !== "custom") {
        customAmountInput.value = ""
      }
    })
  })

  // Custom Amount Input Handler
  if (customAmountInput) {
    customAmountInput.addEventListener("input", function () {
      if (this.value) {
        // Remove selection from preset amounts
        amountOptions.forEach((opt) => opt.classList.remove("selected"))
        selectedAmount = this.value
      }
    })
  }

  // Payment Method Selection
  const paymentOptions = document.querySelectorAll(".payment-option")
  let selectedPaymentMethod = null

  paymentOptions.forEach((option) => {
    option.addEventListener("click", function () {
      // Remove active class from all options
      paymentOptions.forEach((opt) => opt.classList.remove("selected"))

      // Add active class to clicked option
      this.classList.add("selected")

      // Get the payment method
      selectedPaymentMethod = this.dataset.method
    })
  })

  // Form Validation
  function validateForm(form) {
    let isValid = true
    const requiredFields = form.querySelectorAll("[required]")

    requiredFields.forEach((field) => {
      const errorElement = field.parentNode.querySelector(".error-message")

      // Remove existing error styling
      field.classList.remove("error")
      if (errorElement) {
        errorElement.remove()
      }

      // Check if field is empty
      if (!field.value.trim()) {
        showFieldError(field, "This field is required")
        isValid = false
      } else {
        // Specific validation based on field type
        if (field.type === "email" && !isValidEmail(field.value)) {
          showFieldError(field, "Please enter a valid email address")
          isValid = false
        }

        if (field.type === "tel" && !isValidPhone(field.value)) {
          showFieldError(field, "Please enter a valid phone number")
          isValid = false
        }
      }
    })

    return isValid
  }

  function showFieldError(field, message) {
    field.classList.add("error")
    const errorElement = document.createElement("div")
    errorElement.className = "error-message"
    errorElement.textContent = message
    field.parentNode.appendChild(errorElement)
  }

  function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    return emailRegex.test(email)
  }

  function isValidPhone(phone) {
    const phoneRegex = /^[+]?[0-9\s\-$$$$]{10,}$/
    return phoneRegex.test(phone)
  }

  // Donation Form Handler
  const donationForm = document.getElementById("donationForm")
  if (donationForm) {
    donationForm.addEventListener("submit", function (e) {
      e.preventDefault()

      if (!selectedAmount) {
        alert("Please select a donation amount")
        return
      }

      if (!selectedPaymentMethod) {
        alert("Please select a payment method")
        return
      }

      if (validateForm(this)) {
        // Simulate donation processing
        const submitBtn = this.querySelector('button[type="submit"]')
        const originalText = submitBtn.textContent

        submitBtn.textContent = "Processing..."
        submitBtn.disabled = true

        setTimeout(() => {
          alert(
            `Thank you for your donation of UGX ${selectedAmount}! You are now an Elpis Partner. You will receive a confirmation shortly.`,
          )
          this.reset()
          amountOptions.forEach((opt) => opt.classList.remove("selected"))
          paymentOptions.forEach((opt) => opt.classList.remove("selected"))
          selectedAmount = null
          selectedPaymentMethod = null
          submitBtn.textContent = originalText
          submitBtn.disabled = false
        }, 2000)
      }
    })
  }

  // Assist Me Form Handler
  const assistForm = document.getElementById("assistForm")
  if (assistForm) {
    assistForm.addEventListener("submit", function (e) {
      e.preventDefault()

      if (validateForm(this)) {
        const submitBtn = this.querySelector('button[type="submit"]')
        const originalText = submitBtn.textContent

        submitBtn.textContent = "Submitting..."
        submitBtn.disabled = true

        setTimeout(() => {
          alert(
            "Your request has been submitted successfully! Our team will review your request and contact you within 48 hours.",
          )
          this.reset()
          submitBtn.textContent = originalText
          submitBtn.disabled = false
        }, 1500)
      }
    })
  }

  // Gallery Functionality
  const galleryFilters = document.querySelectorAll(".filter-btn")
  const galleryItems = document.querySelectorAll(".gallery-item")
  const modal = document.querySelector(".modal")
  const modalImg = document.querySelector(".modal-content img")
  const modalClose = document.querySelector(".modal-close")

  // Gallery Filter Functionality
  galleryFilters.forEach((filter) => {
    filter.addEventListener("click", function () {
      // Remove active class from all filters
      galleryFilters.forEach((f) => f.classList.remove("active"))

      // Add active class to clicked filter
      this.classList.add("active")

      const filterValue = this.dataset.filter

      // Show/hide gallery items based on filter
      galleryItems.forEach((item) => {
        if (filterValue === "all" || item.dataset.category === filterValue) {
          item.style.display = "block"
          item.classList.add("fade-in")
        } else {
          item.style.display = "none"
          item.classList.remove("fade-in")
        }
      })
    })
  })

  // Gallery Modal Functionality
  galleryItems.forEach((item) => {
    item.addEventListener("click", function () {
      const imgSrc = this.querySelector("img").src
      const imgAlt = this.querySelector("img").alt

      if (modal && modalImg) {
        modalImg.src = imgSrc
        modalImg.alt = imgAlt
        modal.classList.add("active")
        document.body.style.overflow = "hidden"
      }
    })
  })

  // Close Modal
  if (modalClose) {
    modalClose.addEventListener("click", closeModal)
  }

  if (modal) {
    modal.addEventListener("click", (e) => {
      if (e.target === modal) {
        closeModal()
      }
    })
  }

  // Close modal with Escape key
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && modal && modal.classList.contains("active")) {
      closeModal()
    }
  })

  function closeModal() {
    if (modal) {
      modal.classList.remove("active")
      document.body.style.overflow = "auto"
    }
  }

  // Partner ID Validation (Simulate)
  const partnerIdInput = document.getElementById("partnerNumber")
  if (partnerIdInput) {
    partnerIdInput.addEventListener("blur", function () {
      const partnerId = this.value.trim()
      if (partnerId) {
        // Simulate partner ID validation
        const isValid = /^EP\d{6}$/.test(partnerId) // Format: EP123456

        const existingMessage = this.parentNode.querySelector(".partner-status")
        if (existingMessage) {
          existingMessage.remove()
        }

        const statusMessage = document.createElement("div")
        statusMessage.className = "partner-status"
        statusMessage.style.fontSize = "0.875rem"
        statusMessage.style.marginTop = "0.25rem"

        if (isValid) {
          statusMessage.style.color = "#28a745"
          statusMessage.textContent = "✓ Valid Elpis Partner ID"
        } else {
          statusMessage.style.color = "#dc3545"
          statusMessage.textContent = "✗ Invalid Partner ID format (should be EP followed by 6 digits)"
        }

        this.parentNode.appendChild(statusMessage)
      }
    })
  }

  // Scroll to Top Functionality
  const scrollToTopBtn = document.createElement("button")
  scrollToTopBtn.innerHTML = "↑"
  scrollToTopBtn.className = "scroll-to-top"
  scrollToTopBtn.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: var(--primary-pink);
        color: white;
        border: none;
        font-size: 20px;
        cursor: pointer;
        display: none;
        z-index: 1000;
        transition: all 0.3s ease;
    `

  document.body.appendChild(scrollToTopBtn)

  // Show/hide scroll to top button
  window.addEventListener("scroll", () => {
    if (window.pageYOffset > 300) {
      scrollToTopBtn.style.display = "block"
    } else {
      scrollToTopBtn.style.display = "none"
    }
  })

  // Scroll to top when button is clicked
  scrollToTopBtn.addEventListener("click", () => {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    })
  })

  // Animation on Scroll
  const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px",
  }

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("fade-in")
      }
    })
  }, observerOptions)

  // Observe elements for animation
  document.querySelectorAll(".card, .stat-item, .job-item").forEach((el) => {
    observer.observe(el)
  })

  // Contact Form Handler (if exists)
  const contactForm = document.getElementById("contactForm")
  if (contactForm) {
    contactForm.addEventListener("submit", function (e) {
      e.preventDefault()

      if (validateForm(this)) {
        const submitBtn = this.querySelector('button[type="submit"]')
        const originalText = submitBtn.textContent

        submitBtn.textContent = "Sending..."
        submitBtn.disabled = true

        setTimeout(() => {
          alert("Thank you for your message! We will get back to you within 24 hours.")
          this.reset()
          submitBtn.textContent = originalText
          submitBtn.disabled = false
        }, 1500)
      }
    })
  }

  // Initialize tooltips (if needed)
  const tooltips = document.querySelectorAll("[data-tooltip]")
  tooltips.forEach((tooltip) => {
    tooltip.addEventListener("mouseenter", function () {
      const tooltipText = this.getAttribute("data-tooltip")
      const tooltipElement = document.createElement("div")
      tooltipElement.className = "tooltip"
      tooltipElement.textContent = tooltipText
      tooltipElement.style.cssText = `
                position: absolute;
                background: rgba(0, 0, 0, 0.8);
                color: white;
                padding: 5px 10px;
                border-radius: 4px;
                font-size: 12px;
                white-space: nowrap;
                z-index: 1000;
                pointer-events: none;
            `

      document.body.appendChild(tooltipElement)

      const rect = this.getBoundingClientRect()
      tooltipElement.style.left = rect.left + rect.width / 2 - tooltipElement.offsetWidth / 2 + "px"
      tooltipElement.style.top = rect.top - tooltipElement.offsetHeight - 5 + "px"
    })

    tooltip.addEventListener("mouseleave", () => {
      const tooltipElement = document.querySelector(".tooltip")
      if (tooltipElement) {
        tooltipElement.remove()
      }
    })
  })

  console.log("Elpis Initiative Uganda website initialized successfully!")
})

// Utility Functions
function formatCurrency(amount) {
  return new Intl.NumberFormat("en-UG", {
    style: "currency",
    currency: "UGX",
    minimumFractionDigits: 0,
  }).format(amount)
}

function debounce(func, wait) {
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

// Export functions for potential use in other scripts
window.ElpisUtils = {
  formatCurrency,
  debounce,
}
