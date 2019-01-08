<?php

namespace App;

use Illuminate\Support\Facades\Cache;

class Utils {
    /**
     * Cache
     *
     * @param Illuminate\Http\Request $request an HTTP request object
     * @param string $key cache and etag key
     * @param function $getFn a function that returns the payload to cache (will be json_encoded)
     * @return Illuminate\Http\Response
     */
    static function cache($key, $getFn, $request=null) {
        $key = strtolower($key);
        $etagKey = "{$key}__etag";
        if(Cache::has($key) && Cache::has($etagKey)) {
            $collection = json_decode(Cache::get($key));
            $etag = Cache::get($etagKey);
        } else {
            if(method_exists($request, 'method') && $request->method() == 'HEAD') {
                $collection = [];
                $etag = 'expired';
            } else {
                $collection = $getFn();
                $collectionJson = json_encode($collection);
                $etag = md5($collectionJson);
                Cache::forever($key, $collectionJson);
                Cache::forever($etagKey, $etag);
            }
        }
    
        return response()->json([
            $key => $collection
        ])->setEtag($etag);
    }
}