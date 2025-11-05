<?php

namespace Dotencrypt\Helper;

class IO
{
    public static function writeFile(string $path, string $content): void{
        $dir = dirname($path);
        is_dir($dir) || mkdir($dir, 0755, true);
        file_put_contents($path, $content);
    }
    
    public static function readFile(string $path): string{
        return file_get_contents($path);
    }
}