<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class TagController extends Controller
{
    public function __invoke(Tag $tag) {
        // search for jobs associated with a tag
        return view('results', ['jobs' => $tag->jobs]);
    }
}
