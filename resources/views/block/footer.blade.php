<footer>
    <div class="container">
        <div class="row">
            <p class="footer-row text-center">@2015-{{ get_year() }} <a href="{{ route('link') }}?target={{ urlencode(config('seo.github_url')) }}" target="_blank">Mark</a> 版权所有</p>
            <p class="footer-row text-center">{{ config('seo.beian') }}</p>
        </div>
    </div>
</footer>