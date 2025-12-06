<aside class="sidebar">
    <div class="brand">
        <img src="{{ asset('images/dpfines_logo.png') }}" alt="logo" style="width:36px;height:36px;border-radius:6px">
        <h3>DPFines Admin</h3>
    </div>

    <div class="small-muted">Signed in as</div>
    <div class="signed-in">{{ Auth::user()?->name }}</div>

    <nav>
        <a href="{{ route('admin.dashboard') }}"
            class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i
                class="fa-solid fa-house"></i> Dashboard</a>
        <a href="{{ route('admin.fines.index') }}"
            class="nav-link {{ request()->routeIs('admin.fines.*') ? 'active' : '' }}"><i class="fa-solid fa-gavel"></i>
            Global Fines</a>
        <a href="{{ route('admin.scraped-fines.index') }}"
            class="nav-link {{ request()->routeIs('admin.scraped-fines.*') ? 'active' : '' }}"><i
                class="fa-solid fa-file-import"></i> Scraped Fines</a>
        <a href="{{ route('admin.fines.create') }}" class="nav-link"><i class="fa-solid fa-plus"></i> New Fine</a>
        <a href="{{ route('admin.scraped-fines.index') }}?status=pending" class="nav-link"><i
                class="fa-solid fa-hourglass-half"></i> Pending Reviews</a>
    </nav>

    <div style="margin-top:1rem;border-top:1px solid rgba(255,255,255,0.04);padding-top:1rem">
        <form action="{{ route('admin.logout') }}" method="POST" style="width:100%">@csrf
            <button type="submit" class="nav-link" style="width:100%;justify-content:flex-start"><i
                    class="fa-solid fa-right-from-bracket"></i> Sign Out</button>
        </form>
    </div>
</aside>