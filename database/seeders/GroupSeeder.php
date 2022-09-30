<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $group1 = new Group();
        $group1->name = "Profesores";
        $group1->save();

        $group2 = new Group();
        $group2->name = "Alumnos";
        $group2->save();
    }
}
