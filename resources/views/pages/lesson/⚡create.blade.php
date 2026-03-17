<?php

use Livewire\Component;

new class extends Component
{
    public $topic = '';
    public $lesson = '';
    public $can_stream = true;
    public $generating = false;
 
    public function generate()
    {
        $this->lesson = '';
        $this->generating = true;

        $parts = [
            "Lesson on {$this->topic}\n\n",
            "Introduction:\n",
            "This lesson explores the theological meaning of {$this->topic}.\n\n",
            "Key Points:\n",
            "- Biblical foundation\n",
            "- Historical interpretation\n",
            "- Practical application\n\n",
            "Discussion Questions:\n",
            "- Why is {$this->topic} important?\n",
            "- How does it impact Christian life?\n",
            "Lesson on {$this->topic}\n\n",
            "Introduction:\n",
            "This lesson explores the theological meaning of {$this->topic}.\n\n",
            "Key Points:\n",
            "- Biblical foundation\n",
            "- Historical interpretation\n",
            "- Practical application\n\n",
            "Discussion Questions:\n",
            "- Why is {$this->topic} important?\n",
            "- How does it impact Christian life?\n",
        ];

        foreach ($parts as $part) {
            $this->lesson .= $part;
            $this->stream(
                to: 'lesson_stream',
                content: $part
            );

            usleep(100000);
        }

        $this->generating = false;
        $this->can_stream = false;
    }

    public function discard()
    {
        $this->lesson = '';
        $this->can_stream = true;
    }

    public function save()
    {

    }

};
?>

<div class="flex-1 space-y-6">
    <flux:heading size="xl">Generate a Bible Lesson</flux:heading>
    <flux:text class="mt-2">Enter a theological topic and generate a structured lesson.</flux:text>

    <flux:separator variant="subtle" class="my-8" />

    <flux:input wire:model="topic" label="Lesson Topic" placeholder="This is the topic of the lesson. Describe what you want to learn." />

    <div class="flex justify-end gap-3">
        <flux:button wire:click="generate" variant="primary" :disabled="$generating || $lesson"
            icon:trailing="arrow-path" wire:loading.attr="disabled">
            Generate Lesson
        </flux:button>
    </div>

    @if($can_stream)
        <div wire:stream="lesson_stream" class="prose max-w-none whitespace-pre-line"></div>
    @elseif(!$can_stream && !$generating)
        <div class="prose max-w-none whitespace-pre-line">{{ $lesson }}</div>
    @endif

    <div class="flex justify-end gap-3">
        @if($lesson && !$generating)
            <flux:button wire:click="discard" variant="filled">
                Discard
            </flux:button>
            <flux:button wire:click="save" variant="primary">
                Save
            </flux:button>
        @endif
    </div>
</div>
