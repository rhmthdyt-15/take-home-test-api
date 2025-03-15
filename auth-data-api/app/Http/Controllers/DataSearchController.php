<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\DataListRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class DataSearchController extends Controller
{
    protected $dataUrl = 'https://bit.ly/48ejMhW';

    protected function fetchData()
    {
        $response = Http::get($this->dataUrl);
        $responseData = $response->json();


        if (isset($responseData['DATA'])) {
            $rawData = $responseData['DATA'];


            $lines = explode("\n", $rawData);

            $parsedData = [];
            foreach ($lines as $line) {
                if (empty($line)) continue;

                $parts = explode("|", $line);
                if (count($parts) === 3) {
                    $parsedData[] = [
                        'ymd' => $parts[0],
                        'nim' => $parts[1],
                        'nama' => $parts[2]
                    ];
                }
            }

            return $parsedData;
        }

        return [];
    }

    public function getData(DataListRequest $request)
    {
        $data = $this->fetchData();
        $filteredData = collect($data);

        if ($request->has('nama') || $request->has('nama')) {
            $nama = $request->input('nama', $request->input('nama'));
            $filteredData = $filteredData->filter(function($item) use ($nama) {
                return stripos($item['nama'], $nama) !== false;
            });
        }

        if ($request->has('nim')) {
            $nim = $request->nim;
            $filteredData = $filteredData->filter(function($item) use ($nim) {
                return $item['nim'] == $nim;
            });
        }

        if ($request->has('ymd')) {
            $ymd = $request->ymd;
            $filteredData = $filteredData->filter(function($item) use ($ymd) {
                return $item['ymd'] == $ymd;
            });
        }

        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $total = $filteredData->count();
        $paginatedData = $filteredData->slice(($page - 1) * $limit, $limit)->values();

        $result = new LengthAwarePaginator(
            $paginatedData,
            $total,
            $limit,
            $page,
            ['path' => $request->url()]
        );


        $path = $request->url();
        $queryParams = $request->query();


        $links = [
            'first' => $this->buildUrl($path, array_merge($queryParams, ['page' => 1])),
            'last' => $this->buildUrl($path, array_merge($queryParams, ['page' => $result->lastPage()])),
            'prev' => $result->currentPage() > 1 ?
                $this->buildUrl($path, array_merge($queryParams, ['page' => $result->currentPage() - 1])) : null,
            'next' => $result->currentPage() < $result->lastPage() ?
                $this->buildUrl($path, array_merge($queryParams, ['page' => $result->currentPage() + 1])) : null,
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved successfully',
            'data' => $result->items(),
            'meta' => [
                'current_page' => $result->currentPage(),
                'from' => $result->firstItem(),
                'last_page' => $result->lastPage(),
                'per_page' => $result->perPage(),
                'to' => $result->lastItem(),
                'total' => $result->total(),
            ],
            'links' => $links
        ]);
    }

    protected function buildUrl($path, $queryParams)
    {
        $query = http_build_query($queryParams);
        return $path . '?' . $query;
    }
}