<?php

namespace App\Http\Controllers\API;

use App\Course;
use App\Jobs\ProcessCoursesCreation;
use App\User;
use App\UserCourse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Validator;

class CoursesController extends Controller
{


    /**
     * Create's fake courses, dispatched to a queue
     *
     * @method GET
     *
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function createCourses(){
        $this->dispatch(new ProcessCoursesCreation());
        return response()->json(['status' => true, 'message' =>'Courses creation in process...', 'data' => []], 200);
    }

    /**
     * Register the authenticated user to a course or courses
     *
     * @param  array  course_ids
     *
     * @method POST
     *
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function registerCourse(Request $request){
        $rules = [
            'course_ids' => 'required',
        ];

        $msg = $this->validateRequest($request, $rules);

        if(isset($msg))
            return response()->json(['status' => false, 'message' =>$msg, 'data' => []], 422);

        $user_already_registered = UserCourse::where('user_id', $request->user()->id)
            ->whereIn('course_id',  $request->course_ids)
            ->get();

        if(count($user_already_registered) > 0){
            response()->json(['status' => false, 'message' =>'You have registered for this course already', 'data' => []], 422);
        } else {

            foreach($request->course_ids as $course_id){
                $courses[] =  [
                    'user_id' => $request->user()->id,
                    'course_id' => $course_id
                ];
            }

            UserCourse::insert($courses);

            return response()->json(['status' => true, 'message' =>'You have successfully registered for a course', 'data' => []], 200);

        }
    }

    /**
     * List Courses
     *
     *
     * @method GET
     *
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function listCourses(){
        $courses = Course::all();

        return response()->json(['status' => true, 'message' =>'List of courses returned', 'data' => $courses], 200);
    }

    /**
     * Export courses to excel
     *
     * @method GET
     *
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function exportCourses(){
        return Excel::download(new Course, 'courses.xlsx');
    }



}
