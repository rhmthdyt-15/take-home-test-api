# Laravel REST API

Sebuah implementasi REST API menggunakan Laravel 10, MySQL, dan Docker untuk manajemen pengguna dan pencarian data.

## Persyaratan Proyek

-   PHP 8.0+
-   Composer
-   MySQL
-   Laravel 10
-   Docker

## Fitur

-   Autentikasi pengguna menggunakan Laravel Sanctum
-   Operasi CRUD untuk manajemen pengguna
-   Pencarian data real-time dari API eksternal
-   Rute yang dilindungi dengan autentikasi

## Endpoint

### Autentikasi

-   `POST /api/login` - Login menggunakan email dan password

### Manajemen Pengguna

-   `GET /api/users` - Mengambil semua data pengguna
-   `POST /api/users` - Membuat pengguna baru
-   `GET /api/users/{id}` - Mengambil data pengguna berdasarkan ID
-   `PUT /api/users/{id}` - Memperbarui data pengguna
-   `DELETE /api/users/{id}` - Menghapus pengguna

### Pencarian Data

-   `GET /api/data?nama={nama}` - Mencari data berdasarkan nama
-   `GET /api/data?nim={nim}` - Mencari data berdasarkan NIM
-   `GET /api/data?ymd={ymd}` - Mencari data berdasarkan tanggal (format YMD)

## Langkah-Langkah Instalasi

1. Clone repositori ini:

    ```bash
    git https://github.com/rhmthdyt-15/take-home-test-api.git
    cd auth-data-api
    ```

2. Install dependensi:

    ```bash
    composer install
    ```

3. Atur file environment:

    ```bash
    php artisan key:generate
    ```

4. Jalankan migrasi dan seeder (harus dijalankan dari dalam container):

    ```bash
    docker-compose exec app php artisan migrate
    docker-compose exec app php artisan db:seed --class=UserSeeder
    ```

5. Menjalankan Server:

    ```bash
    docker-compose up
    ```

6. Akses aplikasi di browser:

    ```
    http://localhost:8000
    ```

7. Akses PhpMyAdmin di browser:
    ```
    http://localhost:8080
    ```

## Pengujian API

Anda dapat menguji API menggunakan Postman atau Swagger. Import file `Laravel REST API.postman_collection.json` ke dalam Postman.

### Kredensial Pengguna Uji

-   Email: admin@example.com
-   Password: password
