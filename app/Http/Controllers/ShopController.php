<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShopRequest;
use App\Models\Shop;
use Crypt;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShopController extends Controller
{
    public function store(StoreShopRequest $store_shop_request): JsonResponse
    {
        $new_shop = $store_shop_request->all();
        $new_shop['api_key'] = Crypt::encrypt($store_shop_request->string('api_key'));
        $new_shop['domain'] = $store_shop_request->httpHost();
        $shop_created = Shop::create($new_shop);

        return response()->json($shop_created, Response::HTTP_CREATED);
    }

    public function destroy(Request $request): JsonResponse
    {
        $domain = $request->httpHost();
        Shop::where('domain', $domain)->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
