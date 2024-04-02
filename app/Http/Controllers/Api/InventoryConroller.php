<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryRequest;
use App\Http\Requests\ItemRequest;
use App\Http\Resources\InentoryResource;
use App\Http\Resources\InventoryResource;
use App\Http\Resources\ItemResource;
use App\Models\Inventory;
use App\Models\Item;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class InventoryConroller extends Controller
{

    public function index()
    {
        $datas=Inventory::query()->user(auth()->user()->id)->orderBy('id','DESC')
            ->get();
        return InventoryResource::collection($datas);
    }

    public function getItem()
    {
        $datas=Item::orderBy('id','DESC')->get();
        return ItemResource::collection($datas);
    }

    public function store(InventoryRequest $request)
    {
        //dd($request->all());
        if ($request->isMethod("POST")){
            try {
                DB::beginTransaction();

                $inventory=new Inventory();
                $inventory->name=$request->name;
                $inventory->description=$request->description;
                $inventory->item_id=$request->item_id;
                $inventory->user_id=auth()->user()->id;
                $inventory->save();

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
        $inventory=Inventory::find($id);
        return InventoryResource::make($inventory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InventoryRequest $request)
    {

        // return "okay";
        if ($request->isMethod("post")){
            try {
                DB::beginTransaction();
                $inventory = Inventory::find($request->id);
                $inventory->name = $request->name;
                $inventory->description = $request->description;
                $inventory->item_id = $request->item_id;

                $inventory->save();
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
            $inventory=Inventory::find($request->id);
            $inventory->delete();
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
