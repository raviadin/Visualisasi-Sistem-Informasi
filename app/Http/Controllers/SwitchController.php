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


        //•	Network traffic int 1/4/1 Downlink Main Office (core switch)  
        $itemResponse4 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => ['65037', '65130'], // Ganti dengan item ID yang sesuai
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

        //•	•	Network traffic int 1/2/1 Downlink Hall 1 (core switch) 
        $itemResponse5 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => ['69575', '69668'], // Ganti dengan item ID yang sesuai
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
            $chartData5[] = [
                'name' => $itemName5,
                'data' => array_column($itemHistory5, 'value'),
            ];
        }



        //•	Network traffic int 1/2/2 Downlink Workshop (core switch) 
        $itemResponse6 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => ['69576', '69669'], // Ganti dengan item ID yang sesuai
                ],
                'limit' => 10,
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



        //•	Network traffic int 1/4/2 Downlink Hall 2 (core switch) (69584) (69677)
        $itemResponse7 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => ['69584', '69677'], // Ganti dengan item ID yang sesuai
                ],
                'limit' => 10,
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



        //•	•	Network traffic int 1/4/3 Downlink Hall 3 (core switch) (69585) (69678)
        $itemResponse8 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => ['69585', '69678'], // Ganti dengan item ID yang sesuai
                ],
                'limit' => 10,
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




        //•	Network traffic int 1/3/1 Downlink Small office 1(core switch) (65033) (65126)
        $itemResponse9 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => ['65033', '65126'], // Ganti dengan item ID yang sesuai
                ],
                'limit' => 10,
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
        



        //•	Network traffic int 1/3/1 Downlink Small office 2(core switch) (69579) (69672)
        $itemResponse10 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => ['69579', '69672'], // Ganti dengan item ID yang sesuai
                ],
                'limit' => 10,
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
                'name' => $itemName10,
                'data' => array_column($itemHistory10, 'value'),
            ];
        }




        //•	Network traffic int 1/3/3 Downlink Security 1(core switch) (65035) (65128)
        $itemResponse11 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => ['65035', '65128'], // Ganti dengan item ID yang sesuai
                ],
                'limit' => 10,
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
                'name' => $itemName11,
                'data' => array_column($itemHistory11, 'value'),
            ];
        }

        


        //•	Network traffic int 1/3/4 Downlink Security 2(core switch) (65036) (65129)
        $itemResponse12 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => ['65036', '65129'], // Ganti dengan item ID yang sesuai
                ],
                'limit' => 10,
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
                'name' => $itemName12,
                'data' => array_column($itemHistory12, 'value'),
            ];
        }      

        


        //•	Network traffic int 1/2/1 ISP Cyberplus (WAN switch) (69843) (69853)
        $itemResponse13 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => ['69843', '69853'], // Ganti dengan item ID yang sesuai
                ],
                'limit' => 10,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData13 = $itemResponse13->json();
        $itemIds13 = array_column($itemData13['result'], 'itemid');

        // Panggil API Zabbix untuk mendapatkan riwayat berdasarkan item ID
        $historyResponse13 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                "itemids" =>  $itemIds13,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData13 = $historyResponse13->json();

        $data13 =  [
            'items' => $itemData13['result'],
            'history' => $historyData13['result'],
        ];

        // Mengolah data untuk chart
        $chartData13 = [];
        foreach ($itemData13['result'] as $item13) {
            $itemId13 = $item13['itemid'];
            $itemName13 = $item13['name'];
            $itemHistory13 = array_filter($historyData13['result'], function ($history13) use ($itemId13) {
                return $history13['itemid'] == $itemId13;
            });
            $chartData13[] = [
                'name' => $itemName13,
                'data' => array_column($itemHistory13, 'value'),
            ];
        }


        

        //•	Network traffic int 1/1/2 ISP Linknet (WAN switch) (69873) (69883)
        $itemResponse14 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => ['69873', '69883'], // Ganti dengan item ID yang sesuai
                ],
                'limit' => 10,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData14 = $itemResponse14->json();
        $itemIds14 = array_column($itemData14['result'], 'itemid');

        // Panggil API Zabbix untuk mendapatkan riwayat berdasarkan item ID
        $historyResponse14 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                "itemids" =>  $itemIds14,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData14 = $historyResponse14->json();

        $data14 =  [
            'items' => $itemData14['result'],
            'history' => $historyData14['result'],
        ];

        // Mengolah data untuk chart
        $chartData14 = [];
        foreach ($itemData14['result'] as $item14) {
            $itemId14 = $item14['itemid'];
            $itemName14 = $item14['name'];
            $itemHistory14 = array_filter($historyData14['result'], function ($history14) use ($itemId14) {
                return $history14['itemid'] == $itemId14;
            });
            $chartData14[] = [
                'name' => $itemName14,
                'data' => array_column($itemHistory14, 'value'),
            ];
        }


        //•	Network traffic int 1/1/24 ISP Linknet (Core switch) (65027) (65120)
        $itemResponse15 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'filter' => [
                    'itemid' => ['65027', '65120'], // Ganti dengan item ID yang sesuai
                ],
                'limit' => 10,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $itemData15 = $itemResponse15->json();
        $itemIds15 = array_column($itemData15['result'], 'itemid');

        // Panggil API Zabbix untuk mendapatkan riwayat berdasarkan item ID
        $historyResponse15 = Http::withOptions([
            'timeout' => 60,
        ])->post($url, [
            'jsonrpc' => '2.0',
            'method' => 'history.get',
            'params' => [
                'output' => 'extend',
                "itemids" =>  $itemIds15,
                'sortfield' => 'clock',
                'sortorder' => 'DESC',
                'time_from' => $oneHourAgo,
                'time_till' => $currentTime,
            ],
            'auth' => $token,
            'id' => 1,
        ]);

        $historyData15 = $historyResponse15->json();

        $data15 =  [
            'items' => $itemData15['result'],
            'history' => $historyData15['result'],
        ];

        // Mengolah data untuk chart
        $chartData15 = [];
        foreach ($itemData15['result'] as $item15) {
            $itemId15 = $item15['itemid'];
            $itemName15 = $item15['name'];
            $itemHistory15 = array_filter($historyData15['result'], function ($history15) use ($itemId15) {
                return $history15['itemid'] == $itemId15;
            });
            $chartData15[] = [
                'name' => $itemName15,
                'data' => array_column($itemHistory15, 'value'),
            ];
        }

        


        return view('switch', compact('chartData4', 'chartData5', 'chartData6', 'chartData7', 'chartData8', 'chartData9', 'chartData10', 'chartData11', 'chartData12', 'chartData13', 'chartData14', 'chartData15'));
    }

    // public function Networktrafficint112Uplink()
    // {
    //     $url = env('ZABBIX_API_URL');
    //     $token = env('ZABBIX_API_TOKEN');

    //     // Network Traffic Cyberplus (Firewall)
    //     $itemRes = Http::withOptions([
    //         'timeout' => 60,
    //     ])->post($url, [
    //         'jsonrpc' => '2.0',
    //         'method' => 'item.get',
    //         'params' => [
    //             'output' => 'extend',
    //             'filter' => [
    //                 'itemid' => ['69551', '69644'], // Ganti dengan item ID yang sesuai
    //             ],
    //             // 'limit' => 10,
    //         ],
    //         'auth' => $token,
    //         'id' => 1,
    //     ]);

    //     $itemData = $itemRes->json();
    //     $itemIds = array_column($itemData['result'], 'itemid');

    //     // Mengumpulkan riwayat berdasarkan item ID
    //     $currentTime = time();
    //     $oneHourAgo = $currentTime - (1 * 60 * 60); // 1 jam sebelumnya
    //     $historyResponse = Http::withOptions([
    //         'timeout' => 60,
    //     ])->post($url, [
    //         'jsonrpc' => '2.0',
    //         'method' => 'history.get',
    //         'params' => [
    //             'output' => 'extend',
    //             'itemids' => $itemIds,
    //             'sortfield' => 'clock',
    //             'sortorder' => 'DESC',
    //             // 'limit' => 30,
    //             'time_from' => $oneHourAgo,
    //             'time_till' => $currentTime,
    //         ],
    //         'auth' => $token,
    //         'id' => 1,
    //     ]);

    //     $historyData = $historyResponse->json();

    //     // Mengolah data untuk chart
    //     $chartDataa = [];
    //     foreach ($itemData['result'] as $item) {

    //         $itemId = $item['itemid'];
    //         $itemName = $item['name'];

    //         $itemHistory = array_filter($historyData['result'], function ($history) use ($itemId) {
    //             return $history['itemid'] == $itemId;
    //         });

    //         // Batasi jumlah data riwayat menjadi 30
    //         $itemHistory = array_slice($itemHistory, 0);

    //         $labels = [];
    //         $values = [];

    //         foreach ($itemHistory as $history) {
    //             $labels[] = date('H:i', $history['clock']);
    //             $values[] = floatval($history['value']);
    //         }

    //         $chartData[] = [
    //             'name' => $itemName,
    //             'labels' => $labels,
    //             'values' => $values,

    //         ];
    //     }

    //     return response()->json($chartData);
    // }

    // public function Networktrafficint113Downlink()
    // {
    //     $url = env('ZABBIX_API_URL');
    //     $token = env('ZABBIX_API_TOKEN');

    //     // Network Traffic Cyberplus (Firewall)
    //     $itemRes = Http::withOptions([
    //         'timeout' => 60,
    //     ])->post($url, [
    //         'jsonrpc' => '2.0',
    //         'method' => 'item.get',
    //         'params' => [
    //             'output' => 'extend',
    //             'filter' => [
    //                 'itemid' => ['69552', '69552'], // Ganti dengan item ID yang sesuai
    //             ],
    //             // 'limit' => 10,
    //         ],
    //         'auth' => $token,
    //         'id' => 1,
    //     ]);

    //     $itemData = $itemRes->json();
    //     $itemIds = array_column($itemData['result'], 'itemid');

    //     // Mengumpulkan riwayat berdasarkan item ID
    //     $currentTime = time();
    //     $oneHourAgo = $currentTime - (1 * 60 * 60); // 1 jam sebelumnya
    //     $historyResponse = Http::withOptions([
    //         'timeout' => 60,
    //     ])->post($url, [
    //         'jsonrpc' => '2.0',
    //         'method' => 'history.get',
    //         'params' => [
    //             'output' => 'extend',
    //             'itemids' => $itemIds,
    //             'sortfield' => 'clock',
    //             'sortorder' => 'DESC',
    //             // 'limit' => 30,
    //             'time_from' => $oneHourAgo,
    //             'time_till' => $currentTime,
    //         ],
    //         'auth' => $token,
    //         'id' => 1,
    //     ]);

    //     $historyData = $historyResponse->json();

    //     // Mengolah data untuk chart
    //     $chartDataa = [];
    //     foreach ($itemData['result'] as $item) {

    //         $itemId = $item['itemid'];
    //         $itemName = $item['name'];

    //         $itemHistory = array_filter($historyData['result'], function ($history) use ($itemId) {
    //             return $history['itemid'] == $itemId;
    //         });

    //         // Batasi jumlah data riwayat menjadi 30
    //         $itemHistory = array_slice($itemHistory, 0);

    //         $labels = [];
    //         $values = [];

    //         foreach ($itemHistory as $history) {
    //             $labels[] = date('H:i', $history['clock']);
    //             $values[] = floatval($history['value']);
    //         }

    //         $chartData[] = [
    //             'name' => $itemName,
    //             'labels' => $labels,
    //             'values' => $values,

    //         ];
    //     }

    //     return response()->json($chartData);
    // }

    // public function Networktrafficint212Uplink()
    // {
    //     $url = env('ZABBIX_API_URL');
    //     $token = env('ZABBIX_API_TOKEN');

    //     // Network Traffic Cyberplus (Firewall)
    //     $itemRes = Http::withOptions([
    //         'timeout' => 60,
    //     ])->post($url, [
    //         'jsonrpc' => '2.0',
    //         'method' => 'item.get',
    //         'params' => [
    //             'output' => 'extend',
    //             'filter' => [
    //                 'itemid' => ['69587', '69680'], // Ganti dengan item ID yang sesuai
    //             ],
    //             // 'limit' => 10,
    //         ],
    //         'auth' => $token,
    //         'id' => 1,
    //     ]);

    //     $itemData = $itemRes->json();
    //     $itemIds = array_column($itemData['result'], 'itemid');

    //     // Mengumpulkan riwayat berdasarkan item ID
    //     $currentTime = time();
    //     $oneHourAgo = $currentTime - (1 * 60 * 60); // 1 jam sebelumnya
    //     $historyResponse = Http::withOptions([
    //         'timeout' => 60,
    //     ])->post($url, [
    //         'jsonrpc' => '2.0',
    //         'method' => 'history.get',
    //         'params' => [
    //             'output' => 'extend',
    //             'itemids' => $itemIds,
    //             'sortfield' => 'clock',
    //             'sortorder' => 'DESC',
    //             // 'limit' => 30,
    //             'time_from' => $oneHourAgo,
    //             'time_till' => $currentTime,
    //         ],
    //         'auth' => $token,
    //         'id' => 1,
    //     ]);

    //     $historyData = $historyResponse->json();

    //     // Mengolah data untuk chart
    //     $chartDataa = [];
    //     foreach ($itemData['result'] as $item) {

    //         $itemId = $item['itemid'];
    //         $itemName = $item['name'];

    //         $itemHistory = array_filter($historyData['result'], function ($history) use ($itemId) {
    //             return $history['itemid'] == $itemId;
    //         });

    //         // Batasi jumlah data riwayat menjadi 30
    //         $itemHistory = array_slice($itemHistory, 0);

    //         $labels = [];
    //         $values = [];

    //         foreach ($itemHistory as $history) {
    //             $labels[] = date('H:i', $history['clock']);
    //             $values[] = floatval($history['value']);
    //         }

    //         $chartData[] = [
    //             'name' => $itemName,
    //             'labels' => $labels,
    //             'values' => $values,

    //         ];
    //     }

    //     return response()->json($chartData);
    // }

    // public function Networktrafficint213Downlink()
    // {
    //     $url = env('ZABBIX_API_URL');
    //     $token = env('ZABBIX_API_TOKEN');

    //     // Network Traffic Cyberplus (Firewall)
    //     $itemRes = Http::withOptions([
    //         'timeout' => 60,
    //     ])->post($url, [
    //         'jsonrpc' => '2.0',
    //         'method' => 'item.get',
    //         'params' => [
    //             'output' => 'extend',
    //             'filter' => [
    //                 'itemid' => ['69588', '69681'], // Ganti dengan item ID yang sesuai
    //             ],
    //             // 'limit' => 10,
    //         ],
    //         'auth' => $token,
    //         'id' => 1,
    //     ]);

    //     $itemData = $itemRes->json();
    //     $itemIds = array_column($itemData['result'], 'itemid');

    //     // Mengumpulkan riwayat berdasarkan item ID
    //     $currentTime = time();
    //     $oneHourAgo = $currentTime - (1 * 60 * 60); // 1 jam sebelumnya
    //     $historyResponse = Http::withOptions([
    //         'timeout' => 60,
    //     ])->post($url, [
    //         'jsonrpc' => '2.0',
    //         'method' => 'history.get',
    //         'params' => [
    //             'output' => 'extend',
    //             'itemids' => $itemIds,
    //             'sortfield' => 'clock',
    //             'sortorder' => 'DESC',
    //             // 'limit' => 30,
    //             'time_from' => $oneHourAgo,
    //             'time_till' => $currentTime,
    //         ],
    //         'auth' => $token,
    //         'id' => 1,
    //     ]);

    //     $historyData = $historyResponse->json();

    //     // Mengolah data untuk chart
    //     $chartDataa = [];
    //     foreach ($itemData['result'] as $item) {

    //         $itemId = $item['itemid'];
    //         $itemName = $item['name'];

    //         $itemHistory = array_filter($historyData['result'], function ($history) use ($itemId) {
    //             return $history['itemid'] == $itemId;
    //         });

    //         // Batasi jumlah data riwayat menjadi 30
    //         $itemHistory = array_slice($itemHistory, 0);

    //         $labels = [];
    //         $values = [];

    //         foreach ($itemHistory as $history) {
    //             $labels[] = date('H:i', $history['clock']);
    //             $values[] = floatval($history['value']);
    //         }

    //         $chartData[] = [
    //             'name' => $itemName,
    //             'labels' => $labels,
    //             'values' => $values,

    //         ];
    //     }

    //     return response()->json($chartData);
    // }

    public function Networktrafficint141DownlinkMainOffice()
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
                    'itemid' => ['65037', '65130'], // Ganti dengan item ID yang sesuai
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

    public function Networktrafficint121DownlinkHall1()
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
                    'itemid' => ['69575', '69668'], // Ganti dengan item ID yang sesuai
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


    public function Networktrafficint122DownlinkWorkshop()
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
                    'itemid' => ['69576', '69669'], // Ganti dengan item ID yang sesuai
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


    public function Networktrafficint142DownlinkHall2()
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
                    'itemid' => ['69584', '69677'], // Ganti dengan item ID yang sesuai
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

    public function Networktrafficint143DownlinkHall3()
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
                    'itemid' => ['69585', '69678'], // Ganti dengan item ID yang sesuai
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


    public function Networktrafficint131DownlinkSmalloffice1()
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
                    'itemid' => ['65033', '65126'], // Ganti dengan item ID yang sesuai
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


    public function Networktrafficint131DownlinkSmalloffice2()
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
                    'itemid' => ['69579', '69672'], // Ganti dengan item ID yang sesuai
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


    // public function Networktrafficint133DownlinkSecurity1()
    // {
    //     $url = env('ZABBIX_API_URL');
    //     $token = env('ZABBIX_API_TOKEN');

    //     // Network Traffic Cyberplus (Firewall)
    //     $itemRes = Http::withOptions([
    //         'timeout' => 60,
    //     ])->post($url, [
    //         'jsonrpc' => '2.0',
    //         'method' => 'item.get',
    //         'params' => [
    //             'output' => 'extend',
    //             'filter' => [
    //                 'itemid' => ['65035', '65128'], // Ganti dengan item ID yang sesuai
    //             ],
    //             // 'limit' => 10,
    //         ],
    //         'auth' => $token,
    //         'id' => 1,
    //     ]);

    //     $itemData = $itemRes->json();
    //     $itemIds = array_column($itemData['result'], 'itemid');

    //     // Mengumpulkan riwayat berdasarkan item ID
    //     $currentTime = time();
    //     $oneHourAgo = $currentTime - (1 * 60 * 60); // 1 jam sebelumnya
    //     $historyResponse = Http::withOptions([
    //         'timeout' => 60,
    //     ])->post($url, [
    //         'jsonrpc' => '2.0',
    //         'method' => 'history.get',
    //         'params' => [
    //             'output' => 'extend',
    //             'itemids' => $itemIds,
    //             'sortfield' => 'clock',
    //             'sortorder' => 'DESC',
    //             // 'limit' => 30,
    //             'time_from' => $oneHourAgo,
    //             'time_till' => $currentTime,
    //         ],
    //         'auth' => $token,
    //         'id' => 1,
    //     ]);

    //     $historyData = $historyResponse->json();

    //     // Mengolah data untuk chart
    //     $chartDataa = [];
    //     foreach ($itemData['result'] as $item) {

    //         $itemId = $item['itemid'];
    //         $itemName = $item['name'];

    //         $itemHistory = array_filter($historyData['result'], function ($history) use ($itemId) {
    //             return $history['itemid'] == $itemId;
    //         });

    //         // Batasi jumlah data riwayat menjadi 30
    //         $itemHistory = array_slice($itemHistory, 0);

    //         $labels = [];
    //         $values = [];

    //         foreach ($itemHistory as $history) {
    //             $labels[] = date('H:i', $history['clock']);
    //             $values[] = floatval($history['value']);
    //         }

    //         $chartData[] = [
    //             'name' => $itemName,
    //             'labels' => $labels,
    //             'values' => $values,

    //         ];
    //     }

    //     return response()->json($chartData);
    // }

    // public function Networktrafficint134DownlinkSecurity2()
    // {
    //     $url = env('ZABBIX_API_URL');
    //     $token = env('ZABBIX_API_TOKEN');

    //     // Network Traffic Cyberplus (Firewall)
    //     $itemRes = Http::withOptions([
    //         'timeout' => 60,
    //     ])->post($url, [
    //         'jsonrpc' => '2.0',
    //         'method' => 'item.get',
    //         'params' => [
    //             'output' => 'extend',
    //             'filter' => [
    //                 'itemid' => ['65036', '65129'], // Ganti dengan item ID yang sesuai
    //             ],
    //             // 'limit' => 10,
    //         ],
    //         'auth' => $token,
    //         'id' => 1,
    //     ]);

    //     $itemData = $itemRes->json();
    //     $itemIds = array_column($itemData['result'], 'itemid');

    //     // Mengumpulkan riwayat berdasarkan item ID
    //     $currentTime = time();
    //     $oneHourAgo = $currentTime - (1 * 60 * 60); // 1 jam sebelumnya
    //     $historyResponse = Http::withOptions([
    //         'timeout' => 60,
    //     ])->post($url, [
    //         'jsonrpc' => '2.0',
    //         'method' => 'history.get',
    //         'params' => [
    //             'output' => 'extend',
    //             'itemids' => $itemIds,
    //             'sortfield' => 'clock',
    //             'sortorder' => 'DESC',
    //             // 'limit' => 30,
    //             'time_from' => $oneHourAgo,
    //             'time_till' => $currentTime,
    //         ],
    //         'auth' => $token,
    //         'id' => 1,
    //     ]);

    //     $historyData = $historyResponse->json();

    //     // Mengolah data untuk chart
    //     $chartDataa = [];
    //     foreach ($itemData['result'] as $item) {

    //         $itemId = $item['itemid'];
    //         $itemName = $item['name'];

    //         $itemHistory = array_filter($historyData['result'], function ($history) use ($itemId) {
    //             return $history['itemid'] == $itemId;
    //         });

    //         // Batasi jumlah data riwayat menjadi 30
    //         $itemHistory = array_slice($itemHistory, 0);

    //         $labels = [];
    //         $values = [];

    //         foreach ($itemHistory as $history) {
    //             $labels[] = date('H:i', $history['clock']);
    //             $values[] = floatval($history['value']);
    //         }

    //         $chartData[] = [
    //             'name' => $itemName,
    //             'labels' => $labels,
    //             'values' => $values,

    //         ];
    //     }

    //     return response()->json($chartData);
    // }

    public function Networktrafficint121ISPCyberplus()
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
                    'itemid' => ['69843', '69853'], // Ganti dengan item ID yang sesuai
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

    // public function Networktrafficint112ISPLinknet()
    // {
    //     $url = env('ZABBIX_API_URL');
    //     $token = env('ZABBIX_API_TOKEN');

    //     // Network Traffic Cyberplus (Firewall)
    //     $itemRes = Http::withOptions([
    //         'timeout' => 60,
    //     ])->post($url, [
    //         'jsonrpc' => '2.0',
    //         'method' => 'item.get',
    //         'params' => [
    //             'output' => 'extend',
    //             'filter' => [
    //                 'itemid' => ['69873', '69883'], // Ganti dengan item ID yang sesuai
    //             ],
    //             // 'limit' => 10,
    //         ],
    //         'auth' => $token,
    //         'id' => 1,
    //     ]);

    //     $itemData = $itemRes->json();
    //     $itemIds = array_column($itemData['result'], 'itemid');

    //     // Mengumpulkan riwayat berdasarkan item ID
    //     $currentTime = time();
    //     $oneHourAgo = $currentTime - (1 * 60 * 60); // 1 jam sebelumnya
    //     $historyResponse = Http::withOptions([
    //         'timeout' => 60,
    //     ])->post($url, [
    //         'jsonrpc' => '2.0',
    //         'method' => 'history.get',
    //         'params' => [
    //             'output' => 'extend',
    //             'itemids' => $itemIds,
    //             'sortfield' => 'clock',
    //             'sortorder' => 'DESC',
    //             // 'limit' => 30,
    //             'time_from' => $oneHourAgo,
    //             'time_till' => $currentTime,
    //         ],
    //         'auth' => $token,
    //         'id' => 1,
    //     ]);

    //     $historyData = $historyResponse->json();

    //     // Mengolah data untuk chart
    //     $chartDataa = [];
    //     foreach ($itemData['result'] as $item) {

    //         $itemId = $item['itemid'];
    //         $itemName = $item['name'];

    //         $itemHistory = array_filter($historyData['result'], function ($history) use ($itemId) {
    //             return $history['itemid'] == $itemId;
    //         });

    //         // Batasi jumlah data riwayat menjadi 30
    //         $itemHistory = array_slice($itemHistory, 0);

    //         $labels = [];
    //         $values = [];

    //         foreach ($itemHistory as $history) {
    //             $labels[] = date('H:i', $history['clock']);
    //             $values[] = floatval($history['value']);
    //         }

    //         $chartData[] = [
    //             'name' => $itemName,
    //             'labels' => $labels,
    //             'values' => $values,

    //         ];
    //     }

    //     return response()->json($chartData);
    // }

    public function Networktrafficint1124ISPLinknet()
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
                    'itemid' => ['65027', '65120'], // Ganti dengan item ID yang sesuai
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


}
