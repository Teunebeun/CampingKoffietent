    <script src="https://kit.fontawesome.com/8c170b6078.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.0.1/TweenMax.min.js" defer></script>
    <script src="{{ asset('/js/NavBar.js') }}" defer></script>
    <div id="header">
        <a href="{{ url('index') }}"><img src="{{ asset($infoFooter->homepage_logo) }}" id="header-image"></a>
    </div>

    <nav class="menu">
        <div class="menu-toggle-header">
            <div id="menu-toggle">
                <div id="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div id="cross">
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
        <ol>
            <li class="menu-item"><a href="{{ url('index') }}">Receptie</a></li>
            <li class="menu-item"><a href="{{ url('initiatief') }}">Initiatieven</a></li>
            <li class="menu-item"><a href="#0">Campingbazen</a></li>
            <li class="menu-item"><a href="{{ url('help-mee') }}">Help mee</a></li>
            <li class="menu-item">
                <a href="#0">Meer
                    <svg version="1.1" class="plus-icon" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 18 18">
                        <line fill="none" stroke-width="4" stroke-linecap="round" stroke-miterlimit="10" x1="10" y1="9"
                            x2="17" y2="9" />
                        <line fill="none" stroke-width="4" stroke-linecap="round" stroke-miterlimit="10" x1="9" y1="9"
                            x2="9" y2="1" />
                        <g id="lineGroup_1">
                            <line fill="none" stroke-width="4" stroke-linecap="round" stroke-miterlimit="10" x1="1"
                                y1="9" x2="8" y2="9" />
                            <line fill="none" stroke-width="4" stroke-linecap="round" stroke-miterlimit="10" x1="9"
                                y1="17" x2="9" y2="9" />
                        </g>
                    </svg>
                </a>
                <ol class="sub-menu">
                    <li class="sub-menu-item"><a href="{{url('sponsoren&partners')}}">Sponsors</a></li>
                    <li class="sub-menu-item"><a href="{{url('contact')}}">Contact</a></li>
                    <li class="sub-menu-item"><a href="{{route('donation-overview')}}">Doneren</a></li>
                    <li class="sub-menu-item"><a href="{{url('openingstijden')}}">Openingstijden</a></li>
                </ol>
            </li>
        </ol>
    </nav>

    @if(Session::has('success'))
        <div class="message message-success">
            <p>{{ Session::get('success') }}</p>
            <i class="far fa-times-circle message-exit"><a href="#"></a></i>
        </div>
    @endif
