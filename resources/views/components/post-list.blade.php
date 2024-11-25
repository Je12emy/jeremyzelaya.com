@props(['title', 'publication_date', 'slug'])

<a href="{{$slug}}">
    <article class="flex flex-row space-x-2">
        <time datetime="{{$publication_date}}" class="text-md font-light">
            {{$publication_date}}
        </time>
        <header> {{$title}} </header>
    </article>
</a>
