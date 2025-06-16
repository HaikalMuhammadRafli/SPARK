<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

-   **[Vehikl](https://vehikl.com/)**
-   **[Tighten Co.](https://tighten.co)**
-   **[WebReinvent](https://webreinvent.com/)**
-   **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
-   **[64 Robots](https://64robots.com)**
-   **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
-   **[Cyber-Duck](https://cyber-duck.co.uk)**
-   **[DevSquad](https://devsquad.com/hire-laravel-developers)**
-   **[Jump24](https://jump24.co.uk)**
-   **[Redberry](https://redberry.international/laravel/)**
-   **[Active Logic](https://activelogic.com)**
-   **[byte5](https://byte5.de)**
-   **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## ✅ Task Tracking

| Task                                                | Status     | Note                                       |
| --------------------------------------------------- | ---------- | ------------------------------------------ |
| Tampilan tabel prestasi dan aksi Edit/Hapus (admin) | ✅ Selesai | Ditampilkan di halaman `Kelola Prestasi`   |
| Ekspor data prestasi ke PDF dan Excel (admin)       | ✅ selesai | Implementasi laporan masih berjalan        |
| Mahasiswa: Tambah data prestasi (Create)            | ✅ selesai | Mahasiswa bisa input sendiri               |
| Mahasiswa: Lihat dan analisis prestasi (Read)       | ✅ selesai | Tampilan laporan belum sepenuhnya jadi     |
| Mahasiswa: Edit dan Hapus prestasi milik sendiri    | ✅ Selesai | Fitur CRUD dasar sudah tersedia            |
| Bug fixing dan validasi form input prestasi         | 🔧 Ongoing | Fokus pada UX dan validasi data            |
| Visualisasi laporan prestasi                        | 🔧 Ongoing | Fokus pada Chart dan Pengambilan data link |

---

## Authentication

-   **Authentication**: All routes require authentication using **Sanctum** tokens.
-   **Authorization**: Some routes are restricted based on the user's role:
    -   **Mahasiswa**: Requires the `authorize:mahasiswa` middleware.
    -   **Admin**: Requires the `authorize:admin` middleware.

### How to get your Authentication Token

1. **Login**:
   To access protected routes, you need to be logged in first. You can obtain a token by logging in via the **POST /login** endpoint.
    ```bash
    curl -X POST http://127.0.0.1:8000/api/login \
    -H "Content-Type: application/json" \
    -d '{"email": "your-email@example.com", "password": "your-password"}'
    ```
2. **Response**:
   After successful login, you will receive an authentication token in the response:

    ```json
    {
        "access_token": "your-access-token-here"
    }
    ```

3. **Using the Token**:
   Include the token in the `Authorization` header as `Bearer <your-access-token-here>` for all protected API requests.

---

## Example Usage with Postman

Follow these steps to test the API with **Postman**:

1. **Open Postman**.
2. **Set the Request Type** to `GET`, `POST`, `PUT`, or `DELETE` as required for the route you're testing.
3. **Set the URL** to the API endpoint (e.g., `http://127.0.0.1:8000/api/prestasi`).
4. **Add Authorization**:
    - Go to the "Authorization" tab in Postman.
    - Select **Bearer Token**.
    - Paste your token into the "Token" field.
5. **Add Headers**:
    - Set `Content-Type: application/json` for the body, if you're sending data.
6. **Send the Request**.

### Example POST Request to Add a New Prestasi

-   **Method**: `POST`
-   **URL**: `http://127.0.0.1:8000/api/prestasi`
-   **Body**: Raw JSON

```json
{
    "prestasi_juara": "Juara 1",
    "prestasi_surat_tugas_url": "http://example.com/surat_tugas",
    "prestasi_poster_url": "http://example.com/poster",
    "prestasi_foto_juara_url": "http://example.com/foto_juara",
    "prestasi_proposal_url": "http://example.com/proposal",
    "prestasi_sertifikat_url": "http://example.com/sertifikat",
    "kelompok_id": 1
}
```
