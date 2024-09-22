<?php

namespace App\Services;

use App\Http\Requests\ExpertProfileRequest;
use App\Http\Requests\updateImageRequest;
use App\Http\Trait\HelperUtil;
use App\Http\Trait\ImageTrait;
use App\Interfaces\ExpertRepository;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpertProfileService
{
    use ImageTrait;
    use HelperUtil;
    protected $expert;
    public function __construct(ExpertRepository $expertRepository)
    {
        $this->expert = $expertRepository;
    }

    public function createProfile(ExpertProfileRequest $request)
    {
        try {
            DB::beginTransaction();
            $imagename = $this->storimage($request->image);

            $expertInfo = $request->all();
            $expertInfo['user_id'] = Auth::id();
            $expertInfo['image'] = $imagename;

            $expert = $this->expert->createExpert($expertInfo);
            if (!$expert) {
                return response()->json(500);
            }
            DB::commit();
            return response()->json($expert, 201);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 500);
        }
    }


    public function UpdateProfile(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->validateId($id, "experts");
            $expert = $this->expert->updateExpert($id, $request->all());
            DB::commit();
            return response()->json($expert, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 500);
        }
        return response()->json($expert, 200);
    }

    public function updateImage(updateImageRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->validateId($id, "experts");
            $expert = $this->expert->getExpertById($id);
            $newimage = $this->storimage($request->image);
            $expert->image = $newimage;
            $expert->save();
            DB::commit();
            return response()->json($expert, 200);
        } catch (Exception $e) {
            Db::rollBack();
            return response()->json($e->getMessage(), 500);
        }
    }

    public function getProfilesExperts()
    {
        $profiles = $this->expert->getAllExperts();
        $experts = $profiles->user;

        $profiles = [];
        foreach ($experts as $pr) {
            $array = [
                'name' => $pr->user->name,
                'image' => $pr->image,
                'phone' => $pr->phone,
                'bio' => $pr->bio
            ];
            $profiles[] = $array;
        }

        return response()->json($profiles, 200);
    }


    public function searchExpert($name)
    {
        $expert = User::where('name', $name)
                        ->where('role', 'Expert')
                        ->get();

        return response()->json($expert, 200);
    }

}
