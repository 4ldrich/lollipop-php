<?php

namespace Lollipop;

/**
 * Simple page Caching
 *
 * @version     3.0.5
 * @author      John Aldrich Bernardo
 * @email       4ldrich@protonmail.com
 * @package     Lollipop 
 * 
 */
class Cache
{
    /**
     * Checks cache folder
     *
     * @access  private
     * @return  void
     *
     */
    static private function _checkFolder() {
        if (!is_dir(self::_getStoragePath())) {
            throw new \Exception('Can\'t find app/cache folder');
        }
        
        if (!is_writable(self::_getStoragePath())) {
            throw new \Exception('Permission denied for app/cache');
        }
    }
    
    /**
     * Cache janitor
     *
     * @access  private
     * @param   string  $key    Cache key
     * @return  void
     * 
     */
    static private function _janitor($key) {
        $fn = self::_getStoragePath() . sha1($key);
        
        if (file_exists($fn)) {
            $contents = file_get_contents($fn);
            
            if (!base64_decode($contents, true)) {
                unlink($fn);
                return;
            }

            $data = unserialize(base64_decode($contents, true));

            if (isset($data['date_created']) && isset($data['ttl']) && isset($data['data'])) {
                if (time() - (int)$data['date_created'] >= $data['ttl']) {
                    unlink($fn);
                }
            } else {
                unlink($fn);
            }
        }
    }
    
    /**
     * Storage Path
     * 
     * @access  private
     * @return  string
     * 
     */
    static private function _getStoragePath() {
        return (is_object(\Lollipop\Config::get('cache')) && isset(\Lollipop\Config::get('cache')->folder)) ? rtrim(\Lollipop\Config::get('cache')->folder, '/') . '/' : LOLLIPOP_STORAGE_CACHE;
    }
    
    /**
     * Check if cache exists
     *
     * @access  public
     * @param   string  $key    Cache key
     * @return  bool
     *
     */
    static public function exists($key) {
        self::_checkFolder();
        self::_janitor($key);
        
        return file_exists(self::_getStoragePath() . sha1($key));
    }
    
    /**
     * Save cache
     *
     * @access  public
     * @param   string  $key    Cache key
     * @param   mixed   $data   Data to be saved
     * @param   bool    $force  Force to override old data
     * @param   int     $ttl    Time-to-leave (default to 24 Hrs)
     * @return  void
     *
     */
    static public function save($key, $data, $force = false, $ttl = 1440) {
        self::_checkFolder();
        
        $ttl = $ttl * 60; // Minutes to Seconds
        
        if (!self::exists($key) || $force) {
            $data = array(
                'date_created' => time(),
                'ttl' => $ttl,
                'data' => $data
            );
            
            file_put_contents(self::_getStoragePath() . sha1($key), base64_encode(serialize($data)));
        }
    }
    
    /**
     * Recover cache
     * 
     * @access  public
     * @param   string  $key    Cache key
     * @return  mixed
     *
     */
    static public function recover($key) {
        self::_checkFolder();
        
        if (self::exists($key)) {
            $contents = file_get_contents(self::_getStoragePath() . sha1($key));
            
            if (base64_decode($contents, true)) {
                $data = unserialize(base64_decode($contents, true));
            
                return isset($data['data']) ? $data['data'] : '';
            }
        }
        
        return '';
    }
    
    /**
     * Remove cache
     *
     * @access  public
     * @param   string  $key
     * @return  bool
     *
     */
    static public function remove($key) {
        self::_checkFolder();
        
        $cache = self::_getStoragePath() . sha1($key);
        
        if (file_exists($cache)) {
            return unlink($cache);
        }
        
        return false;
    }
    
    /**
     * Remove all cache
     *
     * @access  public
     * @return  void
     *
     */
    static public function purge() {
        self::_checkFolder();
        
        // Get all files from the cache folder
        $contents = glob(self::_getStoragePath() . '*');

        // Remove cache files
        foreach ($contents as $content) {
            if (is_file($content)) {
                unlink($content);
            }
        }
    }
}

?>
