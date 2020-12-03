<?php


namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Exception;

class ParentController extends Controller
{
    public static $successCode = 200;
    public static $successText = "Success";
    public static $notFoundCode = 401;
    public static $notFoundText = "NotFound";
    public static $unauthorizedCode = 401;
    public static $unauthorizedText = 'Unauthorised';
    public static $inputValidationErrorCode = 400;
    public static $badRequestCode = 400;

    protected $default_limit = 15;
    protected $pagination = true;

    protected $filter = [];
    protected $model_name = null;

    protected $validator_create = [];
    protected $validator_update = [];

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    protected function get(Request $request, $id) {
        $input = $request->input();
        $model = $this->model_name::findOrFail($id);

        if($model == false){
            return response()->json(['error'=>ParentController::$notFoundText], ParentController::$notFoundCode);
        }
        else {
            $columns =  $model->checkGetRight();
            if(is_null($columns) || is_array($columns ) && count($columns) == 0)
                return response()->json(['error'=>ParentController::$unauthorizedText], ParentController::$unauthorizedCode);

            if($columns != "all")
                $model->setVisible($columns);

            $array = $model->toArray();

            if($request->has('with')) {
                $relations = $input['with'];
                foreach ($relations as $relation) {
                    if($columns == "all" || in_array($relation, $columns)) {
                        $array[$relation] = $model->$relation;
                    }
                }
            }

            return response()->json(['success'=>$array], ParentController::$successCode);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function create(Request $request) {
        //Validate Input
        if(count($this->validator_create) == 0) $this->setCreateValidator();
        $validator = Validator::make($request->all(), $this->validator_create);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], ParentController::$inputValidationErrorCode);
        }
        $input = $request->input();

        try {
            $input = $this->doBeforeCreated($input);
        }
        catch (Exception $e) {
            return response()->json(['error'=>$e->getMessage()], ParentController::$badRequestCode);
        }


        $model = new $this->model_name();
        foreach ($input as $key => $value) {
            $model->$key = $value;
        }

        if($model->checkCreateRight()) {
            $model->save();
            $this->doAfterCreated($model);
            return response()->json(['success' => $model], ParentController::$successCode);
        }
        else
            return response()->json(['error'=>ParentController::$unauthorizedText], ParentController::$unauthorizedCode);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    protected function update(Request $request, $id) {
        if(count($this->validator_update) == 0) $this->setUpdateValidator();
        $validator = Validator::make($request->all(), $this->validator_update);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], $this->inputValidationErrorCode);
        }
        $input = $request->input();
        $model = $this->model_name::findOrFail($id);

        try {
            $model = $this->updateModel($input, $model);
            $this->doAfterUpdated($model);
        } catch (\Exception $e) {
            //Falls der Update Vorgang wegen fehlender Berechtigung gescheitert ist
            return response()->json(['error'=>$e->getMessage()], $this->unauthorizedCode);
        }

        return response()->json(['success'=>$model], $this->successStatus);
    }

    protected function delete($id) {
        $model = $this->model_name::findOrFail($id);
        if($model->checkDeleteRight()) {
            $model->delete();
            $this->doAfterDeleted($model);
            return response()->json(['success'=>'true'], ParentController::$successCode);
        }
        else {
            return response()->json(['error'=>ParentController::$unauthorizedText], ParentController::$unauthorizedCode);
        }
    }

    /*
     *
     *
     *  Überpürft welche Attribute geändert werden dürfen. Falls
     */
    protected function updateModel($input, $model) {
        $attributes = $model->checkUpdateRight();

        foreach ($input as $key => $value) {
            //Es wird für jedes übergebene input field überprüft, ob es geändert werden soll und wenn ja, ob es überhaupt geändert werden darf
            try {
                if($model->$key != $value
                    && ($attributes == "all" || in_array($key, $attributes))) {
                    if($key != 'updated_at') {
                        if($key == 'password') {
                            $value = bcrypt($value);
                        }
                        $model->$key = $value;
                    }
                }
            }
            catch (\Exception $e) {
                //$key scheint kein gültiges Attribut zu sein
            }
        }
        $model->save();
        return $model;
    }

    protected function doAfterCreated($model) {}
    protected function doBeforeCreated($input) {
        return $input;
    }
    protected function doAfterDeleted($model) {}
    protected function setUpdateValidator() {
        //For more complex validations like in App\Contacting
    }
    protected function setCreateValidator() {
        //For more complex validations like in App\Contacting
    }


}
