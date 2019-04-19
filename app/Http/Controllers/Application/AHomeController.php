<?php

namespace App\Http\Controllers\Application;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => 'index']);
        $this->middleware('vActualizacion');
    }
    public function index()
    {
        return view('contents.application.welcome_dashboard');
    }
}
