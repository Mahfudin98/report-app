<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ApiTransactionController extends Controller
{
    public function transactionStore(Request $request)
    {
        $this->validate($request, [
            // tabel transactions
            'member_id'         => $request->type_customer != 2 ? 'required' : 'nullable',
            'tanggal_transaksi' => 'required',
            'image'             => 'nullable|image|mimes:png,jpeg,jpg|max:500000',
            'expedisi'          => 'required',
            'ongkir'            => 'required',
            'origin_customer'   => 'required',
            'type_transaction'  => 'required',
            'type_customer'     => 'required',
            'catatan'           => 'nullable',

            // table customer
            'customer_name'     => $request->type_customer == 2 ? 'required' : 'nullable',
            'customer_phone'    => $request->type_customer == 2 ? 'required' : 'nullable',
            'customer_alamat'   => $request->type_customer == 2 ? 'required' : 'nullable',

            // table transaction_products
            'product_id'        => 'required',
            'product_name'      => 'required',
            'product_price'     => 'required',
            'qty'               => 'required',
            'discount'          => 'nullable',
        ]);

        $user = request()->user();

        $charactersLength = strlen(strtoupper('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'));
        $randomString = '';
        for ($i = 0; $i < 9; $i++) {
            $randomString .= strtoupper('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890')[rand(0, $charactersLength - 1)];
        }
        $code = $randomString . mt_rand(1000, 9999);

        $filename = '';

        if ($request->hasFile('image') != '') {
            $file = $request->file('image');
            $filename = time() . Str::slug($code) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/transaction', $filename);
        }

        DB::beginTransaction();

        try {

            $transaction = Transaction::create([
                'user_id'           => $user->id,
                'member_id'         => $request->member_id,
                'nomor_pesanan'     => $code,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'image'             => $filename,
                'expedisi'          => $request->expedisi,
                'ongkir'            => $request->ongkir,
                'origin_customer'   => $request->origin_customer,
                'type_transaction'  => $request->type_transaction,
                'type_customer'     => $request->type_customer,
                'catatan'           => $request->catatan
            ]);

            $data = $request->all();
            foreach ($data['qty'] as $item => $value) {
                $product = [
                    'transaction_id'    => $transaction->id,
                    'product_id'        => $data['product_id'][$item],
                    'product_name'      => $data['product_name'][$item],
                    'product_price'     => $data['product_price'][$item],
                    'qty'               => $data['qty'][$item],
                    'discount'          => $data['discount'][$item],
                    'jumlah_harga'      => $data['qty'][$item] * $data['product_price'][$item] - $data['discount'][$item]
                ];

                $transactionProduct = TransactionProduct::create($product);
            }

            if ($request->type_customer == 2) {
                $customer = Customer::create([
                    'user_id'           => $user->id,
                    'transaction_id'    => $transaction->id,
                    'customer_name'     => $request->customer_name,
                    'customer_phone'    => $request->customer_phone,
                    'customer_alamat'   => $request->customer_alamat
                ]);
            }
            DB::commit();
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
