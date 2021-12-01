<?php

namespace App\Http\Controllers\API\Item;

use App\Models\Item;
use App\Http\Controllers\Controller;
use App\Http\Resources\Item\ItemResource;
use App\Http\Requests\Items\StoreItemRequest;
use App\Http\Requests\Items\UpdateItemRequest;

class ItemController extends Controller
{
    public function index() {
        return ItemResource::collection(Item::paginate(10));
    }

    public function show(Item $item) {
        return new ItemResource($item);
    }
    
    public function store(StoreItemRequest $storeItemRequest) {
        try {
            return Item::create($storeItemRequest->all());
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(UpdateItemRequest $updateItemRequest, Item $item) {
        try {
            $item->update($updateItemRequest->all());
            return new ItemResource($item);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy(Item $item) {
        try {
            $item->delete();
            return response()->json([
                'message' => 'Item Deleted !'
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
