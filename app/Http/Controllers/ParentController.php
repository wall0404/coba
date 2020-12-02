<?php


namespace App\Http\Controllers;


class ParentController extends Controller
{
    public static $successCode = 200;
    public static $successText = "Success";
    public static $notFoundCode = 401;
    public static $notFoundText = "NotFound";
    public static $unauthorizedCode = 401;
    public static $unauthorizedText = 'Unauthorised';
    public static $inputValidationErrorCode = 400;

    protected $default_limit = 15;
    protected $pagination = true;

    protected $filter = [];
    protected $model_name = null;

}
