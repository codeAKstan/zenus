// Mobile Menu Toggle
document.addEventListener("DOMContentLoaded", () => {
  const mobileMenuToggle = document.getElementById("mobileMenuToggle")
  const navMenu = document.getElementById("navMenu")

  if (mobileMenuToggle && navMenu) {
    mobileMenuToggle.addEventListener("click", () => {
      navMenu.classList.toggle("active")
      mobileMenuToggle.classList.toggle("active")
    })
  }

  // Smooth scrolling for anchor links
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

  // Add scroll effect to header
  window.addEventListener("scroll", () => {
    const header = document.querySelector(".header")
    if (window.scrollY > 100) {
      header.style.background = "rgba(45, 27, 105, 0.95)"
      header.style.backdropFilter = "blur(10px)"
    } else {
      header.style.background = "#2d1b69"
      header.style.backdropFilter = "none"
    }
  })

  // Intersection Observer for animations
  const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px",
  }

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = "1"
        entry.target.style.transform = "translateY(0)"
      }
    })
  }, observerOptions)

  // Observe service items for scroll animations
  document.querySelectorAll(".service-item").forEach((item) => {
    item.style.opacity = "0"
    item.style.transform = "translateY(30px)"
    item.style.transition = "opacity 0.6s ease, transform 0.6s ease"
    observer.observe(item)
  })

  // Form validation (if forms are added later)
  function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    return re.test(email)
  }

  // Add loading states to buttons
  document.querySelectorAll(".btn").forEach((button) => {
    button.addEventListener("click", function (e) {
      if (this.classList.contains("btn-primary") || this.classList.contains("btn-success")) {
        const originalText = this.textContent
        this.textContent = "Loading..."
        this.disabled = true

        // Simulate loading (remove this in production)
        setTimeout(() => {
          this.textContent = originalText
          this.disabled = false
        }, 2000)
      }
    })
  })
})

// Utility functions
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

// Resize handler
window.addEventListener(
  "resize",
  debounce(() => {
    // Handle responsive adjustments
    const navMenu = document.getElementById("navMenu")
    if (window.innerWidth > 768 && navMenu) {
      navMenu.classList.remove("active")
    }
  }, 250),
)
