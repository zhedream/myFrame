<?php

namespace app\Requests;

class UserRequest extends FromRequest
{


    public function authorize(){
        return true;
    }
    
    public function rules(){

        return [
            'username'=>[
                'required',
                function($val){

                    return true;
                }
            ],
            'email'=>[
                'required',
                function($val){

                    return true;
                }
            ]
        ];
    }


}