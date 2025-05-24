<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'birth_date',
        'notes'
    ];

    protected $casts = [
        'birth_date' => 'date'
    ];

    // Accesseur pour le nom complet
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    // Calculer l'âge
    public function getAgeAttribute()
    {
        return $this->birth_date->age;
    }

    // Calculer les jours jusqu'au prochain anniversaire
    public function getDaysUntilBirthdayAttribute()
    {
        $today = Carbon::today();
        $birthday = $this->birth_date->copy()->year($today->year);

        if ($birthday->isPast()) {
            $birthday->addYear();
        }

        return $today->diffInDays($birthday);
    }

    // Vérifier si c'est l'anniversaire aujourd'hui
    public function getIsBirthdayTodayAttribute()
    {
        return $this->birth_date->format('m-d') === Carbon::today()->format('m-d');
    }

    // Scope pour les anniversaires du mois
    public function scopeBirthdaysThisMonth($query)
    {
        return $query->whereMonth('birth_date', Carbon::now()->month);
    }

    // Scope pour les anniversaires d'aujourd'hui
    public function scopeBirthdaysToday($query)
    {
        return $query->whereMonth('birth_date', Carbon::today()->month)
            ->whereDay('birth_date', Carbon::today()->day);
    }
}
