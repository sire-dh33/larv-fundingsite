<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;

class CampaignController extends Controller
{
    public function random($count)
    {
        $campaigns = Campaign::select('*')->inRandomOrder()->limit($count)->get();
        
        $data['campaigns'] = $campaigns;

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Campaign has been displayed successfully',
            'data' => $data,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg',
            'address' => 'required',
            'required' => 'required',
            'collected'=> 'required',

        ]);

        $campaign = Campaign::create([
            'title' => $request->title,
            'description' => $request->description,
            'address' => $request->address,
            'required' => $request->required,
            'collected' => $request->collected,
            
            // Kepedulian terhadap lingkungan sekitar adalah salah satu bentuk kepedulian sosial yang dapat diwujudkan oleh siapa saja.
            // Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus in magna ac tellus fringilla eleifend.
            // This provides a convenient way to test a Laravel application without having installed a "real" web server software here.
        ]);

        if ($request->hasFile('image'))
        {
            $image = $request->file('image');
            $image_extension = $image->getClientOriginalExtension();
            $image_name = $campaign->id . "." . $image_extension;
            $image_folder =  '/photos/campaign/';
            $image_location = $image_folder . $image_name;
            
            try {
                $image->move(public_path($image_folder) , $image_name);

                $campaign->update([
                    'image' => $image_location,
                ]);
            } catch (\Exception $e) {
                $data['campaign'] = $campaign;
                
                return response()->json([
                    'response_code' => '01',
                    'response_message' => 'Failed to upload Campaign image',
                    'data' => $data,
                ], 200);
            }
            
            $data['campaign'] = $campaign;

            return response()->json([
                'response_code' => '00',
                'response_message' => 'Campaign has been added successfully',
                'data' => $data,
            ], 200);
        }

    }

    public function index()
    {
        $campaigns = Campaign::paginate(6);

        $data['campaigns'] = $campaigns;

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Campaigns has been displayed successfully',
            'data' => $data,

        ], 200);
    }

    public function detail($id)
    {
        $campaign = Campaign::find($id);

        $data['campaign'] = $campaign;

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Campaign data has been displayed successfully',
            'data' => $data,

        ], 200);
    }

}
