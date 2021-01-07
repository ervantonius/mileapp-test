<?php

namespace App\Http\Controllers;

use DB;
use App\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{
    public function list()
    {
        $package = Package::all();

        if (empty($package)) {
            return response()->json(['success' => true, 'message' => 'There\'s no package']);
        } else {
            return response()->json(['success' => true, 'data' => $package]);
        }
    }

    private function validation(Request $request, $required = 'required|')
    {
        $rules = [
            'customer_name'                 => $required.'min:1|max:100|string',
            'customer_address'              => $required.'min:1|string',
            'customer_email'                => 'email',
            'customer_phone'                => $required.'string',
            'customer_address_detail'       => 'string',
            'customer_zip_code'             => $required.'string',
            'customer_zone_code'            => $required.'string',
            'destination_name'              => $required.'min:1|max:100|string',
            'destination_address'           => $required.'min:1|string',
            'destination_email'             => 'email',
            'destination_phone'             => $required.'string',
            'destination_address_detail'    => 'string',
            'destination_zip_code'          => $required.'string',
            'destination_zone_code'         => $required.'string',
            'amount'                        => $required.'min:1|numeric',
            'discount'                      => 'numeric',
            'catatan_tambahan'              => 'string',
        ];

        $input_data = [];
        foreach ($rules as $_input_data => $__)
        {
            $input_data[] = $_input_data;
        }

        $input = $request->only($input_data);
        $validation = Validator::make($input, $rules);

        if ($validation->fails()) {
            return response()->json(['success' => true, 'message' => $validation->errors()], 500);
        }

        return $input;
    }

    public function store(Request $request)
    {
        $input = $this->validation($request);
        if (is_object($input)) {
            return $input;
        }

        if (is_array($input)) {
            $package = Package::create($input);

            return response()->json(['success' => true, 'data' => $package]);
        }

        return response()->json(['success' => false, 'message' => 'There\'s something wrong when created package'], 500);
    }

    public function detail($id)
    {
        $package = Package::find($id);

        if (empty($package)) {
            return response()->json(['success' => true, 'message' => 'Package not found'], 404);
        } else {
            return response()->json(['success' => true, 'data' => $package]);
        }
    }

    public function put(Request $request, $id)
    {
        $package = Package::find($id);

        if (empty($package)) {
            return $this->store($request);
        } else {
            $input = $this->validation($request);
            if (is_object($input)) {
                return $input;
            }

            $package->update($input);
        }

        return response()->json(['success' => true, 'data' => $package]);
    }

    public function patch(Request $request, $id)
    {
        $package = Package::find($id);
        if (empty($package)) {
            return response()->json(['success' => true, 'message' => 'Package not found'], 404);
        }
        
        $input = $this->validation($request, '');
        if (is_object($input)) {
            return $input;
        }

        $package->update($input);

        return response()->json(['success' => true, 'data' => $package]);
    }

    public function destroy($id)
    {
        $package = Package::find($id);
        
        if (empty($package)) {
            return response()->json(['success' => true, 'message' => 'Package not found'], 404);
        }
        
        $package->delete();

        return response()->json(['success' => true, 'message' => 'Package deleted']);
    }
}
