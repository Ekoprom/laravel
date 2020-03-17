<?php

use Illuminate\Http\Request;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources(
	[
		'user' => 'API\UserController'
	]
);

//Route::group(['prefix' => '', 'namespace' => 'Api', 'as' => 'api.', 'middleware' => 'autho:api'], function () {
Route::group(['prefix' => '', 'namespace' => 'Api', 'as' => 'api.'], function () {
	Route::resource('tasks', 'TaskController', ['except' => ['create', 'edit']]);
	Route::post('image/store', 'ImageController@store');

	// Orders test
	Route::get('orders', function(Request $request) {
		$client = new Client(['verify' => false]);

		try {
			$res = $client->get(env('APP_1C_API') . 'dealers/orders', [
				'query' => [
					'date_start' => $request->dateStart,
					'date_end'   => $request->dateEnd,
				]
			]);
		} catch (Exception $e) {
			report($e);
			return response()->json(['error' => $e->getMessage()]);
		}

		return $res->getBody();
	});

	Route::get('order', function(Request $request) {
		$client = new Client(['verify' => false]);
		
		try {
			$res = $client->get(env('APP_1C_API') . 'dealers/order', [
				'query' => [
					'number' => $request->number,
					'date'   => $request->date,
				]
			]);
		} catch (Exception $e) {
			report($e);
			return response()->json(['error' => $e->getMessage()]);
		}

		return $res->getBody();
	});

	Route::get('products', function(Request $request) {
		$client = new Client(['verify' => false]);
		
		try {
			$res = $client->get('https://ekopromgroup.ru/upload/acrit.exportproplus/products.xml');
		} catch (Exception $e) {
			report($e);
			return response()->json(['error' => $e->getMessage()]);
		}

		$data = array(
			'categories' => array(),
			'items' => array(),
		);

		$xml = simplexml_load_string($res->getBody()->getContents());
		if ($xml instanceof \SimpleXMLElement) {
			foreach ($xml->categories->category as $category) {
				$data['categories'][] = array(
					'id'   => $category->attributes()['id']->__toString(),
					'name' => $category->__toString(),
				);
			}

			foreach ($xml->items->item as $item) {
				$data['items'][] = array(
					'category' => $item->category->__toString(),
					'name'     => $item->name->__toString(),
					'article'  => $item->article->__toString(),
					'quantity' => null,
					'free'     => null,
					'reserve'  => null,
				);
			}
		}

		return json_encode($data, true);
	});	

	Route::get('products/remains', function(Request $request) {
		$client = new Client(['verify' => false]);
	
		$items = $request->items;
		try {
			$res = $client->get(env('APP_1C_API') . 'dealers/remains', [
				'query' => [
					'stock' => '000000001',
					'arts'   => implode('|', $request->items),
				]
			]);
		} catch (Exception $e) {
			report($e);
			return response()->json(['error' => $e->getMessage()]);
		}

		return $res->getBody();
	});		
});
