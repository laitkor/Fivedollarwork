<?php
/**
 * Wrapper for Memcache, v. 0.3
 *
 * By Jiri Kupiainen (http://jirikupiainen.com/)
 *
 * You are free to do whatever you please with this code. Enjoy.
 */
class CakeMemcache {
        var $_connected = false;
        var $_Memcache = null;

        var $servers = array('contestsoftware.stpi.com:11212'); // you can add more servers by adding their hostname and port to this array. if port is default (11211), it can be omitted.

        /**
         * Connect to the memcached server(s)
         */
        function _connect() {
                if (defined('DISABLE_CACHE')) {
                        return false;
                }

                $this->_Memcache =& new Memcache();

                // several servers - use addServer
                foreach ($this->servers as $server) {
                        $parts = explode(':', $server);

                        $host = $parts[0];
                        $port = ife(isset($parts[1]), $parts[1], 11211); // default port

                        if ($this->_Memcache->addServer($host, $port)) {
                                $this->_connected = true;
                        }
                }

                return $this->_connected;
        }

        /**
         * Set a value in the cache
         *
         * Expiration time is one hour if not set
         */
        function set($key, $var, $expires = 3600) {
                if (defined('DISABLE_CACHE') || !$this->_connected) {
                        return false;
                }

                if (!is_numeric($expires)) {
                        $expires = strtotime($expires);
                }
                if ($expires < 1) {
                        $expires = 1; // don't allow caching infinitely
                }

                return $this->_Memcache->set($key, $var, 0, time()+$expires);
        }

        /**
         * Get a value from cache
         */
        function get($key) {
                if (defined('DISABLE_CACHE') || !$this->_connected) {
                        return false;
                }

                return $this->_Memcache->get($key);
        }

        /**
         * Remove value from cache
         */
        function delete($key) {
                if (defined('DISABLE_CACHE') || !$this->_connected) {
                        return false;
                }

                return $this->_Memcache->delete($key);
        }
}
?> 