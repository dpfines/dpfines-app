<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <div class="footer-logo">
                    <i class="fas fa-shield-alt"></i>
                    <span>DP Fines</span>
                </div>
                <p>The most comprehensive database of global privacy and data protection enforcement actions.</p>
            </div>

            <div class="footer-col">
                <h4>Navigation</h4>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="database.php">Fines Database</a></li>
                    <li><a href="dashboards.php">Dashboards</a></li>
                    <li><a href="https://github.com/dpfines/dpfines-app" target="_blank">Join the Project</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Legal</h4>
                <ul>
                    <li><a href="privacy.php">Privacy Policy</a></li>
                    <li><a href="terms.php">Terms of Service</a></li>
                    <li><a href="cookies.php">Cookie Policy</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Newsletter</h4>
                <p>Get weekly enforcement updates</p>
                <form action="newsletter.php" method="POST" class="newsletter-form">
                    <input type="email" name="email" placeholder="Your email" required>
                    <button type="submit" class="btn btn-primary">Subscribe</button>
                </form>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-info">
                <p>&copy; <?php echo date('Y'); ?> Data Protection Fines (DP Fines). All rights reserved. A community-driven open project.</p>
                <div class="social-links">
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                    <a href="https://github.com/dpfines/" target="_blank" aria-label="GitHub"><i class="fab fa-github"></i></a>
                </div>
            </div>
        </div>

        <!-- Donation Section -->
        <div class="donation-section">
            <h4>Support This Project</h4>
            <p>Help us maintain and improve DP Fines. Your donations support server costs, data updates, and development.</p>
            <a href="https://donate.stripe.com/test_yourlink" target="_blank" rel="noopener noreferrer" class="btn btn-donate">
                <i class="fab fa-stripe"></i> Donate via Stripe
            </a>
        </div>
    </div>
</footer>

