<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'item';

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subitems()
    {
        return $this->hasMany(SubItem::class, 'item_id');
    }

    public function restocks()
    {
        return $this->hasMany(Restock::class, 'item_id');
    }

    public function setImagesAttribute($images)
    {
        if (is_array($images)) {
            $this->attributes['images'] = json_encode($images);
        }
    }

    public function getImagesAttribute($images)
    {
        return json_decode($images, true);
    }
}
