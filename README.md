### Prerequisites

* [Docker Desktop](https://www.docker.com/products/docker-desktop)
* [Windows Subsystem for Linux 2](https://docs.microsoft.com/en-us/windows/wsl/install-win10)
* [Ubuntu](https://www.microsoft.com/nl-be/p/ubuntu/9nblggh4msv6)

### Installation

1. Clone repo in Ubuntu
    ```sh
    git clone git@github.com:Jadabyte/Webtech-Backend_reseller-site.git
    ```
2. Install Composer dependencies
    ```sh
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v $(pwd):/opt \
        -w /opt \
        laravelsail/php80-composer:latest \
        composer install --ignore-platform-reqs
    ```
3. Configure Bash alias
    ```sh
    alias sail='bash vendor/bin/sail'
    ```
4. Start Docker containers
    ```sh
    sail up
    ```
5. Install npm packages
    ```sh
    sail npm install
    ```
6. Compile assets
    ```sh
    sail npm run dev
    ```
7. Run migrations
    ```sh
    sail php artisan migrate
    ```
8. Run seeders for product categories
    ```sh
    sail php artisan db:seed --class=ProductCategorySeeder
    ```
