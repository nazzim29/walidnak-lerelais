<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entretiens', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum("type",[
                "bilan", "pro"
            ]);
            $table->boolean("formation_relisee")->default(false);
            $table->string("precision_formation")->nullable();
            $table->boolean("certification_relisee")->default(false);
            $table->string("precision_certification")->nullable();
            $table->boolean("autre_relisee")->default(false);
            $table->string("precision_autre")->nullable();
            $table->boolean("progression_relisee")->default(false);
            $table->string("precision_progression")->nullable();
            $table->text("aspiration_court")->nullabe();
            $table->text("aspiration_court_observation")->nullabe();
            $table->text("aspiration_moyen")->nullabe();
            $table->text("aspiration_moyen_observation")->nullabe();
            $table->text("atouts_freins")->nullabe();
            $table->text("atouts_freins_observation")->nullabe();
            $table->string("future_formation")->nullable();
            $table->string("future_formation_dispositif")->nullable();
            $table->string("future_formation_modalite")->nullable();
            $table->date("future_formation_date")->nullable();
            $table->string("future_certification")->nullable();
            $table->string("future_certification_dispositif")->nullable();
            $table->string("future_certification_modalite")->nullable();
            $table->date("future_certification_date")->nullable();
            $table->string("future_autre")->nullable();
            $table->string("future_autre_dispositif")->nullable();
            $table->string("future_autre_modalite")->nullable();
            $table->date("future_autre_date")->nullable();
            $table->string("future_progression")->nullable();
            $table->string("future_progression_dispositif")->nullable();
            $table->string("future_progression_modalite")->nullable();
            $table->date("future_progression_date")->nullable();
            $table->boolean("cpf")->default(false);
            $table->boolean("cpf_abondement")->default(false);
            $table->boolean("cep")->default(false);
            $table->text("conclusion_employee")->nullable();
            $table->text("conclusion_superieur")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entretiens');
    }
};
