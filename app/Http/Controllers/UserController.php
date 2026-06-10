<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    //--login system
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Display a listing of all users.
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Display the specified user profile.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role'       => 'required|string|max:50',
            'age'        => 'nullable|string',
            'country'    => 'nullable|string|max:100',
            'password'   => 'nullable|string|min:8|confirmed', // Confirmed requires a password_confirmation field
        ]);

        // If password field is empty, remove it from data array so it isn't overwritten blank
        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User profile updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deleting yourself accidentally
        if (auth()->id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'You cannot delete your own logged-in account.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    // for API user edit and update
    /**
     * Get Profile
     */
    public function profile()
    {
       
        return response()->json([
            'success' => true,
            'data' => Auth::user()
        ]);
    }

    /**
     * Update Profile
     */
    public function updateProfile(Request $request)
    {
        // return response()->json(['message' => 'Username & Password incorrect']);
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'email'      => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id)
            ],
            'age'        => 'nullable',
            'country'    => 'nullable|string|max:255',
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'age'        => $request->age,
            'country'    => $request->country,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data'    => $user->fresh()
        ]);
    }

    /**
     * Delete Profile
     */
    public function deleteProfile()
    {
        $user = Auth::user();
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'Account deleted successfully'
        ]);
    }


}