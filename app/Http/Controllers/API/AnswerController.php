<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Answer;
use Exception;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function create(Request $request)
    {
        try {

            $request->validate([
                'question_id' => ['required', 'integer', 'exists:questions,id'],
                'answer' => ['required', 'string', 'max:255'],
            ]);

            $form = Answer::create([
                'user_id' => $request->user()->id,
                'question_id' => $request->question_id,
                'answer' => $request->answer,
            ]);

            if (!$form)
                throw new Exception("Form has not been created!");

            return ResponseFormatter::success($form, 'Form has been created successfully');
        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage(), 404);
        }
    }

    public function update(Request $request)
    {
        try {

            $request->validate([
                'id' => ['required', 'integer'],
                'answer' => ['string', 'max:255'],
            ]);

            $id = $request->input('id');
            $answer_ = $request->input('answer');

            if (!$id)
                throw new Exception("ID field is required!");

            $answer = Answer::query()->find($id);

            if (!$answer)
                throw new Exception("Answer has not been found!");

            if ($answer_)
                $answer->answer = $answer_;

            $answer->save();

            return ResponseFormatter::success($answer, 'Answer has been updated successfully');
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

            $answer = Answer::query()->find($id);

            if (!$answer)
                throw new Exception("Answer has not been found!");

            $answer->delete();

            return ResponseFormatter::success(null, 'Answer has been deleted successfully');
        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage(), 404);
        }
    }
}
