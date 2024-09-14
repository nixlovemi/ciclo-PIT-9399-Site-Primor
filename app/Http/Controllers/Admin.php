<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\User;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
use App\Helpers\SysUtils;
use App\Helpers\Constants;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\LocalLogger;
use App\Models\RecipeStep;

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
        $response = User::fLogin($form['f-email'] ?? '', $form['f-password'] ?? '');
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
            'TYPE' => Constants::FORM_VIEW,
            'ACTION' => '',
            'RECIPE' => $Recipe,
        ]);
    }

    public function receitasAdd()
    {
        return view('admin-recipes.register', [
            'TITLE' => 'Adicionar Receita',
            'TYPE' => Constants::FORM_ADD,
            'ACTION' => route('admin.receitas.doAdd'),
            'RECIPE' => null,
        ]);
    }

    public function receitasDoAdd(Request $request)
    {
        $response = Recipe::fSave($request);
        if ($response->isError()) {
            return redirect()->route('admin.receitas.add')
                ->withInput()
                ->withErrors(['msg' => ApiResponse::getValidateMessage($response)]);
        }

        $Receita = $response->getValueFromResponse('Recipe');
        return redirect()
            ->route('admin.receitas.edit', [
                'codedId' => $Receita?->coded_id ?? ''
            ])
            ->withSuccess($response->getMessage());
    }

    public function receitasEdit(string $codedId)
    {
        /** @var ?Recipe $Client */
        $Recipe = Recipe::getModelByCodedId($codedId);

        return view('admin-recipes.register', [
            'TITLE' => 'Editar Receita',
            'TYPE' => Constants::FORM_EDIT,
            'ACTION' => route('admin.receitas.doEdit'),
            'RECIPE' => $Recipe,
        ]);
    }

    public function receitasDoEdit(Request $request)
    {
        $response = Recipe::fSave($request);
        if ($response->isError()) {
            return redirect()->route('admin.receitas.edit', ['codedId' => $request->input('f-cid')])
                ->withInput()
                ->withErrors(['msg' => ApiResponse::getValidateMessage($response)]);
        }

        $Receita = $response->getValueFromResponse('Recipe');
        return redirect()
            ->route('admin.receitas.edit', [
                'codedId' => $Receita?->coded_id ?? ''
            ])
            ->withSuccess($response->getMessage());
    }

    public function addIngredient(Request $request)
    {
        $recipeCodedId = $request->input('recipeCodedId') ?: '';
        $recipeIngCodedId = $request->input('recipeIngCodedId') ?: '';
        $json = $request->input('json') ?: 'false';
        $Recipe = Recipe::getModelByCodedId($recipeCodedId);
        $RecipeIngredient = RecipeIngredient::getModelByCodedId($recipeIngCodedId);

        $view = view('admin-recipes.add-ingredient', [
            'RECIPE' => $Recipe,
            'RECIPE_INGREDIENT' => $RecipeIngredient,
        ]);

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

    public function doSaveIngredient(Request $request)
    {
        $requestData = $request->only(['rcid', 'icid']);
        $Recipe = Recipe::getModelByCodedId($requestData['rcid'] ?? '');
        $RecipeIngredient = RecipeIngredient::getModelByCodedId($requestData['icid'] ?? '');

        if (!$RecipeIngredient instanceof RecipeIngredient) {
            $RecipeIngredient = new RecipeIngredient();
        }
        $isEdit = $RecipeIngredient->id > 0;

        $form = [
            'quantity' => $request->input('f-quantity') ?: null,
            'description' => $request->input('f-description') ?: null,
        ];
        $RecipeIngredient->fill($form);
        $RecipeIngredient->recipe_id = optional($Recipe)->id;

        try {
            $validationResult = $RecipeIngredient->validateModel();
            if ($validationResult->isError()) {
                return $this->returnResponse(true, ApiResponse::getValidateMessage($validationResult), [], Response::HTTP_OK);
            }

            $RecipeIngredient->save();
            $RecipeIngredient->refresh();

            $msg = ($isEdit) ? 'Ingrediente atualizado!' : 'Ingrediente adicionado!';
            return $this->returnResponse(false, $msg, [], Response::HTTP_OK);
        } catch (\Throwable $exception) {
            LocalLogger::log('Erro ao salvar ingrediente! Msg: ' . $exception->getMessage());
            return $this->returnResponse(true, 'Erro ao salvar ingrediente!', [], Response::HTTP_OK);
        }
    }

    public function addStep(Request $request)
    {
        $recipeCodedId = $request->input('recipeCodedId') ?: '';
        $recipeStepCodedId = $request->input('recipeStepCodedId') ?: '';
        $json = $request->input('json') ?: 'false';
        $Recipe = Recipe::getModelByCodedId($recipeCodedId);
        $RecipeStep = RecipeStep::getModelByCodedId($recipeStepCodedId);

        $view = view('admin-recipes.add-step', [
            'RECIPE' => $Recipe,
            'RECIPE_STEP' => $RecipeStep,
        ]);

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

    public function doSaveStep(Request $request)
    {
        $requestData = $request->only(['rcid', 'scid']);
        $Recipe = Recipe::getModelByCodedId($requestData['rcid'] ?? '');
        $RecipeStep = RecipeStep::getModelByCodedId($requestData['scid'] ?? '');

        if (!$RecipeStep instanceof RecipeStep) {
            $RecipeStep = new RecipeStep();
        }
        $isEdit = $RecipeStep->id > 0;

        $form = [
            'title' => $request->input('f-title') ?: null,
            'description' => $request->input('f-description') ?: null,
        ];
        $RecipeStep->fill($form);
        $RecipeStep->recipe_id = optional($Recipe)->id;

        try {
            $validationResult = $RecipeStep->validateModel();
            if ($validationResult->isError()) {
                return $this->returnResponse(true, ApiResponse::getValidateMessage($validationResult), [], Response::HTTP_OK);
            }

            $RecipeStep->save();
            $RecipeStep->refresh();

            $msg = ($isEdit) ? 'Modo de Preparo atualizado!' : 'Modo de Preparo adicionado!';
            return $this->returnResponse(false, $msg, [], Response::HTTP_OK);
        } catch (\Throwable $exception) {
            LocalLogger::log('Erro ao salvar Modo de Preparo! Msg: ' . $exception->getMessage());
            return $this->returnResponse(true, 'Erro ao salvar Modo de Preparo!', [], Response::HTTP_OK);
        }
    }
}