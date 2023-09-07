<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\NewContact;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{

    public function store(Request $request){
        $data = $request->all();

        $validation = Validator::make($data,
            [
                'name' => 'required, max: 60',
                'email' => 'required, max: 50',
                'message' => 'required',
            ]);

        if ( $validation->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validation->errors(),
            ]);
        }

        $lead = Lead::create($data);
        Mail::to('emaildigino@gmail.com')->send( new NewContact($lead));

        return response()->json([
            'success' => true
        ]);

    }
}
