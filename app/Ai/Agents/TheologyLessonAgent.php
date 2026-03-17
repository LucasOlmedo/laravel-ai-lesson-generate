<?php

namespace App\Ai\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

class TheologyLessonAgent implements Agent, Conversational, HasStructuredOutput, HasTools
{
    use Promptable;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return "You are a theology teacher. When given a theological topic,
            generate a short structured lesson suitable for a quick class or study outline.
            The lesson should be simple, educational, and organized clearly.";
    }

    /**
     * Get the list of messages comprising the conversation so far.
     *
     * @return Message[]
     */
    public function messages(): iterable
    {
        return [];
    }

    /**
     * Get the tools available to the agent.
     *
     * @return Tool[]
     */
    public function tools(): iterable
    {
        return [];
    }

    /**
     * Get the agent's structured output schema definition.
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'title' => $schema->string()->required(),
            'introduction' => $schema->string()->required(),
            'key_points' => $schema->array()->items(
                $schema->object([
                    'title' => $schema->string()->required(),
                    'explanation' => $schema->string()->required(),
                ]),
            ),
            'bible_references' => $schema->array()->items(
                $schema->string()
            )->min(1)->max(4)->required(),
            'discussion_questions' => $schema->array()->items(
                $schema->string()
            )->min(1)->max(3)->required(),
            'summary' => $schema->string()->required(),
        ];
    }
}
