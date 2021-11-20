<?php

namespace App\Http\Controllers;

use App\User;
use App\Topic;
use App\Question;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $topics = Topic::all();
        $questions = Question::expected()->get();
        return view('home', compact('users', 'topics', 'questions'));
    }
}
