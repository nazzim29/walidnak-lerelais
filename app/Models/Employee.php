<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'first_name',
        'date_entree',
        'emploi',
        'sexe',
        'contrat',
        'last_name',
        'birth_date',
        'date_hired',
        'phone_number',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function fullNameAttribute(){
        return $this->first_name." ".$this->last_name;
    }
    public function entretiens(){
        return $this->hasMany(Entretien::class);
    }
}
