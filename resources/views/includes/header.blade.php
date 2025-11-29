<header class="site-header">
    <div class="container">
        <div class="header-content">
            <div class="logo">
                <a href="{{ url('/') }}" aria-label="DP Fines home">
                    <img src="{{ asset('images/dpfines_logo.png') }}" alt="DP Fines logo" class="site-logo"/>
                    <span class="logo-text">DP Fines</span>
                </a>
            </div>

            <nav class="main-nav">
                <a href="/">Home</a>
                <a href="/about">About</a>
                <a href="https://github.com/dpfines" target="_blank" rel="noopener noreferrer">Join the Project</a>
            </nav>



            <button class="mobile-menu-toggle" id="mobileMenuToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="/index">Home</a>
        <a href="/about">About</a>
        <a href="https://github.com/dpfines" target="_blank" rel="noopener noreferrer">Join the Project</a>

    </div>
</header>
