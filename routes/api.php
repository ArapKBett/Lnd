Route::middleware('auth:sanctum')->group(function () {
    Route::post('/integrate/credit', function (Request $request) {
        // Guzzle to external API
        $response = Http::post('https://api.creditbureau.com/check', $request->all());
        return $response->json();
    });
});
