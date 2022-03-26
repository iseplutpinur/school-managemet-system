<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userView()
    {
        $users = User::all();
        $page_attr = [
            'title' => 'View User',
            'breadcrumbs' => [
                ['name' => 'Manage User'],
            ],
            'navigation' => 'user.view',
        ];
        return view('backend.user.view_user', compact('users', 'page_attr'));
    }
}
