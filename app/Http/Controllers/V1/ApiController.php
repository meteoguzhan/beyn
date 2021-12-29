<?php

    namespace App\Http\Controllers\V1;

    use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    use Illuminate\Foundation\Bus\DispatchesJobs;
    use Illuminate\Foundation\Validation\ValidatesRequests;
    use Illuminate\Routing\Controller as BaseController;
    use Symfony\Component\HttpFoundation\Response;
    use Illuminate\Http\JsonResponse;

    class ApiController extends BaseController
    {
        use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

        public function success($message = null, $data = []): JsonResponse
        {
            if (is_null($message)) {
                $message = __('Successful');
            }

            return response()->json([
                'code' => Response::HTTP_OK,
                'message' => $message,
                'data' => $data
            ], Response::HTTP_OK);
        }

        public function error($message = null): JsonResponse
        {
            if (is_null($message)) {
                $message = __('Error');
            }

            return response()->json([
                'code' => Response::HTTP_FORBIDDEN,
                'message' => $message
            ], Response::HTTP_FORBIDDEN);
        }
    }
