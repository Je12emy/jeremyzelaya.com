<head>
    @vite('resources/css/app.css')
</head>

<body class="bg-black text-white my-4">
    <article class="text-base">
        <x-post-header :title="$article->title" :publication_date="$article->publication_date" />
        {!! $content !!}
    </article>
    <aside class="max-w-max">
        <section class="flex flex-col space-y-2 ">
            <header> Other Posts </header>
            @foreach ($others as $other)
            <x-post-list :title="$other->title" :publication_date="$other->publication_date" :slug="$other->slug" />
            @endforeach
        </section>
    </aside>
</body>

<style>
    body {
        display: grid;
        grid-template-columns: 25% 1fr 25%;
        gap: 2rem;
        grid-template-areas: ". content aside";
    }

    article {
        grid-area: content;
    }

    aside {
        grid-area: aside;
    }
</style>
