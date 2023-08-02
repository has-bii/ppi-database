<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Question;
use Exception;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function create(Request $request)
    {
        try {

            $request->validate([
                'form_id' => ['required', 'integer', 'exists:forms,id'],
                'type' => ['required', 'string', 'max:255'],
            ]);

            $question = Question::create([
                'question_id' => $request->question_id,
                'type' => $request->type,
            ]);

            if (!$question)
                throw new Exception("Question has not been created!");

            return ResponseFormatter::success($question, 'Question has been created successfully');
        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage(), 404);
        }
    }

    public function update(Request $request)
    {
        try {

            $request->validate([
                'id' => ['required', 'integer'],
                'type' => ['string', 'max:255'],
            ]);

            $id = $request->input('id');
            $type = $request->input('type');

            if (!$id)
                throw new Exception("ID field is required!");

            $question = Question::query()->find($id);

            if (!$question)
                throw new Exception("Question has not been found!");

            if ($type)
                $question->type = $type;

            $question->save();

            return ResponseFormatter::success($question, 'Question has been updated successfully');
        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage(), 404);
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->input('id');

            if (!$id)
                throw new Exception("ID field is required!");

            $question = Question::query()->find($id);

            if (!$question)
                throw new Exception("Question has not been found!");

            $question->delete();

            return ResponseFormatter::success(null, 'Question has been deleted successfully');
        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage(), 404);
        }
    }
}
