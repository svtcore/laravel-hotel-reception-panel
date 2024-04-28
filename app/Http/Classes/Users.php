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
    /**
     * Retrieves all users along with their associated roles.
     *
     * @return iterable|null A collection of users with their roles if available; otherwise, null.
     */
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

    /**
     * Retrieves a user by their ID along with their associated roles.
     *
     * @param int $id The ID of the user to retrieve.
     * @return object|null The user object with associated roles if found; otherwise, null.
     */
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

    /**
     * Retrieves all roles.
     *
     * @return iterable|null A collection of roles if available; otherwise, null.
     */
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

    /**
     * Updates user information and assigns a new role.
     *
     * @param array $inputData The data to update the user with.
     * @param int $id The ID of the user to update.
     * @return bool True if the user was successfully updated; otherwise, false.
     */
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

    /**
     * Deletes a user by their ID.
     *
     * @param int $id The ID of the user to delete.
     * @return bool True if the user was successfully deleted; otherwise, false.
     */
    public function deleteById($id): bool
    {
        try {
            $user = User::findOrFail($id);
            $result = $user->delete();
            if ($result) return true;
            else return false;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Store a new user with the provided data.
     *
     * @param array $inputData The data to create the user.
     * @return bool True if the user was successfully stored; otherwise, false.
     */

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

    /**
     * Send a confirmation email to the user.
     *
     * @param array $inputData The input data containing user email.
     * @return bool True if the confirmation email was sent successfully; otherwise, false.
     */
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

    /**
     * Send a reset password email to the user.
     *
     * @param array $inputData The input data containing user email.
     * @return bool True if the reset password email was sent successfully; otherwise, false.
     */
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

    /**
     * Check if the provided confirmation token is valid.
     *
     * @param string $token The confirmation token to be checked.
     * @return bool True if the token is valid; otherwise, false.
     */
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

    /**
     * Confirm user registration by setting a new password and clearing the confirmation token.
     *
     * @param array $inputData The input data containing the confirmation token and the new password.
     * @return bool True if the registration is confirmed successfully; otherwise, false.
     */
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
