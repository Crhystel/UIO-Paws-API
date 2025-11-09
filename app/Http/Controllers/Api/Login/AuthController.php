<?php
    namespace App\Http\Controllers\Api\Login;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\User;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Validation\ValidationException;

    class AuthController extends Controller
    {
        public function register(Request $request)
        {
<<<<<<< HEAD
            try {
                $validated = $request->validate([
                    'first_name' => 'required|string|max:255',
                    'middle_name' => 'nullable|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'second_last_name' => 'nullable|string|max:255',
                    'document_type' => 'required|string|max:255',
                    'document_number' => 'required|string|max:255',
                    'phone' => 'required|string|max:20',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:8', 
                ]);
                $createData = $validated;
                $createData['password_hash'] = Hash::make($validated['password']);
                unset($createData['password']);
                $createData['is_active'] = true;

                $user = User::create($createData);
                
                $user->assignRole('User'); 

                return response()->json(['message' => 'Usuario registrado exitosamente.'], 201);

            } catch (ValidationException $e) {
                return response()->json(['message' => 'Datos inválidos.', 'errors' => $e->errors()], 422);
            
            } catch (\Exception $e) {
                Log::error('Excepción durante el registro: ' . $e->getMessage());
                return response()->json([
                    'message' => 'Ocurrió un error inesperado durante el registro.'], 500);
            }
=======
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json(['message' => 'Usuario registrado exitosamente.'], 201);
>>>>>>> c4804f8 (rearranging controller files)
        }

        public function login(Request $request)
        {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            $user = User::where('email', $request->email)->first();
<<<<<<< HEAD
            if (!$user) {
                return response()->json(['error' => 'Usuario no encontrado en la base de datos.'], 404);
            }

            if (!$user || !Hash::check($request->password, $user->password_hash)) {
=======

            if (!$user || !Hash::check($request->password, $user->password)) {
>>>>>>> c4804f8 (rearranging controller files)
                throw ValidationException::withMessages([
                    'email' => ['Las credenciales son incorrectas.'],
                ]);
            }

            $token = $user->createToken('auth_token')->plainTextToken;
<<<<<<< HEAD
            $userRole = $user->getRoleNames()->first();
=======
>>>>>>> c4804f8 (rearranging controller files)

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
<<<<<<< HEAD
                'user_role' => $userRole
=======
                'user_role' => $user->role
>>>>>>> c4804f8 (rearranging controller files)
            ]);
        }

        public function logout(Request $request)
        {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Sesión cerrada.']);
        }

        public function userProfile(Request $request)
        {
<<<<<<< HEAD
            return response()->json($request->user()->load('roles'));
=======
            return response()->json($request->user());
>>>>>>> c4804f8 (rearranging controller files)
        }
    }