<?php

namespace Dotencrypt\Helper;

class IO
{
    public static function writeFile(string $path, string $content): bool{
        $dir = dirname($path);
        is_dir($dir) || mkdir($dir, 0755, true);
        return file_put_contents($path, $content) !== false;
    }
    
    public static function readFile(string $path, bool $json = false): string|array|null{
        if(!file_exists($path)) return null;
        
        $content = file_get_contents($path);
        
        if($json){
            $content = json_decode($content, true);
        }
        
        return $content;
    }
    
    public static function getFiles(string $path): array{
        $files = [];
        
        foreach(scandir($path) as $filename){
            if(is_file($path . '/' . $filename) && preg_match('/(.*).encrypted$/i', $filename, $matches)) $files[] = $matches[1];
        }
        
        return $files;
    }
    
    public static function getLastModDate(string $path): int{
        return filemtime($path);
    }
}