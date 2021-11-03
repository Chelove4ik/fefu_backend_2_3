<?php

namespace App\Http\Controllers;

use App\Models\Appeal;
use Illuminate\Http\Request;

class AppealController extends Controller
{
    public function __invoke(Request $request)
    {
        $errors = [];
        $success = $request->session()->get('success', false);

        if ($request->isMethod('POST')) {
            $name = $request->input('name');
            $phone = $request->input('phone');
            $email = $request->input('email');
            $message = $request->input('message');

            if ($name === null) {
                $errors['name_len'] = 'Поле name не может быть пустым';
            }
            if (strlen($name) > 20) {
                $errors['name_len'] = 'Поле name должно содержать не более 20 символов';
            }
            if ($phone !== null && strlen((string)(int)$phone) !== 11) {
                $errors['phone_len'] = 'Поле phone должно содержать 11 числовых символов';
            }
            if (strlen($email) > 100) {
                $errors['email_len'] = 'Поле email должно содержать не более 100 символов';
            }
            if ($phone === null && $email === null) {
                $errors['contact'] = 'Хотя бы одно из контактных полей (phone, email) должно быть заполнено';
            }
            if ($message === null) {
                $errors['message_len'] = 'Поле message не может быть пустым';
            }
            if (strlen($message) > 100) {
                $errors['message_len'] = 'Поле message должно содержать не более 100 символов';
            }

            if (count($errors) > 0) {
                $request->flash();
            } else {
                $appeal = new Appeal();
                $appeal->name = $name;
                $appeal->phone = $phone;
                $appeal->email = $email;
                $appeal->message = $message;
                $appeal->save();

                $success = true;
                return redirect()
                    ->route('appeal')
                    ->with('success', $success);
            }
        }

        return view('appeal', ['errors' => $errors, 'success' => $success]);
    }
}
