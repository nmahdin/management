<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Main extends Controller
{
    public function index()
    {
        return view('admin.dashboards.main');
    }
}
