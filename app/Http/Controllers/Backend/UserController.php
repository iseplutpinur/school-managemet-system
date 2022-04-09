<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $user = User::select(['id', 'name', 'role', 'email', 'active', 'profile_photo_path'])
                ->selectRaw('IF(active = 1, "Yes", "No") as active_str');

            // filter
            if (isset($request->filter)) {
                $filter = $request->filter;
                if ($filter['active'] != '') {
                    $user->where('active', '=', $filter['active']);
                }
                if ($filter['role'] != '') {
                    $user->where('role',  '=', $filter['role']);
                }
            }

            return Datatables::of($user)
                ->addIndexColumn()
                ->addColumn('role_str', function (User $user) {
                    return ucfirst(implode(' ', explode('_', $user->role)));
                })
                ->make(true);
        }

        $page_attr = [
            'title' => 'View User',
            'breadcrumbs' => [
                ['name' => 'Manage User'],
            ],
            'navigation' => 'user.view',
        ];
        $user_role = User::getAllRole();
        return view('backend.view_user', compact('page_attr', 'user_role'));
    }

    public function check_login(Request $request)
    {
        die;
        $email      = $request->input('email');
        $password   = $request->input('password');

        if (Auth::guard('web')->attempt(['email' => $email, 'password' => $password])) {
            return response()->json([
                'success' => true
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Login Gagal!'
            ], 401);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'role' => ['required', 'string', 'max:255'],
                'active' => ['required', 'number', 'max:1'],
                'password' => ['required', 'string', new Password]
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);

            $user = User::where('email', $request->email)->first();

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return response()->json();
        } catch (Exception $error) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $error,
            ], 500);
        }
    }
}
