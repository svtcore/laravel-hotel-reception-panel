<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;

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
     * Show the application dashboard and redirect users based on their roles.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        try {
            $user = User::find(Auth::user()->id);

            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole('receptionist')) {
                return redirect()->route('receptionist.booking.index');
            } else {
                return redirect()->route('login');
            }
        } catch (Exception $e) {
            return redirect()->route('login');
        }
    }
}
