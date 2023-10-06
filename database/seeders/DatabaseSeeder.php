<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Pais;
use App\Models\User;
use App\Models\Turma;
use App\Models\Cidade;
use App\Models\Estado;
use App\Models\Pessoa;
use App\Models\Documento;
use App\Models\Matricula;
use App\Models\Deficiencia;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //User::factory(10)->create();
        //Deficiencia::factory(2)->create();
        //Documento::factory(1)->create();
        //Pais::factory(1)->create();
        //Estado::factory(27)->create();
        //Cidade::factory(27)->create();
        //Pessoa::factory(27)->create();
        //Turma::factory(1)->create();
        Matricula::factory(1)->create();
    }
}
