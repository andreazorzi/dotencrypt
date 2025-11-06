# DotEncrypt 🔐
[![Latest Version on Packagist](https://img.shields.io/packagist/v/andreazorzi/dotencrypt.svg?style=flat-square)](https://packagist.org/packages/andreazorzi/dotencrypt)
[![Total Downloads](https://img.shields.io/packagist/dt/andreazorzi/dotencrypt.svg?style=flat-square)](https://packagist.org/packages/andreazorzi/dotencrypt)

A Laravel multi-env encryptor for secure team sharing.

## Installation
```bash
composer require andreazorzi/dotencrypt
```

## Requirements
- PHP 8.0+
- Illuminate/Console

## Usage

### Encrypt
```bash
php artisan dotencrypt:encrypt {files?*}
```
If no file is specified, the command will search for `.env` and `.env.production` by default.
Once launched, the command will prompt for an encryption password, then encrypt the selected env files in the `storage/env` folder.

### Decrypt
```bash
php artisan dotencrypt:decrypt {files?*}
```
If no file is specified, the command will search for `.env` and `.env.production` by default in the `storage/env` folder.
Once launched, the command will prompt for the decryption password, then decrypt the selected encrypted files and restore them to their original location.
If the decryption password does not match the encryption password, an error will be shown in the console.

# Check Updates
```bash
php artisan dotencrypt:check-updates
```
This command compares all encrypted files in the `storage/env` folder with their local counterparts to detect synchronization issues.

### Behavior
- Hashes match: No action needed, files are in sync
- Local file missing or local file is older: Suggests running decrypt to restore the latest version
- Local file is newer: Suggests running encrypt to update the encrypted version

This helps keep your team's environment files synchronized and prevents accidental overwrites.

## License
MIT License