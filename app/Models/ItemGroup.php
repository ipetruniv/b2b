<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class ItemGroup extends Model
{
    /** 
     * The attributes that are mass assignable.
     *
     * @var array
     */
  
    protected $table = 'items_group';
    protected $fillable = [ 'items_group_code_1c','name', 'code_1c_parent', 'url' ];
    public $timestamps  = false;

     /**
     * 
     * @param object $xml
     * @return object
     */
    public function createItemGroup($xml) 
    {   
        return  $this->create([
            'items_group_code_1c' => $xml->code_1c,
            'name'    =>$xml->name,  
            'code_1c_parent' => $xml->code_1c_parent,
            'url' => $this->Transite($xml->name),
        ]); 
      
    } 
    
    /**
     * @param object $xml
     * @return object
     */
    public function updateItemGroup($xml) 
    {
        return $this->where('items_group_code_1c', '=', (string)$xml->code_1c)->update([
            'name' =>(string)$xml->name, 
            'code_1c_parent' => (string)$xml->code_1c_parent
        ]);
    }
    
     /**
     * @param string $code
     * @return boolean
     */
    public function IsIssetItemGroup($code)
    {
        return  $this->where('items_group_code_1c', '=', (string)$code)->first();
    }
    
    
     public function Transite($string)
    {
        $roman = ["Sch","sch",'Yo','Zh','Kh','Ts','Ch','Sh','Yu','Ya','yo','zh','kh','ts','ch','sh','yu','ya',
                  'A','B','V','G','D','E','Z','I','Y','K','L','M','N','O','P','R','S','T','U','F','','Y','','E',
                  'a','b','v','g','d','e','z','i','y','k','l','m','n','o','p','r','s','t','u','f','','y','','e',
                  '-',"«","»", "№", "Ӏ" ,"’", "ˮ" , "'" , "`" ,"^", "\.", "," , ":","<",">", "!", "_",
                ];
        $cyrillic = ["Щ","щ",'Ё','Ж','Х','Ц','Ч','Ш','Ю','Я','ё','ж','х','ц','ч','ш','ю','я','А','Б','В','Г','Д',
                     'Е','З','І','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Ь','И','Ъ','Э','а','б','в','г','д','е',
                     'з','і','й','к','л','м','н','о','п','р','с','т','у','ф','ь','и','ъ','э', 
                      ' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ','-'];
        return str_replace($cyrillic, $roman, $string);

    }
    
    
    

}
