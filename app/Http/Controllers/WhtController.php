<?php

namespace App\Http\Controllers;

use App\WhtCode;
use App\WhtType;
use Illuminate\Http\Request;

class WhtController extends Controller
{
    public function getWhtTypeList()
    {
        return WhtType::all();
    }

    public function getWhtCodeList()
    {
        return WhtCode::all();
    }
}
