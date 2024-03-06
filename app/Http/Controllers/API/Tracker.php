<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Journey;
use App\Models\Tracker as TrackerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Tracker extends BaseController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function insertJourney(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'RiderID' => 'required',
            'StartingPoint' => 'required',
            'DestinationPoint' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        $JourneyID = Journey::create($input);
//        $recordExist = Journey::find($input['RiderID']);
//        if($recordExist){
//            Journey::where('RiderID', $input['RiderID'])->update(['StartingPoint' => $request->StartingPoint,'DestinationPoint' => $request->DestinationPoint]);
//        }else{
//            Journey::create($input);
//        }
        $success['riderID'] = $input['RiderID'];
        $success['journeyID'] = $JourneyID->id;
        $success['link'] = url('/riderTracker/' . $input['RiderID'] . '/journey/' . $JourneyID->id);
        return $this->sendResponse($success, 'Record Insert successfully.');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function insertCurrentLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'journeyID' => 'required',
            'RiderID' => 'required',
            'lat' => 'required',
            'long' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        TrackerModel::create($input);
        $success['riderID'] = $input['RiderID'];
        return $this->sendResponse($success, 'Record Insert successfully.');
    }
}
