<nav class="mb-2 flex flex-row space-x-4 items-center">
    <a href="/" @class(['text-lg'])>
        home
    </a>

    <a href="/blog" @class(['text-lg', request()->routeIs('blog.*') => 'font-bold'])>
        blog
    </a>
</nav>
