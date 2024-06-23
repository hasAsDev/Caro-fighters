<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    // Xử lí cập nhật mật khẩu
    public function update(Request $request): RedirectResponse
    {
        // Validate
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password', 'min:8', 'max: 30'],
            'password' => ['required', 'confirmed', 'min:8', 'max: 30'],
        ]);

        // Cập nhật mật khẩu vào csdl
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        // Điều hướng
        return back()->with('status', 'password-updated');
    }
}
