<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ServerController extends Controller
{
    public function index()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        $currentTime = time();
        $oneHourAgo = $currentTime - (1 * 60 * 60); // 1 jam sebelumnya

        //•	Memory Usage (QAD Server) 
        $itemResponse = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => ['54160', '54195'], // Ganti dengan item ID yang sesuai
                ],
                'limit' => 10,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData = $itemResponse->json();
        $itemIds = array_column($itemData['result'], 'itemid');

        // Panggil API Zabbix untuk mendapatkan riwayat berdasarkan item ID
        $historyResponse = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                "itemids" =>  $itemIds,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData = $historyResponse->json();

        $data =  [
            'items' => $itemData['result'],
            'history' => $historyData['result'],
        ];

        // Mengolah data untuk chart
        $chartData = [];
        foreach ($itemData['result'] as $item) {
            $itemId = $item['itemid'];
            $itemName = $item['name'];
            $itemHistory = array_filter($historyData['result'], function ($history) use ($itemId) {
                return $history['itemid'] == $itemId;
            });
            $chartData[] = [
                'name' => $itemName,
                'data' => array_column($itemHistory, 'value'),
            ];
        }


        //CPU Utilization (QAD Server)  
        $itemResponse1 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '54200', // Ganti dengan item ID yang sesuai
                ],
                'limit' => 10,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData1 = $itemResponse1->json();
        $itemIds1 = array_column($itemData1['result'], 'itemid');

        // Panggil API Zabbix untuk mendapatkan riwayat berdasarkan item ID
        $historyResponse1 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                "itemids" =>  $itemIds1,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'history' =>0,
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData1 = $historyResponse1->json();

        $data1 =  [
            'items' => $itemData1['result'],
            'history' => $historyData1['result'],
        ];

        // Mengolah data untuk chart
        $chartData1 = [];
        foreach ($itemData1['result'] as $item1) {
            $itemId1 = $item1['itemid'];
            $itemName1 = $item1['name'];
            $itemHistory1 = array_filter($historyData1['result'], function ($history1) use ($itemId1) {
                return $history1['itemid'] == $itemId1;
            });
            $chartData1[] = [
                'name' => $itemName1,
                'data' => array_column($itemHistory1, 'value'),
            ];
        }


        //•	Disk Space Usage (QAD Server) 
        $itemResponse2 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => ['54244', '54248'], // Ganti dengan item ID yang sesuai
                ],
                'limit' => 10,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData2 = $itemResponse2->json();
        $itemIds2 = array_column($itemData2['result'], 'itemid');

        // Panggil API Zabbix untuk mendapatkan riwayat berdasarkan item ID
        $historyResponse2 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                "itemids" =>  $itemIds2,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData2 = $historyResponse2->json();

        $data2 =  [
            'items' => $itemData2['result'],
            'history' => $historyData2['result'],
        ];

        // Mengolah data untuk chart
        $chartData2 = [];
        $chartData2 = [];
        foreach ($itemData2['result'] as $item2) {
            $itemId2 = $item2['itemid'];
            $itemName2 = $item2['name'];
            $itemHistory2 = array_filter($historyData2['result'], function ($history2) use ($itemId2) {
                return $history2['itemid'] == $itemId2;
            });
            $dataItemHistory = array_column($itemHistory2, 'value');
            $chartData2[] = [
                $itemName2,
                $dataItemHistory,
            ];
        }


        //•	Memory utilization (Attandance Server) 
        $itemResponse3 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '53625', // Ganti dengan item ID yang sesuai
                ],
                'limit' => 10,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData3 = $itemResponse3->json();
        $itemIds3 = array_column($itemData3['result'], 'itemid');

        // Panggil API Zabbix untuk mendapatkan riwayat berdasarkan item ID
        $historyResponse3 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                "itemids" =>  $itemIds3,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'history' =>0,
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData3 = $historyResponse3->json();

        $data3 =  [
            'items' => $itemData3['result'],
            'history' => $historyData3['result'],
        ];

        // Mengolah data untuk chart
        $chartData3 = [];
        foreach ($itemData3['result'] as $item3) {
            $itemId3 = $item3['itemid'];
            $itemName3 = $item3['name'];
            $itemHistory3 = array_filter($historyData3['result'], function ($history3) use ($itemId3) {
                return $history3['itemid'] == $itemId3;
            });
            $chartData3[] = [
                'name' => $itemName3,
                'data' => array_column($itemHistory3, 'value'),
            ];
        }


        //CPU Utilization (Attandance Server)  
        $itemResponse4 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '53618', // Ganti dengan item ID yang sesuai
                ],
                'limit' => 10,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData4 = $itemResponse4->json();
        $itemIds4 = array_column($itemData4['result'], 'itemid');

        // Panggil API Zabbix untuk mendapatkan riwayat berdasarkan item ID
        $historyResponse4 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                "itemids" =>  $itemIds4,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'history' =>0,
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData4 = $historyResponse4->json();

        $data4 =  [
            'items' => $itemData4['result'],
            'history' => $historyData4['result'],
        ];

        // Mengolah data untuk chart
        $chartData4 = [];
        foreach ($itemData4['result'] as $item4) {
            $itemId4 = $item4['itemid'];
            $itemName4 = $item4['name'];
            $itemHistory4 = array_filter($historyData4['result'], function ($history4) use ($itemId4) {
                return $history4['itemid'] == $itemId4;
            });
            $chartData4[] = [
                'name' => $itemName4,
                'data' => array_column($itemHistory4, 'value'),
            ];
        }


        //•	Disk Space Usage (Attandance Server) 
        $itemResponse5 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => ['53712', '53713'], // Ganti dengan item ID yang sesuai
                ],
                'limit' => 10,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData5 = $itemResponse5->json();
        $itemIds5 = array_column($itemData5['result'], 'itemid');

        // Panggil API Zabbix untuk mendapatkan riwayat berdasarkan item ID
        $historyResponse5 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                "itemids" =>  $itemIds5,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData5 = $historyResponse5->json();

        $data5 =  [
            'items' => $itemData5['result'],
            'history' => $historyData5['result'],
        ];

        // Mengolah data untuk chart
        $chartData5 = [];
        foreach ($itemData5['result'] as $item5) {
            $itemId5 = $item5['itemid'];
            $itemName5 = $item5['name'];
            $itemHistory5 = array_filter($historyData5['result'], function ($history5) use ($itemId5) {
                return $history5['itemid'] == $itemId5;
            });
            $dataItemHistory5 = array_column($itemHistory5, 'value');
            $chartData5[] = [
                $itemName5,
                $dataItemHistory5,
            ];
        }
        return view('server',compact('chartData','chartData1','chartData2','chartData3', 'chartData4', 'chartData5'));
    }

    public function MemoryUsageQAD()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        // Memory Usage QAD
        $itemRes = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' =>  ['54160', '54195'], // Ganti dengan item ID yang sesuai
                ],
                // 'limit' => 10,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData = $itemRes->json();
        $itemIds = array_column($itemData['result'], 'itemid');

        // Mengumpulkan riwayat berdasarkan item ID
        $currentTime = time();
        $oneHourAgo = $currentTime - (1 * 60 * 60); // 1 jam sebelumnya
        $historyResponse = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                'itemids' => $itemIds,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                // 'limit' => 30,
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData = $historyResponse->json();

        // Mengolah data untuk chart
        $chartDataa = [];
        foreach ($itemData['result'] as $item) {

            $itemId = $item['itemid'];
            $itemName = $item['name'];

            $itemHistory = array_filter($historyData['result'], function ($history) use ($itemId) {
                return $history['itemid'] == $itemId;
            });

            // Batasi jumlah data riwayat menjadi 30
            $itemHistory = array_slice($itemHistory, 0);

            $labels = [];
            $values = [];

            foreach ($itemHistory as $history) {
                $labels[] = date('H:i', $history['clock']);
                $values[] = floatval($history['value']);
            }

            $chartData[] = [
                'name' => $itemName,
                'labels' => $labels,
                'values' => $values,

            ];
        }

        return response()->json($chartData);
    }

    public function CPUUtillQAD()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        // CPU Utilization QAD
        $itemRes = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '54200', // Ganti dengan item ID yang sesuai
                ],
                // 'limit' => 10,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData = $itemRes->json();
        $itemIds = array_column($itemData['result'], 'itemid');

        // Mengumpulkan riwayat berdasarkan item ID
        $currentTime = time();
        $oneHourAgo = $currentTime - (1 * 60 * 60); // 1 jam sebelumnya
        $historyResponse = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                'itemids' => $itemIds,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'history' => 0,
                // 'limit' => 30,
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData = $historyResponse->json();

        // Mengolah data untuk chart
        $chartDataa = [];
        foreach ($itemData['result'] as $item) {

            $itemId = $item['itemid'];
            $itemName = $item['name'];

            $itemHistory = array_filter($historyData['result'], function ($history) use ($itemId) {
                return $history['itemid'] == $itemId;
            });

            // Batasi jumlah data riwayat menjadi 30
            $itemHistory = array_slice($itemHistory, 0);

            $labels = [];
            $values = [];

            foreach ($itemHistory as $history) {
                $labels[] = date('H:i', $history['clock']);
                $values[] = floatval($history['value']);
            }

            $chartData[] = [
                'name' => $itemName,
                'labels' => $labels,
                'values' => $values,

            ];
        }

        return response()->json($chartData);
    }

    public function DiskSpaceUsageQAD()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        // Disk Space Usage QAD
        $itemRes = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => ['54244', '54248'], // Ganti dengan item ID yang sesuai
                ],
                // 'limit' => 10,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData = $itemRes->json();
        $itemIds = array_column($itemData['result'], 'itemid');

        // Mengumpulkan riwayat berdasarkan item ID
        $currentTime = time();
        $oneHourAgo = $currentTime - (1 * 60 * 60); // 1 jam sebelumnya
        $historyResponse = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                'itemids' => $itemIds,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                // 'limit' => 30,
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData = $historyResponse->json();

        // Mengolah data untuk chart
        $chartDataa = [];
        foreach ($itemData['result'] as $item) {

            $itemId = $item['itemid'];
            $itemName = $item['name'];

            $itemHistory = array_filter($historyData['result'], function ($history) use ($itemId) {
                return $history['itemid'] == $itemId;
            });

            // Batasi jumlah data riwayat menjadi 30
            $itemHistory = array_slice($itemHistory, 0);

            $labels = [];
            $values = [];

            foreach ($itemHistory as $history) {
                $labels[] = date('H:i', $history['clock']);
                $values[] = floatval($history['value']);
            }

            $chartData[] = [
                'name' => $itemName,
                'labels' => $labels,
                'values' => $values,

            ];
        }

        return response()->json($chartData);
    }

    public function MemoryUtilATT()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        // Memory Utilization ATT
        $itemRes = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '53625', // Ganti dengan item ID yang sesuai
                ],
                // 'limit' => 10,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData = $itemRes->json();
        $itemIds = array_column($itemData['result'], 'itemid');

        // Mengumpulkan riwayat berdasarkan item ID
        $currentTime = time();
        $oneHourAgo = $currentTime - (1 * 60 * 60); // 1 jam sebelumnya
        $historyResponse = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                'itemids' => $itemIds,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'history' => 0,
                // 'limit' => 30,
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData = $historyResponse->json();

        // Mengolah data untuk chart
        $chartDataa = [];
        foreach ($itemData['result'] as $item) {

            $itemId = $item['itemid'];
            $itemName = $item['name'];

            $itemHistory = array_filter($historyData['result'], function ($history) use ($itemId) {
                return $history['itemid'] == $itemId;
            });

            // Batasi jumlah data riwayat menjadi 30
            $itemHistory = array_slice($itemHistory, 0);

            $labels = [];
            $values = [];

            foreach ($itemHistory as $history) {
                $labels[] = date('H:i', $history['clock']);
                $values[] = floatval($history['value']);
            }

            $chartData[] = [
                'name' => $itemName,
                'labels' => $labels,
                'values' => $values,

            ];
        }

        return response()->json($chartData);
    }

    public function CPUUtillATT()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        // CPU Utilization ATT
        $itemRes = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '53618', // Ganti dengan item ID yang sesuai
                ],
                // 'limit' => 10,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData = $itemRes->json();
        $itemIds = array_column($itemData['result'], 'itemid');

        // Mengumpulkan riwayat berdasarkan item ID
        $currentTime = time();
        $oneHourAgo = $currentTime - (1 * 60 * 60); // 1 jam sebelumnya
        $historyResponse = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                'itemids' => $itemIds,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'history' => 0,
                // 'limit' => 30,
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData = $historyResponse->json();

        // Mengolah data untuk chart
        $chartDataa = [];
        foreach ($itemData['result'] as $item) {

            $itemId = $item['itemid'];
            $itemName = $item['name'];

            $itemHistory = array_filter($historyData['result'], function ($history) use ($itemId) {
                return $history['itemid'] == $itemId;
            });

            // Batasi jumlah data riwayat menjadi 30
            $itemHistory = array_slice($itemHistory, 0);

            $labels = [];
            $values = [];

            foreach ($itemHistory as $history) {
                $labels[] = date('H:i', $history['clock']);
                $values[] = floatval($history['value']);
            }

            $chartData[] = [
                'name' => $itemName,
                'labels' => $labels,
                'values' => $values,

            ];
        }

        return response()->json($chartData);
    }

    public function DiskSpaceUsageATT()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        // Disk Space Usage ATT
        $itemRes = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => ['53712', '53713'], // Ganti dengan item ID yang sesuai
                ],
                // 'limit' => 10,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData = $itemRes->json();
        $itemIds = array_column($itemData['result'], 'itemid');

        // Mengumpulkan riwayat berdasarkan item ID
        $currentTime = time();
        $oneHourAgo = $currentTime - (1 * 60 * 60); // 1 jam sebelumnya
        $historyResponse = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                'itemids' => $itemIds,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'history' => 0,
                // 'limit' => 30,
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData = $historyResponse->json();

        // Mengolah data untuk chart
        $chartDataa = [];
        foreach ($itemData['result'] as $item) {

            $itemId = $item['itemid'];
            $itemName = $item['name'];

            $itemHistory = array_filter($historyData['result'], function ($history) use ($itemId) {
                return $history['itemid'] == $itemId;
            });

            // Batasi jumlah data riwayat menjadi 30
            $itemHistory = array_slice($itemHistory, 0);

            $labels = [];
            $values = [];

            foreach ($itemHistory as $history) {
                $labels[] = date('H:i', $history['clock']);
                $values[] = floatval($history['value']);
            }

            $chartData[] = [
                'name' => $itemName,
                'labels' => $labels,
                'values' => $values,

            ];
        }

        return response()->json($chartData);
    }
}
