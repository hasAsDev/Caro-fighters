<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;


class AuthenticatedSessionController extends Controller
{
    // Hiển thị trang đăng nhập
    public function create(): View
    {
        return view('guest.login');
    }

    // Xử lí đăng nhập
    public function store(Request $request): RedirectResponse
    {
        // Validate
        $attributes = $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'min:8', 'max:255'],
            'password' => ['required', 'min:8', 'max: 30'],
        ]);

        // Đăng nhập bằng tài khoản do người dùng cung cấp, nếu không thành công thì báo lỗi
        if (!Auth::attempt($attributes)) {
            throw ValidationException::withMessages([
                'email' => "Those credentials are incorrect!",
            ]);
        }
        ;

        // Tạo session
        $request->session()->regenerate();

        // Điều hướng
        return redirect('/dashboard');
    }

    // Xử lí đăng xuất
    public function destroy(Request $request): RedirectResponse
    {
        // Đăng xuất
        Auth::logout();

        // Hủy session
        $request->session()->invalidate();

        // Tạo mới session
        $request->session()->regenerateToken();

        // Điều hướng
        return redirect('/');
    }
}
