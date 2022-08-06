<?php

namespace App\Http\Controllers;

use App\Transaction;

class TransactionController extends Controller
{
    public function addTransaction()
    {
        if (!request()->has("json"))
            return ["status" => "error", "message" => "JSON query missing"];

        $json = json_decode(request("json"), true);

        $transactions = Transaction::create($json);

        if ($transactions->id)
            return ["status" => "ok"];
        return ["status" => "error", "message" => "Failed to persist record."];
    }

    public function bulkAddTransactions()
    {
        if (!request()->has("json"))
            return ["Status" => "error", "Message" => "JSON query missing"];

        $json = json_decode(request("json"), true);

        if (!is_array($json))
            return ["Status" => "error", "Message" => "Failed to Parse JSON"];

        try {
            \Log::info(request("json"));
            $transactions = Transaction::insert($json);
        } catch (\Exception $exception) {
            return ["Status" => "error", "Message" => $exception->getMessage()];
        }

        if ($transactions)
            return ["Status" => "ok", "Message" => "Transaction(s) successfully added!"];
        return ["Status" => "error", "Message" => "Failed to persist record."];
    }

    public function lastAutoIdx()
    {
        return Transaction::orderBy('AutoIdx', "DESC")->first(["AutoIdx"]);
    }
}
