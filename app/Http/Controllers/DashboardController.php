<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        $currentTime = time();
        $oneHourAgo = $currentTime - 1 * 60 * 60; // 1 jam sebelumnya

        //•	Network Traffic Cyberplus (Firewall)
        $itemResponse = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => ['53452', '53562'], // Ganti dengan item ID yang sesuai
                ],
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
                'itemids' => $itemIds,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData = $historyResponse->json();

        $data = [
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

        //•	Network Traffic Linknet (Firewall)
        $itemResponse1 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => ['53453', '53563'], // Ganti dengan item ID yang sesuai
                ],
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
                'itemids' => $itemIds1,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData1 = $historyResponse1->json();

        $data1 = [
            'items' => $itemData1['result'],
            'history' => $historyData1['result'],
        ];

        // Mengolah data untuk chart
        $chartData1 = [];
        foreach ($itemData1['result'] as $item) {
            $itemId = $item['itemid'];
            $itemName = $item['name'];
            $itemHistory = array_filter($historyData1['result'], function ($history) use ($itemId) {
                return $history['itemid'] == $itemId;
            });
            $chartData1[] = [
                'name' => $itemName,
                'data' => array_column($itemHistory, 'value'),
            ];
        }

        //• Ping Gateway ISP Cyberplus
        $itemResponse2 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '72750', // Ganti dengan item ID yang sesuai
                ],
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
                'itemids' => $itemIds2,
                'history' => 0,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData2 = $historyResponse2->json();

        $data2 = [
            'items' => $itemData2['result'],
            'history' => $historyData2['result'],
        ];

        // Mengolah data untuk chart
        $chartData2 = [];
        foreach ($itemData2['result'] as $item) {
            $itemId = $item['itemid'];
            $itemName = $item['name'];
            $itemHistory = array_filter($historyData2['result'], function ($history) use ($itemId) {
                return $history['itemid'] == $itemId;
            });
            $chartData2[] = [
                'name' => $itemName,
                'data' => array_column($itemHistory, 'value'),
            ];
        }

        //• Ping Gateway ISP Linknet
        $itemResponse3 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '72753', // Ganti dengan item ID yang sesuai
                ],
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
                'itemids' => $itemIds3,
                'history' => 0,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData3 = $historyResponse3->json();

        $data3 = [
            'items' => $itemData3['result'],
            'history' => $historyData3['result'],
        ];

        // Mengolah data untuk chart
        $chartData3 = [];
        foreach ($itemData3['result'] as $item) {
            $itemId = $item['itemid'];
            $itemName = $item['name'];
            $itemHistory = array_filter($historyData3['result'], function ($history) use ($itemId) {
                return $history['itemid'] == $itemId;
            });
            $chartData3[] = [
                'name' => $itemName,
                'data' => array_column($itemHistory, 'value'),
            ];
        }

        //• Ping Loss Gateway Traffic Cyberplus Loss
        $itemResponse4 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '72748', // Ganti dengan item ID yang sesuai
                ]
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
                'itemids' => $itemIds4,
                'history' => 0,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData4 = $historyResponse4->json();

        $data4 = [
            'items' => $itemData4['result'],
            'history' => $historyData4['result'],
        ];

        // Mengolah data untuk chart
        $chartData4 = [];
        foreach ($itemData4['result'] as $item) {
            $itemId = $item['itemid'];
            $itemName = $item['name'];
            $itemHistory = array_filter($historyData4['result'], function ($history) use ($itemId) {
                return $history['itemid'] == $itemId;
            });
            $chartData4[] = [
                'name' => $itemName,
                'data' => array_column($itemHistory, 'value'),
            ];
        }

        //• Ping Loss Gateway Traffic Linknet Loss
        $itemResponse5 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '72751', // Ganti dengan item ID yang sesuai
                ],
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
                'itemids' => $itemIds5,
                'history' => 0,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData5 = $historyResponse5->json();

        $data5 = [
            'items' => $itemData5['result'],
            'history' => $historyData5['result'],
        ];

        // Mengolah data untuk chart
        $chartData5 = [];
        foreach ($itemData5['result'] as $item) {
            $itemId = $item['itemid'];
            $itemName = $item['name'];
            $itemHistory = array_filter($historyData5['result'], function ($history) use ($itemId) {
                return $history['itemid'] == $itemId;
            });
            $chartData5[] = [
                'name' => $itemName,
                'data' => array_column($itemHistory, 'value'),
            ];
        }

        //•	Ping 8.8.8.8
        $itemResponse6 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '68862', // Ganti dengan item ID yang sesuai
                ],
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData6 = $itemResponse6->json();
        $itemIds6 = array_column($itemData6['result'], 'itemid');

        // Panggil API Zabbix untuk mendapatkan riwayat berdasarkan item ID
        $historyResponse6 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                'itemids' => $itemIds6,
                'history' => 0,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData6 = $historyResponse6->json();

        $data6 = [
            'items' => $itemData6['result'],
            'history' => $historyData6['result'],
        ];

        // Mengolah data untuk chart
        $chartData6 = [];
        foreach ($itemData6['result'] as $item) {
            $itemId = $item['itemid'];
            $itemName = $item['name'];
            $itemHistory = array_filter($historyData6['result'], function ($history) use ($itemId) {
                return $history['itemid'] == $itemId;
            });
            $chartData6[] = [
                'name' => $itemName,
                'data' => array_column($itemHistory, 'value'),
            ];
        }

        //• Ping detik.com
        $itemResponse7 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '73130', // Ganti dengan item ID yang sesuai
                ],
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData7 = $itemResponse7->json();
        $itemIds7 = array_column($itemData7['result'], 'itemid');

        // Panggil API Zabbix untuk mendapatkan riwayat berdasarkan item ID
        $historyResponse7 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                'itemids' => $itemIds7,
                'history' => 0,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData7 = $historyResponse7->json();

        $data7 = [
            'items' => $itemData7['result'],
            'history' => $historyData7['result'],
        ];

        // Mengolah data untuk chart
        $chartData7 = [];
        foreach ($itemData7['result'] as $item) {
            $itemId = $item['itemid'];
            $itemName = $item['name'];
            $itemHistory = array_filter($historyData7['result'], function ($history) use ($itemId) {
                return $history['itemid'] == $itemId;
            });
            $chartData7[] = [
                'name' => $itemName,
                'data' => array_column($itemHistory, 'value'),
            ];
        }

        //•	Ping teams.microsoft.com
        $itemResponse8 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '73149', // Ganti dengan item ID yang sesuai
                ],
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData8 = $itemResponse8->json();
        $itemIds8 = array_column($itemData8['result'], 'itemid');

        // Panggil API Zabbix untuk mendapatkan riwayat berdasarkan item ID
        $historyResponse8 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                'itemids' => $itemIds8,
                'history' => 0,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData8 = $historyResponse8->json();

        $data8 = [
            'items' => $itemData8['result'],
            'history' => $historyData8['result'],
        ];

        // Mengolah data untuk chart
        $chartData8 = [];
        foreach ($itemData8['result'] as $item) {
            $itemId = $item['itemid'];
            $itemName = $item['name'];
            $itemHistory = array_filter($historyData8['result'], function ($history) use ($itemId) {
                return $history['itemid'] == $itemId;
            });
            $chartData8[] = [
                'name' => $itemName,
                'data' => array_column($itemHistory, 'value'),
            ];
        }

        //•	Memory Usage QAD Server
        $itemResponse9 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => ['54160', '54195'], // Ganti dengan item ID yang sesuai
                ],
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData9 = $itemResponse9->json();
        $itemIds9 = array_column($itemData9['result'], 'itemid');

        // Panggil API Zabbix untuk mendapatkan riwayat berdasarkan item ID
        $historyResponse9 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                'itemids' => $itemIds9,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData9 = $historyResponse9->json();

        $data9 = [
            'items' => $itemData9['result'],
            'history' => $historyData9['result'],
        ];

        // Mengolah data untuk chart
        $chartData9 = [];
        foreach ($itemData9['result'] as $item) {
            $itemId = $item['itemid'];
            $itemName = $item['name'];
            $itemHistory = array_filter($historyData9['result'], function ($history) use ($itemId) {
                return $history['itemid'] == $itemId;
            });
            $chartData9[] = [
                'name' => $itemName,
                'data' => array_column($itemHistory, 'value'),
            ];
        }

        //•	CPU Utilization QAD Server
        $itemResponse10 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '54200', // Ganti dengan item ID yang sesuai
                ],
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData10 = $itemResponse10->json();
        $itemIds10 = array_column($itemData10['result'], 'itemid');

        // Panggil API Zabbix untuk mendapatkan riwayat berdasarkan item ID
        $historyResponse10 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                'itemids' => $itemIds10,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'history' => 0,
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData10 = $historyResponse10->json();

        $data10 = [
            'items' => $itemData10['result'],
            'history' => $historyData10['result'],
        ];

        // Mengolah data untuk chart
        $chartData10 = [];
        foreach ($itemData10['result'] as $item) {
            $itemId = $item['itemid'];
            $itemName = $item['name'];
            $itemHistory = array_filter($historyData10['result'], function ($history) use ($itemId) {
                return $history['itemid'] == $itemId;
            });
            $chartData10[] = [
                'name' => $itemName,
                'data' => array_column($itemHistory, 'value'),
            ];
        }
        return view('dashboard', compact('chartData', 'chartData1', 'chartData2', 'chartData3', 'chartData4', 'chartData5', 'chartData6', 'chartData7', 'chartData8', 'chartData9', 'chartData10'));
    }

    public function NetworkTrafficCyberplus()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        // Network Traffic Cyberplus (Firewall)
        $itemRes = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => ['53452', '53562'], // Ganti dengan item ID yang sesuai
                ],
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData = $itemRes->json();
        $itemIds = array_column($itemData['result'], 'itemid');

        // Mengumpulkan riwayat berdasarkan item ID
        $currentTime = time();
        $oneHourAgo = $currentTime - 1 * 60 * 60; // 1 jam sebelumnya
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

    public function NetworkTrafficLinknet()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        // Network Traffic Linknet (Firewall)
        $itemRes1 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => ['53453', '53563'], // Ganti dengan item ID yang sesuai
                ],
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData1 = $itemRes1->json();
        $itemIds1 = array_column($itemData1['result'], 'itemid');

        // Mengumpulkan riwayat berdasarkan item ID
        $currentTime = time();
        $oneHourAgo = $currentTime - 1 * 60 * 60; // 1 jam sebelumnya
        $historyResponse1 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                'itemids' => $itemIds1,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData1 = $historyResponse1->json();

        // Mengolah data untuk chart
        $chartDataa = [];
        foreach ($itemData1['result'] as $item) {
            $itemId1 = $item['itemid'];
            $itemName = $item['name'];

            $itemHistory1 = array_filter($historyData1['result'], function ($history1) use ($itemId1) {
                return $history1['itemid'] == $itemId1;
            });

            // Batasi jumlah data riwayat menjadi 30
            $itemHistory1 = array_slice($itemHistory1, 0);

            $labels1 = [];
            $values1 = [];

            foreach ($itemHistory1 as $history1) {
                $labels1[] = date('H:i', $history1['clock']);
                $values1[] = floatval($history1['value']);
            }

            $chartData1[] = [
                'name' => $itemName,
                'labels' => $labels1,
                'values' => $values1,
            ];
        }

        return response()->json($chartData1);
    }

    public function PingGatewayISPCyberplus()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        // PingGatewayISPCyberplus
        $itemRes1 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '72750', // Ganti dengan item ID yang sesuai
                ],
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData1 = $itemRes1->json();
        $itemIds1 = array_column($itemData1['result'], 'itemid');

        // Mengumpulkan riwayat berdasarkan item ID
        $currentTime = time();
        $oneHourAgo = $currentTime - 1 * 60 * 60; // 1 jam sebelumnya
        $historyResponse1 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                'itemids' => $itemIds1,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'history' => 0,
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData1 = $historyResponse1->json();

        // Mengolah data untuk chart
        $chartDataa = [];
        foreach ($itemData1['result'] as $item) {
            $itemId1 = $item['itemid'];
            $itemName = $item['name'];

            $itemHistory1 = array_filter($historyData1['result'], function ($history1) use ($itemId1) {
                return $history1['itemid'] == $itemId1;
            });

            // Batasi jumlah data riwayat menjadi 30
            $itemHistory1 = array_slice($itemHistory1, 0);

            $labels1 = [];
            $values1 = [];

            foreach ($itemHistory1 as $history1) {
                $labels1[] = date('H:i', $history1['clock']);
                $values1[] = floatval($history1['value']);
            }

            $chartData1[] = [
                'name' => $itemName,
                'labels' => $labels1,
                'values' => $values1,
            ];
        }

        return response()->json($chartData1);
    }

    public function PingGatewayISPLinknet()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        // PingGatewayISPLinknet
        $itemRes1 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '72753', // Ganti dengan item ID yang sesuai
                ],
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData1 = $itemRes1->json();
        $itemIds1 = array_column($itemData1['result'], 'itemid');

        // Mengumpulkan riwayat berdasarkan item ID
        $currentTime = time();
        $oneHourAgo = $currentTime - 1 * 60 * 60; // 1 jam sebelumnya
        $historyResponse1 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                'itemids' => $itemIds1,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'history' => 0,
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData1 = $historyResponse1->json();

        // Mengolah data untuk chart
        $chartDataa = [];
        foreach ($itemData1['result'] as $item) {
            $itemId1 = $item['itemid'];
            $itemName = $item['name'];

            $itemHistory1 = array_filter($historyData1['result'], function ($history1) use ($itemId1) {
                return $history1['itemid'] == $itemId1;
            });

            // Batasi jumlah data riwayat menjadi 30
            $itemHistory1 = array_slice($itemHistory1, 0);

            $labels1 = [];
            $values1 = [];

            foreach ($itemHistory1 as $history1) {
                $labels1[] = date('H:i', $history1['clock']);
                $values1[] = floatval($history1['value']);
            }

            $chartData1[] = [
                'name' => $itemName,
                'labels' => $labels1,
                'values' => $values1,
            ];
        }

        return response()->json($chartData1);
    }

    public function PinglossCyberplus()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        // PinglossCyberplus
        $itemRes1 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '72748', // Ganti dengan item ID yang sesuai
                ],
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData1 = $itemRes1->json();
        $itemIds1 = array_column($itemData1['result'], 'itemid');

        // Mengumpulkan riwayat berdasarkan item ID
        $currentTime = time();
        $oneHourAgo = $currentTime - 1 * 60 * 60; // 1 jam sebelumnya
        $historyResponse1 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                'itemids' => $itemIds1,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'history' => 0,
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData1 = $historyResponse1->json();

        // Mengolah data untuk chart
        $chartDataa = [];
        foreach ($itemData1['result'] as $item) {
            $itemId1 = $item['itemid'];
            $itemName = $item['name'];

            $itemHistory1 = array_filter($historyData1['result'], function ($history1) use ($itemId1) {
                return $history1['itemid'] == $itemId1;
            });

            // Batasi jumlah data riwayat menjadi 30
            $itemHistory1 = array_slice($itemHistory1, 0);

            $labels1 = [];
            $values1 = [];

            foreach ($itemHistory1 as $history1) {
                $labels1[] = date('H:i', $history1['clock']);
                $values1[] = floatval($history1['value']);
            }

            $chartData1[] = [
                'name' => $itemName,
                'labels' => $labels1,
                'values' => $values1,
            ];
        }

        return response()->json($chartData1);
    }

    public function PinglossLinknet()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        // PinglossLinknet
        $itemRes1 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '72751', // Ganti dengan item ID yang sesuai
                ],
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData1 = $itemRes1->json();
        $itemIds1 = array_column($itemData1['result'], 'itemid');

        // Mengumpulkan riwayat berdasarkan item ID
        $currentTime = time();
        $oneHourAgo = $currentTime - 1 * 60 * 60; // 1 jam sebelumnya
        $historyResponse1 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                'itemids' => $itemIds1,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'history' => 0,
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData1 = $historyResponse1->json();

        // Mengolah data untuk chart
        $chartDataa = [];
        foreach ($itemData1['result'] as $item) {
            $itemId1 = $item['itemid'];
            $itemName = $item['name'];

            $itemHistory1 = array_filter($historyData1['result'], function ($history1) use ($itemId1) {
                return $history1['itemid'] == $itemId1;
            });

            // Batasi jumlah data riwayat menjadi 30
            $itemHistory1 = array_slice($itemHistory1, 0);

            $labels1 = [];
            $values1 = [];

            foreach ($itemHistory1 as $history1) {
                $labels1[] = date('H:i', $history1['clock']);
                $values1[] = floatval($history1['value']);
            }

            $chartData1[] = [
                'name' => $itemName,
                'labels' => $labels1,
                'values' => $values1,
            ];
        }

        return response()->json($chartData1);
    }

    public function Ping8888()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        // Ping8888
        $itemRes1 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '68862', // Ganti dengan item ID yang sesuai
                ],
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData1 = $itemRes1->json();
        $itemIds1 = array_column($itemData1['result'], 'itemid');

        // Mengumpulkan riwayat berdasarkan item ID
        $currentTime = time();
        $oneHourAgo = $currentTime - 1 * 60 * 60; // 1 jam sebelumnya
        $historyResponse1 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                'itemids' => $itemIds1,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'history' => 0,
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData1 = $historyResponse1->json();

        // Mengolah data untuk chart
        $chartDataa = [];
        foreach ($itemData1['result'] as $item) {
            $itemId1 = $item['itemid'];
            $itemName = $item['name'];

            $itemHistory1 = array_filter($historyData1['result'], function ($history1) use ($itemId1) {
                return $history1['itemid'] == $itemId1;
            });

            // Batasi jumlah data riwayat menjadi 30
            $itemHistory1 = array_slice($itemHistory1, 0);

            $labels1 = [];
            $values1 = [];

            foreach ($itemHistory1 as $history1) {
                $labels1[] = date('H:i', $history1['clock']);
                $values1[] = floatval($history1['value']);
            }

            $chartData1[] = [
                'name' => $itemName,
                'labels' => $labels1,
                'values' => $values1,
            ];
        }

        return response()->json($chartData1);
    }

    public function Pingdetikcom()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        // Pingdetikcom
        $itemRes1 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '73130', // Ganti dengan item ID yang sesuai
                ],
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData1 = $itemRes1->json();
        $itemIds1 = array_column($itemData1['result'], 'itemid');

        // Mengumpulkan riwayat berdasarkan item ID
        $currentTime = time();
        $oneHourAgo = $currentTime - 1 * 60 * 60; // 1 jam sebelumnya
        $historyResponse1 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                'itemids' => $itemIds1,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'history' => 0,
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData1 = $historyResponse1->json();

        // Mengolah data untuk chart
        $chartDataa = [];
        foreach ($itemData1['result'] as $item) {
            $itemId1 = $item['itemid'];
            $itemName = $item['name'];

            $itemHistory1 = array_filter($historyData1['result'], function ($history1) use ($itemId1) {
                return $history1['itemid'] == $itemId1;
            });

            // Batasi jumlah data riwayat menjadi 30
            $itemHistory1 = array_slice($itemHistory1, 0);

            $labels1 = [];
            $values1 = [];

            foreach ($itemHistory1 as $history1) {
                $labels1[] = date('H:i', $history1['clock']);
                $values1[] = floatval($history1['value']);
            }

            $chartData1[] = [
                'name' => $itemName,
                'labels' => $labels1,
                'values' => $values1,
            ];
        }

        return response()->json($chartData1);
    }

    public function Pingteamsmicrosoftcom()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        // Pingteamsmicrosoftcom
        $itemRes1 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '73149', // Ganti dengan item ID yang sesuai
                ],
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData1 = $itemRes1->json();
        $itemIds1 = array_column($itemData1['result'], 'itemid');

        // Mengumpulkan riwayat berdasarkan item ID
        $currentTime = time();
        $oneHourAgo = $currentTime - 1 * 60 * 60; // 1 jam sebelumnya
        $historyResponse1 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                'itemids' => $itemIds1,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'history' => 0,
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData1 = $historyResponse1->json();

        // Mengolah data untuk chart
        $chartDataa = [];
        foreach ($itemData1['result'] as $item) {
            $itemId1 = $item['itemid'];
            $itemName = $item['name'];

            $itemHistory1 = array_filter($historyData1['result'], function ($history1) use ($itemId1) {
                return $history1['itemid'] == $itemId1;
            });

            // Batasi jumlah data riwayat menjadi 30
            $itemHistory1 = array_slice($itemHistory1, 0);

            $labels1 = [];
            $values1 = [];

            foreach ($itemHistory1 as $history1) {
                $labels1[] = date('H:i', $history1['clock']);
                $values1[] = floatval($history1['value']);
            }

            $chartData1[] = [
                'name' => $itemName,
                'labels' => $labels1,
                'values' => $values1,
            ];
        }

        return response()->json($chartData1);
    }

    public function MemoryUsage()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        // MemoryUsage
        $itemRes1 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => ['54160', '54195'], // Ganti dengan item ID yang sesuai
                ],
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData1 = $itemRes1->json();
        $itemIds1 = array_column($itemData1['result'], 'itemid');

        // Mengumpulkan riwayat berdasarkan item ID
        $currentTime = time();
        $oneHourAgo = $currentTime - 1 * 60 * 60; // 1 jam sebelumnya
        $historyResponse1 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                'itemids' => $itemIds1,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData1 = $historyResponse1->json();

        // Mengolah data untuk chart
        $chartDataa = [];
        foreach ($itemData1['result'] as $item) {
            $itemId1 = $item['itemid'];
            $itemName = $item['name'];

            $itemHistory1 = array_filter($historyData1['result'], function ($history1) use ($itemId1) {
                return $history1['itemid'] == $itemId1;
            });

            // Batasi jumlah data riwayat menjadi 30
            $itemHistory1 = array_slice($itemHistory1, 0);

            $labels1 = [];
            $values1 = [];

            foreach ($itemHistory1 as $history1) {
                $labels1[] = date('H:i', $history1['clock']);
                $values1[] = floatval($history1['value']);
            }

            $chartData1[] = [
                'name' => $itemName,
                'labels' => $labels1,
                'values' => $values1,
            ];
        }

        return response()->json($chartData1);
    }

    public function CPUUtilization()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        // CPUUtilization
        $itemRes1 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '54200', // Ganti dengan item ID yang sesuai
                ],
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData1 = $itemRes1->json();
        $itemIds1 = array_column($itemData1['result'], 'itemid');

        // Mengumpulkan riwayat berdasarkan item ID
        $currentTime = time();
        $oneHourAgo = $currentTime - 1 * 60 * 60; // 1 jam sebelumnya
        $historyResponse1 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                'itemids' => $itemIds1,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'history' => 0,
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData1 = $historyResponse1->json();

        // Mengolah data untuk chart
        $chartDataa = [];
        foreach ($itemData1['result'] as $item) {
            $itemId1 = $item['itemid'];
            $itemName = $item['name'];

            $itemHistory1 = array_filter($historyData1['result'], function ($history1) use ($itemId1) {
                return $history1['itemid'] == $itemId1;
            });

            // Batasi jumlah data riwayat menjadi 30
            $itemHistory1 = array_slice($itemHistory1, 0);

            $labels1 = [];
            $values1 = [];

            foreach ($itemHistory1 as $history1) {
                $labels1[] = date('H:i', $history1['clock']);
                $values1[] = floatval($history1['value']);
            }

            $chartData1[] = [
                'name' => $itemName,
                'labels' => $labels1,
                'values' => $values1,
            ];
        }

        return response()->json($chartData1);
    }
}
