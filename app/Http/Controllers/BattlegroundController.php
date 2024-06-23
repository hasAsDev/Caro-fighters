<?php

namespace App\Http\Controllers;

use App\Events\BattleUpdated;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Battleground;
use App\Models\User;
use App\Jobs\BattleUpdate;

class BattlegroundController extends Controller
{
    public function show(Request $request, string $battleground_id): View
    {
        return view("battleground", ['battleground_id' => $battleground_id]);
    }

    public function index(Request $request, string $battleground_id): Response
    {
        // Lay du lieu battleground
        $battleground = Battleground::find($battleground_id);

        // Lay du lieu fighter_X
        $fighter_X = User::find($battleground->fighter_X);

        // Lay du lieu fighter_O
        $fighter_O = User::find($battleground->fighter_O);



        // Response
        return response([
            'battleground' => [
                "fighter_X" => $battleground->fighter_X,
                "fighter_O" => $battleground->fighter_O,
                "winner" => $battleground->winner,
                "turn" => $battleground->turn,
                "battle_record" => json_decode($battleground->battle_record),
            ],
            'fighter_X' => [
                "name" => $fighter_X->name,
            ],
            'fighter_O' => [
                "name" => $fighter_O->name,
            ],
        ], 200);
    }

    public function update(Request $request, string $battleground_id): Response
    {
        $position = $request->position;
        $fighter_id = Auth::user()->id;
        // update battle record, winner, turn
        $battleground = Battleground::find($battleground_id);

        $new_battle_record = json_decode($battleground->battle_record);

        if ($fighter_id == $battleground->fighter_X && $battleground->turn == "X") {
            $new_battle_record[floor($position / 15)][$position % 15] = "X";

            $new_winner = $this->calculateWinner($new_battle_record, $battleground->fighter_X, $battleground->fighter_O);

            if ($new_winner >= 0) {
                $new_turn = "E";
            } else {
                $new_turn = "O";
            }

            $battleground->battle_record = json_encode($new_battle_record);
            $battleground->winner = $new_winner;
            $battleground->turn = $new_turn;
            $battleground->save();

            //Kich hoat job
            BattleUpdate::dispatch(["battleground_id" => $battleground_id]);

            return response($new_winner, 200);
        } elseif ($fighter_id == $battleground->fighter_O && $battleground->turn == "O") {
            $new_battle_record[floor($position / 15)][$position % 15] = "O";

            $new_winner = $this->calculateWinner($new_battle_record, $battleground->fighter_X, $battleground->fighter_O);

            if ($new_winner >= 0) {
                $new_turn = "E";
            } else {
                $new_turn = "X";
            }

            $battleground->battle_record = json_encode($new_battle_record);
            $battleground->winner = $new_winner;
            $battleground->turn = $new_turn;
            $battleground->save();

            //Kich hoat job
            BattleUpdate::dispatch(["battleground_id" => $battleground_id]);

            return response("O", 200);
        } else {
            return response($new_battle_record, 200);
        }

    }

    protected function calculateWinner(array $battle_record, int $fighter_X, int $fighter_O): int
    {
        $rows = count($battle_record);
        $cols = count($battle_record[0]);
        // Tinh hang
        for ($i = 0; $i <= $rows - 5; $i++) {
            for ($j = 0; $j <= $cols - 1; $j++) {
                if (
                    $battle_record[$i][$j] != ""
                    && $battle_record[$i][$j] == $battle_record[$i + 1][$j]
                    && $battle_record[$i][$j] == $battle_record[$i + 2][$j]
                    && $battle_record[$i][$j] == $battle_record[$i + 3][$j]
                    && $battle_record[$i][$j] == $battle_record[$i + 4][$j]
                ) {
                    return $battle_record[$i][$j] == "X" ? $fighter_X : $fighter_O;
                }
            }
        }
        // Tinh cot
        for ($i = 0; $i <= $rows - 1; $i++) {
            for ($j = 0; $j <= $cols - 5; $j++) {
                if (
                    $battle_record[$i][$j] != ""
                    && $battle_record[$i][$j] == $battle_record[$i][$j + 1]
                    && $battle_record[$i][$j] == $battle_record[$i][$j + 2]
                    && $battle_record[$i][$j] == $battle_record[$i][$j + 3]
                    && $battle_record[$i][$j] == $battle_record[$i][$j + 4]
                ) {
                    return $battle_record[$i][$j] == "X" ? $fighter_X : $fighter_O;
                }
            }
        }
        // Tinh duong cheo
        for ($i = 2; $i <= $rows - 3; $i++) {
            for ($j = 2; $j <= $cols - 3; $j++) {
                if (
                    $battle_record[$i][$j] != ""
                    && $battle_record[$i][$j] == $battle_record[$i - 2][$j - 2]
                    && $battle_record[$i][$j] == $battle_record[$i - 1][$j - 1]
                    && $battle_record[$i][$j] == $battle_record[$i + 1][$j + 1]
                    && $battle_record[$i][$j] == $battle_record[$i + 2][$j + 2]
                ) {
                    return $battle_record[$i][$j] == "X" ? $fighter_X : $fighter_O;
                }
                if (
                    $battle_record[$i][$j] != ""
                    && $battle_record[$i][$j] == $battle_record[$i - 2][$j + 2]
                    && $battle_record[$i][$j] == $battle_record[$i - 1][$j + 1]
                    && $battle_record[$i][$j] == $battle_record[$i + 1][$j - 1]
                    && $battle_record[$i][$j] == $battle_record[$i + 2][$j - 2]
                ) {
                    return $battle_record[$i][$j] == "X" ? $fighter_X : $fighter_O;
                }
            }
        }
        // Tinh hoa
        for ($i = 0; $i <= $rows - 1; $i++) {
            if (!in_array("", $battle_record[$i])) {
                return 0;
            }
        }

        return -1;
    }
}
