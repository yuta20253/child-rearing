<?php

namespace App\Docs;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="My API",
 *     version="1.0.0",
 *     description="APIドキュメントの説明"
 * )
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST
 * )
 *
 * @OA\Get(
 *     path="/example",
 *     summary="Example endpoint",
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 */
class Swagger
{
}
