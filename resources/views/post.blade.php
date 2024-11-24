<head>
    @vite('resources/css/app.css')
</head>

<body class="bg-black text-white my-4">
    <article class="text-base">
        <header class="flex flex-col space-y-2">
            <h1 class="text-2xl font-extrabold"> {{$article->title}} </h1>
            <hr>

            @php
            use Carbon\Carbon;
            $date = Carbon::parse($article->publication_date)->toFormattedDateString();
            @endphp
            <time datetime="{{$article->publication_date}}" class="text-md font-light"> {{$date}} </time>
        </header>
        {!! $content !!}
    </article>
    <aside class="max-w-max">
        <section class="flex flex-col space-y-2 ">
            <header> Other Posts </header>
            <hr>
            @foreach ($others as $other)
            <a href="{{$other->slug}}">
                <article class="flex flex-row space-x-2">
                    <time datetime="{{$other->publication_date}}" class="text-md font-light">
                        {{$other->publication_date}}
                    </time>
                    <header> {{$other->title}} </header>
                </article>
            </a>
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

    .heading-permalink {
        /* Hide the symbol */
        display: none;
    }

</style>
