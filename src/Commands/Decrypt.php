<?php

namespace Dotencrypt\Commands;

use Illuminate\Console\Command;
use Dotencrypt\Helper\Encryptor;
use Dotencrypt\Helper\IO;

class Decrypt extends Command
{
    protected $signature = 'dotencrypt:decrypt {files?*}';
    protected $description = 'This command will create a laravel model';
    
    private $path = 'storage/env';
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function handle()
    {
        do{
            $key = $this->secret('Enter decryption key');
        } while (empty($key));
        
        $files = $this->argument('files') ?: IO::getFiles($this->path);
        
        foreach ($files as $file) {
            if(!file_exists($this->path."/".$file.'.encrypted')) continue;
            
            echo "Decrypting $file: ";
            
            $content = json_decode(IO::readFile($this->path."/$file.encrypted"), true);
            
            $decrypted = Encryptor::decrypt($content['content'], $key);
            
            if ($decrypted === null) {
                $this->line("<fg=red>decryption failed!</>");
                continue;
            }
            
            IO::writeFile("$file", $decrypted);
            $this->info("decrypted successfully!");
        }
        
        $this->newLine();
        $this->info('Decription finished!');
    }
}