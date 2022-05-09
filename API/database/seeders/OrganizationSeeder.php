<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Organization;
use App\Models\Module;
use DateTime;
use DateInterval;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('organizations')->delete();
        $organization = new Organization;
        $organization->name = 'Dulceres';
        $organization->image_url = '/ficticious_place.jpg';
        $organization->save();
        $modules = Module::all();
        $licenses = $modules->map(function($module) {
            $expires = new DateTime();
            $expires->add(new DateInterval('P10Y'));
            return [
                'module_id' => $module->id,
                'expires' => $expires
            ];
        });
        $organization->updateLicenses($licenses);
    }
}
