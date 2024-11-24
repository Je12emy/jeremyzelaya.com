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
    public function index()
    {
        return redirect(route('home'));
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

        return view('post', ['content' => $content, 'article' => $document, 'others' => $otherPosts]);
    }

    private function getOtherposts(string $exclude)
    {
        $files = File::files(resource_path($this->contentDirectory));
        // TODO: Remove the post to render from the array
        $files = Arr::random($files, 2);

        return $files;
    }
}
