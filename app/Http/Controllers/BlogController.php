<?php

namespace App\Http\Controllers;

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
        $filename = "$this->contentDirectory/{$slug}.md";
        $path = resource_path($filename);
        abort_if(! File::exists($path), 404);

        $document = $yamlFrontMatter::parseFile($path);

        return view('blog.show', ['article' => $document, 'view' => "content.$slug"]);
    }
}
