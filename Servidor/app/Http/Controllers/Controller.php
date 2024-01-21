<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
* @OA\Info(
* title="Projecte BALEARCS-E", version="1.0",
* description="REST API. Projecte BALLEARCS-E. DAW Client i servidor.",
* @OA\Contact( name="Joan Toni.",email="joanantoniramon@paucasesnovescifp.cat")
* )
*
* @OA\Server(url="http://balearcs.dawpaucasesnoves.com/balearcs/public")
*
* @OAS\SecurityScheme(
* securityScheme="bearerAuth",
* type="http",
* scheme="bearer"
* )
*/
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
