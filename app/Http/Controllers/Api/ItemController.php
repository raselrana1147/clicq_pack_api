<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemRequest;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ItemController extends Controller
{


    public function index()
    {
        $datas=Item::orderBy('id','DESC')->get();

        return ItemResource::collection($datas);
    }

    public function store(ItemRequest $request)
    {
        //dd($request->all());
        if ($request->isMethod("POST")){
            try {
                DB::beginTransaction();

                $item=new Item();
                $item->name=$request->name;
                $item->description=$request->description;
                $item->quantity=$request->quantity;

                if($request->hasFile('image')){
                    $manager = new ImageManager(new Driver());
                    $image=$request->file('image');
                    $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();
                    $image_path=public_path('images/item/'.$image_name);
                    $make_image = $manager->read($image);
                    $make_image=$make_image->resize(300,250);
                    $make_image->save($image_path)->toJpeg(80);
                    $item->image=$image_name;
                }
                $item->save();
                DB::commit();
                return response()->json([
                    'data'=>"Successfully created",
                    'status'=>Response::HTTP_CREATED
                ],Response::HTTP_OK);

            }catch (QueryException $exception){
                return response()->json([
                    'data'=>$exception->getMessage(),
                    'status'=>Response::HTTP_INTERNAL_SERVER_ERROR
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $item=Item::find($id);
        return ItemResource::make($item);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemRequest $request)
    {
       // dd($request->all());
        // return "okay";
        if ($request->isMethod("post")){
            try {
                DB::beginTransaction();
                $item = Item::find($request->id);
                $item->name = $request->name;
                $item->description = $request->description;
                $item->quantity = $request->quantity;

                if ($request->hasFile('image')) {

                    if (File::exists(public_path('/images/item/' . $item->image))) {
                        File::delete(public_path('/images/item/' . $item->image));
                    }

                    $manager = new ImageManager(new Driver());
                    $image = $request->file('image');
                    $image_name = strtolower(Str::random(10)) . time() . "." . $image->getClientOriginalExtension();
                    $image_path = public_path('images/item/' . $image_name);
                    $make_image = $manager->read($image);
                    $make_image = $make_image->resize(300, 250);
                    $make_image->save($image_path)->toJpeg(80);
                    $item->image = $image_name;
                }
                $item->save();
                DB::commit();
                return response()->json([
                    'data' => "Successfully update",
                    'status' => Response::HTTP_OK
                ], Response::HTTP_OK);

            } catch (QueryException $exception) {
                return response()->json([
                    'data' => $exception->getMessage(),
                    'status' => Response::HTTP_INTERNAL_SERVER_ERROR
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
      }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $item=Item::find($request->id);
            $item->delete();
            return response()->json([
                'data' => "Successfully delete",
                'status' => Response::HTTP_OK
            ], Response::HTTP_OK);
        }catch (QueryException $exception){
            return response()->json([
                'data' => $exception->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
