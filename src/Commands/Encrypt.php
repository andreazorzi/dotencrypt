<?php

namespace Dotencrypt\Commands;

use Dotencrypt\Helper\Encryptor;
use Dotencrypt\Helper\IO;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

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
            $key = $this->secret('Enter encryption key ('.(Config::get('dotencrypt.strong_password') ? 'min 8 chars, mixed case, numbers, symbols' : 'min 8 chars').')');
            
            $is_stong_enough = Encryptor::isStrongPassword($key);
            
            if (!$is_stong_enough) {
                $this->warn("<fg=yellow;options=underscore,bold>Password is not strong enough!</>");
            }
        } while (empty($key) || !$is_stong_enough);
        
        $files = $this->argument('files') ?: Config::get("dotencrypt.env_files");
        
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