<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    // Hiển thị trang đăng kí
    public function create(): View
    {
        return view('guest.register');
    }

    // Xử lí đăng kí
    public function store(Request $request): RedirectResponse
    {
        // Validate 
        $request->validate([
            'name' => ['required', 'string', 'min: 8', 'max:15', 'unique:' . User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'min:8', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', 'min: 8', 'max: 30'],
        ]);

        // Tạo dữ liệu
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Đăng nhập
        Auth::login($user);

        // Điều hướng
        return redirect(route('dashboard', absolute: false));
    }
}
