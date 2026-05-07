<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $loans = $user->loans()->with('payments')->latest()->get();

        return view('client.loans.index', compact('loans'));
    }
}
