<?php

namespace Deployer;

require 'recipe/common.php';

set('application', 'oneredpaperclip-waaseyaa');
set('keep_releases', 5);
set('allow_anonymous_stats', false);

set('shared_dirs', ['storage']);
set('shared_files', ['.env']);
set('writable_dirs', ['storage']);

host('production')
    ->setHostname('147.182.150.145')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '/home/deployer/oneredpaperclip-waaseyaa')
    ->set('labels', ['stage' => 'production']);

desc('Upload pre-built release artifact from CI');
task('deploy:upload', function (): void {
    upload('.build/', '{{release_path}}/', [
        'options' => ['--recursive', '--compress'],
    ]);
});

desc('Create storage symlink in public directory');
task('deploy:storage-link', function (): void {
    run('ln -sfn {{deploy_path}}/shared/storage/app/public {{release_path}}/public/storage');
});

desc('Reload PHP-FPM to pick up new release');
task('php-fpm:reload', function (): void {
    run('sudo systemctl reload php8.4-fpm');
});

desc('Deploy oneredpaperclip to production');
task('deploy', [
    'deploy:info',
    'deploy:setup',
    'deploy:lock',
    'deploy:release',
    'deploy:upload',
    'deploy:shared',
    'deploy:writable',
    'deploy:storage-link',
    'deploy:symlink',
    'deploy:unlock',
    'deploy:cleanup',
    'php-fpm:reload',
]);

after('deploy:failed', 'deploy:unlock');
