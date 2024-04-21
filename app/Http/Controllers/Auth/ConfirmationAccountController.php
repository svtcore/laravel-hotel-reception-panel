<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Classes\Users;
use App\Http\Requests\auth\ConfirmationRequest;
use Exception;
use Illuminate\Support\Facades\Validator;

class ConfirmationAccountController extends Controller
{
    private $users = NULL;

    public function __construct()
    {
        $this->users = new Users();
    }

    public function index(Request $request)
    {
        try {
            $token = $request->segment(3);
            $validator = Validator::make(['token' => $token], [
                'token' => 'required|string|max:60',
            ]);

            if ($validator->fails()) {
                return abort(404);
            }
            if ($this->users->checkConfirmationToken($token))
                return view('auth.confirm_registration')->with(['token' => $token]);
            else return abort(404);
        } catch (Exception $e) {
            return abort(404);
        }
    }

    public function confirm(ConfirmationRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if ($validatedData === null) {
                return response()->withErrors(['errors' => 'Validation failed']);
            }
            if ($this->users->confirmRegistration($validatedData)) {
                return redirect()->route('home')->with('success', 'You are confirmed, now you can use panel');
            } else return abort(500);
        } catch (Exception $e) {
            return abort(500);
        }
    }
}
