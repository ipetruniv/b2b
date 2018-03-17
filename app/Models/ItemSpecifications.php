<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class ItemSpecifications extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'item_specifications';
    protected $fillable = [ 'code_1c','name' ];
    public $timestamps  = false;

    /**
     *
     * @param object $xml
     * @return object
     */
    public function createItem($xml)
    {
        return  $this->create([
            'code_1c' => $xml->code_1c,
            'name' =>$xml->name
        ]);

    }

    /**
     * @param object $xml
     * @return object
     */
    public function updateItem($xml)
    {
        return $this->where('code_1c', '=', $xml->code_1c)->update([
            'name' =>$xml->name
        ]);
    }

    /**
     * @param string $code
     * @return boolean
     */
    public function IsIssetItem($code)
    {
        return  $this->where('code_1c', '=', $code)->first();
    }



}
