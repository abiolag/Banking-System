<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // Get all active users except the current user
        $users = User::where('id', '!=', Auth::id())
                    ->where('status', 'active')
                    ->get(['name', 'account_number', 'account_type']);

        return view('users.index', compact('users'));
    }
}