<?php
 namespace App\Modules; 
 use Blade;

 /*Сервіс для підключення модулів*/ 
 
 class ModulesServiceProvider extends \Illuminate\Support\ServiceProvider 
 { 
   
    public function boot() 
    {  
        Blade::directive('widget', function ($name) {
            return "<?php echo app('widget')->show($name); ?>";
        });

        $this->loadViewsFrom(__DIR__.'/'.'Catalog'.'/Widgets/View', 'Widgets');
        $this->loadViewsFrom(__DIR__.'/'.'Order'.'/Widgets/View', 'Widgets');
        $this->loadViewsFrom(__DIR__.'/'.'Search'.'/Widgets/View', 'Widgets');

       
        // отримуємо список всіх модулів для підключення
        $modules = config("module.modules"); 
        if($modules) { 
            while (list(,$module) = each($modules)) { 
                //Підключення роутів
                if(file_exists(__DIR__.'/'.$module.'/Routes/routes.php')) { 
                    $this->loadRoutesFrom(__DIR__.'/'.$module.'/Routes/routes.php');
                }
                //Завантажуємо View
                //view('Test::admin');
                if(is_dir(__DIR__.'/'.$module.'/Views')) {
                    $this->loadViewsFrom(__DIR__.'/'.$module.'/Views', $module);
                }
                //Міграції
                if(is_dir(__DIR__.'/'.$module.'/Migration')) {
                    $this->loadMigrationsFrom(__DIR__.'/'.$module.'/Migration');
                }
                
                //Переводи
                //trans('Test::messages.welcome')
                //if(is_dir(__DIR__.'/'.$module.'/Lang')) {
                    //$this->loadTranslationsFrom(__DIR__.'/'.$module.'/Lang', $module);
                //}
            }
        }
    }

    public function register() 
    {
         \App::singleton('widget', function(){
            return new \App\Modules\Widgets\Widget();
          }); 

    }
 }