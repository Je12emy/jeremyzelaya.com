<x-layout>
    {{$content}}

    {{$aside ?? ""}}
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
