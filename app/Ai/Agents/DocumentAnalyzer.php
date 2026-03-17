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

class DocumentAnalyzer implements Agent, Conversational, HasTools, HasStructuredOutput
{
    use Promptable;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return 'You are a document analysis assistant. When given text or a document, '
            . 'provide a concise summary, identify the key topics discussed, '
            . 'rate the overall sentiment from 1 (very negative) to 10 (very positive), '
            . 'and list any action items or next steps mentioned in the content. '
            . 'Be specific and practical in your analysis.';
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
     * Get the structured output schema for the agent.
     *
     * @return array
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'summary' => $schema->string()->required(),
            // 'topics' => $schema->array()->required(),
            // 'topics.*.name' => $schema->string()->required(),
            'sentiment' => $schema->integer()->min(1)->max(10)->required(),
            // 'action_items' => $schema->array()->required(),
            // 'action_items.*.name' => $schema->string()->required(),
        ];
    }
}
