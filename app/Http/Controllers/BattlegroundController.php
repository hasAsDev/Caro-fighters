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
        // Lấy dữ liệu battleground
        $battleground = Battleground::find($battleground_id);

        // Lấy dữ liệu fighter_X
        $fighter_X = User::find($battleground->fighter_X);

        // Lấy dữ liệu fighter_O
        $fighter_O = User::find($battleground->fighter_O);


        // Response
        return response([
            'battleground' => [
                "fighter_X" => $battleground->fighter_X,
                "fighter_O" => $battleground->fighter_O,
                "winner" => $battleground->winner,
                "turn" => $battleground->turn,
                "battle_record" => json_decode($battleground->battle_record),
                "X_timer" => $battleground->X_timer,
                "O_timer" => $battleground->O_timer,
                "time_point" => $battleground->time_point,
            ],
            'fighter_X' => [
                'name' => $fighter_X->name,
                'elo' => $fighter_X->elo,
            ],
            'fighter_O' => [
                'name' => $fighter_O->name,
                'elo' => $fighter_O->elo,
            ],
            'win_XO' => $battleground->winner == $battleground->fighter_X ? "X" : ($battleground->winner == $battleground->fighter_O ? "O" : ($battleground->winner == 0 ? "Draw" : "Count"))
        ], 200);
    }

    public function update(Request $request, string $battleground_id): Response
    {
        $position = $request->position;
        $fighter_id = Auth::user()->id;
        // update battle record, winner, turn
        $battleground = Battleground::find($battleground_id);

        $new_battle_record = json_decode($battleground->battle_record);
        $now = gettimeofday()['sec'];
        if ($fighter_id == $battleground->fighter_X && $battleground->turn == "X") {
            //Tính giờ
            $new_O_timer = $battleground->O_timer + ($now - $battleground->time_point) + 3;
            $new_time_point = $now;

            $new_battle_record[floor($position / 15)][$position % 15] = "X";

            $new_winner = $this->calculateWinner($new_battle_record, $battleground->fighter_X, $battleground->fighter_O);

            if ($new_winner > 0) {
                $new_turn = "E";
                // Tính điểm
                $fighter_X = User::find($battleground->fighter_X);
                $fighter_O = User::find($battleground->fighter_O);
                [$new_X_elo, $new_O_elo] = $this->calculateElo($fighter_X->elo, $fighter_O->elo, 'X');
                $fighter_X->elo = $new_X_elo;
                $fighter_O->elo = $new_O_elo;

                $fighter_X->save();
                $fighter_O->save();

            } elseif ($new_winner == 0) {
                $new_turn = "E";
                // Tính điểm
                $fighter_X = User::find($battleground->fighter_X);
                $fighter_O = User::find($battleground->fighter_O);
                [$new_X_elo, $new_O_elo] = $this->calculateElo($fighter_X->elo, $fighter_O->elo, 'Draw');
                $fighter_X->elo = $new_X_elo;
                $fighter_O->elo = $new_O_elo;

                $fighter_X->save();
                $fighter_O->save();
            } else {
                $new_turn = "O";
            }


            $battleground->battle_record = json_encode($new_battle_record);
            $battleground->winner = $new_winner;
            $battleground->turn = $new_turn;
            $battleground->O_timer = $new_O_timer;
            $battleground->time_point = $new_time_point;

            // Lưu
            $battleground->save();

            //Kich hoat job
            BattleUpdate::dispatch(["battleground_id" => $battleground_id]);

            return response($new_winner, 200);
        } elseif ($fighter_id == $battleground->fighter_O && $battleground->turn == "O") {
            //Tính giờ
            $new_X_timer = $battleground->X_timer + ($now - $battleground->time_point) + 3;
            $new_time_point = $now;

            $new_battle_record[floor($position / 15)][$position % 15] = "O";

            $new_winner = $this->calculateWinner($new_battle_record, $battleground->fighter_X, $battleground->fighter_O);

            if ($new_winner > 0) {
                $new_turn = "E";
                // Tính điểm
                $fighter_X = User::find($battleground->fighter_X);
                $fighter_O = User::find($battleground->fighter_O);
                [$new_X_elo, $new_O_elo] = $this->calculateElo($fighter_X->elo, $fighter_O->elo, 'O');
                $fighter_X->elo = $new_X_elo;
                $fighter_O->elo = $new_O_elo;

                $fighter_X->save();
                $fighter_O->save();
            } elseif ($new_winner == 0) {
                $new_turn = "E";
                // Tính điểm
                $fighter_X = User::find($battleground->fighter_X);
                $fighter_O = User::find($battleground->fighter_O);
                [$new_X_elo, $new_O_elo] = $this->calculateElo($fighter_X->elo, $fighter_O->elo, 'Draw');
                $fighter_X->elo = $new_X_elo;
                $fighter_O->elo = $new_O_elo;

                $fighter_X->save();
                $fighter_O->save();
            } else {
                $new_turn = "X";
            }


            $battleground->battle_record = json_encode($new_battle_record);
            $battleground->winner = $new_winner;
            $battleground->turn = $new_turn;
            $battleground->X_timer = $new_X_timer;
            $battleground->time_point = $new_time_point;

            // Lưu
            $battleground->save();

            //Kich hoat job
            BattleUpdate::dispatch(["battleground_id" => $battleground_id]);

            return response("O", 200);
        } else {
            return response($new_battle_record, 200);
        }

    }

    public function timeout(Request $request, string $battleground_id): Response
    {
        $battleground = Battleground::find($battleground_id);
        $now = gettimeofday()['sec'];

        $fighter_id = (int) $request->fighter_id;
        if ($fighter_id === Auth::id() && $fighter_id === $battleground->fighter_X && $battleground->turn === "X") {
            $battleground->turn = "E";
            $battleground->winner = $battleground->fighter_O;
            $battleground->O_timer = $battleground->O_timer + ($now - $battleground->time_point);
            $battleground->time_point = $now;
            $battleground->save();
            // Tính điểm
            $fighter_X = User::find($battleground->fighter_X);
            $fighter_O = User::find($battleground->fighter_O);
            [$new_X_elo, $new_O_elo] = $this->calculateElo($fighter_X->elo, $fighter_O->elo, 'O');
            $fighter_X->elo = $new_X_elo;
            $fighter_O->elo = $new_O_elo;

            $fighter_X->save();
            $fighter_O->save();

            BattleUpdate::dispatch(["battleground_id" => $battleground_id]);

        } elseif ($fighter_id === Auth::id() && $fighter_id === $battleground->fighter_O && $battleground->turn === "O") {
            $battleground->turn = "E";
            $battleground->winner = $battleground->fighter_X;
            $battleground->X_timer = $battleground->X_timer + ($now - $battleground->time_point);
            $battleground->time_point = $now;
            $battleground->save();
            // Tính điểm
            $fighter_X = User::find($battleground->fighter_X);
            $fighter_O = User::find($battleground->fighter_O);
            [$new_X_elo, $new_O_elo] = $this->calculateElo($fighter_X->elo, $fighter_O->elo, 'X');
            $fighter_X->elo = $new_X_elo;
            $fighter_O->elo = $new_O_elo;

            $fighter_X->save();
            $fighter_O->save();

            BattleUpdate::dispatch(["battleground_id" => $battleground_id]);
        }

        return response($battleground->winner, 200);
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

    protected function calculateElo(int $X_elo, int $O_elo, string $win_fighter): array
    {
        $k = 20;
        // Xác suất thắng của X
        $PX = 1 / (1 + (pow(10, ($O_elo - $X_elo) / 400)));
        $PO = 1 / (1 + (pow(10, ($X_elo - $O_elo) / 400)));

        if ($win_fighter === "X") {
            $X_elo = ceil($X_elo + $k * (1 - $PX));
            $O_elo = ceil($O_elo + $k * (0 - $PO));

        } elseif ($win_fighter === "O") {
            $X_elo = ceil($X_elo + $k * (0 - $PX));
            $O_elo = ceil($O_elo + $k * (1 - $PO));

        } elseif ($win_fighter === "Draw") {
            $X_elo = ceil($X_elo + $k * (0.5 - $PX));
            $O_elo = ceil($O_elo + $k * (0.5 - $PO));
        }

        return [(int) $X_elo, (int) $O_elo];
    }
}
