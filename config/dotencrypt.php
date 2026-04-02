<?php

return [
    'env_files' => explode(",", env('DOTENCRYPT_ENV_FILES', [".env,.env.production"])),
];