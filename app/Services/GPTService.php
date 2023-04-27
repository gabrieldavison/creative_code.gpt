<?php

namespace App\Services;

use OpenAI;

class GPTService
{
    public static function getPromptResponse(string $userPrompt, string $code)
    {
        $yourApiKey = env('OPENAI_API_KEY');
        $client = OpenAI::client($yourApiKey);
        $template_prompt = <<<END
You are going to construct a p5.js sketch based on a users prompt and some previous code. If there is no previous code you should construct the p5.js sketch from scratch. You should only reply with code, nothing else, no commentary only javascript code. The code you should base your sketch on is `%s` . The users prompt is `%s` . You should write the code in p5 "instance mode" style. Remember you cannot access any of p5s global variables in instance mode you need to access them by passing arounf the "p" object to any functions that require them. Do not enclose the code in any makrdown tags or quotations (e.g. do not use ``` to enclose the code). Your reply should be valid javascript code. You should not include the code "let myp5 = new p5(sketch);" in your response. You should assign the variable sketch to "window.sketch"
Example Prompt: "draw a circle in the center of the canvas"
Example Response:

window.sketch = function(p) {
p.setup = function() {
    p.createCanvas(400, 400);
};

p.draw = function() {
    p.ellipse(p.width/2, p.height/2, 50, 50); //draws circle in center of canvas
};
};

END;
        // $template_prompt = 'You are going to construct a p5.js sketch based on a users prompt and some previous code. If there is no previous code you should construct the p5.js sketch from scratch. You should only reply with code, nothing else, no commentary only javascript code. The code you should base your sketch on is `%s` . The users prompt is `%s` . You should write the code in p5 "instance mode" style. Remember you cannot access any of p5s global variables in instance mode you need to access them by passing arounf the "p" object to any functions that require them. Do not enclose the code in any makrdown tags or quotations (e.g. do not use ``` to enclose the code). Your reply should be valid javascript code. You should not include the code "let myp5 = new p5(sketch);" in your response.';
        $prompt = sprintf($template_prompt, $code, $userPrompt);
        $response = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        $message = $response->choices[0]->message->content;

        return $message;
    }
}
