<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Page;
class HomeController extends Controller
{
    public function index()
    {
        return view('web.pages.index');
    }


    function privacyPolicy()
    {
        $page = Page::where('key', 'privacy-policy')->firstOrFail();
        return view('web.pages.privacy-policy', compact('page'));
    }

    function termCondition()
    {

        $page = Page::where('key', 'term-condition')->firstOrFail();
        return view('web.pages.term-condition', compact('page'));
    }

}
