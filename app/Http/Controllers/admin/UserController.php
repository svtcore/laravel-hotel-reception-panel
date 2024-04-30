<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Classes\Users;
use App\Http\Requests\admin\users\StoreRequest;
use App\Http\Requests\admin\users\UpdateRequest;
use App\Http\Requests\auth\MailRequest;
use Exception;

class UserController extends Controller
{

    private $users = NULL;

    public function __construct()
    {
        $this->users = new Users();
    }

    /**
     * Display a listing of users.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory Returns the view for displaying a listing of users.
     */
    public function index()
    {
        return view('users.index')->with([
            'users' => $this->users->getAll() ?? array()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('users.create')->with([
            'roles' => $this->users->getRoles() ?? array()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if ($validatedData === null) {
                return response()->withErrors(['errors' => 'Validation failed']);
            }
            if ($this->users->store($validatedData)) {
                return redirect()->route('admin.users.index')->with('success', 'Confirmation has been sent');
            } else return redirect()->back()->withErrors(['error' => 'There is error in while adding record']);
        } catch (Exception $e) {
            return response()->withErrors(['errors' => 'Error in update user controller']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(string $id)
    {
        return view('users.edit')->with([
            'user' => $this->users->getById($id) ?? abort(404),
            'roles' => $this->users->getRoles() ?? array(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, string $id)
    {
        try {
            $validatedData = $request->validated();

            if ($validatedData === null) {
                return response()->withErrors(['errors' => 'Validation failed']);
            }
            if ($this->users->update($validatedData, $id)) {
                return redirect()->route('admin.users.index', $id)->with('success', 'User data successful updated');
            } else return redirect()->back()->withErrors(['error' => 'There is error in while updating record']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'There is error in while updating record']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        if ($this->users->deleteById($id)) {
            return redirect()->route('admin.users.index')->with('success', 'Record successful deleted');
        } else return redirect()->back()->withErrors(['error' => __('The requested resource could not be found.')]);
    }

    /**
     * Send the reset password link to the specified email.
     *
     * @param  MailRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkToEmail(MailRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if ($validatedData === null) {
                return response()->withErrors(['errors' => 'Validation failed']);
            }
            if ($this->users->sendResetPassword($validatedData))
                return back()->with('success', 'Reset password link sent successfully');
            else return back()->with('error', 'There is error while sending email to reset password');
        } catch (Exception $e) {
            return back()->with('error', 'There is error while sending email to reset password');
        }
    }
}
