<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DvlaController extends Controller
{
    //

    public function showVehicleDetails(Request $request){

        // $registration = strtoupper($request->reg_number);

        // $data = Http::accept('application/json')
        //         ->withOptions([
        //             'verify' => env('VERIFY_SSL'),
        //         ])->withHeaders(['x-api-key' => urlencode(env('DVSA_API_KEY'))])
        //         ->get('https://beta.check-mot.service.gov.uk/trade/vehicles/mot-tests?registration=' . $registration);

        // if (isset($data['httpStatus'])) {
        //     return $data['httpStatus'];
        // } else {
        //     return $data;
        // }

        $registration = strtoupper($request->reg_number);

        $token = Http::accept('application/json')
                ->withOptions([
                    'verify' => env('VERIFY_SSL'),
                ])->withHeaders([
                    'content-type' => 'application/x-www-form-urlencoded'
                ])
                ->asForm()
                ->post(env('DVSA_TOKEN_URL'), [
                        'grant_type' => 'client_credentials',
                        'client_id' => env('DVSA_API_CLIENT_ID'),
                        'client_secret' => env('DVSA_API_CLIENT_SECRET'),
                        'scope' => env('DVSA_SCOPE_URL'),
                ])->collect();

        // Gets the vehicle details if theres Bearer authorization
        $data = Http::accept('application/json')
                    ->withOptions([
                        'verify' => env('VERIFY_SSL'),
                    ])->withHeaders([
                        'Authorization' => 'Bearer ' . $token['access_token'],
                            'x-api-key' => env('DVSA_API_KEY')
                        ])->get('https://history.mot.api.gov.uk/v1/trade/vehicles/registration/' . $registration)
                    ->collect();


        return view('admin.appointments._vehicle-information',[
            'data' => $data,
            'registration' => $registration,
        ]);

    }

    public function api($reg) {

        $response = Http::accept('application/json')
                        ->withOptions([
                            'verify' => env('VERIFY_SSL'),
                        ])->withHeaders(['x-api-key' => urlencode(env('DVSA_API_KEY'))])
                        ->get('https://beta.check-mot.service.gov.uk/trade/vehicles/mot-tests?registration=' . $reg);

        return $response;

    }



}
