<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpertProfileRequest;
use App\Http\Requests\updateImageRequest;
use Illuminate\Http\Request;
use App\Http\Trait\ImageTrait;
use App\Models\Choice;
use App\Models\Course;
use App\Models\Discount;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Expert;
use App\Models\Quiz;
use App\Models\QuizeAttempt;
use App\Models\QuizeItem;
use App\Models\Video;
use App\Models\VideoGroup;
use App\Services\ExpertProfileService;
use Symfony\Component\CssSelector\Node\FunctionNode;

class ExpertController extends Controller
{
    use ImageTrait;
    protected $expertService;
    public function __construct(ExpertProfileService $expertProfileService)
    {
        $this->expertService = $expertProfileService;
        $this->middleware('auth:api');
    }

    public function AddProfileInfo(ExpertProfileRequest $request)
    {
        return $this->expertService->createProfile($request);
    }


    public function UpdateProfile(Request $request, $id)
    {
        return $this->expertService->UpdateProfile($request, $id);
    }


    public function updateImage(updateImageRequest $request, $id)
    {
        return $this->expertService->updateImage($request, $id);
    }

    public function getProfilesExperts()
    {
        return $this->expertService->getProfilesExperts();
    }


    public function searchExpert($name)
    {
        return $this->expertService->searchExpert($name);
    }


}
