<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Jobs\BattleStart;
use App\Models\BattleQueue;
use App\Models\Battleground;
use App\Models\User;

class BattleController extends Controller
{
    public function show(): View
    {
        $fighter_id = Auth::user()->id;
        $battlegrounds = Battleground::where('winner', "<", "0")->whereAny(["fighter_X", "fighter_O"], $fighter_id)->get();
        return view('battle', ['battlegrounds' => $battlegrounds]);
    }

    public function battle(Request $request): RedirectResponse
    {
        // Lấy fighter id
        $fighter = $request->user();

        // Thêm vào hàng đợi
        $fighter_id = $this->addQueues(($fighter->id));

        // Ghép cặp
        $matchup = BattleQueue::all()->take(2);
        if (count($matchup->toArray()) == 2) {
            // Xóa khỏi hàng đợi
            BattleQueue::destroy($matchup);
            // Tạo
            $fighter_X = $matchup->toArray()[0]['fighter_id'];
            $fighter_O = $matchup->toArray()[1]['fighter_id'];
            BattleStart::dispatch([
                'fighter_X' => $fighter_X,
                'fighter_O' => $fighter_O,
            ]);

        }
        return redirect('/battle');
    }

    protected function addQueues(int $fighter_id): int
    {
        if (!BattleQueue::where('fighter_id', $fighter_id)->get()->first()) {
            $battle_queue = BattleQueue::create(['fighter_id' => $fighter_id]);
            return $battle_queue->fighter_id;
        }
        return -1;
    }

}
