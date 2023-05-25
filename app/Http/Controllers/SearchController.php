<?php

namespace App\Http\Controllers;

use App\Utils\Utilities;
use App\Models\FoodType;
use App\Models\PriceRange;
use App\Models\Restaurant;
use App\Models\Schedule;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchController extends Controller
{
    /**
     * Search a restaurant
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function search(): \Illuminate\Foundation\Application|View|Factory|Application
    {
        $food_types = FoodType::All();

        $schedules = Schedule::all();

        $price_ranges = PriceRange::All();

        $data = [
            'food_types' => $food_types,
            'schedules' => $schedules,
            'price_ranges' => $price_ranges,
            'is_get' => true
        ];

        return view('searcher', $data);
    }


    public function search_location(Request $request): JsonResponse
    {
        $query = $request->input('query');

        $client = new Client(['base_uri' => 'https://api.opencagedata.com/geocode/v1/']);
        $response = $client->get('json', [
            'query' => [
                'q' => $query,
                'key' => env('OPENCAGE_API_KEY')
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        $predictions = [];

        foreach ($data['results'] as $result) {
            $formatted = $result['formatted'];
            $predictions[] = $formatted;
        }

        return response()->json($predictions);
    }

    /**
     * Search a restaurant
     *
     * @param Request $request
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     * @throws GuzzleException
     */
    public function search_with_filters(Request $request): \Illuminate\Foundation\Application|View|Factory|Application
    {
        $order_location = false;
        $restaurants = Restaurant::query();
        $restaurants->withAvg('reviews', 'rate');

        if(Auth::check() && (!$request->filled('search_text') || ($request->filled('search_text') && $request->input('filter_search_text') != 'location'))) {
            $user = Auth::user();
            $longitude = $user->user_food_preferences->longitude;
            $latitude = $user->user_food_preferences->latitude;
            $order_location = true;
        }

        if ($request->filled('search_text')) {
            $option = $request->input('filter_search_text');
            $search_text_value = $request->input('search_text');
            switch ($option) {
                case 'name':
                    $restaurants->where('name', 'LIKE', '%'.$search_text_value.'%');
                    break;

                case 'description':
                    $restaurants->where('description', 'LIKE', '%'.$search_text_value.'%');
                    break;

                case 'location':
                    $lat_long_search = Utilities::get_lat_long($search_text_value);
                    $longitude = $lat_long_search['longitude'];
                    $latitude = $lat_long_search['latitude'];
                    $order_location = true;
                    break;
            }
        }

        $restaurants->where(function ($query) use ($request) {
            if ($request->filled('food_types')) {
                $food_types = $request->input('food_types');
                $query->whereHas('food_types', function ($q) use ($food_types) {
                    $q->whereIn('food_type_id', $food_types);
                });
            }

            if ($request->filled('price_ranges')) {
                $price_ranges = $request->input('price_ranges');
                $query->whereIn('price_range_id', $price_ranges);
            }

            if ($request->filled('schedules')) {
                $schedules = $request->input('schedules');
                $query->whereHas('schedules', function ($q) use ($schedules) {
                    $q->whereIn('schedule_id', $schedules);
                });
            }
        });

        $terrace = $request->input('terrace');
        if($terrace != 2) {
            $restaurants->where('terrace', $terrace);
        }

        $sort_by = $request->input('sort_by');
        if ($sort_by == 'rating') {
            $restaurants->orderByDesc('reviews_avg_rate');
        }

        $results = $restaurants->get();

        if($order_location){
            $results = $results->map(function ($restaurant) use ($latitude, $longitude) {
                $distance = Utilities::calculate_distance($latitude, $longitude, $restaurant->latitude, $restaurant->longitude);
                $restaurant->distance = number_format($distance, 2);
                return $restaurant;
            });
        }

        if ($sort_by == 'nearest') {
            $results = $results->sortBy('distance');
        } elseif ($sort_by == 'farthest') {
            $results = $results->sortByDesc('distance');
        }

        $per_page = 9;
        $page = $request->query('page', 1);

        $paginated_results = new LengthAwarePaginator(
            $results->forPage($page, $per_page),
            $results->count(),
            $per_page,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $food_types = FoodType::All();
        $schedules = Schedule::all();
        $price_ranges = PriceRange::All();

        $data = [
            'food_types' => $food_types,
            'schedules' => $schedules,
            'price_ranges' => $price_ranges,
            'restaurants' => $paginated_results
        ];

        return view('searcher', $data);
    }
}
