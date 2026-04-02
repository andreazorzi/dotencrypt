<?php

namespace Dotencrypt\Commands;

use Illuminate\Console\Command;
use Dotencrypt\Helper\Encryptor;
use Dotencrypt\Helper\IO;

class Encrypt extends Command
{
    protected $signature = 'dotencrypt:encrypt {files?*}';
    protected $description = 'This command will encrypt your env files';
    
    private $path = 'storage/env';
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function handle()
    {
        do{
            $key = $this->secret('Enter encryption key');
        } while (empty($key));
        
        $files = $this->argument('files') ?: config("dotencrypt.env_files");
        
        dd($files);
        
        foreach ($files as $file) {
            if(!file_exists($file)) continue;
            
            $content = IO::readFile($file);
            $hash = hash('sha256', $content);
            
            $encrypted = Encryptor::encrypt($content, $key);
            
            IO::writeFile($this->path."/$file.encrypted", json_encode([
                'hash' => $hash,
                'time' => time(),
                'content' => $encrypted
            ]));
            
            $this->line("Encrypting $file: <fg=green>encrypted!</>");
        }
        
        $this->newLine();
        $this->info('Encryption finished!');
    }
}