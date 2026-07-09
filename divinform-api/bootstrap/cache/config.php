<?php return array (
  'view' => 
  array (
    'paths' => 
    array (
      0 => '/var/www/clients/client0/web105/web/divinform/divinform-api/resources/views',
    ),
    'compiled' => '/var/www/clients/client0/web105/web/divinform/divinform-api/storage/framework/views',
  ),
  'concurrency' => 
  array (
    'default' => 'process',
  ),
  'services' => 
  array (
    'postmark' => 
    array (
      'token' => NULL,
    ),
    'resend' => 
    array (
      'key' => NULL,
    ),
    'ses' => 
    array (
      'key' => NULL,
      'secret' => NULL,
      'region' => 'us-east-1',
    ),
    'slack' => 
    array (
      'notifications' => 
      array (
        'bot_user_oauth_token' => NULL,
        'channel' => NULL,
      ),
    ),
  ),
  'broadcasting' => 
  array (
    'default' => 'log',
    'connections' => 
    array (
      'reverb' => 
      array (
        'driver' => 'reverb',
        'key' => NULL,
        'secret' => NULL,
        'app_id' => NULL,
        'options' => 
        array (
          'host' => NULL,
          'port' => 443,
          'scheme' => 'https',
          'useTLS' => true,
        ),
        'client_options' => 
        array (
        ),
      ),
      'pusher' => 
      array (
        'driver' => 'pusher',
        'key' => NULL,
        'secret' => NULL,
        'app_id' => NULL,
        'options' => 
        array (
          'cluster' => NULL,
          'host' => 'api-mt1.pusher.com',
          'port' => 443,
          'scheme' => 'https',
          'encrypted' => true,
          'useTLS' => true,
        ),
        'client_options' => 
        array (
        ),
      ),
      'ably' => 
      array (
        'driver' => 'ably',
        'key' => NULL,
      ),
      'log' => 
      array (
        'driver' => 'log',
      ),
      'null' => 
      array (
        'driver' => 'null',
      ),
    ),
  ),
  'app' => 
  array (
    'name' => 'Ferme Divinform',
    'env' => 'production',
    'debug' => false,
    'url' => 'https://admin.divinform.com',
    'frontend_url' => 'https://divinform.com',
    'asset_url' => NULL,
    'timezone' => 'Africa/Douala',
    'locale' => 'fr',
    'fallback_locale' => 'fr',
    'faker_locale' => 'fr_FR',
    'cipher' => 'AES-256-CBC',
    'key' => 'base64:XeiHvL89rNYV30XGxlngO4D78yenVgtTUtddUsa1CQg=',
    'previous_keys' => 
    array (
    ),
    'maintenance' => 
    array (
      'driver' => 'file',
      'store' => 'database',
    ),
    'providers' => 
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Cookie\\CookieServiceProvider',
      6 => 'Illuminate\\Database\\DatabaseServiceProvider',
      7 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      8 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      9 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      10 => 'Illuminate\\Hashing\\HashServiceProvider',
      11 => 'Illuminate\\Mail\\MailServiceProvider',
      12 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      13 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      14 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      15 => 'Illuminate\\Queue\\QueueServiceProvider',
      16 => 'Illuminate\\Redis\\RedisServiceProvider',
      17 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      18 => 'Illuminate\\Session\\SessionServiceProvider',
      19 => 'Illuminate\\Translation\\TranslationServiceProvider',
      20 => 'Illuminate\\Validation\\ValidationServiceProvider',
      21 => 'Illuminate\\View\\ViewServiceProvider',
      22 => 'App\\Providers\\AppServiceProvider',
      23 => 'Tymon\\JWTAuth\\Providers\\LaravelServiceProvider',
    ),
    'aliases' => 
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Arr' => 'Illuminate\\Support\\Arr',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'Date' => 'Illuminate\\Support\\Facades\\Date',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Http' => 'Illuminate\\Support\\Facades\\Http',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'Str' => 'Illuminate\\Support\\Str',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'JWTAuth' => 'Tymon\\JWTAuth\\Facades\\JWTAuth',
      'JWTFactory' => 'Tymon\\JWTAuth\\Facades\\JWTFactory',
    ),
  ),
  'auth' => 
  array (
    'defaults' => 
    array (
      'guard' => 'api',
      'passwords' => 'users',
    ),
    'guards' => 
    array (
      'web' => 
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
      'api' => 
      array (
        'driver' => 'jwt',
        'provider' => 'users',
      ),
    ),
    'providers' => 
    array (
      'users' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Models\\User',
      ),
    ),
    'passwords' => 
    array (
      'users' => 
      array (
        'provider' => 'users',
        'table' => 'password_reset_tokens',
        'expire' => 60,
        'throttle' => 60,
      ),
    ),
    'password_timeout' => 10800,
  ),
  'cache' => 
  array (
    'default' => 'file',
    'stores' => 
    array (
      'array' => 
      array (
        'driver' => 'array',
        'serialize' => false,
      ),
      'session' => 
      array (
        'driver' => 'session',
        'key' => '_cache',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'connection' => NULL,
        'table' => 'cache',
        'lock_connection' => NULL,
        'lock_table' => NULL,
      ),
      'file' => 
      array (
        'driver' => 'file',
        'path' => '/var/www/clients/client0/web105/web/divinform/divinform-api/storage/framework/cache/data',
        'lock_path' => '/var/www/clients/client0/web105/web/divinform/divinform-api/storage/framework/cache/data',
      ),
      'memcached' => 
      array (
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' => 
        array (
          0 => NULL,
          1 => NULL,
        ),
        'options' => 
        array (
        ),
        'servers' => 
        array (
          0 => 
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'cache',
        'lock_connection' => 'default',
      ),
      'dynamodb' => 
      array (
        'driver' => 'dynamodb',
        'key' => NULL,
        'secret' => NULL,
        'region' => 'us-east-1',
        'table' => 'cache',
        'endpoint' => NULL,
      ),
      'octane' => 
      array (
        'driver' => 'octane',
      ),
      'failover' => 
      array (
        'driver' => 'failover',
        'stores' => 
        array (
          0 => 'database',
          1 => 'array',
        ),
      ),
    ),
    'prefix' => 'ferme_divinform_cache_',
  ),
  'cors' => 
  array (
    'paths' => 
    array (
      0 => 'api/*',
      1 => 'sanctum/csrf-cookie',
    ),
    'allowed_methods' => 
    array (
      0 => '*',
    ),
    'allowed_origins' => 
    array (
      0 => 'https://divinform.com',
    ),
    'allowed_origins_patterns' => 
    array (
    ),
    'allowed_headers' => 
    array (
      0 => '*',
    ),
    'exposed_headers' => 
    array (
    ),
    'max_age' => 0,
    'supports_credentials' => false,
  ),
  'database' => 
  array (
    'default' => 'mysql',
    'connections' => 
    array (
      'sqlite' => 
      array (
        'driver' => 'sqlite',
        'url' => NULL,
        'database' => 'c0divinform',
        'prefix' => '',
        'foreign_key_constraints' => true,
        'busy_timeout' => NULL,
        'journal_mode' => NULL,
        'synchronous' => NULL,
      ),
      'mysql' => 
      array (
        'driver' => 'mysql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'c0divinform',
        'username' => 'c0div9376',
        'password' => '123@bc9Z',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'mariadb' => 
      array (
        'driver' => 'mariadb',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'c0divinform',
        'username' => 'c0div9376',
        'password' => '123@bc9Z',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'pgsql' => 
      array (
        'driver' => 'pgsql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'c0divinform',
        'username' => 'c0div9376',
        'password' => '123@bc9Z',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'search_path' => 'public',
        'sslmode' => 'prefer',
      ),
      'sqlsrv' => 
      array (
        'driver' => 'sqlsrv',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'c0divinform',
        'username' => 'c0div9376',
        'password' => '123@bc9Z',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
      ),
    ),
    'migrations' => 
    array (
      'table' => 'migrations',
      'update_date_on_publish' => true,
    ),
    'redis' => 
    array (
      'client' => 'phpredis',
      'options' => 
      array (
        'cluster' => 'redis',
        'prefix' => 'ferme_divinform_database_',
      ),
      'default' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'username' => NULL,
        'password' => NULL,
        'port' => '6379',
        'database' => '0',
      ),
      'cache' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'username' => NULL,
        'password' => NULL,
        'port' => '6379',
        'database' => '1',
      ),
    ),
  ),
  'filesystems' => 
  array (
    'default' => 'public',
    'disks' => 
    array (
      'local' => 
      array (
        'driver' => 'local',
        'root' => '/var/www/clients/client0/web105/web/divinform/divinform-api/storage/app/private',
        'throw' => false,
      ),
      'public' => 
      array (
        'driver' => 'local',
        'root' => '/var/www/clients/client0/web105/web/divinform/divinform-api/storage/app/public',
        'url' => 'https://admin.divinform.com/storage',
        'visibility' => 'public',
        'throw' => false,
      ),
      's3' => 
      array (
        'driver' => 's3',
        'key' => NULL,
        'secret' => NULL,
        'region' => NULL,
        'bucket' => NULL,
        'url' => NULL,
        'endpoint' => NULL,
        'use_path_style_endpoint' => false,
        'throw' => false,
      ),
    ),
    'links' => 
    array (
      '/var/www/clients/client0/web105/web/divinform/divinform-api/public/storage' => '/var/www/clients/client0/web105/web/divinform/divinform-api/storage/app/public',
    ),
  ),
  'hashing' => 
  array (
    'driver' => 'bcrypt',
    'bcrypt' => 
    array (
      'rounds' => '12',
      'verify' => true,
    ),
    'argon' => 
    array (
      'memory' => 65536,
      'threads' => 1,
      'time' => 4,
      'verify' => true,
    ),
    'rehash_on_login' => true,
  ),
  'jwt' => 
  array (
    'secret' => 'nWPY9beHEOxvFjbolH8cuSswjNVHm2XhP8yZSocx5iAe9wXi5rjAmLeHhPLlMAhg',
    'keys' => 
    array (
      'public' => NULL,
      'private' => NULL,
      'passphrase' => NULL,
    ),
    'ttl' => 1440,
    'refresh_ttl' => 20160,
    'algo' => 'HS256',
    'required_claims' => 
    array (
      0 => 'iss',
      1 => 'iat',
      2 => 'exp',
      3 => 'nbf',
      4 => 'sub',
      5 => 'jti',
    ),
    'persistent_claims' => 
    array (
    ),
    'lock_subject' => true,
    'leeway' => 0,
    'blacklist_enabled' => true,
    'blacklist_grace_period' => 0,
    'decrypt_cookies' => false,
    'providers' => 
    array (
      'jwt' => 'Tymon\\JWTAuth\\Providers\\JWT\\Lcobucci',
      'auth' => 'Tymon\\JWTAuth\\Providers\\Auth\\Illuminate',
      'storage' => 'Tymon\\JWTAuth\\Providers\\Storage\\Illuminate',
    ),
    'show_black_list_exception' => false,
  ),
  'logging' => 
  array (
    'default' => 'stack',
    'deprecations' => 
    array (
      'channel' => NULL,
      'trace' => false,
    ),
    'channels' => 
    array (
      'stack' => 
      array (
        'driver' => 'stack',
        'channels' => 
        array (
          0 => 'single',
        ),
        'ignore_exceptions' => false,
      ),
      'single' => 
      array (
        'driver' => 'single',
        'path' => '/var/www/clients/client0/web105/web/divinform/divinform-api/storage/logs/laravel.log',
        'level' => 'error',
        'replace_placeholders' => true,
      ),
      'daily' => 
      array (
        'driver' => 'daily',
        'path' => '/var/www/clients/client0/web105/web/divinform/divinform-api/storage/logs/laravel.log',
        'level' => 'error',
        'days' => 14,
        'replace_placeholders' => true,
      ),
      'slack' => 
      array (
        'driver' => 'slack',
        'url' => NULL,
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'error',
        'replace_placeholders' => true,
      ),
      'papertrail' => 
      array (
        'driver' => 'monolog',
        'level' => 'error',
        'handler' => 'Monolog\\Handler\\SyslogUdpHandler',
        'handler_with' => 
        array (
          'host' => NULL,
          'port' => NULL,
          'connectionString' => 'tls://:',
        ),
        'processors' => 
        array (
          0 => 'Monolog\\Processor\\PsrLogMessageProcessor',
        ),
      ),
      'stderr' => 
      array (
        'driver' => 'monolog',
        'level' => 'error',
        'handler' => 'Monolog\\Handler\\StreamHandler',
        'formatter' => NULL,
        'with' => 
        array (
          'stream' => 'php://stderr',
        ),
        'processors' => 
        array (
          0 => 'Monolog\\Processor\\PsrLogMessageProcessor',
        ),
      ),
      'syslog' => 
      array (
        'driver' => 'syslog',
        'level' => 'error',
        'facility' => 8,
        'replace_placeholders' => true,
      ),
      'errorlog' => 
      array (
        'driver' => 'errorlog',
        'level' => 'error',
        'replace_placeholders' => true,
      ),
      'null' => 
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\NullHandler',
      ),
      'emergency' => 
      array (
        'path' => '/var/www/clients/client0/web105/web/divinform/divinform-api/storage/logs/laravel.log',
      ),
    ),
  ),
  'mail' => 
  array (
    'default' => 'smtp',
    'mailers' => 
    array (
      'smtp' => 
      array (
        'transport' => 'smtp',
        'url' => NULL,
        'host' => 'smtp.gmail.com',
        'port' => '465',
        'encryption' => 'ssl',
        'username' => 'mabenguejunior@gmail.com',
        'password' => 'bayc ldei jvnn amxx',
        'timeout' => NULL,
        'local_domain' => 'admin.divinform.com',
      ),
      'ses' => 
      array (
        'transport' => 'ses',
      ),
      'postmark' => 
      array (
        'transport' => 'postmark',
      ),
      'resend' => 
      array (
        'transport' => 'resend',
      ),
      'sendmail' => 
      array (
        'transport' => 'sendmail',
        'path' => '/usr/sbin/sendmail -bs -i',
      ),
      'log' => 
      array (
        'transport' => 'log',
        'channel' => NULL,
      ),
      'array' => 
      array (
        'transport' => 'array',
      ),
      'failover' => 
      array (
        'transport' => 'failover',
        'mailers' => 
        array (
          0 => 'smtp',
          1 => 'log',
        ),
      ),
      'roundrobin' => 
      array (
        'transport' => 'roundrobin',
        'mailers' => 
        array (
          0 => 'ses',
          1 => 'postmark',
        ),
      ),
    ),
    'from' => 
    array (
      'address' => 'contact@divinform.com',
      'name' => 'Ferme Divinform',
    ),
    'markdown' => 
    array (
      'theme' => 'default',
      'paths' => 
      array (
        0 => '/var/www/clients/client0/web105/web/divinform/divinform-api/resources/views/vendor/mail',
      ),
      'extensions' => 
      array (
      ),
    ),
  ),
  'queue' => 
  array (
    'default' => 'sync',
    'connections' => 
    array (
      'sync' => 
      array (
        'driver' => 'sync',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'connection' => NULL,
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
        'after_commit' => false,
      ),
      'beanstalkd' => 
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => 0,
        'after_commit' => false,
      ),
      'sqs' => 
      array (
        'driver' => 'sqs',
        'key' => NULL,
        'secret' => NULL,
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'default',
        'suffix' => NULL,
        'region' => 'us-east-1',
        'after_commit' => false,
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => NULL,
        'after_commit' => false,
      ),
      'deferred' => 
      array (
        'driver' => 'deferred',
      ),
      'failover' => 
      array (
        'driver' => 'failover',
        'connections' => 
        array (
          0 => 'database',
          1 => 'deferred',
        ),
      ),
    ),
    'batching' => 
    array (
      'database' => 'mysql',
      'table' => 'job_batches',
    ),
    'failed' => 
    array (
      'driver' => 'database-uuids',
      'database' => 'mysql',
      'table' => 'failed_jobs',
    ),
  ),
  'session' => 
  array (
    'driver' => 'file',
    'lifetime' => '120',
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => '/var/www/clients/client0/web105/web/divinform/divinform-api/storage/framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'store' => NULL,
    'lottery' => 
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'ferme_divinform_session',
    'path' => '/',
    'domain' => NULL,
    'secure' => NULL,
    'http_only' => true,
    'same_site' => 'lax',
    'partitioned' => false,
  ),
  'site_settings' => 
  array (
    'groups' => 
    array (
      'branding' => 'Identité & logo',
      'contact' => 'Coordonnées',
      'social' => 'Réseaux sociaux',
      'hero' => 'Accueil — Bannière',
      'stats' => 'Accueil — Chiffres clés',
      'formations' => 'Accueil — Nos formations',
      'sections' => 'Accueil — Titres de sections',
      'why' => 'Accueil — Pourquoi nous',
      'footer' => 'Pied de page',
      'seo' => 'SEO (référencement)',
    ),
    'settings' => 
    array (
      'site_name' => 
      array (
        'group' => 'branding',
        'label' => 'Nom du site',
        'type' => 'text',
        'default' => 'C.F Divin Élevage',
        'rules' => 'nullable|string|max:100',
        'public' => true,
      ),
      'company_name' => 
      array (
        'group' => 'branding',
        'label' => 'Raison sociale',
        'type' => 'text',
        'default' => 'Centre de Formation Divin Élevage',
        'rules' => 'nullable|string|max:150',
        'public' => true,
      ),
      'logo_emoji' => 
      array (
        'group' => 'branding',
        'label' => 'Logo (emoji)',
        'type' => 'text',
        'default' => '🎓',
        'rules' => 'nullable|string|max:16',
        'public' => true,
        'help' => 'Emoji affiché dans le logo si aucune image n\'est fournie.',
      ),
      'logo_image_url' => 
      array (
        'group' => 'branding',
        'label' => 'Logo (URL image)',
        'type' => 'image',
        'default' => '',
        'rules' => 'nullable|string|max:300',
        'public' => true,
        'help' => 'Si renseignée, remplace l\'emoji par une image.',
      ),
      'tagline' => 
      array (
        'group' => 'branding',
        'label' => 'Slogan court (sous le logo)',
        'type' => 'text',
        'default' => 'Centre de formation en élevage',
        'rules' => 'nullable|string|max:120',
        'public' => true,
      ),
      'slogan' => 
      array (
        'group' => 'branding',
        'label' => 'Slogan principal',
        'type' => 'text',
        'default' => 'La forge des leaders pour un élevage sain',
        'rules' => 'nullable|string|max:200',
        'public' => true,
      ),
      'phone1' => 
      array (
        'group' => 'contact',
        'label' => 'Téléphone 1',
        'type' => 'text',
        'default' => '060337821',
        'rules' => 'nullable|string|max:30',
        'public' => true,
      ),
      'phone2' => 
      array (
        'group' => 'contact',
        'label' => 'Téléphone 2',
        'type' => 'text',
        'default' => '076328536',
        'rules' => 'nullable|string|max:30',
        'public' => true,
      ),
      'whatsapp' => 
      array (
        'group' => 'contact',
        'label' => 'Numéro WhatsApp',
        'type' => 'text',
        'default' => '060337821',
        'rules' => 'nullable|string|max:30',
        'public' => true,
        'help' => 'Format national (060337821) ou international (+241 60 33 78 21). Le zéro initial est retiré automatiquement pour le lien wa.me.',
      ),
      'email' => 
      array (
        'group' => 'contact',
        'label' => 'Adresse email',
        'type' => 'email',
        'default' => 'divinformelevage@gmail.com',
        'rules' => 'nullable|email|max:120',
        'public' => true,
      ),
      'website' => 
      array (
        'group' => 'contact',
        'label' => 'Site web',
        'type' => 'text',
        'default' => 'www.divinform.com',
        'rules' => 'nullable|string|max:120',
        'public' => true,
      ),
      'address' => 
      array (
        'group' => 'contact',
        'label' => 'Adresse (ligne 1)',
        'type' => 'text',
        'default' => 'C.F Divin Élevage',
        'rules' => 'nullable|string|max:200',
        'public' => true,
      ),
      'address_detail' => 
      array (
        'group' => 'contact',
        'label' => 'Adresse (ligne 2)',
        'type' => 'text',
        'default' => 'Gabon',
        'rules' => 'nullable|string|max:200',
        'public' => true,
      ),
      'wa_msg_default' => 
      array (
        'group' => 'contact',
        'label' => 'Message WhatsApp par défaut',
        'type' => 'textarea',
        'default' => 'Bonjour, je souhaite avoir des informations sur le centre de formation.',
        'rules' => 'nullable|string|max:400',
        'public' => true,
      ),
      'wa_msg_formation' => 
      array (
        'group' => 'contact',
        'label' => 'Message WhatsApp (inscription formation)',
        'type' => 'textarea',
        'default' => 'Bonjour, je souhaite m\'inscrire à la formation : {formation}. Pouvez-vous me communiquer les modalités ?',
        'rules' => 'nullable|string|max:400',
        'public' => true,
        'help' => 'Utilisez {formation} pour insérer le titre de la formation et {session} pour la session choisie.',
      ),
      'wa_msg_product' => 
      array (
        'group' => 'contact',
        'label' => 'Message WhatsApp (produit)',
        'type' => 'textarea',
        'default' => 'Bonjour, je suis intéressé(e) par : {product}. Est-ce disponible et à quel prix ?',
        'rules' => 'nullable|string|max:400',
        'public' => true,
        'help' => 'Utilisez {product} pour insérer le nom du produit.',
      ),
      'facebook_url' => 
      array (
        'group' => 'social',
        'label' => 'Facebook',
        'type' => 'url',
        'default' => 'https://www.facebook.com/profile.php?id=61572106177650',
        'rules' => 'nullable|string|max:200',
        'public' => true,
      ),
      'tiktok_url' => 
      array (
        'group' => 'social',
        'label' => 'TikTok',
        'type' => 'url',
        'default' => 'https://www.tiktok.com/@user9655911945880',
        'rules' => 'nullable|string|max:200',
        'public' => true,
      ),
      'instagram_url' => 
      array (
        'group' => 'social',
        'label' => 'Instagram',
        'type' => 'url',
        'default' => '',
        'rules' => 'nullable|string|max:200',
        'public' => true,
      ),
      'linkedin_url' => 
      array (
        'group' => 'social',
        'label' => 'LinkedIn',
        'type' => 'url',
        'default' => '',
        'rules' => 'nullable|string|max:200',
        'public' => true,
      ),
      'youtube_url' => 
      array (
        'group' => 'social',
        'label' => 'YouTube',
        'type' => 'url',
        'default' => '',
        'rules' => 'nullable|string|max:200',
        'public' => true,
      ),
      'hero_eyebrow' => 
      array (
        'group' => 'hero',
        'label' => 'Sur-titre (badge)',
        'type' => 'text',
        'default' => 'Centre de formation en élevage',
        'rules' => 'nullable|string|max:120',
        'public' => true,
      ),
      'hero_title' => 
      array (
        'group' => 'hero',
        'label' => 'Titre — début',
        'type' => 'text',
        'default' => 'Apprenez le métier',
        'rules' => 'nullable|string|max:120',
        'public' => true,
      ),
      'hero_highlight' => 
      array (
        'group' => 'hero',
        'label' => 'Titre — mot surligné (vert)',
        'type' => 'text',
        'default' => 'd\'éleveur',
        'rules' => 'nullable|string|max:60',
        'public' => true,
      ),
      'hero_title_suffix' => 
      array (
        'group' => 'hero',
        'label' => 'Titre — suite',
        'type' => 'text',
        'default' => 'sur une vraie ferme-école',
        'rules' => 'nullable|string|max:160',
        'public' => true,
      ),
      'hero_subtitle' => 
      array (
        'group' => 'hero',
        'label' => 'Sous-titre (paragraphe)',
        'type' => 'textarea',
        'default' => 'Nos formations pratiques en élevage et en agriculture vous donnent les compétences et la confiance nécessaires pour lancer votre propre exploitation, quel que soit votre niveau de départ.',
        'rules' => 'nullable|string|max:600',
        'public' => true,
      ),
      'hero_cta_primary' => 
      array (
        'group' => 'hero',
        'label' => 'Bouton principal',
        'type' => 'text',
        'default' => '🎓 Découvrir nos formations',
        'rules' => 'nullable|string|max:60',
        'public' => true,
      ),
      'hero_cta_secondary' => 
      array (
        'group' => 'hero',
        'label' => 'Bouton secondaire',
        'type' => 'text',
        'default' => '📞 Nous contacter',
        'rules' => 'nullable|string|max:60',
        'public' => true,
      ),
      'hero_image_url' => 
      array (
        'group' => 'hero',
        'label' => 'Image de fond (URL)',
        'type' => 'image',
        'default' => 'https://divinform.com/img/agriregenerative.jpg',
        'rules' => 'nullable|string|max:400',
        'public' => true,
      ),
      'hero_card_title' => 
      array (
        'group' => 'hero',
        'label' => 'Encart — titre',
        'type' => 'text',
        'default' => 'LA FERME-ÉCOLE',
        'rules' => 'nullable|string|max:60',
        'public' => true,
      ),
      'hero_card_items' => 
      array (
        'group' => 'hero',
        'label' => 'Encart — points clés',
        'type' => 'list',
        'public' => true,
        'rules' => 'nullable|array',
        'item_label' => 'Point',
        'fields' => 
        array (
          0 => 
          array (
            'key' => 'label',
            'label' => 'Intitulé',
            'type' => 'text',
          ),
        ),
        'default' => 
        array (
          0 => 
          array (
            'label' => '🎓 Formations certifiantes',
          ),
          1 => 
          array (
            'label' => '🐄 Travaux pratiques',
          ),
          2 => 
          array (
            'label' => '📋 Accompagnement projet',
          ),
          3 => 
          array (
            'label' => '🤝 Suivi post-formation',
          ),
        ),
      ),
      'stats' => 
      array (
        'group' => 'stats',
        'label' => 'Chiffres clés (bannière)',
        'type' => 'list',
        'public' => true,
        'rules' => 'nullable|array',
        'item_label' => 'Chiffre',
        'fields' => 
        array (
          0 => 
          array (
            'key' => 'num',
            'label' => 'Valeur',
            'type' => 'text',
          ),
          1 => 
          array (
            'key' => 'label',
            'label' => 'Libellé',
            'type' => 'text',
          ),
        ),
        'default' => 
        array (
          0 => 
          array (
            'num' => '6',
            'label' => 'Formations au catalogue',
          ),
          1 => 
          array (
            'num' => '100%',
            'label' => 'Pratique sur la ferme',
          ),
          2 => 
          array (
            'num' => '15 ans',
            'label' => 'D\'expérience en élevage',
          ),
          3 => 
          array (
            'num' => '7j/7',
            'label' => 'Accompagnement',
          ),
        ),
      ),
      'formations_eyebrow' => 
      array (
        'group' => 'formations',
        'label' => 'Sur-titre',
        'type' => 'text',
        'default' => 'Notre catalogue',
        'rules' => 'nullable|string|max:120',
        'public' => true,
      ),
      'formations_title' => 
      array (
        'group' => 'formations',
        'label' => 'Titre',
        'type' => 'text',
        'default' => 'Nos formations',
        'rules' => 'nullable|string|max:160',
        'public' => true,
      ),
      'formations_subtitle' => 
      array (
        'group' => 'formations',
        'label' => 'Description',
        'type' => 'textarea',
        'default' => 'Des formations courtes, concrètes et menées sur le terrain, pour apprendre un métier et vivre de son élevage.',
        'rules' => 'nullable|string|max:400',
        'public' => true,
      ),
      'categories_eyebrow' => 
      array (
        'group' => 'sections',
        'label' => 'La ferme — sur-titre',
        'type' => 'text',
        'default' => 'Notre ferme',
        'rules' => 'nullable|string|max:120',
        'public' => true,
      ),
      'categories_title' => 
      array (
        'group' => 'sections',
        'label' => 'La ferme — titre',
        'type' => 'text',
        'default' => 'Les produits de la ferme',
        'rules' => 'nullable|string|max:160',
        'public' => true,
      ),
      'categories_subtitle' => 
      array (
        'group' => 'sections',
        'label' => 'La ferme — description',
        'type' => 'textarea',
        'default' => 'Notre ferme-école est une exploitation en activité. Les produits issus de nos ateliers pédagogiques sont proposés en vente directe.',
        'rules' => 'nullable|string|max:400',
        'public' => true,
      ),
      'contact_eyebrow' => 
      array (
        'group' => 'sections',
        'label' => 'Contact — sur-titre',
        'type' => 'text',
        'default' => 'Contactez-nous',
        'rules' => 'nullable|string|max:120',
        'public' => true,
      ),
      'contact_title' => 
      array (
        'group' => 'sections',
        'label' => 'Contact — titre',
        'type' => 'text',
        'default' => 'Une question sur nos formations ?',
        'rules' => 'nullable|string|max:160',
        'public' => true,
      ),
      'contact_subtitle' => 
      array (
        'group' => 'sections',
        'label' => 'Contact — description',
        'type' => 'textarea',
        'default' => 'Notre équipe vous renseigne sur les programmes, les dates de session et les modalités d\'inscription.',
        'rules' => 'nullable|string|max:400',
        'public' => true,
      ),
      'cta_box_title' => 
      array (
        'group' => 'sections',
        'label' => 'Encart CTA — titre',
        'type' => 'text',
        'default' => 'Prêt à vous former ?',
        'rules' => 'nullable|string|max:160',
        'public' => true,
      ),
      'cta_box_subtitle' => 
      array (
        'group' => 'sections',
        'label' => 'Encart CTA — sous-titre',
        'type' => 'textarea',
        'default' => 'Contactez-nous pour connaître les prochaines sessions et réserver votre place.',
        'rules' => 'nullable|string|max:300',
        'public' => true,
      ),
      'why_eyebrow' => 
      array (
        'group' => 'why',
        'label' => 'Sur-titre',
        'type' => 'text',
        'default' => 'Notre pédagogie',
        'rules' => 'nullable|string|max:120',
        'public' => true,
      ),
      'why_title' => 
      array (
        'group' => 'why',
        'label' => 'Titre',
        'type' => 'text',
        'default' => 'Pourquoi se former chez nous ?',
        'rules' => 'nullable|string|max:160',
        'public' => true,
      ),
      'why_subtitle' => 
      array (
        'group' => 'why',
        'label' => 'Description',
        'type' => 'textarea',
        'default' => 'Une formation qui se vit sur le terrain, transmise par des éleveurs en activité.',
        'rules' => 'nullable|string|max:400',
        'public' => true,
      ),
      'why_items' => 
      array (
        'group' => 'why',
        'label' => 'Cartes « Pourquoi nous »',
        'type' => 'list',
        'public' => true,
        'rules' => 'nullable|array',
        'item_label' => 'Carte',
        'fields' => 
        array (
          0 => 
          array (
            'key' => 'icon',
            'label' => 'Icône (emoji)',
            'type' => 'text',
          ),
          1 => 
          array (
            'key' => 'title',
            'label' => 'Titre',
            'type' => 'text',
          ),
          2 => 
          array (
            'key' => 'desc',
            'label' => 'Description',
            'type' => 'textarea',
          ),
        ),
        'default' => 
        array (
          0 => 
          array (
            'icon' => '🎓',
            'title' => 'Une ferme-école',
            'desc' => 'Vous n\'apprenez pas dans une salle : vous apprenez sur une ferme en activité, au contact des animaux.',
          ),
          1 => 
          array (
            'icon' => '👨‍🌾',
            'title' => 'Des formateurs éleveurs',
            'desc' => 'Nos formateurs vivent de leur élevage. Ils enseignent ce qu\'ils pratiquent chaque jour.',
          ),
          2 => 
          array (
            'icon' => '🔧',
            'title' => 'De la pratique avant tout',
            'desc' => 'La majorité du temps est consacrée aux travaux pratiques, pas à la théorie.',
          ),
          3 => 
          array (
            'icon' => '📋',
            'title' => 'Un projet, pas un cours',
            'desc' => 'Chaque stagiaire repart avec un plan d\'installation chiffré et adapté à ses moyens.',
          ),
          4 => 
          array (
            'icon' => '🤝',
            'title' => 'Un suivi après la formation',
            'desc' => 'Nous restons joignables pour vous accompagner dans vos premiers mois d\'activité.',
          ),
          5 => 
          array (
            'icon' => '🏅',
            'title' => 'Une attestation reconnue',
            'desc' => 'Une attestation de fin de formation vous est remise à l\'issue de chaque session.',
          ),
        ),
      ),
      'footer_about' => 
      array (
        'group' => 'footer',
        'label' => 'Texte « À propos »',
        'type' => 'textarea',
        'default' => 'Centre de formation en élevage et en agriculture. Nous formons celles et ceux qui veulent vivre de la terre, sur une ferme-école en activité.',
        'rules' => 'nullable|string|max:400',
        'public' => true,
      ),
      'copyright' => 
      array (
        'group' => 'footer',
        'label' => 'Mention copyright',
        'type' => 'text',
        'default' => '© {year} C.F Divin Élevage. Tous droits réservés.',
        'rules' => 'nullable|string|max:200',
        'public' => true,
        'help' => 'Utilisez {year} pour l\'année courante.',
      ),
      'footer_services' => 
      array (
        'group' => 'footer',
        'label' => 'Liste « Services »',
        'type' => 'list',
        'public' => true,
        'rules' => 'nullable|array',
        'item_label' => 'Service',
        'fields' => 
        array (
          0 => 
          array (
            'key' => 'label',
            'label' => 'Intitulé',
            'type' => 'text',
          ),
        ),
        'default' => 
        array (
          0 => 
          array (
            'label' => 'Formations en élevage',
          ),
          1 => 
          array (
            'label' => 'Formations en agriculture',
          ),
          2 => 
          array (
            'label' => 'Accompagnement des porteurs de projet',
          ),
          3 => 
          array (
            'label' => 'Ferme-école & travaux pratiques',
          ),
        ),
      ),
      'meta_title' => 
      array (
        'group' => 'seo',
        'label' => 'Titre de la page (onglet navigateur)',
        'type' => 'text',
        'default' => 'C.F Divin Élevage — Centre de formation en élevage au Gabon',
        'rules' => 'nullable|string|max:160',
        'public' => true,
      ),
      'meta_description' => 
      array (
        'group' => 'seo',
        'label' => 'Méta-description',
        'type' => 'textarea',
        'default' => 'Centre de formation en élevage et en agriculture au Gabon. Formations pratiques en aviculture, pisciculture, élevage porcin et cuniculture, sur une ferme-école en activité.',
        'rules' => 'nullable|string|max:300',
        'public' => true,
      ),
    ),
  ),
  'tinker' => 
  array (
    'commands' => 
    array (
    ),
    'alias' => 
    array (
    ),
    'dont_alias' => 
    array (
      0 => 'App\\Nova',
    ),
    'trust_project' => 'always',
  ),
);
