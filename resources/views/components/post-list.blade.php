@props(['title', 'publication_date', 'slug'])

@php
use Carbon\Carbon;
$date = Carbon::parse($publication_date)->toFormattedDateString();
@endphp

<a href="{{$slug}}">
    <article class="flex flex-row space-x-3">
        <time datetime="{{$publication_date}}" class="text-md font-light">
            {{$date}}
        </time>
        <header class=""> {{$title}} </header>
    </article>
</a>
