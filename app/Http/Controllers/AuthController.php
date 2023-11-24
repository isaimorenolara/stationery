<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth/register');
    }

    public function registerSave(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ])->validate();

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return redirect()->route('login');
    }

    public function registerUpdate(Request $request)
    {
        $userID = auth()->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('profile')->with('error', 'Profile update failed.');
        }

        $user = User::findOrFail($userID->id);

        $data = [
            'name' => $request->input('name'),
            'password' => $request->input('password'),
        ];

        $user->update($data);

        return redirect()->back();
    }

    public function login()
    {
        return view('auth/login');
    }

    public function loginAction(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ])->validate();

        $user = User::where('email', $request->email)->first();

        if ($user && $request->password === $user->password) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        } else {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed')
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        return redirect('/');
    }

    public function profile()
    {
        return view('profile');
    }

    public function dashboard()
    {
        $userActivityCounts = $this->getUserActivityCounts();
        return view('dashboard', compact('userActivityCounts'));
    }

    public function getUserActivityCounts()
    {
        $userID = auth()->user();

        // Obtiene la cantidad de inserciones (registros no eliminados) del usuario
        $insertionsCount = DB::table('products')
            ->where('user_id', $userID->id)
            ->whereNull('deleted_at') // No eliminados
            ->count();

        // Obtiene la cantidad de eliminaciones suaves (registros eliminados) del usuario
        $softDeletesCount = DB::table('products')
            ->where('user_id', $userID->id)
            ->whereNotNull('deleted_at') // Eliminados suavemente
            ->count();

        return [
            'insertionsCount' => $insertionsCount,
            'softDeletesCount' => $softDeletesCount,
        ];
    }
}
