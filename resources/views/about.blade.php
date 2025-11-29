@extends('layout')

@section('content')

<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- ABOUT HEADER -->



<section class="hero">
    <div class="container">
    <div class="hero-content reveal-on-scroll">
            <h1>Our Mission</h1>
            <p>                DP Fines is a comprehensive, open-source platform tracking global data privacy and protection enforcement actions. We're building the world's most accessible database of regulatory fines and compliance actions to promote transparency and awareness in data protection.
</p>
        </div>
    </div>
</section>


<!-- WHAT WE DO -->
<section class="about-section bg-light">
    <div class="container">
        <h2>What We Do</h2>
        <div class="features-grid">

            <div class="feature-box reveal-on-scroll">
                <div class="feature-icon"><i class="fas fa-search"></i></div>
                <h3>Track Enforcement Actions</h3>
                <p>Monitor and catalog fines issued by data protection authorities worldwide</p>
            </div>

            <div class="feature-box reveal-on-scroll">
                <div class="feature-icon"><i class="fas fa-chart-bar"></i></div>
                <h3>Provide Analytics</h3>
                <p>Offer insights into enforcement trends, regulatory patterns, and sector-specific compliance issues</p>
            </div>

            <div class="feature-box reveal-on-scroll">
                <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                <h3>Empower Compliance Professionals</h3>
                <p>Give organizations and legal teams the tools to stay informed about global privacy regulations</p>
            </div>

        </div>
    </div>
</section>

<!-- DATABASE FEATURES -->
<section class="about-section">
    <div class="container">
        <h2>Our Database Features</h2>

        <div class="features-list">

            <div class="feature-item reveal-on-scroll">
                <i class="fas fa-check-circle"></i>
                <div>
                    <h3>12,500+ Enforcement Actions</h3>
                    <p>Comprehensive coverage of fines and actions growing daily</p>
                </div>
            </div>

            <div class="feature-item reveal-on-scroll">
                <i class="fas fa-globe"></i>
                <div>
                    <h3>Global Coverage</h3>
                    <p>Regulators from multiple jurisdictions across all continents</p>
                </div>
            </div>

            <div class="feature-item reveal-on-scroll">
                <i class="fas fa-book"></i>
                <div>
                    <h3>Detailed Case Summaries</h3>
                    <p>Legal basis, fines, and outcomes for each enforcement action</p>
                </div>
            </div>

            <div class="feature-item reveal-on-scroll">
                <i class="fas fa-filter"></i>
                <div>
                    <h3>Advanced Filtering</h3>
                    <p>Search by organization, sector, regulation, and violation type</p>
                </div>
            </div>

            <div class="feature-item reveal-on-scroll">
                <i class="fas fa-sync-alt"></i>
                <div>
                    <h3>Regular Updates</h3>
                    <p>New enforcement actions added continuously to keep you current</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- WHY WE BUILT THIS -->
<section class="about-section bg-light">
    <div class="container">
        <h2>Why We Built This</h2>

        <p class="lead-text">
            In an increasingly regulated digital world, understanding data protection enforcement is crucial for:
        </p>

        <div class="reasons-grid">

            <div class="reason-card reveal-on-scroll">
                <i class="fas fa-briefcase"></i>
                <h3>Compliance Teams</h3>
                <p>Staying ahead of regulatory requirements and industry trends</p>
            </div>

            <div class="reason-card reveal-on-scroll">
                <i class="fas fa-gavel"></i>
                <h3>Legal Professionals</h3>
                <p>Researching precedent cases and enforcement patterns</p>
            </div>

            <div class="reason-card reveal-on-scroll">
                <i class="fas fa-building"></i>
                <h3>Organizations</h3>
                <p>Benchmarking their compliance programs against peers</p>
            </div>

            <div class="reason-card reveal-on-scroll">
                <i class="fas fa-microscope"></i>
                <h3>Researchers</h3>
                <p>Studying global privacy trends and regulatory evolution</p>
            </div>

            <div class="reason-card reveal-on-scroll">
                <i class="fas fa-users"></i>
                <h3>The Public</h3>
                <p>Understanding their data protection rights and enforcement</p>
            </div>

        </div>
    </div>
</section>

<!-- OPEN SOURCE SECTION -->
<section class="about-section">
    <div class="container">
        <h2>Open Source & Community-Driven</h2>

        <p class="lead-text">
            DP Fines is built as an open-source project because we believe:
        </p>

        <div class="principles-grid">

            <div class="principle-item reveal-on-scroll">
                <h3>Transparency</h3>
                <p>Transparency in data protection should be met with transparency in enforcement tracking</p>
            </div>

            <div class="principle-item reveal-on-scroll">
                <h3>Community</h3>
                <p>Community contributions make our database more comprehensive and accurate</p>
            </div>

            <div class="principle-item reveal-on-scroll">
                <h3>Accessibility</h3>
                <p>Compliance information should not be limited to large corporations</p>
            </div>

        </div>

        <div class="cta-box">
            <p>
                <strong>Contribute on GitHub:</strong>
                <a href="https://github.com/dpfines/dpfines-app" target="_blank">
                    github.com/dpfines/dpfines-app
                </a>
            </p>
        </div>

    </div>
</section>

