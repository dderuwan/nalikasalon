<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\promotions;

class PromotionContoller extends Controller
{
    public function index()
    {
        $promotions = promotions::all();
        return view('GiftVouchhers&Promotions.promotions.index', compact('promotions'));
    }

    public function create()
    {
        return view('GiftVouchhers&Promotions.promotions.create');
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

            $voucher = new promotions();
            $voucher->promotions_Id = $this->generatePromotionsID();
            $voucher->promotions_name = $request->gift_voucher_name;
            $voucher->description = $request->description; 
            $voucher->price = $request->price;
            $voucher->start_date= $request->start_date;
            $voucher->end_date= $request->end_date;
            $voucher->save();

            notify()->success('Promotion Created successfully. ⚡️', 'Success');
            return redirect()->route('Promotion')->with('success', 'Promotion created successfully.');
        } catch (Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

    private function generatePromotionsID()
    {
        return 'GIFT-' . rand(1000, 9999);
    }

    public function edit($id)
    {
        $giftVoucher = promotions::findOrFail($id);  
        return view('GiftVouchhers&Promotions.promotions.edit', compact('giftVoucher',)); 
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

            $voucher = promotions::findOrFail($id);
            $voucher->promotions_Id = $request->gift_voucher_Id;
            $voucher->promotions_name = $request->gift_voucher_name;
            $voucher->description = $request->description; 
            $voucher->price = $request->price;
            $voucher->start_date= $request->start_date;
            $voucher->end_date= $request->end_date;
            $voucher->save();

            notify()->success('Promotion updated successfully. ⚡️', 'Success');
            return redirect()->route('Promotion')->with('success', 'Promotion updated successfully.');
        } catch (Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }


    public function destroy($id)
    {
        $voucher = promotions::find($id);
        if ($voucher) {
            $voucher->delete();

            return redirect('Promotion')->with('success', 'Promotion deleted successfully');
        } else {
            return redirect()->route('Promotion')->with('error', 'Promotion not found.');
        }
    }
}
