<?php

return [
    'env_files' => explode(",", env('DOTENCRYPT_ENV_FILES', ".env,.env.production")),
    'strong_password' => env('DOTENCRYPT_STRONG_PASSWORD', true)
];