<!-- OUR TEAM -->
<section class="about-section bg-light">
    <div class="container">
        <h2>Our Team</h2>

        <p class="lead-text">
            DP Fines is developed and maintained by a dedicated team of privacy enthusiasts, developers, and legal researchers committed to making data protection enforcement information accessible to all.
        </p>

        <div class="team-grid">

            <div class="team-card reveal-on-scroll">
                <div class="team-image">
                    <img src="https://media.licdn.com/dms/image/v2/D4D03AQEVNoH-1IM1nA/profile-displayphoto-crop_800_800/B4DZmc2TY5JgAI-/0/1759273106365?e=1766016000&v=beta&t=MOSkMDiN0MqiFJKWIMmLtKpndhQjLBo8MGwzTPIjBi0" alt="Abdulmajeed Raji">
                </div>
                <h3>Abdulmajeed Raji</h3>
                <p class="role">Founding Member</p>
                <div class="team-links">
                    <a href="https://www.linkedin.com/in/abdulmajeed-raji/" target="_blank"><i class="fab fa-linkedin"></i> LinkedIn</a>
                </div>
            </div>

            <div class="team-card reveal-on-scroll">
                <div class="team-image">
                    <img src="https://media.licdn.com/dms/image/v2/D4E03AQFNIjpKAoPAFA/profile-displayphoto-shrink_800_800/profile-displayphoto-shrink_800_800/0/1698686899979?e=1766016000&v=beta&t=BWAeYTpLAjn_URQkJlRnktgZPUurADcQAMI51Wi78eE" alt="Zainab Oladiti">
                </div>
                <h3>Zainab Oladiti</h3>
                <p class="role">Founding Member</p>
                <div class="team-links">
                    <a href="https://www.linkedin.com/in/zainab-oladiti" target="_blank"><i class="fab fa-linkedin"></i> LinkedIn</a>
                </div>
            </div>

        </div>

        <div class="contributors-box">
            <h3>And Many More Contributors</h3>
            <p>
                We're grateful to all contributors to our project.
                <a href="https://github.com/dpfines/dpfines-app" target="_blank">
                    See all contributors on GitHub <i class="fas fa-external-link-alt"></i>
                </a>
            </p>
        </div>
    </div>
</section>

<!-- ACKNOWLEDGMENTS -->
<section class="about-section">
    <div class="container">
        <h2>Acknowledgments</h2>

        <p class="lead-text">We extend our gratitude to:</p>

        <div class="acknowledgments-list">

            <div class="ack-item reveal-on-scroll">
                <i class="fas fa-heart"></i>
                <div>
                    <h3>Global Community</h3>
                    <p>Contributors who help maintain and expand our database</p>
                </div>
            </div>

            <div class="ack-item reveal-on-scroll">
                <i class="fas fa-institutions"></i>
                <div>
                    <h3>Regulatory Authorities</h3>
                    <p>Worldwide who publish enforcement actions and make enforcement transparent</p>
                </div>
            </div>

            <div class="ack-item reveal-on-scroll">
                <i class="fas fa-tools"></i>
                <div>
                    <h3>Open Source Community</h3>
                    <p>For the tools and frameworks that power our platform</p>
                </div>
            </div>

            <div class="ack-item reveal-on-scroll">
                <i class="fas fa-lightbulb"></i>
                <div>
                    <h3>Privacy Advocates</h3>
                    <p>And legal professionals who provide valuable insights and feedback</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- TECHNOLOGY STACK -->
<section class="about-section bg-light">
    <div class="container">
        <h2>Technology Stack</h2>

        <p class="lead-text">Built with modern web technologies:</p>

        <div class="tech-grid">

            <div class="tech-card reveal-on-scroll">
                <i class="fas fa-server"></i>
                <h3>Laravel PHP</h3>
                <p>Robust backend framework for scalable applications</p>
            </div>

            <div class="tech-card reveal-on-scroll">
                <i class="fas fa-lock"></i>
                <h3>Security</h3>
                <p>Secure authentication and data protection standards</p>
            </div>

            <div class="tech-card reveal-on-scroll">
                <i class="fas fa-database"></i>
                <h3>Data Collection</h3>
                <p>Manual entry and scraper workflows for accuracy</p>
            </div>

            <div class="tech-card reveal-on-scroll">
                <i class="fas fa-users-cog"></i>
                <h3>Admin Panel</h3>
                <p>Comprehensive tools for data management and curation</p>
            </div>

        </div>
    </div>
</section>

<!-- CONTACT -->
<section class="about-section">
        <div class="contact-box reveal-on-scroll">
            <div class="contact-item reveal-on-scroll">

        <p class="lead-text">
            Have questions, suggestions, or want to contribute? We'd love to hear from you.
        </p>

        <div class="contact-box">

            <div class="contact-item reveal-on-scroll">
                <i class="fas fa-envelope"></i>
                <div>
                    <h3>Email</h3>
                    <a href="mailto:info@dpfines.com">info@dpfines.com</a>
                </div>
            </div>

            <div class="contact-item">
                <i class="fas fa-code-branch"></i>
                <div>
                    <h3>GitHub</h3>
                    <a href="https://github.com/dpfines/dpfines-app" target="_blank">
                        github.com/dpfines/dpfines-app
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- FINAL CTA -->
<section class="hero">
    <div class="container">
        <h2>Join Our Mission</h2>
        <p>
            This is more than just a database—it's a community effort to make data protection enforcement transparent and accessible to everyone. Whether you're a developer, legal professional, or privacy advocate, there are many ways to contribute.
        </p>

        <div class="cta-buttons reveal-on-scroll">
            <a href="/database" class="btn btn-primary btn-large">
                <i class="fas fa-database"></i> Explore Database
            </a>

            <a href="https://github.com/dpfines/dpfines-app" target="_blank" class="btn btn-secondary btn-large">
                <i class="fas fa-code-branch"></i> Learn How to Contribute
            </a>
        </div>
    </div>
</section>

@endsection
