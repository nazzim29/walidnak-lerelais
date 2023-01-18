<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entretien extends Model
{
    use HasFactory;
    protected $fillable = [
        "type",
        "formation_relisee",
        "employee_id",
        "precision_formation",
        "certification_relisee",
        "precision_certification",
        "autre_relisee",
        "precision_autre",
        "progression_relisee",
        "precision_progression",
        "aspiration_court",
        "aspiration_court_observation",
        "aspiration_moyen",
        "aspiration_moyen_observation",
        "atouts_freins",
        "atouts_freins_observation",
        "future_formation",
        "future_formation_dispositif",
        "future_formation_modalite",
        "future_formation_date",
        "future_certification",
        "future_certification_dispositif",
        "future_certification_modalite",
        "future_certification_date",
        "future_progression",
        "future_progression_dispositif",
        "future_progression_modalite",
        "future_progression_date",
        "cpf",
        "cpf_abondement",
        "cep",
        "conclusion_employee",
        "conclusion_superieur",
    ];
    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
