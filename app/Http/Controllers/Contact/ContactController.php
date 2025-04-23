<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Maneja el envío del formulario de contacto.
     */
    public function send(Request $request)
    {
        // Validar los campos del formulario
        $validated = $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'surnames' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'contact_method' => 'required|in:phone,email',
            'email' => 'required_if: contact-method, email|nullable|email',
            'phone' => 'required_if: contact-method, phone|nullable|string|max:9|regex:/^[0-9\s\-]+$/',
            'details' => 'required|string|max:255',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'name.regex' => 'El nombre solo puede contener letras y espacios.',
            'surnames.required' => 'Los apellidos son obligatorios.',
            'surnames.max' => 'Los apellidos no pueden tener más de 255 caracteres.',
            'surnames.regex' => 'Los apellidos solo pueden contener letras y espacios.',
            'contact_method.required' => 'Debes escoger un tipo de contacto.',
            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'phone.max' => 'El teléfono no puede tener más de 9 números.',
            'phone.regex' => 'El teléfono solo puede contener números, espacios y guiones.',
            'details.required' => 'El mensaje es obligatorio.',
            'details.max' => 'Los detalles no pueden exceder los 255 caracteres.',
        ]);

        // Preparar el contenido del correo
        $content = [
            'name' => $validated['name'],
            'surnames' => $validated['surnames'],
            'contact_method' => $validated['contact_method'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'content_message' => $validated['details'],
        ];

        try {
            // Enviar el correo
            Mail::send('email.contact-email', $content, function ($message) {
                $message->to(env('MAIL_FROM_ADDRESS'))->subject('Nuevo mensaje de contacto');
                $message->subject('Nuevo mensaje de contacto');
            });

            // Redirigir con un mensaje de éxito
            return back()->with('toast', ['type' => 'success', 'message' => 'El mensaje se ha enviado correctamente.']);
        } catch (Exception $e) {
            Log::error('Error al enviar el correo de contacto: '.$e->getMessage());

            return back()->with('toast', ['type' => 'error', 'message' => 'Ha ocurrido un error al enviar el mensaje.']);
        }
    }
}
