<?php

namespace App\Http\Controllers;

use App\Models\Battleground;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    //
    public function showranking(): View
    {
        $fighters = User::orderBy('elo', 'desc')->orderBy('created_at', 'asc')->take(10)->get();
        return view('ranking', ['fighters' => $fighters]);
    }

    public function searchbattleground(Request $request): RedirectResponse
    {
        $battleground_id = $request->battleground_id;
        #validate
        // dd($request);
        $request->validate([
            'battleground_id' => 'exists:App\Models\Battleground,battleground_id',
        ]);

        if (Battleground::find($battleground_id)) {
            return redirect("/battleground" . "/$battleground_id");
        } else {
            return redirect('/dashboard');
        }
    }
}
