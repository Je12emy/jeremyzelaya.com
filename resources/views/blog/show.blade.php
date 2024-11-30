<x-layouts.blog>
    <x-slot:content>
        <article class="text-base">
            <x-post-header :title="$article->title" :publication_date="$article->publication_date" />
            @include($view)
        </article>
    </x-slot:content>
</x-layouts.blog>
