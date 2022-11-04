<?php

namespace App\Http\Controllers\Weather;

use App\Http\Controllers\Controller;
use App\Lib\ResponseFormatter;
use App\Models\Weather\Weather;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

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
    public function index()
    {
        try {
            $data = Weather::get();
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
            $data = $request->only(
                'lat',
                'lon',
                'timezone',
                'pressure',
                'humidity',
                'wind_speed'
            );

            $rule = [
                "lat" => ["required", "string"],
                "lon" => ["required", "string"],
                "timezone" => ["required", "string", "timezone"],
                "pressure" => ["required", "numeric"],
                "humidity" => ["required", "numeric"],
                "wind_speed" => ["required", "numeric"],
            ];

            $validate = Validator::make($data, $rule);

            if ($validate->fails()) {
                return $this->response->fail("Validation fail", $validate->messages(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $dataWeather = collect($data)->only(
                'lat',
                'lon',
                'timezone',
                'pressure',
                'humidity',
                'wind_speed'
            );
            $weather = Weather::create($dataWeather->toArray());

            return $this->response->success("Successfully create new weather", $weather);
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

            $weather = Weather::findOrFail($id);

            return $this->response->success("Successfully get weather", $weather);
        } catch (Exception $e) {

            return $this->response->fail($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $weather_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        try {
            $data = $request->only(
                'lat',
                'lon',
                'timezone',
                'pressure',
                'humidity',
                'wind_speed'
            );

            $data["id"] = $id;

            $rule = [
                "id" => ["required", "numeric", Rule::exists("weathers", "id")->whereNull("deleted_at")],
                "lat" => ["required", "string"],
                "lon" => ["required", "string"],
                "timezone" => ["required", "string", "timezone"],
                "pressure" => ["required", "numeric"],
                "humidity" => ["required", "numeric"],
                "wind_speed" => ["required", "numeric"],
            ];

            $validate = Validator::make($data, $rule);

            if ($validate->fails()) {
                return $this->response->fail("Validation fail", $validate->messages(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $dataWeather = collect($data)->only(
                'lat',
                'lon',
                'timezone',
                'pressure',
                'humidity',
                'wind_speed'
            );
            $weather = Weather::where("id", $id)->update($dataWeather->toArray());
            $weather = Weather::findOrFail($id);

            return $this->response->success("Successfully update weather", $weather);
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

            $weather->delete();

            return $this->response->success("Successfully delete weather", $weather);
        } catch (Exception $e) {

            return $this->response->fail($e->getMessage());
        }
    }
}
