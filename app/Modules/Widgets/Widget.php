<?php

namespace App\Modules\Widgets;

class Widget 
{
    protected $widgets;
    
    public function __construct()
    {
        $this->widgets = config("widgets"); 
    }
  
    public function show($obj, $data =[])
    { 
      
        //Есть ли такой виджет
        if(isset($this->widgets[$obj])) {

            //создаем его объект передавая параметры в конструктор
            $obj = new $this->widgets[$obj]($data);
 
           //возвращаем результат выполнения
           return $obj->execute();
        }
 
    }
    
}