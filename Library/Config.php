<?php
    namespace Lollipop;

    /**
     * Lollipop Config Class
     *
     * @version     1.0
     * @author      John Aldrich Bernardo
     * @email       4ldrich@protonmail.com
     * @package     Lollipop
     *
     */
    class Config
    {
        /**
         * @type    array   Configuration settings
         *
         */
        static private $_config = array();

        /**
         * Add configuration
         * 
         * @access  public
         * @param   string  $key    Configuration key
         * @param   string  $value  Configuration value
         * @return  void
         * 
         */
        static public function add($key, $value) {
            self::$_config[$key] = $value;
        }
        
        /**
         * Get configuration
         * 
         * @access  public
         * @param   string  $key    Configuration key
         * @return  mixed
         * 
         */
        static public function get($key) {
            return isset(self::$_config[$key]) ? self::$_config[$key] : null;
        }
        
        /**
         * Remove configuration
         * 
         * @access  public
         * @param   string  $key    Configuration key
         * @return  void
         * 
         */
        static public function remove($key) {
            unset(self::$_config[$key]);
        }
    }
    
?>
