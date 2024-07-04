<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    // Hiển thị trang sửa thông tin người dùng
    public function edit(): View
    {
        $tops = User::orderBy('elo', 'desc')->orderBy('created_at', 'asc')->get();
        $arr = $tops->toArray();
        $top = -1;
        foreach ($arr as $key => $value) {
            if ($value['id'] == Auth::user()->id) {
                $top = $key + 1;
                break;
            }
        }
        ;
        return view('profile.edit', [
            'user' => Auth::user(),
            'top' => $top,
        ]);
    }

    // Xử lí cập nhật tên người dùng
    public function update(Request $request): RedirectResponse
    {
        // Validate
        $request->validate([
            'name' => ['required', 'string', 'min: 8', 'max:15', 'unique:' . User::class],

        ]);

        // Cập nhật tên người dùng mới
        Auth::user()->name = $request->name;
        Auth::user()->save();

        // Điều hướng người dùng
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    // Xử lí xóa tài khoản
    public function destroy(Request $request): RedirectResponse
    {
        // Validate
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        // Lấy thông tin người dùng
        $user = $request->user();

        // Đăng xuất
        Auth::logout();

        // Xóa dữ liệu người dùng
        $user->delete();

        // Vô hiệu hóa seesion
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Điều hướng
        return Redirect::to('/');
    }
}
