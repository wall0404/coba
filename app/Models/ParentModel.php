<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ParentModel extends Model
{

    public function checkDeleteRight() {
        return $this->user_id == Auth::id();
    }
    public function checkGetRight()
    {
        return $this->user_id == Auth::id() ? "all" : [];
    }
    public function checkCreateRight() {
        return $this->user_id == Auth::id();
    }
}
