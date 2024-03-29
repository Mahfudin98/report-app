<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Member;
use App\Models\Transaction;
use App\Models\TransactionProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Helpers\UserActivity as UserActivityHelper;
use App\Models\Order;
use App\Models\UserDetail;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class ApiTransactionController extends Controller
{
    public function index()
    {
        $user = request()->user();
        $start = Carbon::now()->startOfMonth()->format('Y-m-d');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d');


        $tr = DB::table('transactions')
            ->leftJoin('members', 'transactions.member_id', '=', 'members.id')
            ->leftJoin('customers', 'transactions.id', '=', 'customers.transaction_id')
            ->select(
                'transactions.*',
                'members.member_name',
                'members.member_alamat',
                'members.member_type',
                'customers.customer_name',
                'customers.customer_alamat',
            )
            ->where('transactions.user_id', $user->id)
            ->orderBy('transactions.tanggal_transaksi', 'DESC');
        if (request()->date != '') {
            $date = explode(' - ', request()->date);
            $start = Carbon::parse($date[0])->format('Y-m-d');
            $end = Carbon::parse($date[1])->format('Y-m-d');
            $tr = $tr->whereBetween('transactions.tanggal_transaksi', [$start, $end]);
        }
        $data = [];
        foreach ($tr->get() as $row) {
            $prod = TransactionProduct::where('transaction_id', $row->id)->get();
            $data[] = [
                'member' => $row->member_id == null ? 'customer' : 'member',
                'nama' => $row->member_id == null ? $row->customer_name : $row->member_name,
                'alamat' => $row->member_id == null ? $row->customer_alamat : $row->member_alamat,
                'nomor_pesanan' => $row->nomor_pesanan,
                'tanggal' => $row->tanggal_transaksi,
                'expedisi' => $row->expedisi,
                'ongkir' => $row->ongkir,
                'origin_customer' => $row->origin_customer == 0 ? 'Iklan ADV' : ($row->origin_customer == 1 ? 'Marketplace' : 'Reorder'),
                'type_transaction' => $row->type_transaction == 1 ? 'Transfer' : 'COD',
                'type_customer' => $row->member_id != null ? ($row->member_type == 1 ? 'Agen' : 'Reseller') : 'Customer',
                'produk' => $prod,
                'total_harga' => $prod->sum('jumlah_harga')
            ];
        }
        return response()->json($this->paginate($data), 200);
    }

    public function paginate($items, $perPage = 50, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function show($code)
    {
        $user = request()->user();
        $tr = DB::table('transactions')
            ->leftJoin('members', 'transactions.member_id', '=', 'members.id')
            ->leftJoin('customers', 'transactions.id', '=', 'customers.transaction_id')
            ->select(
                'transactions.*',
                'members.member_name',
                'members.member_alamat',
                'members.member_type',
                'members.member_phone',
                'customers.customer_name',
                'customers.customer_alamat',
                'customers.customer_phone',
            )
            ->where('transactions.user_id', $user->id)
            ->where('transactions.nomor_pesanan', $code)
            ->first();
        $prod = TransactionProduct::where('transaction_id', $tr->id)->get();
        $detail = DB::table('users')->join('user_details', 'users.id', '=', 'user_details.user_id')->join('divisions', 'users.division_id', '=', 'divisions.id')
            ->select(
                'users.email',
                'users.username',
                'user_details.nama_depan',
                'user_details.nama_belakang',
                'user_details.image',
                'user_details.alamat',
                'user_details.tanggal_lahir',
                'user_details.phone',
                'divisions.division_code',
                'divisions.division_name'
            )->where('users.id', $user->id)->first();
        $data = [
            // data cs
            'nama_cs' => $detail->nama_depan . " " . $detail->nama_belakang,
            'email_cs' => $detail->email,
            'phone_cs' => $detail->phone,
            'member' => $tr->member_id != null ? ($tr->member_type == 1 ? 'Agen' : 'Reseller') : 'Customer',
            'nama' => $tr->member_id == null ? $tr->customer_name : $tr->member_name,
            'alamat' => $tr->member_id == null ? $tr->customer_alamat : $tr->member_alamat,
            'phone' => $tr->member_id == null ? $tr->customer_phone : $tr->member_phone,
            'nomor_pesanan' => $tr->nomor_pesanan,
            'tanggal' => $tr->tanggal_transaksi,
            'expedisi' => $tr->expedisi,
            'ongkir' => $tr->ongkir,
            'origin_customer' => $tr->origin_customer == 0 ? 'Iklan ADV' : ($tr->origin_customer == 1 ? 'Marketplace' : 'Reorder'),
            'type_transaction' => $tr->type_transaction == 1 ? 'Transfer' : 'COD',
            'type_customer' => $tr->member_id != null ? ($tr->member_type == 1 ? 'Agen' : 'Reseller') : 'Customer',
            'produk' => $prod,
            'total_harga' => $prod->sum('jumlah_harga')
        ];
        return response()->json(['status' => 'success', 'data' => $data, 'message' => 'Data load successfully.'], 200);
    }

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
            'addition'          => 'nullable',
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
        } else {
            $filename = null;
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
                    'addition'          => $data['addition'][$item],
                    'jumlah_harga'      => $data['qty'][$item] * $data['product_price'][$item] - $data['discount'][$item] + $data['addition'][$item]
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
            Order::create([
                'user_id'        => $user->id,
                'transaction_id' => $transaction->id,
                'member_id'      => $request->type_customer != 2 ? $request->member_id : null,
                'customer_id'    => $request->type_customer == 2 ? $customer->id : null,
                'date'           => $request->tanggal_transaksi,
            ]);
            DB::commit();
            UserActivityHelper::addToLogTR($request->type_customer != 2 ? 'Add Transaction Member' : 'Add Transaction Customer', $request->tanggal_transaksi);
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function delete($code)
    {
        $user = request()->user();
        $tr = Transaction::where('nomor_pesanan', $code)->where('user_id', $user->id)->first();
        UserActivityHelper::addToLog($tr->type_customer != 2 ? 'Remove Transaction Member' : 'Remove Transaction Customer');
        $pr = TransactionProduct::where('transaction_id', $tr->id)->delete();
        $order = Order::where('transaction_id', $tr->id)->delete();
        $tr->delete();
        return response()->json(['status' => 'success']);
    }

    public function order()
    {
        if (request()->date != '') {
            $date = Carbon::parse(request()->date)->format('d');
        } else {
            $date = Carbon::today()->format('d');
        }
        $order = DB::table('orders')
            ->join('transactions', 'orders.transaction_id', '=', 'transactions.id')
            ->leftJoin('members', 'orders.member_id', '=', 'members.id')
            ->leftJoin('customers', 'orders.customer_id', '=', 'customers.id')
            ->select(
                'orders.*',
                'transactions.id',
                'transactions.nomor_pesanan',
                'transactions.image',
                'transactions.ongkir',
                'transactions.expedisi',
                'transactions.type_transaction',
                'transactions.origin_customer',
                'transactions.catatan',
                'members.member_name',
                'members.member_alamat',
                'members.member_phone',
                'customers.customer_name',
                'customers.customer_alamat',
                'customers.customer_phone',
            )->orderBy('orders.date', 'Desc')->whereDay('date', '=', $date)->get();
        $data = [];
        foreach ($order as $row) {
            // $prod = TransactionProduct::where('transaction_id', $row->id)->get();
            $prod = DB::table('transaction_products')->join('products', 'transaction_products.product_id', '=', 'products.id')
                ->select('transaction_products.*')
                ->where('transaction_id', $row->transaction_id)->selectRaw('products.product_weight * transaction_products.qty as weight')->get();
            $user = UserDetail::where('user_id', $row->user_id)->get();
            $data[] = [
                'member' => $row->member_id == null ? 'customer' : 'member',
                'user'  => $user[0]['nama_depan'] . ' ' . $user[0]['nama_belakang'],
                'nama' => $row->member_id == null ? $row->customer_name : $row->member_name,
                'alamat' => $row->member_id == null ? $row->customer_alamat : $row->member_alamat,
                'nomor_pesanan' => $row->nomor_pesanan,
                'tanggal' => $row->date,
                'phone' => $row->member_id != null ? $row->member_phone : $row->customer_phone,
                'ongkir' => $row->ongkir,
                'image' => $row->image != null ? Storage::disk('public')->url('transaction/' . $row->image) : null,
                'expedisi' => $row->expedisi,
                'type_transaction' => $row->type_transaction == 1 ? 'Transfer' : 'COD',
                'origin_customer' => $row->origin_customer == 0 ? 'Iklan ADV' : ($row->origin_customer == 1 ? 'Marketplace' : 'Repeat Order'),
                'produk' => $prod,
                'weight' => $prod->sum('weight'),
                'status' => $row->status,
                'total_harga' => $prod->sum('jumlah_harga')
            ];
        }
        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function updateOrder($code)
    {
        $tr = Transaction::where('nomor_pesanan', $code)->first();
        $order = Order::where('transaction_id', $tr->id)->first();
        $order->update([
            'status' => $order->status == 0 ? 1 : 0
        ]);
        return response()->json(['status' => 'success', 'data' => $order]);
    }
}