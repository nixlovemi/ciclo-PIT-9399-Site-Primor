<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Helpers\SysUtils;
use Symfony\Component\HttpFoundation\Response;

class Api extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function receitasFilter(Request $request)
    {
        $rData = $request->only(['search']);
        $search = trim($rData['search'] ?? '');
        $filteredRecipes = null;
        $html = null;

        if (strlen($search) <= 0 || empty($search)) {
            $html = view('partials.pageRecipesList', [
                'RECIPES' => SysUtils::getRecipes()
            ])->render();
        }

        if (strlen($search) >= 3) {
            $recipes = SysUtils::getRecipes();
            $filteredRecipes = array_filter($recipes, function($v, $k) use ($search) {
                $search = mb_strtolower($search);
                $r_type = mb_strtolower($v['type'] ?? '');
                $r_title = mb_strtolower($v['title'] ?? '');
                $r_details = mb_strtolower($v['details'] ?? '');

                return mb_strpos($r_type, $search) !== false ||
                    mb_strpos($r_title, $search) !== false ||
                    mb_strpos($r_details, $search) !== false;
            }, ARRAY_FILTER_USE_BOTH);

            $html = view('partials.pageRecipesList', [
                'RECIPES' => $filteredRecipes
            ])->render();
        }
        
        return $this->returnResponse(
            false,
            'Receitas filtradas com sucesso!',
            [
                'html' => $html
            ],
            Response::HTTP_OK
        );
    }
}