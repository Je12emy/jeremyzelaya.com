<x-layout>
    <x-navbar />
    {{$content}}

    {{$aside ?? ""}}
</x-layout>

<style>
    body {
        display: grid;
        grid-template-rows: min-content;
        grid-template-areas:
            "nav"
            "content"
            "aside";
    }

    @media screen and (min-width: 768px) {
        body {
            grid-template-columns: 25% 1fr 25%;
            gap: 2rem;
            grid-template-areas:
                ". nav ."
                ". content aside";
        }

    }

    article {
        grid-area: content;
    }

    nav {
        grid-area: nav;
    }

    aside {
        grid-area: aside;
    }
</style>
