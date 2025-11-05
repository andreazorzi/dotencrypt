<?php

namespace Dotencrypt\Commands;

use Illuminate\Console\Command;
use Dotencrypt\Helper\Encryptor;
use Dotencrypt\Helper\IO;

class Encrypt extends Command
{
    protected $signature = 'dotencrypt:encrypt {files?*}';
    protected $description = 'This command will create a laravel model';
    
    private $env_files = [".env", ".env.production"];
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function handle()
    {
        $files = $this->argument('files') ?: $this->env_files;
        
        do{
            $key = $this->secret('Enter encryption key');
        } while (empty($key));
        
        foreach ($files as $file) {
            if(!file_exists($file)) continue;
            
            $content = file_get_contents($file);
            $hash = hash('sha256', $content);
            
            $encrypted = Encryptor::encrypt($content, $key);
            
            IO::writeFile("storage/env/$file.encrypted", json_encode([
                'hash' => $hash,
                'content' => $encrypted
            ]));
        }
        
        $this->info('Files encrypted successfully!');
    }
}