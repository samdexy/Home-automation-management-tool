<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Category;

/**
 * Class Device
 *
 * @package App
 * @property string $title
*/
class Device extends Model
{
    protected $fillable = ['name','alias','device_id', 'category_id'];
    protected $hidden = [];
    

    public function categories() {
        return $this->belongsTo(Category::class);
    }
}
