<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restock extends Model
{
    use SoftDeletes;

    protected $table = 'restock';
    protected $fillable = ['item_id', 'sub_item', 'quantity'];


    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function subitems()
    {
        return $this->belongsTo(SubItem::class, 'sub_item');
    }
    
}
