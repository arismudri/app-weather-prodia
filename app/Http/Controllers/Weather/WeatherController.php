<?php

namespace App\Http\Controllers\Weather;

use App\Http\Controllers\Controller;
use App\Lib\ResponseFormatter;
use App\Models\Weather\Weather;
use App\Models\Weather\WeatherDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;
use Yajra\Datatables\Datatables;

class WeatherController extends Controller
{
    protected $response;

    public function __construct()
    {
        $this->response = new ResponseFormatter();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable()
    {
        try {
            $data = DataTables::of(
                Weather::query()
            )->make(true);
            return $data;
        } catch (Exception $e) {

            return $this->response->fail($e->getMessage());
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = Weather::with("details")->get();
            return $this->response->success("Successfully get all weather", $data);
        } catch (Exception $e) {

            return $this->response->fail($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $response = Http::get(env('WEATHER_MAP_URL', 'https://api.openweathermap.org/data/2.5/weather'), [
                "lat" => env("WEATHER_MAP_LAT", "-6.229728"),
                "lon" => env("WEATHER_MAP_LON", "106.6894312"),
                "appid" => env("WEATHER_MAP_APP_ID", "3392aa3cdcf359c23e1616ac696f9192"),
            ])->collect();

            $data = [
                'lat' => $response["coord"]["lat"] ?? 0,
                'lon' => $response["coord"]["lon"] ?? 0,
                'timezone' => $response["timezone"] ?? 0,
                'pressure' => $response["main"]["pressure"] ?? 0,
                'humidity' => $response["main"]["humidity"] ?? 0,
                'wind_speed' => $response["wind"]["speed"] ?? 0,
            ];

            $weather = Weather::create($data);

            $weatherDetails = collect($response["weather"])->map(function ($item) {
                return new WeatherDetail([
                    "weather_detail_id" => $item["id"],
                    "main" => $item["main"],
                    "description" => $item["description"],
                ]);
            });

            $weather->details()->saveMany($weatherDetails);

            $weather->details;

            return $this->response->success("Successfully create new weather", compact("weather", "response"));
        } catch (Exception $e) {

            return $this->response->fail($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $weather_id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {

        try {
            $rule = [
                "id" => ["required", "numeric", Rule::exists("weathers", "id")->whereNull("deleted_at")],
            ];

            $validate = Validator::make(compact("id"), $rule);

            if ($validate->fails()) {
                return $this->response->fail("Validation fail", $validate->messages(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $weather = Weather::with("details")->where("id", $id)->firstOrFail();

            return $this->response->success("Successfully get weather", $weather);
        } catch (Exception $e) {

            return $this->response->fail($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $weather_id
     * @return \Illuminate\Http\Response
     */
    public function detailView(string $id)
    {

        try {
            $rule = [
                "id" => ["required", "numeric", Rule::exists("weathers", "id")->whereNull("deleted_at")],
            ];

            $validate = Validator::make(compact("id"), $rule);

            if ($validate->fails()) {
                return $this->response->fail("Validation fail", $validate->messages(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $weather = Weather::with("details")->where("id", $id)->firstOrFail();
            $details =  $weather->details;
            return view("weather.detail", compact("details"));
        } catch (Exception $e) {

            return $this->response->fail($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $weather_id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        try {
            $rule = [
                "id" => ["required", "numeric", Rule::exists("weathers", "id")->whereNull("deleted_at")],
            ];

            $validate = Validator::make(compact("id"), $rule);

            if ($validate->fails()) {
                return $this->response->fail("Validation fail", $validate->messages(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $weather = Weather::findOrFail($id);

            $weather->details()->delete();

            $weather->delete();

            return $this->response->success("Successfully delete weather", $weather);
        } catch (Exception $e) {

            return $this->response->fail($e->getMessage());
        }
    }
}
