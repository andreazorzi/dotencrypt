<?php

namespace Dotencrypt\Commands;

use Illuminate\Console\Command;
use Dotencrypt\Helper\Encryptor;
use Dotencrypt\Helper\IO;

class CheckUpdates extends Command
{
    protected $signature = 'dotencrypt:check-updates';
    protected $description = 'This command will check for env files updates';
    
    private $path = 'storage/env';
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function handle()
    {
        $files = IO::getFiles($this->path);
        
        $local_out_of_dates = [];
        $encrypted_out_of_dates = [];
        
        foreach ($files as $file) {
            $content = IO::readFile($this->path."/$file.encrypted", true);
            $env_content = IO::readFile($file);
            
            if(is_null($env_content)){
                $local_out_of_dates[] = $file;
                continue;
            }
            
            if($content["hash"] == hash('sha256', $env_content)) continue;
            
            if(IO::getLastModDate($file) < $content["time"]){
                $local_out_of_dates[] = $file;
            }
            else{
                $encrypted_out_of_dates[] = $file;
            }
        }
        
        $this->newLine();
        if(!empty($encrypted_out_of_dates)){
            $this->warn("Encrypted files out of date: ".implode(', ', $encrypted_out_of_dates));
            $this->warn("Run 'php artisan dotencrypt:encrypt' command to fix this issue");
            $this->newLine();
            $this->newLine();
        }
        
        if(!empty($local_out_of_dates)){
            $this->warn("Local files out of date: ".implode(', ', $local_out_of_dates)."");
            $this->warn("Run 'php artisan dotencrypt:decrypt' command to fix this issue");
            $this->newLine();
            $this->newLine();
        }
        
        if(empty($encrypted_out_of_dates) && empty($local_out_of_dates)){
            $this->info("All files are up to date!");
            $this->newLine();
            $this->newLine();
        }
    }
}