// Mobile menu toggle


document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const mobileMenu = document.getElementById('mobileMenu');

    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('active');
            const icon = this.querySelector('i');
            if (mobileMenu.classList.contains('active')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
    }

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        if (mobileMenu && mobileMenuToggle) {
            if (!mobileMenu.contains(event.target) &&
                !mobileMenuToggle.contains(event.target) &&
                mobileMenu.classList.contains('active')) {
                mobileMenu.classList.remove('active');
                const icon = mobileMenuToggle.querySelector('i');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        }
    });

    // Animate bars on page load
    animateBars();
    // Initialize reveal-on-scroll animations
    initRevealOnScroll();
    // Initialize policy section toggles
    initPolicySections();
});

// Animate chart bars
function animateBars() {
    const bars = document.querySelectorAll('.bar-fill');
    bars.forEach((bar, index) => {
        const width = bar.style.width;
        bar.style.width = '0';
        setTimeout(() => {
            bar.style.width = width;
        }, index * 100);
    });
}

// Form validation for newsletter
const newsletterForm = document.querySelector('.newsletter-form');
if (newsletterForm) {
    newsletterForm.addEventListener('submit', function(e) {
        const email = this.querySelector('input[type="email"]').value;
        if (!validateEmail(email)) {
            e.preventDefault();
            alert('Please enter a valid email address');
        }
    });
}

// Email validation
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Search form enhancements
const searchForm = document.querySelector('.search-form');
if (searchForm) {
    const searchInput = searchForm.querySelector('input[name="search"]');

    // Clear button for search
    if (searchInput && searchInput.value) {
        // Add clear functionality if needed
    }
}

// Simple intersection-observer based reveal for elements with .reveal-on-scroll
function initRevealOnScroll(){
    const els = document.querySelectorAll('.reveal-on-scroll');
    if(!els || !('IntersectionObserver' in window)){
        // fallback: just reveal immediately
        els.forEach(e => e.classList.add('revealed'));
        return;
    }
    const io = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if(entry.isIntersecting){
                entry.target.classList.add('revealed');
                obs.unobserve(entry.target);
            }
        });
    }, { rootMargin: '0px 0px -10% 0px', threshold: 0.06 });
    els.forEach(el => io.observe(el));
}

// Initialize collapsible policy sections
function initPolicySections(){
    document.querySelectorAll('.policy-section-header').forEach(function(header){
        header.addEventListener('click', function(e){
            e.preventDefault();
            const section = this.closest('.policy-section');
            if(section){ section.classList.toggle('collapsed'); }
        });
    });
}

// Newsletter AJAX submit
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById('footer-newsletter-form');
    const successBox = document.getElementById('footer-success');
    const errorBox = document.getElementById('footer-error');

    if (form) {
        form.addEventListener('submit', async function (e) {
            e.preventDefault(); // Stop normal form submission

            successBox.style.display = "none";
            errorBox.style.display = "none";

            const formData = new FormData(form);

            try {
                const response = await fetch(form.action, {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    successBox.style.display = "block";
                    successBox.textContent = "✔ You are subscribed! Check your inbox.";
                    form.reset();
                } else {
                    errorBox.style.display = "block";
                    errorBox.textContent = data.message || "Something went wrong.";
                }
            } catch (error) {
                errorBox.style.display = "block";
                errorBox.textContent = "Network error, please try again.";
            }
        });
    }
});

