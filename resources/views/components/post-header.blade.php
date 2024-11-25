@props(['title', 'publication_date'])

<header class="flex flex-col mb-2">
    <h1 class="text-2xl font-extrabold"> {{$title}} </h1>
    @php
    use Carbon\Carbon;
    $date = Carbon::parse($publication_date)->toFormattedDateString();
    @endphp

    <time datetime="{{$publication_date}}" class="text-md font-light"> {{$date}} </time>
</header>
