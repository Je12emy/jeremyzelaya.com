<x-layout>
    <article class="text-base">
        <x-post-header :title="$article->title" :publication_date="$article->publication_date" />
        {!! $content !!}
    </article>
    <aside class="mt-4">
        <section>
            <header class="font-bold text-lg mb-2"> Other Posts </header>
            <ul class="flex flex-col border-l-gray-400 pl-3 border-l-2 space-y-2">
                @foreach ($others as $other)
                <li>
                    <x-post-list :title="$other->title" :publication_date="$other->publication_date"
                        :slug="$other->slug" />
                </li>
                @endforeach
            </ul>
        </section>
    </aside>
</x-layout>

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
