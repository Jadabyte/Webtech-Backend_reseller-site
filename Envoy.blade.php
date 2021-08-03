@servers(['prod' => ['jadabyte@fantasticfox.chickenkiller.com']])

@task('deploy', ['on' => 'prod'])
    cd /home/jadabyte/app
    git pull origin main
    php composer.phar install --optimize-autoloader --no-dev
    php artisan cache:clear
    php artisan view:cache
    php artisan optimize
@endtask