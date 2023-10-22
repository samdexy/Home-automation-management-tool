<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Device;


/**
 * Class Device
 *
 * @package App
 * @property string $title
*/
class Category extends Model
{
    protected $fillable = ['name'];
    protected $hidden = [];
    

    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}
