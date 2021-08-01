@servers(['prod' => ['jadabyte@139.162.142.231']])

@task('deploy', ['on' => 'prod'])
    cd /home/jadabyte/app
    git pull origin master
    composer install --optimize-autoloader --no-dev
    php artisan cache:clear
    php artisan view:cache
    php artisan optimize
@endtask