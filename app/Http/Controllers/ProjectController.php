<?php

namespace App\Http\Controllers;

class ProjectController extends Controller
{
    public function index()
    {
        return view('pages.projects', [
            'projects' => config('projects'),
        ]);
    }
}
