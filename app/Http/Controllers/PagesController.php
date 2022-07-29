<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Datatables;

class PagesController extends Controller
{
    public static $pageTitle = 'Pages';
    public static $pageDescription = 'Pages Description';
    public static $modelName = 'App\Models\Pdf';
    public static $folderPath = 'test';
    public static $permissionName = 'test';
    public static $pageBreadcrumbs = [
        [
            'page' => '/',
            'title' => 'Application',
        ],
        [
            'page' => 'test',
            'title' => 'Test',
        ]
    ];

    public function index()
    {
        if (auth()->user()) {
            return redirect()->route('dashboard');
        }
        
        $pageTitle = 'Login';
        $pageDescription = 'Some description for the page';

        return view('pages.login', compact('pageTitle', 'pageDescription'));
    }

    public function username()
    {
        return 'username';
    }

    public function login(Request $request)
    {
        if (Auth::attempt($request->only('username', 'password'))) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        } else {
            return back()->withErrors([
                'username' => 'The provided credentials do not match our records.',
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function dashboard()
    {
        $userCount = User::count();
        $roleCount = Role::count();

        $pageTitle = 'Dashboard';

        return view('pages.dashboard', compact('userCount', 'roleCount', 'pageTitle'));
    }

    public function job(Request $req)
    {
        $pageTitle = 'Github Jobs';

        return view('pages.job', compact('pageTitle'));
    }

    public function detail($id)
    {
        $pageTitle = 'Detail';

        return view('pages.detail', compact('pageTitle','id'));
    }
}
