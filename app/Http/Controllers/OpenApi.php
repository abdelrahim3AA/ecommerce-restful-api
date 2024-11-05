<?php


namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="E-commerce API",
 *         description="API documentation for the E-commerce platform"
 *     ),
 *     @OA\Components(
 *         @OA\SecurityScheme(
 *             securityScheme="passport",
 *             type="http",
 *             scheme="bearer",
 *             bearerFormat="JWT",
 *             description="Please enter the token in the format **Bearer {token}**"
 *         )
 *     )
 * )
 */
class OpenApi
{
    // This class is intentionally left empty. 
    // The annotations above will be read by Swagger.
}
