<?php
/**
 * Class in charge of loading the needed class definitions across the whole project
 * Thus avoiding to include each time we create a new class object
 * To make it work, the folder where the class are needs to be defined manually. See _autoload $dir =array()
 */
class Autoload
{
        private static $_instance = null;

        public static function load()
    {
        if(null !== self::$_instance) {
            throw new RuntimeException(sprintf('%s is already started', __CLASS__));
        }

        self::$_instance = new self();


        if(!spl_autoload_register(array(self::$_instance, '_autoload'), false)) {
            throw RuntimeException(sprintf('%s : Could not start the autoload', __CLASS__));
        }
    }

        public static function shutDown()
    {
        if(null !== self::$_instance) {

            if(!spl_autoload_unregister(array(self::$_instance, '_autoload'))) {
                throw new RuntimeException('Could not stop the autoload');
            }

            self::$_instance = null;
        }
    }

        private static function _autoload($class)
    {
        $filename = $class.'.php';
        $dir =array('model/','./','config/','DAO/', 'metier/', 'controller/', 'tools/');
        foreach ($dir as $d){
        $file=$d.$filename; 
        //echo $file;
        if (file_exists($file))
        {
            include $file;
        }
        }
    
    }
}