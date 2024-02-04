<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
 
use App\Models\Tasks;
use App\Models\User;

class AssetsController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public function serve( Request $request, $file )
    {
        $data = file_get_contents( base_path("/public/" . $file) );

        return response($data)
            ->header("Cache-Control","max-age=86400");
    }

}
