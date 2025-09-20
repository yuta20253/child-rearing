<?php

namespace App\Docs;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="子育てプロジェクト",
 *     version="1.0.0",
 *     description="子育てプロジェクトAPIドキュメント"
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
