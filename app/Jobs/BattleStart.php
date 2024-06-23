<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Events\BattleStarted;
use App\Models\Battleground;

class BattleStart implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public array $fighter_ids)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        // Tạo chiến trường
        $board = $this->createBoard(15, 15);
        $battleground = Battleground::create([
            'fighter_X' => $this->fighter_ids['fighter_X'],
            'fighter_O' => $this->fighter_ids['fighter_O'],
            'winner' => -1,
            'turn' => "X",
            'battle_record' => json_encode($board)
        ]);
        // Kích hoạt sự kiện
        BattleStarted::dispatch($battleground->toArray());
    }

    protected function createBoard(int $rows, int $cols): array
    {
        $board = [];
        for ($i = 0; $i < $rows; $i++) {
            $line = [];
            for ($j = 0; $j < $cols; $j++) {
                $line[] = '';
            }
            $board[] = $line;
        }
        return $board;
    }
}
