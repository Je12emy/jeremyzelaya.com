@php
use Carbon\Carbon;

$latest = $posts[0];
$date = Carbon::parse($latest['publication_date'])->toFormattedDateString();
@endphp

<x-blog-layout>
    <x-slot:content>
        <article class="flex flex-col space-y-6 mt-4">
            <a href="blog/{{$latest['slug']}}">
                <section class="flex flex-col items-center space-y-2">
                    <header class="text-2xl font-bold"> {{$latest['title']}} </header>
                    <time datetime="{{$latest['publication_date']}}" class="text-lg font-light">
                        {{$date}}
                    </time>
                    @isset($latest['summary'])
                    <summary class="text-base" style="display: block"> {{$latest['summary'] ?? ""}} </summary>
                    <button class="font-semibold text-lg"> Read More </button>
                    @endisset
                </section>
            </a>
            <section>
                <header class="text-lg mb-3"> All Articles </header>
                <div class="flex flex-col space-y-4">
                    @foreach ($posts as $post)
                    @php
                    $date = Carbon::parse($post['publication_date'])->toFormattedDateString();
                    @endphp
                    <a href="blog/{{$post['slug']}}">
                        <article class="flex flex-row space-x-3 items-start">
                            <time class="min-w-fit text-xl font-light" datetime="{{$post['publication_date']}}">
                                {{$date}}
                            </time>
                            <div class="flex flex-col items-start space-y-2">
                                <header class="text-xl"> {{$post['title']}} </header>
                                @isset($post['summary'])
                                <summary style="display: block"> {{$post['summary'] ?? ""}} </summary>
                                <button class="font-semibold"> Read More </button>
                                @endisset
                            </div>
                        </article>
                    </a>
                    @endforeach
                </div>
            </section>
        </article>
    </x-slot:content>
</x-blog-layout>
