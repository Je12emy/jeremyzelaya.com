@php
use Carbon\Carbon;
@endphp

<x-layouts>
    @if(empty($posts))
    <article>
        <span class="font-medium text-2xl"> huh??? </span>
        <h1 class="text-3xl font-light"> ...there is nothing here </h1>
        <p> If you are seeing this, you should add markdown content to the <i> content </i> directory.
        <p>
    </article>
    @else

    @php
    $latest = $posts[0];
    $date = Carbon::parse($latest['publication_date'])->toFormattedDateString();
    @endphp

    <article class="flex flex-col space-y-6 mt-8">
        <a href="blog/{{$latest['slug']}}">
            <section class="flex flex-col items-center space-y-2">
                <header class="text-2xl font-bold"> {{$latest['title']}} </header>
                <time datetime="{{$latest['publication_date']}}" class="text-lg font-light">
                    {{$date}}
                </time>
                @isset($latest['summary'])
                <summary class="text-base" style="display: block"> {{$latest['summary'] ?? ""}} </summary>
                @endisset
            </section>
        </a>
        <section>
            <header class="text-lg mb-3 font-normal text-center"> All Articles </header>
            <div class="flex flex-col space-y-4">
                @foreach ($posts as $post)
                @php
                $date = Carbon::parse($post['publication_date'])->toFormattedDateString();
                @endphp
                <a href="blog/{{$post['slug']}}">
                    <article class="flex flex-col md:flex-row md:space-x-2 md:items-start">
                        <time class="min-w-fit text-lg md:text-xl font-light md:max-w-32 md:min-w-32"
                            datetime="{{$post['publication_date']}}">
                            {{$date}}
                        </time>
                        <div class="flex flex-col items-start space-y-2">
                            <header class="text-xl font-bold"> {{$post['title']}} </header>
                            @isset($post['summary'])
                            <summary style="display: block"> {{$post['summary'] ?? ""}} </summary>
                            @endisset
                        </div>
                    </article>
                </a>
                @endforeach
            </div>
        </section>
    </article>
    @endif
</x-layouts>
