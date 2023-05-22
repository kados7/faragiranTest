<?php
namespace App\Http\Controllers\Validator\Course;

use Illuminate\Http\Request;

class storeLessonValidator {

    protected $request;
    protected $validator;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function isValidate(){
        $this->validator= Validator($this->request->all(),[
            'name'=>'required|string',
            'price'=>'required|integer',
        ]);

        if($this->validator->fails()){
            return false;
        }
        return true;
    }

    public function getMessage(){
        return [
            'success' => false,
            'message' => "Validation Error",
            'response' => $this->validator->getMessageBag()->first(),
        ];
    }
}
