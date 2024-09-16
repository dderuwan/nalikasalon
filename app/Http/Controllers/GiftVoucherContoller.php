<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;


use App\Models\GiftVouchers;



class GiftVoucherContoller extends Controller
{
    public function index()
    {
        $GiftVouchers = GiftVouchers::all();
        return view('GiftVouchhers&Promotions.giftVouchers.index', compact('GiftVouchers'));
    }

    public function create()
    {
        return view('GiftVouchhers&Promotions.giftVouchers.create');
    }

    public function store(Request $request)
    {
        //dd($request);

        try {
            $request->validate([
                'price' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
            ]);

            $voucher = new GiftVouchers();
            $voucher->gift_voucher_Id = $this->generateVourcherID();
            $voucher->gift_voucher_name = $request->gift_voucher_name;
            $voucher->description = $request->description; 
            $voucher->price = $request->price;
            $voucher->start_date= $request->start_date;
            $voucher->end_date= $request->end_date;
            $voucher->save();

            notify()->success('Gift Voucher Created successfully. ⚡️', 'Success');
            return redirect()->route('GiftVoucher')->with('success', 'Gift Voucher created successfully.');
        } catch (Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

    private function generateVourcherID()
    {
        return 'GIFT-' . rand(1000, 9999);
    }

    public function edit($id)
    {
        $giftVoucher = GiftVouchers::findOrFail($id);  
        return view('GiftVouchhers&Promotions.giftVouchers.edit', compact('giftVoucher',)); 
    }


    public function update(Request $request, $id)
    {
        try {
            //dd($request);
            $request->validate([
                'price' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
            ]);

            $voucher = GiftVouchers::findOrFail($id);
            $voucher->gift_voucher_Id = $request->gift_voucher_Id;
            $voucher->gift_voucher_name = $request->gift_voucher_name;
            $voucher->description = $request->description; 
            $voucher->price = $request->price;
            $voucher->start_date= $request->start_date;
            $voucher->end_date= $request->end_date;
            $voucher->save();

            notify()->success('Gift Voucher updated successfully. ⚡️', 'Success');
            return redirect()->route('GiftVoucher')->with('success', 'Gift Voucher updated successfully.');
        } catch (Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }


    public function destroy($id)
    {
        $voucher = GiftVouchers::find($id);
        if ($voucher) {
            $voucher->delete();

            return redirect('GiftVoucher')->with('success', 'Gift Voucher deleted successfully');
        } else {
            return redirect()->route('GiftVoucher')->with('error', 'Gift Voucher not found.');
        }
    }
}
