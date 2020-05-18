<footer class="footer" id="footer">
        <div class="footer-item">
            <p class="footer-item-header">Social Media</p>
            <div class="effect buttons">
                <a href="{{$infoFooter->facebook_link}}" class="fb" title="Volg ons op Facebook!"><i class="fa fa-facebook"
                        aria-hidden="true"></i></a>
                <a href="{{$infoFooter->twitter_link}}" class="tw" title="Volg ons op Twitter!"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                <a href="{{$infoFooter->instagram_link}}" class="insta" title="Volg ons op Instagram!"><i class="fa fa-instagram"
                        aria-hidden="true"></i></a>
                <a href="mailto:{{$infoFooter->email_link}}" class="in" title="Stuur ons een mail!"><i class="fa fa-mail-forward"
                        aria-hidden="true"></i></a>
            </div>
        </div>
        <div class="footer-item">
            <p class="footer-item-header">Adres</p>
            <p>{{$infoFooter->adres_street}}</p>
            <p>{{$infoFooter->adres_place}}</p>
        </div>
        <div class="footer-item">
            <p class="footer-item-header">Overige sites</p>

            @foreach($otherLinks as $otherLink)
                <a href="{{ $otherLink->link }}" class="footer-link">{{ $otherLink->name }}</a>
                <p></p>
            @endforeach
        </div>
        <div class="footer-item">
            <div class="cms-link-box">
                <a href="{{ route('login') }}"><img src="{{ asset('/img/CMS-link-image.png') }}" class="cms-link"></a>
            </div>
        </div>
    </footer>
