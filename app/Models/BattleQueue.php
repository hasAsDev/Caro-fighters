<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BattleQueue extends Model
{
    use HasFactory;

    protected $table = 'battle_queues';
    protected $fillable = ['fighter_id'];
    public $timestamps = false;
}
