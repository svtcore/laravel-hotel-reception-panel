<?php

namespace App\Http\Classes;

use App\Mail\ConfirmationAccountMail;
use App\Mail\ResetPasswordMail;
use Exception;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class Users
{
    public function getAll(): ?iterable
    {
        try {
            $users = User::with(['roles'])->get();
            if ($users && $users->count()) {
                return $users;
            } else return null;
        } catch (Exception $e) {
            return null;
        }
    }

    public function getById($id): ?object
    {
        try {
            $user = User::with(['roles'])->where('id', $id)->first();
            if ($user) return $user;
            else return null;
        } catch (Exception $e) {
            return null;
        }
    }

    public function getRoles(): ?iterable
    {
        try {
            $roles = Role::all();
            if ($roles && $roles->count() > 0) return $roles;
            else return null;
        } catch (Exception $e) {
            return null;
        }
    }

    public function update($inputData, $id): bool
    {
        try {
            $user = User::findOrFail($id);
            if ($user) {
                $user->update([
                    'name' => $inputData['name'],
                    'email' => $inputData['email'],
                ]);
                $user->roles()->detach();
                $user->assignRole($inputData['role']);
                return true;
            } else return false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function deleteById($id): bool
    {
        try {
            $user = User::findOrFail($id);
            $result = $user->delete($id);
            if ($result) return true;
            else return false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function store($inputData): bool
    {
        try {
            $result = User::create([
                'name' => $inputData['name'],
                'email' => $inputData['email'],
            ]);
            if ($result) {
                $id = $result->id;
                $user = User::findOrFail($id);
                $user->assignRole($inputData['role']);
                if ($this->sendConfirmation($inputData)) return true;
            } else return false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function sendConfirmation($inputData): bool
    {
        $user = User::where('email', $inputData['email'])->first();
        if ($user) {
            $token = Str::random(60);
            $user->confirm_token = $token;
            $user->save();
            $result = Mail::to($user->email)->send(new ConfirmationAccountMail($token));

            if ($result) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function sendResetPassword($inputData): bool
    {
        $user = User::where('email', $inputData['email'])->first();
        if ($user) {
            $token = Password::getRepository()->create($user);
            $result = Mail::to($user->email)->send(new ResetPasswordMail($token));
            if ($result) {
                return true;
            } else {
                return false;
            }
        } else return false;
    }

    public function checkConfirmationToken($token): bool
    {
        try {
            $user = User::where('confirm_token', $token)->first();
            if (isset($user->name)) return true;
            else return false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function confirmRegistration($inputData): bool
    {
        try {
            $user = User::where('confirm_token', $inputData['token'])->first();
            if ($user) {
                $user->password = Hash::make($inputData['password']);
                $user->confirm_token = null;
                $user->save();
                return true;
            } else return false;
        } catch (Exception $e) {
            return false;
        }
    }
}
