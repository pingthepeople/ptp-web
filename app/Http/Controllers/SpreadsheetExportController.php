<?php

namespace App\Http\Controllers;

use App\Bill;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\Csv\Writer;

class SpreadsheetExportController extends Controller
{
    public function myBillsToCsv()
    {
        $user = Auth::user();
        if(!$user) {
            return response('', 403);
        }

        $csv = Writer::createFromFileObject(new \SplTempFileObject());

        $client = new Client(['timeout'=>60]);
        $response = $client->request('POST', env('BILL_REPORT_URL'), ['json'=>[
            'Id' => $user->id,
            'Secret' => env('BILL_REPORT_SECRET')
        ]]);
        $bills = json_decode($response->getBody(), true);

        $csv->insertOne(array_keys($bills[0]));
        foreach ($bills as $bill) {
            $csv->insertOne($bill);
        }

        $csv->output('bills.csv');
    }
}
