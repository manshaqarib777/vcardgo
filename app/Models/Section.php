<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class Section extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * This function 
     *
     * @author      Md. Al-Mahmud <mamun120520@gmail.com>
     * @version     1.0
     * @see         
     * @since       06/26/2022
     * Time         14:56:27
     * @param       
     * @return      
     */
    public function permissions() {
		  return $this->hasMany(Permission::class,'section_id','id');
    }
    #end

}
