<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        if (!Auth::user()->is_admin) {
            return redirect('/home')->with('error', 'Unauthorized access.');
        }

        $users = User::where('is_admin', false)->get();
        return view('admin.dashboard', compact('users'));
    }

    public function creditUser(Request $request, $userId)
    {
        if (!Auth::user()->is_admin) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'amount' => 'required|numeric|min:0.01'
        ]);

        $user = User::findOrFail($userId);
        $user->balance += $request->amount;
        $user->save();

        return back()->with('success', "Successfully credited \${$request->amount} to {$user->name}");
    }

    public function createAdminUser()
    {
        // Check if admin already exists to avoid duplicates
        $existingAdmin = User::where('email', 'admin@arkardbank.com')->first();
        
        if ($existingAdmin) {
            return "Admin user already exists!";
        }

        // Method to create admin users (run this once)
        $admin = User::create([
            'name' => 'Remittance Dept',
            'email' => 'admin@arkardbank.com',
            'password' => bcrypt('admin123'), // Change this password!
            'is_admin' => true,
            'balance' => 100000000000 // 100 billion
        ]);

        return "Admin user created successfully! Email: admin@arkardbank.com, Password: admin123";
    }
}