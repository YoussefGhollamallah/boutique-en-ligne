 <?php

class myAutoload
{
    public static function start () 
    {

        spl_autoload_register([__CLASS__, 'autoload']);

        $root = $_SERVER['DOCUMENT_ROOT'];
        $host = $_SERVER['HTTP_HOST'];

        define('HOST', 'http://' . $host . '/boutique-en-ligne/');
        define('ROOT', $root . '/boutique-en-ligne/');

        define('CONTROLLER', ROOT . 'src/controllers/');
        define('VIEW', ROOT . 'src/views/');
        define('MODEL', ROOT . 'src/models/');
        define('CLASSES', ROOT . 'classes/');
        define ('CONFIG', ROOT . 'config/');

        define('ASSETS', HOST . 'assets/');
    }

    public static function autoload($class)
    {
        if(file_exists(MODEL . $class . '.php'))
        {
            include_once MODEL . $class . '.php';
        } 
        
        elseif (file_exists(CLASSES . $class . '.php'))
        {
            include_once CLASSES . $class . '.php';
        } 

        elseif (file_exists(CONTROLLER . $class . '.php'))
        {
            include_once CONTROLLER . $class . '.php';
        }
        elseif (file_exists(CONFIG . $class . '.php'))
        {
            include_once CONFIG . $class . '.php';
        }
        else 
        {
            throw new Exception("Class $class not found.");
        }
    }
}

?>