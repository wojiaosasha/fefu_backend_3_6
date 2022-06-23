<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriesResource;
use App\Models\ProductCategory;
use App\OpenApi\Responses\AllCategoriesResponse;
use App\OpenApi\Responses\ShowCategoriesResponse;
use App\OpenApi\Responses\NotFoundResponse;
use Illuminate\Contracts\Support\Responsable;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class CategoriesApiController extends Controller
{
    /**
     * Display categories.
     *
     * @return Responsable
     */
    #[OpenApi\Operation(tags: ['catalog'],  method: 'GET')]
    #[OpenApi\Response(factory: AllCategoriesResponse::class, statusCode: 200)]
    public function index( )
    {
        return CategoriesResource::collection(
            ProductCategory::all()
        );
    }


    /**
     * Display Categories through slug.
     *
     * @param string $slug
     * @return Responsable
     */
    #[OpenApi\Operation(tags: ['catalog'],  method: 'GET')]
    #[OpenApi\Response(factory: ShowCategoriesResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    public function show(string $slug)
    {
        return new CategoriesResource(
            ProductCategory::query()->where('slug', $slug)->firstOrFail()
        );
    }

}
