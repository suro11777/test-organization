<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     version="1.0",
 *     title="API Documentation",
 * ),
 * @OA\Server(
 *     url="/api",
 * ),
 * @OA\SecurityScheme(
 *     securityScheme="Sanctum",
 *     type="http",
 *     scheme="bearer",
 * ),
 * @OA\Tag(
 *     name="Building",
 * ),
 * @OA\Tag(
 *     name="Organization",
 * ),
 */
abstract class Controller
{
    //
}
