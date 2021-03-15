<h1 align="center">
  FACEBOOK BOT REACTION
</h1>
<h4 align="center">
  Is a simple bot reaction for facebook.
</h4>
<div align="center">
  <a href="https://github.com/dz-id">
    <img alt="Last Commit" src="https://img.shields.io/github/last-commit/dz-id/laravel-facebook-reaction-bot.svg"/>
  </a>
  <a href="https://github.com/dz-id">
    <img alt="Language" src="https://img.shields.io/github/languages/count/dz-id/laravel-facebook-reaction-bot.svg"/>
  </a>
  <a href="https://github.com/dz-id">
    <img alt="Top Language" src="https://img.shields.io/github/languages/top/dz-id/laravel-facebook-reaction-bot.svg"/>
  </a>
  <a href="https://github.com/dz-id">
    <img alt="Search" src="https://img.shields.io/github/search/dz-id/fb-bot/laravel-facebook-reaction-bot.svg"/>
  </a>
  <a href="https://github.com/dz-id">
    <img alt="Repo Size" src="https://img.shields.io/github/repo-size/dz-id/laravel-facebook-reaction-bot.svg"/>
  </a>
  <a href="https://github.com/dz-id">
    <img alt="Starts" src="https://img.shields.io/github/stars/dz-id/laravel-facebook-reaction-bot.svg"/>
  </a>
  <a href="https://github.com/dz-id">
    <img alt="Forks" src="https://img.shields.io/github/forks/dz-id/laravel-facebook-reaction-bot.svg"/>
  </a>
  <a href="https://github.com/dz-id">
    <img alt="PHP 7.X" src="https://img.shields.io/badge/PHP-73.X-success.svg"/>
  </a>
  <a href="https://github.com/dz-id">
    <img alt="PHP CURL" src="https://img.shields.io/badge/PHP%20CURL-ALL-success.svg"/>
  </a>
</div>
<p align="center">
  Made with ❤️ by <a href="https://github.com/dz-id">DulLah</a>
</p>

Demo : [https://bot.dz-tools.my.id](https://bot.dz-tools.my.id)

## Instalasi
* Langkah pertama clone repo
>```git clone https://github.com/dz-id/laravel-facebook-reaction-bot```
* Masuk ke folder repo
>```cd laravel-facebook-reaction-bot```
* Install semua dependencies dengan [Composer](https://getcomposer.org)
>```composer install```
* Hapus semua compile cache pada aplikasi
>```php artisan optimize:clear```
* Jalankan migrasi Database (<b>Jangan lupa setel koneksi database di file .env sebelum migrasi</b>)
>```php artisan migrate```
* Mulai server Lokal
>```php artisan serve```
* Sekarang anda dapat mengakses server [http://localhost:8000](http://localhost:8000)

## Jalankan BOT
Ada 2 cara untuk menjalankan bot dengan ```CLI``` dan ```Cron Jobs```
Sangat disarankan menggunakan ```Cron Jobs``` Jika sudah di deploy ke server.

##### Menggunakan CLI
* Anda perlu menjalankan Job queue dengan perintah
* ```php artisan queue:work```
* Setelah menjalankan ```queue:work```, selanjutnya bukan tab baru dan jalankan perintah
* ```php artisan bot:run --delay-minute=5```
* Maksud dari ```--delay-minute=5``` artinya bot di eksekusi setiap 5 menit sekali silahkan sesuaikan sendiri ya untuk 2 perintah diatas tidak boleh ditutup biarkan dia tetap jalan dan pastinya Kamu harus terhubung selalu ke internet Ya.

##### Menggunakan Cron Jobs
* Kamu perlu mengaktifkan cron jobs setiap 1 menit sekali dengan perintah
* ``` /usr/local/bin/php /path/laravel-facebook-reaction-bot/artisan schedule:run >> /dev/null 2>&1```
* Perintah diatas hanyalah contoh saja, silakan sesuaikan sendiri dengan lokasi script kamu Ya
* Secara default bot akan dieksekusi setiap 5 menit untuk mengubahnya masuk ke file <b>app/Console/Karnel.php</b> dan edit bagian ```$schedule->command("bot:register")->everyFiveMinutes(); ``` maksud dari <b>everyFiveMinutes()</b> artinya hanya dapat dijalankan setiap 5 menit, kamu dapat mengubahnya sesuka hati cek dekomentasi [Laravel Schedule](https://laravel.com/docs/8.x/scheduling#schedule-frequency-options) untuk lebih lengkapnya.
