<?php

namespace App\Http\Controllers;

use App\Models\Missatges;
use App\Models\Usuaris;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MissatgesController extends Controller
{
    public function envia(Request $request)
    {
        try {
            $reglesValidacio = [
                'nom' => 'required|string|max:255',
                'llinatges' => 'required|string|max:255',
                'mail' => 'required|email|max:255',
                'missatge' => 'required|string|min:3|max:3000',
            ];

            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'email' => 'El :attribute ha de ser una adreça de correu electrònic vàlida.',
                'min' => 'La :attribute ha de tenir almenys :min caràcters.',
                'max' => 'La :attribute no pot tenir més de :max caràcters.',
                'in' => 'El valor seleccionat per a :attribute no és vàlid.',
                'date' => 'El camp :attribute ha de ser una data vàlida.',
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);

            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            $tupla = Missatges::create($request->all());
            $data = array('nom' => $tupla->nom, 'llinatges' => $tupla->llinatges, 'mail' => $tupla->mail, 'missatge' => $tupla->missatge);
            Mail::send('mails.mail_contacte', $data, function ($message) use ($tupla) {
                $message->to("aurorabalaguer@paucasesnovescifp.cat")->subject('Missatge de "Contacta amb nosaltres" de ' . $tupla->nom . " " . $tupla->llinatges)
                    ->cc(['missatgeria@balearcgrupe.com']);
            });
            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'data' => $e], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }
}
