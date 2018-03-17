<?php 
namespace App\Modules\Widgets\Contract;

interface ContractWidget {
  
  /** 
    * 
    *  Основний метод будь-якого віджета, який повинен повертати вивід шаблону:
    *  return view('Widgets::NameWidget', [
    *  'data' => $data
    *  ]);
    */
  
  
  public function execute();
}