<div id="sidenav">
    <div class="logo-container">
        <a href="{{ route('cms-home') }}">
            <img src="{{ asset('/img/CampingKoffietentImage.jpg') }}" alt="CampingKoffietentLogo" id="logo">
        </a>
    </div>

    <div id="menu">
        <div class="menu-item">
            <a href="{{  route('cms-home')  }}">
                <div class="icon-container">
                    <i class="gg-home"></i>
                </div>
                <span>Dashboard</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="{{ route('cms-schedule-home') }}">
                <div class="icon-container">
                    <i class="gg-calendar-dates"></i>
                </div>
                <span>Rooster</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="{{  route('activities')  }}">
                <div class="icon-container">
                    <i class="gg-coffee"></i>
                </div>
                <span>Initiatieven</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="{{ route('cms-vacancy') }}">
                <div class="icon-container">
                    <i class="gg-file-document"></i>
                </div>
                <span>Vacatures</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="#">
                <div class="icon-container">
                    <i class="gg-girl"></i>
                </div>
                <span>Campingbazen</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="{{ route('cms-sponsor') }}">
                <div class="icon-container">
                    <i class="gg-briefcase"></i>
                </div>
                <span>Sponsoren</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="{{ route('donations.index') }}">
                <div class="icon-container">
                    <i class="gg-gift"></i>
                </div>
                <span>Donaties</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="{{route('inbox.index')}}">
                <div class="icon-container">
                    <i class="gg-mail"></i>
                </div>
                <span>Inbox</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="{{ route('accountbeheer') }}">
                <div class="icon-container">
                    <i class="gg-profile"></i>
                </div>
                <span>Accounts</span>
            </a>
        </div>

        <div class="menu-item">
            <a href="{{ route('cms-content') }}">
                <div class="icon-container">
                    <i class="gg-readme"></i>
                </div>
                <span>Content</span>
            </a>
        </div>
    </div>

    <div id="logout-container">
        <div class="menu-item">
            <a href="{{ route('logout') }}">
                <div class="icon-container">
                    <i class="gg-log-out"></i>
                </div>
                <span>Uitloggen</span>
            </a>
        </div>
    </div>
</div>
