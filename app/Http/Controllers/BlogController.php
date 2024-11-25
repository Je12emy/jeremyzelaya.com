<?php

namespace App\Http\Controllers;

use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class BlogController extends Controller
{
    private $contentDirectory = 'views/content';

    /**
     * Display a listing of the resource.
     */
    public function index(YamlFrontMatter $yamlFrontMatter)
    {
        $files = File::files(resource_path($this->contentDirectory));

        $data = [];
        foreach ($files as $file) {
            $yaml = $yamlFrontMatter::parseFile($file)->matter();
            array_push($data, $yaml);
        }

        $sorted = Arr::sortDesc($data, function (mixed $item) {
            return $item['publication_date'];
        });

        return view('blog.index', ['posts' => $sorted]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug, YamlFrontMatter $yamlFrontMatter)
    {
        $path = resource_path("$this->contentDirectory/{$slug}.md");
        abort_if(! File::exists($path), 404);

        $document = $yamlFrontMatter::parseFile($path);
        $content = Markdown::convert($document->body())->getContent();

        $otherPosts = [];
        foreach ($this->getOtherposts($slug) as $post) {
            array_push($otherPosts, $yamlFrontMatter::parseFile($post));
        }

        return view('blog.show', ['content' => $content, 'article' => $document, 'others' => $otherPosts]);
    }

    private function getOtherposts(string $exclude)
    {
        $files = File::files(resource_path($this->contentDirectory));
        // TODO: Remove the post to render from the array
        $files = Arr::random($files, 2);

        return $files;
    }
}
