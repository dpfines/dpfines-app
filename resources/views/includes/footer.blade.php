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
                    <li><a href="/index">Home</a></li>
                    <li><a href="/about">About</a></li>
                    <li><a href="/database">Fines Database</a></li>
                    <li><a href="/dashboards">Dashboards</a></li>
                    <li><a href="https://github.com/dpfines/dpfines-app" target="_blank">Join the Project</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Legal</h4>
                <ul>
                    <li><a href="/privacy">Privacy Policy</a></li>
                    <li><a href="/terms">Terms of Service</a></li>
                    <li><a href="/cookies">Cookie Policy</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Newsletter</h4>
                <p>Get weekly enforcement updates</p>

                <form id="footer-newsletter-form" action="{{ route('newsletter.subscribe') }}"
      method="POST"
      class="newsletter-form"
      id="footer-newsletter-form">
    @csrf
    <input type="email" name="email" placeholder="Your email" required>
    <button type="submit" class="btn btn-primary">Subscribe</button>
</form>

<div id="footer-success" style="display:none; color: #4ade80; margin-top:10px;">
    ✔ You are subscribed! Check your inbox.
</div>

<div id="footer-error" style="display:none; color: #f87171; margin-top:10px;">
</div>



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


    </div>

</footer>

