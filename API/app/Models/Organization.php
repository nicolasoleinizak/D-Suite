<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\License;

class Organization extends Model
{
    use HasFactory;

    public function updateLicenses($licenses){
        foreach($licenses as $license){
            $new_license = License::updateOrCreate(
                ['module_id' => $license['module_id'], 'organization_id' => $this->id],
                ['expires' => $license['expires']]
            );
        }
    }
}
