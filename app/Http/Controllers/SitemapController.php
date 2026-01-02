<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Project;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        $posts = BlogPost::where('is_published', true)
            ->where('index_page', true)
            ->orderBy('updated_at', 'desc')
            ->get();
            
        $projects = Project::latest('updated_at')->get();

        return response()->view('sitemap', [
            'posts' => $posts,
            'projects' => $projects,
        ])->header('Content-Type', 'text/xml');
    }
}
