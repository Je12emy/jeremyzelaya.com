<head>
    @vite('resources/css/app.css')
</head>

<body class="bg-black text-white">
    <article>
        <header>
            <h1 class="text-2xl font-extrabold"> {{$article->title}} </h1>
            <hr>
            <span class="text-md font-light"> {{$article->publication_date}} </span>
        </header>
        {!! $content !!}
    </article>
</body>

<style>
    body {
        display: grid;
        grid-template-columns: 25% 1fr 25%;
        gap: 2rem;
        grid-template-areas: ". content .";
    }

    article {
        grid-area: content;
    }
</style>
