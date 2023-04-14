<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

       //Relationshpis one to many (reverse)

        public function pet()
        {
            return $this->belongsTo(Pet::class);
        }

        public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function service()
        {
            return $this->belongsTo(Service::class);
        }
}
