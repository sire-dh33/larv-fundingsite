<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    public function random($count)
    {
        $blogs = Blog::select('*')->inRandomOrder()->limit($count)->get();
        
        $data['blogs'] = $blogs;

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Blogs has been displayed successfully',
            'data' => $data,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg'
        ]);

        $blog = Blog::create([
            'title' => $request->title,
            'description' => $request->description,
            
            // Kepedulian terhadap lingkungan sekitar adalah salah satu bentuk kepedulian sosial yang dapat diwujudkan oleh siapa saja.
            // Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus in magna ac tellus fringilla eleifend.
            // This provides a convenient way to test a Laravel application without having installed a "real" web server software here.
        ]);

        if ($request->hasFile('image'))
        {
            $image = $request->file('image');
            $image_extension = $image->getClientOriginalExtension();
            $image_name = $blog->id . "." . $image_extension;
            $image_folder =  '/photos/blog/';
            $image_location = $image_folder . $image_name;
            
            try {
                $image->move(public_path($image_folder) , $image_name);

                $blog->update([
                    'image' => $image_location,
                ]);
            } catch (\Exception $e) {
                $data['blog'] = $blog;
                
                return response()->json([
                    'response_code' => '01',
                    'response_message' => 'Failed to upload Blog image',
                    'data' => $data,
                ], 200);
            }
            
            $data['blog'] = $blog;

            return response()->json([
                'response_code' => '00',
                'response_message' => 'Blog has been added successfully',
                'data' => $data,
            ], 200);
        }

    }
}
