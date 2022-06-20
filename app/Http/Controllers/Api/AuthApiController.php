<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BaseLoginApiRequest;
use App\Http\Requests\BaseRegisterApiRequest;
use App\Models\User;
use App\OpenApi\Parameters\LoginParameters;
use App\OpenApi\Parameters\RegisterParameters;
use App\OpenApi\Responses\FailedValidationResponse;
use App\OpenApi\Responses\GetUserResponse;
use App\OpenApi\Responses\LogoutUserResponse;
use App\OpenApi\Responses\NotFoundUserResponses;
use App\OpenApi\Responses\UserTokenResponse;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;
use Illuminate\Http\Request;

#[OpenApi\PathItem]

class AuthApiController extends Controller
{
    /**
     * output user data
     * @return JsonResponse
     * @return Responsable
     */
    #[OpenApi\Operation(tags: ['auth'])]
    #[OpenApi\Response(factory: GetUserResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: NotFoundUserResponses::class, statusCode: 401)]
    public function getUser(Request $request)
    {
        return $request->user();
    }

    /**
     * login user
     * @param BaseLoginApiRequest
     * @return JsonResponse
     * @return Responsable
     */
    #[OpenApi\Operation(tags: ['auth'], method: 'POST')]
    #[OpenApi\Parameters(factory: LoginParameters::class)]
    #[OpenApi\Response(factory: UserTokenResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: FailedValidationResponse::class, statusCode: 422)]
    #[OpenApi\Response(factory: NotFoundUserResponses::class, statusCode: 401)]
    public function login(BaseLoginApiRequest $request)
    {
        $data = $request->validated();

        if (Auth::attempt($data, true)) {
            $user = Auth::user();

            $user->app_logged_in_at = Carbon::now();
            $user->save();

            $authToken = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'authToken' => $authToken,
            ]);
        }

        // Auth::attempt может вернуть ложь, если произошла ошибка валидации или пользователь не найден,
        // поэтому обработал второй вариант отдельно, может можно умнее как-то, но я не знаю :)
        return response()->json([
            $data['email'] => 'user not found or invalid password',
        ], 401);

    }

    /**
     * register user
     * @param BaseRegisterApiRequest
     * @return JsonResponse
     * @return Responsable
     */
    #[OpenApi\Operation(tags: ['auth'], method: 'POST')]
    #[OpenApi\Parameters(factory: RegisterParameters::class)]
    #[OpenApi\Response(factory: FailedValidationResponse::class, statusCode: 422)]
    #[OpenApi\Response(factory: UserTokenResponse::class, statusCode: 200)]
    public function register(BaseRegisterApiRequest $request)
    {
        $data = $request->validated();

        $user = User::query()
            ->where('email', $data['email'])
            ->first();

        if ($user) {
            $user = User::changeFromRequest($user, $data);
        } else {
            $user = User::createFromRequest($data);
        }

        $authToken = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'authToken' => $authToken,
        ]);

    }

    /**
     * logout user
     * @return JsonResponse
     * @return Responsable
     */
    #[OpenApi\Operation(tags: ['auth'], method: 'POST')]
    #[OpenApi\Response(factory: LogoutUserResponse::class, statusCode: 200)]
    public function logout(Request $request)
    {
        $user = $request->user();

        $user->currentAccessToken()->delete();

        return response()->json('Successfull logout');

    }


}
