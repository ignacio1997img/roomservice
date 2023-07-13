<?php

namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function create_user(Request $request){
        
        $ok = User::where('people_id', $request->people_id)->first();
        if($ok)
        {
            return redirect()->route('voyager.users.index')->with(['message' => 'La persona se cuentra con usuario activo..', 'alert-type' => 'error']);
        }

        $ok = User::where('email', $request->email)->first();
        if($ok)
        {
            return redirect()->route('voyager.users.index')->with(['message' => 'Elija otro correo por favor.', 'alert-type' => 'error']);
        }
        
        $people = People::where('id', $request->people_id)->first();
        DB::beginTransaction();
        try {
            
            $user = User::create([
                'name' =>  $people->first_name.' '.$people->last_name,
                'people_id' => $people->id,
                'role_id' => $request->role_id,
                'email' => $request->email,
                'avatar' => 'users/default.png',
                'password' => bcrypt($request->password),
            ]);
            
            //Para mas roles adiconales
            // if ($request->user_belongstomany_role_relationship <> '') {
            //     $user->roles()->attach($request->user_belongstomany_role_relationship);
            // }

            DB::commit();
            return redirect()->route('voyager.users.index')->with(['message' => "El usuario, se registro con exito.", 'alert-type' => 'success']);
        } catch (\Exception $e) {
            DB::rollback();

            // return 0;
            return redirect()->route('voyager.users.index')->with(['message' => 'Ocurrio un error.', 'alert-type' => 'error']);

        }     
    }

    public function update_user(Request $request, User $user){

        // return $user;
        // return $request;
        $ok = User::where('people_id', $request->people_id)->where('id', '!=', $user->id)->first();
        // return $ok;
        if($ok && $request->people_id)
        {
            return redirect()->route('voyager.users.index')->with(['message' => 'La persona ya cuenta con usuario.', 'alert-type' => 'error']);
        }

        $ok = User::where('email', $request->email)->where('id', '!=', $user->id)->first();
        if($ok)
        {
            return redirect()->route('voyager.users.index')->with(['message' => 'Elija otro correo por favor.', 'alert-type' => 'error']);
        }

        // return $request;
        DB::beginTransaction();
        try {
            $user->update([
                // 'role_id' => $request->role_id,
                'email' => $request->email,
            ]);
            
            if ($request->password != '') {
                $user->password = bcrypt($request->password);
                $user->save();
            }
            if ($request->role_id) {
                // return 1;
                $user->role_id = $request->role_id;
                $user->save();
            }
            // return 2;
            $people = People::where('id', $request->people_id)->first();
            
            if ($request->people_id != '') {
                $user->update([
                    'people_id' => $request->people_id,
                    'name' => $people->first_name.' '.$people->last_name,
                ]);
            }
     


            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }  

        // if ($request->user_belongstomany_role_relationship <> '') {
        //     $user->roles()->sync($request->user_belongstomany_role_relationship);
        // }
        return redirect()
        ->route('voyager.users.index')
        ->with([
                'message' => "El usuario, se actualizo con exito.",
                'alert-type' => 'success'
            ]);
    }
}
