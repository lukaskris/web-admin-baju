<?php

namespace App\Models;

use Encore\Admin\Facades\Admin;
use Illuminate\Database\Eloquent\Model;

class SubItem extends Model
{
    protected $table = 'sub_item';
    protected $fillable = ['size', 'color', 'quantity'];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function restocks()
    {
        return $this->hasMany(Restock::class);
    }

    public function brothers(){
        return $this->item->subitems();
    }

    public static function options($id)
    {
        if (!$self = static::find($id)) {
          return [];
        }

        return $self->brothers()->pluck('size','id');
    }
}