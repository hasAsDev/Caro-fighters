<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;


class Battleground extends Model
{
    use HasFactory, HasUlids;

    protected $table = "battlegrounds";

    protected $primaryKey = "battleground_id";

    protected $fillable = [
        "fighter_X",
        "fighter_O",
        "winner",
        "turn",
        "battle_record",
        "X_timer",
        "O_timer",
        "time_point",
    ];
    public $timestamps = false;
}
