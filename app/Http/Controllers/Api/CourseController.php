<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Validator\Course\EditPriceValidator;
use App\Http\Controllers\Validator\Course\storeLessonValidator;
use App\Models\Course;
use App\Models\Lesson;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function storeLesson(Request $request , Course $course){
        //validation
        $validator = new storeLessonValidator($request);

        if(! $validator->isValidate()){
            return $validator->getMessage();
        }

        // store lesson and price
        try {
            DB::beginTransaction();

            $newLesson=Lesson::create([
                'course_id' => $course->id,
                'name' => $request->name,
            ]);

            $newLesson->price()->create([
                'amount' => $request->price
            ]);

            DB::commit();

        //exception
        }catch (Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'There is a problem in the server. Try again',
                'response' => $e->getMessage(),
            ];
        }

        return [
            'success' => true,
            'message'=> 'درس جدید با موفیت ایجاد شد',
            'response' => $newLesson
        ];
    }



    public function editPrice(Request $request , Course $course){
        // validation
        $validator = new EditPriceValidator($request);

        if(! $validator->isValidate()){
            return $validator->getMessage();
        }

        //update price
        try {

            $course->price()->update([
                'amount' => $request->price
            ]);

        //exception
        }catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'There is a problem in the server. Try again',
                'response' => $e->getMessage(),

            ];
        }

        return [
            'success' => true,
            'message'=> 'قیمت دوره با موفقیت تغییر یافت',
            'response' => $course->price
        ];
    }
}
