<?php
namespace App\Http\Controllers\Validator\Course;

use Illuminate\Http\Request;

class EditPriceValidator {

    protected $request;
    protected $validator;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function isValidate(){
        // dd($request->all());
        $this->validator= Validator($this->request->all(),[
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
