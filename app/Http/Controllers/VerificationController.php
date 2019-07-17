<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse as Response;

class VerificationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param string $token
     * @return Response
     */
    public function __invoke(string $token): Response
    {
        if (strlen($token) === 120) {
            $account = DB::table('accounts')
                ->where('token', $token)
                ->update([
                    'email_verified_at' => Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())
                ]);
            // return redirect('http://localhost:8080/login', 301);
            // dd($account);
            // if ($account) {
            //
            //     return response()->json('Succesfully verified account.', 200);
            // }
        } else {
            dd('error');
        }
    }
}
