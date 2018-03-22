<?php

namespace App\Http\Controllers\Application;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => 'index']);
    }
    public function index()
    {
        return view('contents.application.welcome_dashboard');
    }
}
