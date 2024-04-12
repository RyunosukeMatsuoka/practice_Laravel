<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8" />
    <title>@yield('title')Conduit</title>
    <!-- Import Ionicon icons & Google Fonts our Bootstrap theme relies on -->
    <link
        href="//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"
        rel="stylesheet"
        type="text/css"
    />
    <link
        href="//fonts.googleapis.com/css?family=Titillium+Web:700|Source+Serif+Pro:400,700|Merriweather+Sans:400,700|Source+Sans+Pro:400,300,600,700,300italic,400italic,600italic,700italic"
        rel="stylesheet"
        type="text/css"
    />
    <!-- Import the custom Bootstrap 4 theme from our hosted CDN -->
    <link rel="stylesheet" href="//demo.productionready.io/main.css" />
</head>
<body>
    <header>
        @include('auth_header')
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        @include('footer')
    </footer>

    <script>
        const homeLink = document.getElementById('home-link');
        const createLink = document.getElementById('create-link');
        const profileLink = document.getElementById('profile-link');

        const currentUrl = window.location.pathname;

        // 現在のURLに応じてactiveクラスを付与する
        if (currentUrl === '/') {
            homeLink.classList.add('active');
            createLink.classList.remove('active');
            profileLink.classList.remove('active');
        } else if (currentUrl.startsWith('/myArticles')) {
            homeLink.classList.add('active');
            createLink.classList.remove('active');
            profileLink.classList.remove('active');
        } else if (currentUrl.startsWith('/tag')) {
            homeLink.classList.add('active');
            createLink.classList.remove('active');
            profileLink.classList.remove('active');
        } else if (currentUrl === '/create') {
            homeLink.classList.remove('active');
            createLink.classList.add('active');
            profileLink.classList.remove('active');
        } else if (currentUrl === '/settings') {
            homeLink.classList.remove('active');
            createLink.classList.remove('active');
            profileLink.classList.remove('active');
        } else if (currentUrl.startsWith('/profile/')) {
            homeLink.classList.remove('active');
            createLink.classList.remove('active');
            profileLink.classList.add('active');
        }
    </script>
</body>
</html>
