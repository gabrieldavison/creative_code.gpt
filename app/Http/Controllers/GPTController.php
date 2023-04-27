<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\GPTService;

class GPTController extends Controller
{
    public function show()
    {
        return Inertia::render('Index');
    }

    public function evaluatePrompt(Request $request)
    {
        // dd($request);
        $prompt = $request->prompt;
        $code = $request->code ?? "";
        // dd($prompt);

        $response = GPTService::getPromptResponse($prompt, $code);
        // dd($response);
        return Inertia::render('Index', ['initialPromptValue' => $prompt, 'initialCodeValue' => $response]);
    }
}
