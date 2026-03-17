<?php

use App\Ai\Agents\DateTimeTimezoneAgent;
use Illuminate\Support\Facades\Route;
use App\Ai\Agents\DocumentAnalyzer;
use App\Ai\Agents\TheologyLessonAgent;
use Illuminate\Http\Request;

Route::get('/welcome', function () {
    return 'welcome';
});

Route::post('/analyze', function (Request $request) {
    $request->validate([
        'document' => 'required|file|max:10240',
    ]);

    $result = (new DocumentAnalyzer)->prompt(
        'Analyze the document and return a summary, key topics, sentiment rating, and action items.',
        attachments: [
            $request->file('document'),
        ],
    );

    return (string)$result;
});

Route::post('/datetime', function (Request $request) {
    $request->validate([
        'location' => 'required|string',
    ]);

    $result = (new DateTimeTimezoneAgent)->prompt(
        "Approximately location: " . $request->input('location'),
    );

    return [
        'data' => $result,
    ];
});

Route::post('/bible-lesson', function (Request $request) {

    $request->validate([
        'topic' => 'required|string'
    ]);

    $result = (new TheologyLessonAgent())->prompt(
        "Create a lesson about: {$request->topic}"
    );

    return [
        'lesson' => $result
    ];
});
