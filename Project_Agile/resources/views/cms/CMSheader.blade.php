<div id="header">
    <div id="header-label">
        <span>Camping de Koffietent - CMS</span>
    </div>

    <div id="header-profile">
        <div id="profile-photo">
            <img src="{{ (Auth::user()->profile_picture != null) ? asset(Auth::user()->profile_picture) : asset('/img/profile_picture_placeholder.svg') }}">
        </div>

        <div id="profile-info">
            <span id="profile-role">Ingelogd als:</span>
            <span id="profile-name">{{ Auth::user()->name . ' ' . Auth::user()->middlename . ' ' . Auth::user()->lastname }}</span>
        </div>
    </div>
</div>
