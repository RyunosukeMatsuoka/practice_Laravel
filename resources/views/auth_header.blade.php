<nav class="navbar navbar-light">
    <div class="container">
        <a class="navbar-brand" href="/">conduit</a>
        <ul class="nav navbar-nav pull-xs-right">
        <li class="nav-item">
            <a class="nav-link" id="home-link" href="/">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="create-link" href="/create">
            <i class="ion-compose"></i>&nbsp;New Article
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-link" href="/profile/{{ Auth::user()->id }}">
            <img src="" class="user-pic" />
            {{ Auth::user()->name }}
            </a>
        </li>
        <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <!-- <a type="submit" class="nav-link" id="signOut-link">Sign out</a> -->
                <p class="nav-link" id="signOut-link">
                    <input type="submit" value="Sign out" />
                </p>
            </form>
        </li>
        </ul>
    </div>
</nav>
