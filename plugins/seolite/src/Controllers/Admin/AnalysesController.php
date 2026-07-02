<?php

namespace Azuriom\Plugin\SeoLite\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Post;
use Azuriom\Plugin\SeoLite\Helpers\SeoAnalysisHelper;
use Illuminate\Http\Request;

class AnalysesController extends Controller
{
    /**
     * Display the analyses dashboard.
     */
    public function index()
    {
        return view('seolite::admin.analyses.index');
    }

    /**
     * Display a listing of articles with SEO analysis.
     */
    public function articles(Request $request)
    {
        $query = Post::orderByDesc('created_at');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(15)->withQueryString();

        // Calculate SEO scores for each post
        $posts->getCollection()->transform(function ($post) {
            $post->seo_data = SeoAnalysisHelper::calculateSeoData($post);
            return $post;
        });

        return view('seolite::admin.analyses.articles', [
            'posts' => $posts,
            'search' => $request->get('search', ''),
        ]);
    }

}
