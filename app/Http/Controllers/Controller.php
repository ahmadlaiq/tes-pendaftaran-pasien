<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Sistem Pendaftaran Pasien API",
    version: "1.0.0",
    description: "Dokumentasi RESTful API untuk Sistem Pendaftaran Pasien Klinik/Puskesmas."
)]
#[OA\Server(
    url: "http://localhost/api",
    description: "Local Server"
)]
#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    scheme: "bearer",
    bearerFormat: "JWT"
)]
abstract class Controller
{
    //
}
