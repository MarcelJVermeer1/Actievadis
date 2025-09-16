<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserManagementController extends Controller {
    /**
     * Display the user data.
     */
    public function index() {
        $currentUser = Auth::user();
        if (!$currentUser || !$currentUser->is_admin) {
            return redirect()->route('dashboard');
        }
        return view('usermanagement', [
            'currentUser' => $currentUser,
            'users' => User::all()
        ]);
    }

    /**
     * Remove the user from the database.
     */
    public function destroy(string $id) {
        $currentUser = Auth::user();
        if (!$currentUser || !$currentUser->is_admin) {
            return redirect()->route('dashboard');
        }

        $user = User::findOrFail($id);
        if ($user->id === $currentUser->id) {
            return redirect()->route('usermanagement')->with('error', 'You cannot delete your own account.');
        }

        if (!$user->delete()) {
            abort(500, 'Failed to delete user.');
        }
        return redirect()->route('usermanagement')->with('success', 'User deleted successfully.');
    }
}
