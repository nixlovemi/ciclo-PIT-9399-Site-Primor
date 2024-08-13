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
            $html = view('partials.pageRecipesList', [
                'RECIPES' => \App\Models\Recipe::where('active', 1)
                                ->where(function ($query) use ($search) {
                                    $query->orWhere('type', 'LIKE', '%' . $search . '%')
                                        ->orWhere('title', 'LIKE', '%' . $search . '%')
                                        ->orWhere('slug', 'LIKE', '%' . $search . '%');
                                })->get()
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