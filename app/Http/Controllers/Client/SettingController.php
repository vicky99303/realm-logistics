<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\BuyPackageRecord;
use App\Models\Deposit;
use App\Models\DepositRecord;
use App\Models\Package;
use App\Models\PaymentRecord;
use App\Rules\DepositAmount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Collection;
use Xendit\Exceptions\ApiException;
use Xendit\Xendit;

class SettingController extends Controller
{
    public function index()
    {
        $data = array(
            'title' => 'Setting'
        );
        return view('userpanel.setting', $data);
    }

    public function packages()
    {
        $dataPackage = Package::all();
        $dataDeposit = DepositRecord::where('user_id', Auth::user()->id)
            ->first();
        $dataPaymentRecord = BuyPackageRecord::where('user_id', Auth::user()->id)
            ->get();
        $data = array(
            'title' => 'Packages',
            'dataPackage' => $dataPackage,
            'dataDeposit' => $dataDeposit,
            'dataCoupon' => $dataPaymentRecord
        );
        return view('userpanel.packages', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getStorePackagePaymentAmount(Request $request)
    {
        $message = '';
        $request->validate([
            'deposit_id' => 'required',
            'package_id' => 'required',
            'amount' => new DepositAmount,
        ]);
        try {
            \DB::beginTransaction();
            $package_id = $request->input('package_id');
            $amount = $request->input('amount');
            $PaymentRecordSave = new BuyPackageRecord;
            $PaymentRecordSave->user_id = Auth::user()->id;
            $PaymentRecordSave->package_id = $package_id;
            $PaymentRecordSave->price = $amount;
            $PaymentRecordSave->save();
            $DepositAmount = DepositRecord::where('user_id', Auth::user()->id)
                ->first();
            if (!empty($DepositAmount)) {
                DepositRecord::where('user_id', Auth::user()->id)
                    ->update(['current_amount' => $DepositAmount->current_amount - $amount, 'used_amount' => $DepositAmount->used_amount + $amount]);
                \DB::commit();
                $message = 'Successfully Updated.';
            }
        } catch (Throwable $e) {
            \DB::rollback();
            $message = 'Something went wrong.';
        }
        return redirect()->back()->with('message', $message);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function getPaymentAmount(Request $request)
    {
        $request->validate([
            'token_id' => 'required',
            'authentication_id' => 'required',
            'status' => 'required',
            'amount' => 'required',
            'card_number' => 'required',
            'card_cvn' => 'required',

        ]);
        Xendit::setApiKey('xnd_development_znFrJvlPjesHKQBxDzjIuAwBfaMe4XCcrDumfTBBleuXJANSrvCeg6fXMyjva0');
        $amount = $request->input('amount');
        $deposit_id = $request->input('deposit_id');
        $params = [
            'token_id' => $request->input('token_id'), // id
            'external_id' => 'card_' . time(),
            'authentication_id' => $request->input('authentication_id'), // authentication_id
            'amount' => $amount,
            'card_cvn' => $request->input('card_cvn'),
            'capture' => false
        ];
        $captureParams = ['amount' => $amount];
        $status = '';
        $message = '';
        try {
            $createCharge = \Xendit\Cards::create($params);
            $id = $createCharge['id'];
            $getCharge = \Xendit\Cards::retrieve($id);
            $captureCharge = \Xendit\Cards::capture($id, $captureParams);
            $PaymentRecordSave = new PaymentRecord;
            $PaymentRecordSave->user_id = Auth::user()->id;
            $PaymentRecordSave->deposit_id = $deposit_id;
            $PaymentRecordSave->status = $captureCharge['status'];
            $PaymentRecordSave->authorized_amount = $captureCharge['authorized_amount'];
            $PaymentRecordSave->capture_amount = $captureCharge['capture_amount'];
            $PaymentRecordSave->currency = $captureCharge['currency'];
            $PaymentRecordSave->created = $captureCharge['created'];
            $PaymentRecordSave->business_id = $captureCharge['business_id'];
            $PaymentRecordSave->merchant_id = $captureCharge['merchant_id'];
            $PaymentRecordSave->merchant_reference_code = $captureCharge['merchant_reference_code'];
            $PaymentRecordSave->external_id = $captureCharge['external_id'];
            $PaymentRecordSave->eci = $captureCharge['eci'];
            $PaymentRecordSave->charge_type = $captureCharge['charge_type'];
            $PaymentRecordSave->masked_card_number = $captureCharge['masked_card_number'];
            $PaymentRecordSave->card_brand = $captureCharge['card_brand'];
            $PaymentRecordSave->card_type = $captureCharge['card_type'];
            $PaymentRecordSave->descriptor = $captureCharge['descriptor'];
            $PaymentRecordSave->bank_reconciliation_id = $captureCharge['bank_reconciliation_id'];
            $PaymentRecordSave->approval_code = $captureCharge['approval_code'];
            $PaymentRecordSave->mid_label = $captureCharge['mid_label'];
            $PaymentRecordSave->token_id = $captureCharge['id'];
            $PaymentRecordSave->save();
            // insert and update deposit amount of specific user
            $DepositAmount = DepositRecord::where('user_id', Auth::user()->id)
                ->first();
            if (empty($DepositAmount)) {
                $newInsert = new DepositRecord;
                $newInsert->user_id = Auth::user()->id;
                $newInsert->current_amount = $captureCharge['capture_amount'];
                $newInsert->used_amount = 0;
                $newInsert->save();
            } else {
                DepositRecord::where('user_id', Auth::user()->id)
                    ->update(['current_amount' => $DepositAmount->current_amount + $captureCharge['capture_amount']]);
            }
            $status = true;
            $message = 'Payment Done Successfully';
        } catch (ApiException $e) {
            $status = false;
            $message = $e->getMessage();
        }
        return response()->json(['status' => $status, 'message' => $message]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function deposit()
    {
        $data = array(
            'title' => 'Deposit',
            'dataDeposit' => Deposit::all(),
            'dataCoupon' => PaymentRecord::where('user_id', Auth::user()->id)
                ->get(),
        );
        return view('userpanel.deposit', $data);
    }
}
