<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function item(){
        return $this->belongsTo(Item::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeUser($query,$value){
        return $query->where('user_id',$value);
    }

    public function scopeItem($query,$value){
        return $query->where('item_id',$value);
    }



}
