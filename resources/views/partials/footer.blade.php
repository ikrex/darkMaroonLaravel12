<footer class="stanford-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h4>Balázs Bettina</h4>
                <p>© {{ date('Y') }} Minden jog fenntartva.</p>
            </div>
            <div class="col-md-4">
                <h4>{{ Session::get('locale') == 'en' ? 'Quick Links' : 'Gyors linkek' }}</h4>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}">{{ Session::get('locale') == 'en' ? 'Home' : 'Kezdőlap' }}</a></li>
                    <li><a href="/about">{{ Session::get('locale') == 'en' ? 'About' : 'Rólunk' }}</a></li>
                    <li><a href="{{ route('registration') }}">{{ Session::get('locale') == 'en' ? 'Registration' : 'Regisztráció' }}</a></li>
                    <li><a href="/contact">{{ Session::get('locale') == 'en' ? 'Contact' : 'Kapcsolat' }}</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h4>{{ Session::get('locale') == 'en' ? 'Contact' : 'Kapcsolat' }}</h4>
                @if(isset($contactInfo))
                    <p>
                        @if(Session::get('locale') == 'en' && $contactInfo->address_en)
                            <strong>{{ Session::get('locale') == 'en' ? 'Address:' : 'Cím:' }}</strong> {{ $contactInfo->address_en }}<br>
                        @elseif($contactInfo->address_hu)
                            <strong>{{ Session::get('locale') == 'en' ? 'Address:' : 'Cím:' }}</strong> {{ $contactInfo->address_hu }}<br>
                        @endif

                        @if($contactInfo->phone)
                            <strong>{{ Session::get('locale') == 'en' ? 'Phone:' : 'Telefon:' }}</strong> {{ $contactInfo->phone }}<br>
                        @endif

                        @if($contactInfo->email)
                            <strong>{{ Session::get('locale') == 'en' ? 'Email:' : 'Email:' }}</strong> {{ $contactInfo->email }}
                        @endif
                    </p>

                    @if($contactInfo->facebook || $contactInfo->instagram || $contactInfo->linkedin)
                        <div class="social-icons mt-3">
                            @if($contactInfo->facebook)
                                <a href="{{ $contactInfo->facebook }}" target="_blank" class="me-2"><i class="bi bi-facebook"></i></a>
                            @endif

                            @if($contactInfo->instagram)
                                <a href="{{ $contactInfo->instagram }}" target="_blank" class="me-2"><i class="bi bi-instagram"></i></a>
                            @endif

                            @if($contactInfo->linkedin)
                                <a href="{{ $contactInfo->linkedin }}" target="_blank"><i class="bi bi-linkedin"></i></a>
                            @endif
                        </div>
                    @endif
                @else
                    <p>
                        <strong>{{ Session::get('locale') == 'en' ? 'Address:' : 'Cím:' }}</strong> 1234 Budapest, {{ Session::get('locale') == 'en' ? 'Example Street 1.' : 'Példa utca 1.' }}<br>
                        <strong>{{ Session::get('locale') == 'en' ? 'Phone:' : 'Telefon:' }}</strong> +36 1 234 5678<br>
                        <strong>{{ Session::get('locale') == 'en' ? 'Email:' : 'Email:' }}</strong> info@example.com
                    </p>
                @endif
            </div>
        </div>
    </div>
</footer>
