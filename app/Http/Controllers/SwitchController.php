<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SwitchController extends Controller
{
    public function index()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        $currentTime = time();
        $oneHourAgo = $currentTime - (1 * 60 * 60); // 1 jam sebelumnya

        //•	Ping Core Switch  
        $itemResponse = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '64581', // Ganti dengan item ID yang sesuai
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
                "itemids" =>  $itemIds,
                'history' => 0,
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

        //•	Ping Access Switch Main Office  
        $itemResponse1 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '71427', // Ganti dengan item ID yang sesuai
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
                "itemids" =>  $itemIds1,
                'history' => 0,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
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

        //•	Ping Access Switch Hall 1 
        $itemResponse2 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '60052', // Ganti dengan item ID yang sesuai
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
                "itemids" =>  $itemIds2,
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

        $data2 =  [
            'items' => $itemData2['result'],
            'history' => $historyData2['result'],
        ];

        // Mengolah data untuk chart
        $chartData2 = [];
        foreach ($itemData2['result'] as $item2) {
            $itemId2 = $item2['itemid'];
            $itemName2 = $item2['name'];
            $itemHistory2 = array_filter($historyData2['result'], function ($history2) use ($itemId2) {
                return $history2['itemid'] == $itemId2;
            });
            $chartData2[] = [
                'name' => $itemName2,
                'data' => array_column($itemHistory2, 'value'),
            ];
        }

        //•	Ping Access Switch Workshop 
        $itemResponse3 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '64025', // Ganti dengan item ID yang sesuai
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
                "itemids" =>  $itemIds3,
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

        //•	Ping Access Switch Hall 2
        $itemResponse4 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '72761', // Ganti dengan item ID yang sesuai
                ],
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

        //•	Ping Access Switch Hall 3
        $itemResponse5 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '61110', // Ganti dengan item ID yang sesuai
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
                "itemids" =>  $itemIds5,
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
            $chartData5[] = [
                'name' => $itemName5,
                'data' => array_column($itemHistory5, 'value'),
            ];
        }

        
        //•	Ping Access Switch Small Office Area 1
        $itemResponse6 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '63254', // Ganti dengan item ID yang sesuai
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
                "itemids" =>  $itemIds6,
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

        $data6 =  [
            'items' => $itemData6['result'],
            'history' => $historyData6['result'],
        ];

        // Mengolah data untuk chart
        $chartData6 = [];
        foreach ($itemData6['result'] as $item6) {
            $itemId6 = $item6['itemid'];
            $itemName6 = $item6['name'];
            $itemHistory6 = array_filter($historyData6['result'], function ($history6) use ($itemId6) {
                return $history6['itemid'] == $itemId6;
            });
            $chartData6[] = [
                'name' => $itemName6,
                'data' => array_column($itemHistory6, 'value'),
            ];
        }
        

        //•	Ping Access Switch Small Office Area 2
        $itemResponse7 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '63983', // Ganti dengan item ID yang sesuai
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
                "itemids" =>  $itemIds7,
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

        $data7 =  [
            'items' => $itemData7['result'],
            'history' => $historyData7['result'],
        ];

        // Mengolah data untuk chart
        $chartData7 = [];
        foreach ($itemData7['result'] as $item7) {
            $itemId7 = $item7['itemid'];
            $itemName7 = $item7['name'];
            $itemHistory7 = array_filter($historyData7['result'], function ($history7) use ($itemId7) {
                return $history7['itemid'] == $itemId7;
            });
            $chartData7[] = [
                'name' => $itemName7,
                'data' => array_column($itemHistory7, 'value'),
            ];
        }

        //•	Ping Access Switch Security Front
        $itemResponse8 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '62999', // Ganti dengan item ID yang sesuai
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
                "itemids" =>  $itemIds8,
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

        $data8 =  [
            'items' => $itemData8['result'],
            'history' => $historyData8['result'],
        ];

        // Mengolah data untuk chart
        $chartData8 = [];
        foreach ($itemData8['result'] as $item8) {
            $itemId8 = $item8['itemid'];
            $itemName8 = $item8['name'];
            $itemHistory8 = array_filter($historyData8['result'], function ($history8) use ($itemId8) {
                return $history8['itemid'] == $itemId8;
            });
            $chartData8[] = [
                'name' => $itemName8,
                'data' => array_column($itemHistory8, 'value'),
            ];
        }

        //•	Ping Access Switch Security Side
        $itemResponse9 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '63041', // Ganti dengan item ID yang sesuai
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
                "itemids" =>  $itemIds9,
                'history' => 0,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData9 = $historyResponse9->json();

        $data9 =  [
            'items' => $itemData9['result'],
            'history' => $historyData9['result'],
        ];

        // Mengolah data untuk chart
        $chartData9 = [];
        foreach ($itemData9['result'] as $item9) {
            $itemId9 = $item9['itemid'];
            $itemName9 = $item9['name'];
            $itemHistory9 = array_filter($historyData9['result'], function ($history9) use ($itemId9) {
                return $history9['itemid'] == $itemId9;
            });
            $chartData9[] = [
                'name' => $itemName9,
                'data' => array_column($itemHistory9, 'value'),
            ];
        }

        //•	Ping Server Farm Switch
        $itemResponse10 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '65885', // Ganti dengan item ID yang sesuai
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
                "itemids" =>  $itemIds10,
                'history' => 0,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData10 = $historyResponse10->json();

        $data10 =  [
            'items' => $itemData10['result'],
            'history' => $historyData10['result'],
        ];

        // Mengolah data untuk chart
        $chartData10 = [];
        foreach ($itemData10['result'] as $item10) {
            $itemId10 = $item10['itemid'];
            $itemName10 = $item10['name'];
            $itemHistory10 = array_filter($historyData10['result'], function ($history10) use ($itemId10) {
                return $history10['itemid'] == $itemId10;
            });
            $chartData10[] = [
                'name' => $itemName,
                'data' => array_column($itemHistory, 'value'),
            ];
        }

        //•	Ping WAN Distribution Switch ISP Cyberplus
        $itemResponse11 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '64925', // Ganti dengan item ID yang sesuai
                ],
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData11 = $itemResponse11->json();
        $itemIds11 = array_column($itemData11['result'], 'itemid');

        // Panggil API Zabbix untuk mendapatkan riwayat berdasarkan item ID
        $historyResponse11 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                "itemids" =>  $itemIds11,
                'history' => 0,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData11 = $historyResponse11->json();

        $data11 =  [
            'items' => $itemData11['result'],
            'history' => $historyData11['result'],
        ];

        // Mengolah data untuk chart
        $chartData11 = [];
        foreach ($itemData11['result'] as $item11) {
            $itemId11 = $item11['itemid'];
            $itemName11 = $item11['name'];
            $itemHistory11 = array_filter($historyData11['result'], function ($history11) use ($itemId11) {
                return $history11['itemid'] == $itemId11;
            });
            $chartData11[] = [
                'name' => $itemName,
                'data' => array_column($itemHistory, 'value'),
            ];
        }
        
        
        //•	Ping WAN Distribution Switch ISP Linknet
        $itemResponse12 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '65843', // Ganti dengan item ID yang sesuai
                ],
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData12 = $itemResponse12->json();
        $itemIds12 = array_column($itemData12['result'], 'itemid');

        // Panggil API Zabbix untuk mendapatkan riwayat berdasarkan item ID
        $historyResponse12 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                "itemids" =>  $itemIds12,
                'history' => 0,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData12 = $historyResponse12->json();

        $data12 =  [
            'items' => $itemData12['result'],
            'history' => $historyData12['result'],
        ];

        // Mengolah data untuk chart
        $chartData12 = [];
        foreach ($itemData12['result'] as $item12) {
            $itemId12 = $item12['itemid'];
            $itemName12 = $item12['name'];
            $itemHistory12 = array_filter($historyData12['result'], function ($history12) use ($itemId12) {
                return $history12['itemid'] == $itemId12;
            });
            $chartData12[] = [
                'name' => $itemName,
                'data' => array_column($itemHistory, 'value'),
            ];
        }
        

        return view('switch', compact('chartData', 'chartData1', 'chartData2', 'chartData3', 'chartData4', 'chartData5', 'chartData6', 'chartData7', 'chartData8', 'chartData9', 'chartData10',  'chartData11', 'chartData12'));
    }

    public function PingCoreSwitch()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        // Ping Core Switch
        $itemRes = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '64581', // Ganti dengan item ID yang sesuai
                ],
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
                'history' => 0,
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


    public function PingAccessSwitchMainOffice()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        // PingAccessSwitchMainOffice
        $itemRes = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '71427', // Ganti dengan item ID yang sesuai
                ],
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
                'history' => 0,
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

    public function PingAccessSwitchHall1()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        // Networktrafficint121DownlinkHall1
        $itemRes = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '60052', // Ganti dengan item ID yang sesuai
                ],
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
                'history' => 0,
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


    public function PingAccessSwitchWorkshop()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        // Networktrafficint122DownlinkWorkshop
        $itemRes = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '64025', // Ganti dengan item ID yang sesuai
                ],
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
                'history' => 0,
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


    public function PingAccessSwitchHall2()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        // PingAccessSwitchHall2
        $itemRes = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '72761', // Ganti dengan item ID yang sesuai
                ],
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
                'history' => 0,
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

    public function PingAccessSwitchHall3()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        // PingAccessSwitchHall3
        $itemRes = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '61110', // Ganti dengan item ID yang sesuai
                ],
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
                'history' => 0,
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


    public function PingAccessSwitchSmallOfficeArea1()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        // PingAccessSwitchSmallOfficeArea1
        $itemRes = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '63254', // Ganti dengan item ID yang sesuai
                ],
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
                'history' => 0,
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


    public function PingAccessSwitchSmallOfficeArea2()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        // PingAccessSwitchSmallOfficeArea1
        $itemRes = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '63983', // Ganti dengan item ID yang sesuai
                ],
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
                'history' => 0,
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


    public function PingAccessSwitchSecurityFront()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        // PingAccessSwitchSecurityFront
        $itemRes = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '62999', // Ganti dengan item ID yang sesuai
                ],
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
                'history' => 0,
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

    public function PingAccessSwitchSecuritySide()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        // PingAccessSwitchSecuritySide
        $itemRes = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '63041', // Ganti dengan item ID yang sesuai
                ],
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
                'history' => 0,
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

    public function PingServerFarmSwitch()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        // PingServerFarmSwitch
        $itemRes = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '65885', // Ganti dengan item ID yang sesuai
                ],
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
                'history' => 0,
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

    public function PingWANDistributionSwitchISPCyberplus()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        // PingWANDistributionSwitchISPCyberplus
        $itemRes = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '64925', // Ganti dengan item ID yang sesuai
                ],
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
                'history' => 0,
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

    public function PingWANDistributionSwitchISPLinknet()
    {
        $url = env('ZABBIX_API_URL');
        $token = env('ZABBIX_API_TOKEN');

        // PingWANDistributionSwitchISPLinknet
        $itemRes = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => '65843', // Ganti dengan item ID yang sesuai
                ],
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
                'history' => 0,
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



}
