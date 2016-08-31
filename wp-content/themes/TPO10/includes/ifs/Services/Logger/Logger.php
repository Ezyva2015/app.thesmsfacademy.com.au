<?php
    class Logger {
        static public $path;
        
        /*
         * Write a message to the log
         *
         * @param   string  $message
         * @return  void
         */
        static public function write($message, $terminate = FALSE)
        {
            if ( ! self::$path)
            {
                self::$path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'log.txt';
            }
            
            $message = '[' . date("D M j G:i:s T Y") . ']'
                       . PHP_EOL .
                       $message
                       . PHP_EOL . PHP_EOL;
            
            $fh = fopen(self::$path, 'a');
            fwrite($fh, $message);
            fclose($fh);
            
            if ($terminate)
            {
                exit();
            }
        }
        
        static public function setPath($path)
        {
            self::$path = $path;
        }
        
        static public function getPath()
        {
            return self::$path;
        }
    }
