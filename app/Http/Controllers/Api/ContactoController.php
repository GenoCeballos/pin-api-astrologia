<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Contacto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
//reglas
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;

class ContactoController extends Controller
{
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        /// Reglas
            
            $validator = Validator::make($request->all(), [
                
                'nombre'=>'required|min:2|max:25',
                'apellido'=>'required|min:2|max:25',
                'telefono'=>'required|regex:/^([0-9\s\-\+\(\)]*)$/|between:5,15',
                'email' => 'required|max:30|email:rfc,dns|unique:contactos,con_email',
                
            ]);

            if( $validator->fails() ) {
                return response()->json([
                    'success'   =>  false,
                    'message'   =>  $validator->errors(),
                    'rdo'       => 1
                ], 200);
            }

        /// Crea contacto
            $contacto = new Contacto();
            $contacto->con_nombre =$request->nombre;
            $contacto->con_apellido =$request->apellido;
            $contacto->con_telefono =$request->telefono;
            $contacto->con_email =$request->email;
            $contacto->con_descripcion =$request->descripcion;
                
            $contacto->save();
          
        /// Envia mail    
            $details = [
                'nombre' => $request->nombre,
                'apellido' => $request->apellido
                ];
            
             Mail::to('ceciliaceb@gmail.com')->send(new \App\Mail\RegistroMail($details));

            return response()->json([
                'mensaje' => 'Registramos Exitosamente tus datos ' .$request->nombre,
                
                'rdo'=>0,
            ]);
       
    }
}