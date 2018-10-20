<footer class="container is-fluid">
    <div class="columns">
        <div class="column is-12">
            <hr id="footer-hr">
            <a id="french-link" href="{{ url('/lang/fr') }}">
                <i class="flag-icon flag-icon-fr footer-icon"></i>
            </a>
            <a id="english-link" href="{{ url('/lang/en') }}">
                <i class="flag-icon flag-icon-gb footer-icon"></i>
            </a>
            <a id="dark-theme-link">
                <i class="footer-icon fas fa-moon"></i> {{__('messages.footer.dark_theme')}}
            </a>
            <a id="light-theme-link">
                <i class="footer-icon fas fa-sun"></i> {{__('messages.footer.light_theme')}}
            </a>
            <a id="github-link" href="https://www.github.com/Lenophie/MoniCAG/">
                {{__('messages.footer.github')}} <i class="fab fa-github"></i>
            </a>
        </div>
    </div>
</footer>

