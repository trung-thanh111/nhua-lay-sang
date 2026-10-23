<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JapaneseSrsCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'card_type',
        'item_id',
        'repetitions',
        'ease_factor',
        'interval_days',
        'due_date',
    ];

    protected $attributes = [
        'repetitions' => 0,
        'ease_factor' => 2.5,
        'interval_days' => 1,
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'ease_factor' => 'float',
    ];

    /**
     * Cập nhật thẻ theo thuật toán SuperMemo SM-2
     * @param int $quality (0: Blackout, 1: Wrong, 2: Hard, 3: Good, 4: Easy, 5: Perfect)
     */
    public function review(int $quality): void
    {
        $quality = max(0, min(5, $quality));

        if ($quality < 3) {
            $this->repetitions = 0;
            $this->interval_days = 1;
        } else {
            if ($this->repetitions === 0) {
                $this->interval_days = 1;
            } elseif ($this->repetitions === 1) {
                $this->interval_days = 6;
            } else {
                $this->interval_days = (int) round($this->interval_days * $this->ease_factor);
            }
            $this->repetitions++;
        }

        // Tính toán lại Ease Factor
        $this->ease_factor = max(1.3, $this->ease_factor + (0.1 - (5 - $quality) * (0.08 + (5 - $quality) * 0.02)));
        $this->due_date = now()->addDays($this->interval_days);
        $this->save();
    }
}
