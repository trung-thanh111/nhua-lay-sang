<footer id="footer">
    <div class="uk-container uk-container-center">
        <section class="top">
            <div class="uk-grid uk-grid-width-medium-1-2 uk-grid-width-medium-1-1">
                <div class="uk-panel">
                    <div class="uk-panel-title"><h3 class="heading"><span class="fc-text-uppercase uk-text-bold">Thông tin liên hệ</span></h3></div>
                    <div class="fc-panel-body">
                        <p>{{ $system['homepage_company'] ?? '' }}</p>
                        <p>Địa chỉ: {{ $system['contact_address'] ?? '' }}</p>
                        <p>Điện thoại: {{ $system['contact_phone'] ?? $system['contact_hotline'] ?? '' }}</p>
                        <p>Email: {{ $system['contact_email'] ?? '' }}</p>
                        <p>Website: {{ $system['contact_web'] ?? url('/') }}</p>
                    </div>
                </div>
                <div class="uk-panel">
                    <div class="uk-panel-title"><h3 class="heading"><span class="fc-text-uppercase uk-text-bold">Kết nối với chúng tôi</span></h3></div>
                    <div class="fc-panel-body">
                        <div class="social-link">
                            <a href="{{ $system['social_facebook'] ?? '#' }}" title="facebook" class="facebook uk-margin-right"><i class="uk-icon-facebook"></i></a>
                            <a href="{{ $system['social_twitter'] ?? '#' }}" title="twitter" class="twitter uk-margin-right"><i class="uk-icon-twitter"></i></a>
                            <a href="{{ $system['social_google'] ?? '#' }}" title="google" class="google uk-margin-right"><i class="uk-icon-google-plus"></i></a>
                            <a href="{{ $system['social_youtube'] ?? '#' }}" title="youtube" class="youtube"><i class="uk-icon-youtube-play"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="copyright">
            <p class="uk-margin-remove">&copy; Copyright {{ date('Y') }} <span class="uk-text-bold">{{ $system['homepage_company'] ?? '' }}</span></p>
        </section>
    </div>
</footer>
