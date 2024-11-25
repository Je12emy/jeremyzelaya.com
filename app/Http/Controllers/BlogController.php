<?php

namespace App\Http\Controllers;

use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use Symfony\Component\Finder\SplFileInfo;

class BlogController extends Controller
{
    private $contentDirectory = 'views/content';

    private $otherPostsCount = 5;

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
        $filename = "$this->contentDirectory/{$slug}.md";
        $path = resource_path($filename);
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
        if (empty($files)) {
            return [];
        }

        if (count($files) < $this->otherPostsCount) {
            return [];
        }

        $files = Arr::random(Arr::where($files, function (SplFileInfo $file) use ($exclude) {
            return $file->getFilename() == $exclude;
        }), $this->otherPostsCount);

        return $files;
    }
}
