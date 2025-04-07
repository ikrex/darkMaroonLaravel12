<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class HomeController extends Controller
{

// HomeController.php
public function index()
{
    $locale = Session::get('locale', 'hu');

    $contents = Content::where('is_active', true)
                      ->orderBy('sort_order')
                      ->get();

    $contentBlocks = [];
    foreach ($contents as $content) {
        if ($locale == 'en' && !empty($content->title_english)) {
            // Angol verzió
            $contentBlock = clone $content;
            $contentBlock->title = $content->title_english;
            $contentBlock->content = $content->content_english;
            $contentBlocks[$content->key] = $contentBlock;
        } else {
            // Magyar verzió
            $contentBlocks[$content->key] = $content;
        }
    }

    return view('home', compact('contentBlocks'));
}


}
