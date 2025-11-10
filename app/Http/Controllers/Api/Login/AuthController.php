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
=======
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            User::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'password_hash' => Hash::make($validated['password']),
            ]);
>>>>>>> 02fb4e0 (fixing typos, variable name problems, and removing unnecessary files)

                return response()->json(['message' => 'Usuario registrado exitosamente.'], 201);

            } catch (ValidationException $e) {
                return response()->json(['message' => 'Datos inválidos.', 'errors' => $e->errors()], 422);
            
            } catch (\Exception $e) {
                Log::error('Excepción durante el registro: ' . $e->getMessage());
                return response()->json([
                    'message' => 'Ocurrió un error inesperado durante el registro.'], 500);
            }
        }

        public function login(Request $request)
        {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json(['error' => 'Usuario no encontrado en la base de datos.'], 404);
            }

            if (!$user || !Hash::check($request->password, $user->password_hash)) {
                throw ValidationException::withMessages([
                    'email' => ['Las credenciales son incorrectas.'],
                ]);
            }

            $token = $user->createToken('auth_token')->plainTextToken;
            $userRole = $user->getRoleNames()->first();

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user_role' => $userRole
            ]);
        }

        public function logout(Request $request)
        {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Sesión cerrada.']);
        }

        public function userProfile(Request $request)
        {
            return response()->json($request->user()->load('roles'));
        }
    }