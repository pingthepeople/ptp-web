<?php

namespace App\Http\Controllers;

use App\Bill;
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
        $bills = $user->bills;

        $csv = Writer::createFromFileObject(new \SplTempFileObject());

        $csv->insertOne(['Bill', 'Title', 'Description', 'Authors', 'Origin Chamber', 'Subjects']);

        foreach ($bills as $bill) {
            $csv->insertOne($bill->toRowArray());
        }

        $csv->output('bills.csv');
    }
}
