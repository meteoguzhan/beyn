<?php

    namespace App\Models\V1;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;

    class Order extends Model
    {
        use HasFactory, SoftDeletes;

        protected $guarded = [];

        public function car(): BelongsTo
        {
            return $this->belongsTo(Car::class);
        }

        public function service(): BelongsTo
        {
            return $this->belongsTo(Service::class);
        }

        public function user(): BelongsTo
        {
            return $this->belongsTo(User::class);
        }
    }
