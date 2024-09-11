<?php

namespace App\Http\Controllers\Expert;

use App\Http\Controllers\Controller;
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
use Symfony\Component\CssSelector\Node\FunctionNode;

class ExpertController extends Controller
{
    use ImageTrait;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function AddProfileInfo(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'bio' => 'required|string|max:1000',
            'phone' => 'required|string|min:10|max:15',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $imagename = $this->storimage($request->image);

        $expert = Expert::create([
            'image' => $imagename,
            'phone' => $request->phone,
            'bio' => $request->bio,
            'user_id' => Auth::id()
        ]);

        return response()->json($expert, 200);
    }


    public function UpdateProfile(Request $request, $id)
    {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:experts,id']
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $expert = Expert::findOrfail($id);

        $expert->update($request->toArray());

        return response()->json("update success", 200);
    }


    public function updateImage(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'expert_id' => 'required|integer|exists:experts,id'

        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $expert = Expert::find($request->expert_id);
        $imagename = $this->storimage($request->image);
        $expert->image = $imagename;
        $expert->save();

        return response()->json("update success", 200);
    }

    public function addVideoGroup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'group_name' => 'required|string|max:1000',
            'course_id' => 'required|integer|exists:courses,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $video_group = VideoGroup::create([
            'group_name' => $request->group_name,
            'course_id' => $request->course_id,
        ]);

        return response()->json($video_group, 200);
    }

    public function deleteVideoGroup($id)
    {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:video_groups,id']
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $video_group = VideoGroup::find($id);
        $video_group->delete();

        return response()->json("delete success", 200);
    }


    // add video for videogroup
    public function addVideo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:200',
            'description' => 'required|string|min:50|max:1000',
            'time' => 'required',
            'url' => 'required|url',
            'video_group_id' => 'required|integer|exists:video_groups,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $video = Video::create([
            'title' => $request->title,
            'description' => $request->description,
            'time' => $request->time,
            'url' => $request->url,
            'video_group_id' => $request->video_group_id
        ]);
        return response()->json($video, 200);
    }


    public function updateVideo(Request $request, $id)
    {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:videos,id']
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $video = Video::findOrfail($id);

        $video->update($request->toArray());

        return response()->json("update success", 200);
    }

    public function deleteVideo($id)
    {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:videos,id']
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $video = Video::findOrfail($id);
        $video->delete();
        return response()->json("delete success", 200);

    }

    ////////////qize

    public function addQuiz(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'number_item' => 'required|integer',
            'date' => 'required|date|after_or_equal:today',
            'video_group_id' => 'required|integer|exists:video_groups,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $quiz = Quiz::create([
            'name' => $request->name,
            'number_item' => $request->number_item,
            'date' => $request->date,
            'video_group_id' => $request->video_group_id
        ]);
        return response()->json($quiz, 200);
    }


    public function updateQuiz(Request $request, $id)
    {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:quizzes,id']
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $quiz = Quiz::findOrfail($id);

        $quiz->update($request->toArray());

        return response()->json("update success", 200);
    }

    public function deleteQuiz($id)
    {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:quizzes,id']
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $quizitem = QuizeItem::findOrfail($id);
        $quizitem->delete();
        return response()->json("delete success", 200);

    }




    //quize item
    public function addQuizItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string|max:300',
            'answer' => 'required|string|max:50',
            'quiz_id' => 'required|integer|exists:quizzes,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $quiz = QuizeItem::create([
            'question' => $request->question,
            'answer' => $request->answer,
            'quiz_id' => $request->quiz_id
        ]);
        return response()->json($quiz, 200);
    }


    public function updateQuizItem(Request $request, $id)
    {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:quize_items,id']
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $quizitem = QuizeItem::findOrfail($id);

        $quizitem->update($request->toArray());

        return response()->json("update success", 200);
    }

    public function deleteQuizItem($id)
    {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:quize_items,id']
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $quiz = QuizeItem::findOrfail($id);
        $quiz->delete();
        return response()->json("delete success", 200);

    }


    //choice
    public function addChoice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'quiz_item_id' => 'required|integer|exists:quize_items,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $choice = Choice::create([
            'name' => $request->name,
            'quiz_item_id' => $request->quiz_item_id
        ]);

        return response()->json($choice, 200);
    }

    public function deleteChoice($id)
    {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:choices,id']
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $choice = Choice::findOrfail($id);
        $choice->delete();

        return response()->json("delete success", 200);
    }


    public function addDiscount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rate' => 'required',
            'course_id' => 'required|integer|exists:courses,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $course = Course::find($request->course_id);
        $oldprice = $course->price;
        $newprice = $oldprice - ($oldprice * $request->rate);
        $course->price = $newprice;
        $course->save();

        Discount::create([
            'rate' => $request->rate,
            'old_price' => $oldprice,
            'new_price' => $newprice,
            'course_id' => $request->course_id,
        ]);

        return response()->json("The discount has been added successfully :)");

    }

    public function cancelDiscount(Request $request, $id)
    {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:courses,id']
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $course = Course::find($id);

        $discount = $course->discount;

        $course->price = $discount->old_price;
        $course->save();
        $discount->delete();

        return response()->json("The discount has been canceled successfully :(", 200);

    }


    public function getStudentsInCourse($id)
    {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:choices,id']
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // $course = Course::find($id);
        // $students = $course->students->with('user');

        $course = Course::with(['students.user'])->find($id);



        $students = $course->students->map(function ($student) {
            return [
                'student_id' => $student->id,
                'name' => $student->user->name,
                'email' => $student->user->email,
                'number_courses' => $student->number_courses
            ];
        });

        return response()->json($students, 200);
    }



}
