<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class WebController extends Controller
{
    public function index()
    {
        return view('admin.index');
//        Gate::authorize('admin');
//
//        return User::find(1)->first()->groups;
    }
}
