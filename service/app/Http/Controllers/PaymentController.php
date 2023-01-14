<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::with(['transaction', 'transaction.transactionDetails', 'transaction.user'])->get();
        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $payments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        DB::beginTransaction();

        try {


            $transaction = Transaction::create([
                'user_id' => Auth::user()->id,
                'total' => $request->total,
            ]);

            Payment::create([
                'transaction_id' => $transaction->id,
                'method' => $request->method,
                'amount' => $request->amount,
                'date' => Carbon::now(),
                'status' => 'waiting',
            ]);

            $products = $request->products;

            foreach ($products as $product) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product['id'],
                    'qty' => $product['qty'],
                    'price' => $product['price'] * $product['qty'],
                ]);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }


        if ($request->method == 'bca') {
            $no_virtual_account = rand(1000000000, 9999999999);
            return response()->json([
                'message' => 'success',
                'code' => 200,
                'no_payment' => $no_virtual_account,
                'amount' => $request->amount,
                'method' => $request->method,
            ]);
        } else if ($request->method == 'gopay') {
            $telp = "085122334455";
            return response()->json([
                'message' => 'success',
                'code' => 200,
                'no_payment' => $telp,
                'amount' => $request->amount,
                'method' => $request->method,
            ]);
        } else if ($request->method == 'dana') {
            $telp = "085122334455";
            return response()->json([
                'message' => 'success',
                'code' => 200,
                'no_payment' => $telp,
                'amount' => $request->amount,
                'method' => $request->method,
            ]);
        } else if ($request->method == 'ovo') {
            $telp = "085122334455";
            return response()->json([
                'message' => 'success',
                'code' => 200,
                'no_payment' => $telp,
                'amount' => $request->amount,
                'method' => $request->method,
            ]);
        } else {
            return response()->json([
                'message' => 'failed',
                'code' => 400,
            ]);
        }
    }

    public function changeStatus(Request $request, $id)
    {
        $payment = Payment::find($id);
        $payment->status = $request->status;
        $payment->save();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $payment
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
