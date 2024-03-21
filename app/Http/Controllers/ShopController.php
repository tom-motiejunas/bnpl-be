<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShopRequest;
use App\Models\Shop;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class ShopController extends Controller
{
    public function store(StoreShopRequest $store_shop_request): JsonResponse
    {
        $new_shop = $store_shop_request->all();
        $new_shop['api_key'] = Hash::make($store_shop_request->string('api_key'));
        $new_shop['domain'] = $store_shop_request->httpHost();
        Shop::create($new_shop);

        return response()->json($new_shop, Response::HTTP_CREATED);
    }

    public function destroy(Request $request): JsonResponse
    {
        $domain = $request->httpHost();
        Shop::where('domain', $domain)->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
