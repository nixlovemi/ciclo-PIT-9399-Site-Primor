<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\User;
use App\Models\Recipe;
use App\Helpers\SysUtils;
use Symfony\Component\HttpFoundation\Response;

class Admin extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function login()
    {
        SysUtils::logout(false);
        return view('admin-login', ['PAGE_TITLE' => 'Login']);
    }

    public function doLogin(Request $request)
    {
        $form = $request->only(['f-email', 'f-password']);
        $response = User::fLogin($form['f-email'], $form['f-password']);
        if ($response->isError()) {
            return redirect()->route('admin.login')->withErrors(['msg' => $response->getMessage()]);
        }

        return redirect()->route('admin.dashboard');
    }

    public function dashboard()
    {
        $totalRecipes = Recipe::all()->count();
        $totalActive = Recipe::where('active', '1')->count();
        return view('admin-dashboard', [
            'PAGE_TITLE' => 'Dashboard',
            'TOTAL_RECIPES' => $totalRecipes,
            'ACTIVE_RECIPES' => $totalActive,
            'INACTIVE_RECIPES' => $totalRecipes - $totalActive
        ]);
    }

    public function receitasIndex()
    {
        return view('admin-recipes.index', ['PAGE_TITLE' => 'Receitas']);
    }

    public function receitasView(string $codedId)
    {
        /** @var ?Recipe $Client */
        $Recipe = Recipe::getModelByCodedId($codedId);

        return view('admin-recipes.register', [
            'TITLE' => 'Visualizar Receita',
            'TYPE' => 'view',
            'ACTION' => '',
            'RECIPE' => $Recipe,
        ]);
    }

    public function addIngredient(Request $request)
    {
        $recipeCodedId = $request->input('recipeCodedId') ?: '';
        $json = $request->input('json') ?: 'false';

        $view = view('admin-recipes.add-ingredient', []);

        if (true === (bool) $json) {
            return $this->returnResponse(
                false,
                'HTML retornado com sucesso!',
                [
                    'html' => $view->render()
                ],
                Response::HTTP_OK
            );
        }

        return $view;
    }
}