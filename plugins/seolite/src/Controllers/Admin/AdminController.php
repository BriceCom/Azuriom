<?php

namespace Azuriom\Plugin\SeoLite\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Post;

class AdminController extends Controller
{
    /**
     * Show the home admin page of the plugin.
     */
    public function index()
    {
        return view('seolite::admin.index');
    }
}
