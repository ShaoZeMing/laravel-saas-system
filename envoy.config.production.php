<?php
/**
 * Envoy deployment script config file
 */
/**
 * application name
 */

$app_name = 'xiuxiuxiu';

/**
 * server settings
 * conn : remote server connection string

 * owner : (optional) remote server service user/owner(group) that run the php-fpm/nginx and the application files
 * permissions.
 *
 * @example row set: 'webserver1'=>['conn'=>'-p 2222 vagrant@127.0.0.1','owner'=>'vagrant'],
 * @example row set: 'webserver2'=>['user@191.168.1.10 -p2222','user'],
 * @example row set: 'root@example.com',
 */
$server_connections = [

    'ming-01' => 'ming@47.93.0.246',
    //    'webserver1'=>['conn'=>'-p 2222 vagrant@127.0.0.1','owner'=>'vagrant'],
    //    'webserver2'=>['user@191.168.1.10 -p2222','user'],
    //    'root@example.com',
];

/**
 * @notice  http/https protocol might be ask for password for your private repos
 *  and that will break the git clone progress,use git protocol instead
 * @example 'git@localhost:user/myrepo.git'
 */
$source_repo = 'git@github.com:ShaoZeMing/laravel-saas-system.git';

$source_name = 'source';

/**
 * deployment base path
 *
 * @example '/var/www'
 */
$deploy_basepath = '/home/ming/deploy';

$php_fpm_bin = '/etc/init.d/php7.1-fpm';


/**
 * pack mode local | remote
 * local : checkout code and prepare the app code package locally,then pack and rsync/scp packed files to remote and extract on remote (good for small vps but scp cost bandwidth)
 * remote : checkout code and prepare the app code package on remote server (fast for good network connection)
 */

$pack_mode = 'remote';

/**
 * deploy mode incr | link
 * incr : sync new code to current running path (if you have lot of code and resource files in your project ,you may choose this mode)
 * link : link new release path to current running path (if you want light and quick code deployment, you may choose this mode)
 */
$deploy_mode = 'link';

/**
 * number of releases keep on remote
 */
$release_keep_count = 5;

/**
 * git sub-module deployed path map source-tree subdir-path -> sub-module deployed path.
 */
$submodule_pathmap = [
    //'lib/mymod'=>'/var/www/mysubmodproject/current',
];

/**
 * shared sub-directories name , eg: storage
 */
$shared_subdirs = [
    'bootstrap/cache',
    'storage',
];
/**
 * addon exclude pattens , eg: /node_modules/
 */
$exclude_addon_pattens = [

    $source_name . '/node_modules',
    $source_name . 'workspace/vendor',
    $source_name . 'workspace/.git',
];

/**
 * Misc. Settings
 */
$settings = [
    // default env set
    'env_default'=>'production',
    // default branch set
    'branch_default'=> 'master',
    // default remote server service user(group) that run the php-fpm/nginx and the application files permissions.
    // @example 'www-data'
    'service_owner_default'=>'www-data',
    // default server prefix for named user at host alias.
    // @example 'server'
    'server_prefix_default'=>'',
    // vcs update local workingcopy before deployment.
    'workingcopy_update'=>true,
    // depends install for local workingcopy before deployment.
    'workingcopy_deps_install'=>false,
    // use shared base app_path env file.
    'use_appbase_envfile'=>true,
    // depends install components settings.
    'deps_install_component'=> [
        'composer'=>true,
        'npm'=>true,
        'bower'=>false,
        'gulp'=>false,
    ],
    'deps_install_command'=> [
        'composer'=>'composer install --prefer-dist --no-dev --no-scripts --no-interaction && composer dump-autoload --optimize',
        'npm'=>'npm install ',
        'bower'=>'bower install',
        'gulp'=>'gulp',
    ],
    'runtime_optimize_component'=> [
        'composer'=>true,
        'artisan'=> [

            'optimize'=>true,
            'config_cache'=>true,
            'route_cache'=>true,
        ],
    ],
    'runtime_optimize_command'=> [
        'composer'=>'composer dump-autoload --optimize',
        'artisan'=> [
            'optimize'=>'php artisan clear-compiled && php artisan optimize',
            'config_cache'=>'php artisan config:clear && php artisan config:cache',
            'route_cache'=>'php artisan route:clear && php artisan route:cache',
        ],
    ],
    // do database migrate on deploy
    'databasemigrate_on_deploy'=>false,
    // allow extra custom files overwrite.
    'extracustomoverwrite_enable'=>false,
    // depends reinstall on remote release.
    'deps_reinstall_on_remote_release'=>true,
    // do database migrate rollback on rollback
    'databasemigraterollback_on_rollback'=>false,
    // enable custom task after deploy
    'enable_custom_task_after_deploy'=>true,
];
