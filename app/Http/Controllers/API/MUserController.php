<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\NotifResource;
use App\Models\PuspagaRw;
use GuzzleHttp\Client;

class MUserController extends Controller
{
    public $rules, $user;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->rules = [
            'id_role' => 'required|exists:App\Models\MRole,id,deleted_at,NULL',
            'id_konselor' => 'nullable|exists:App\Models\MKonselor,id,deleted_at,NULL|required_if:id_role,' . config('env.role.konselor'),
            'id_psikolog_volunteer' => 'nullable|exists:App\Models\PsikologVolunteer,id,deleted_at,NULL|required_if:id_role,' . config('env.role.psikolog'),
            'id_mahasiswa' => 'nullable|exists:App\Models\DMahasiswa,id,deleted_at,NULL|required_if:id_role,' . config('env.role.mahasiswa'),
            'id_opd' => 'nullable|exists:App\Models\MOpd,id,deleted_at,NULL|required_if:id_role,' . config('env.role.opd'),
            'name' => 'nullable|string',
            'username' => 'required|string|unique:App\Models\User,username',
            'password' => 'required|min:6|confirmed',
            'id_kelurahan' => 'nullable|exists:App\Models\MKelurahan,id,deleted_at,NULL|required_if:id_role,' . config('env.role.kelurahan'),
            'id_kecamatan' => 'nullable|exists:App\Models\MKecamatan,id,deleted_at,NULL|required_if:id_role,' . config('env.role.kecamatan'),
        ];

        // if($request->id_konselor){
        //     $this->rules['id_konselor'] = 'exists:App\Models\MKonselor,id,deleted_at,NULL';
        // }
        // if($request->id_role == config('env.role.konselor')){
        //     $this->rules['id_konselor'] .= '|required';
        // }
        // if($request->id_opd){
        //     $this->rules['id_opd'] = 'exists:App\Models\MOpd,id,deleted_at,NULL';
        // }
        // if($request->id_role == config('env.role.opd')){
        //     $this->rules['id_opd'] .= '|required';
        // }

        if ($request->id_role != config('env.role.opd') && $request->id_role != config('env.role.konselor')) {
            $this->rules['name'] .= '|required';
        }

        $this->user = User::select([
            'm_user.*',
            DB::raw('m_role.name AS role_name'),
            DB::raw('m_konselor.name AS konselor_name'),
            DB::raw('m_opd.name AS opd_name'),
            'm_kecamatan.name AS kecamatan_name',
            'm_kelurahan.name AS kelurahan_name',
            'kecamatan_kelurahan.id AS kecamatan_kelurahan_id',
            'kecamatan_kelurahan.name AS kecamatan_kelurahan_name',
        ])
            ->join('m_role', 'm_role.id', '=', 'm_user.id_role')
            ->leftJoin('m_konselor', 'm_konselor.id', '=', 'm_user.id_konselor')
            ->leftJoin('m_opd', 'm_opd.id', '=', 'm_user.id_opd')
            ->leftJoin('m_kecamatan', 'm_kecamatan.id', '=', 'm_user.id_kecamatan')
            ->leftJoin('m_kelurahan', 'm_kelurahan.id', '=', 'm_user.id_kelurahan')
            ->leftJoin('m_kecamatan AS kecamatan_kelurahan', 'kecamatan_kelurahan.id', '=', 'm_kelurahan.id_kecamatan');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $limit = $request->limit ? intval($request->limit) : 10;
            $order = $request->order ? $request->order : 'DESC';
            $sortby = $request->sortby ? strtolower($request->sortby) : 'id';

            $users = $this->user;

            if ($request->filled('id_role')) {
                $users->where('id_role', $request->id_role);
            }

            if ($request->filled('search')) {
                $users->where(DB::raw('lower(m_user.name)'), 'like', '%' . strtolower($request->search) . '%')
                    ->orWhere(DB::raw('lower(m_konselor.name)'), 'like', '%' . strtolower($request->search) . '%')
                    ->orWhere(DB::raw('lower(m_opd.name)'), 'like', '%' . strtolower($request->search) . '%')
                    ->orWhere(DB::raw('lower(m_user.username)'), 'like', '%' . strtolower($request->search) . '%');
            }

            if ($sortby == 'name') {
                $users = $users
                    ->orderBy('name', $order)
                    ->orderBy('konselor_name', $order)
                    ->orderBy('opd_name', $order)
                    ->paginate($limit);
            } else {
                $users = $users->orderBy($sortby, $order)->paginate($limit);
            }

            $this->saveLog($users);
            return $users;
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), $this->rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $user = User::create([
                'id_role' => $request->id_role,
                'id_konselor' => $request->id_role == config('env.role.konselor') ? $request->id_konselor : null,
                'id_opd' => $request->id_role == config('env.role.opd') ? $request->id_opd : null,
                'name' => ($request->name),
                'username' => Str::lower($request->username),
                'password' => Hash::make($request->password),
                'id_kelurahan' => $request->id_role == config('env.role.kelurahan') ? $request->id_kelurahan : null,
                'id_kecamatan' => $request->id_role == config('env.role.kecamatan') ? $request->id_kecamatan : null,
                'id_psikolog_volunteer' => $request->id_role == config('env.role.psikolog') ? $request->id_psikolog_volunteer : null,
            ]);

            DB::commit();
            $this->responseCode = 201;
            $this->responseData = $this->user->where('m_user.id', $user->id)->first();
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' ' . $e->getLine();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $id = intval($id);
            $user = $this->user->where('m_user.id', $id)->first();
            if (!$user) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 200;
            $this->responseData = $user;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $id = intval($id);
            $user = User::find($id);
            if (!$user) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $rules = $this->rules;
            $rules['username'] .= ',' . $id;
            unset($rules['password']);

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $user->id_role = $request->id_role;
            $user->id_konselor = $request->id_role == config('env.role.konselor') ? $request->id_konselor : null;
            $user->id_opd = $request->id_role == config('env.role.opd') ? $request->id_opd : null;
            $user->name = ($request->name);
            $user->username = Str::lower($request->username);
            $user->id_kelurahan = $request->id_role == config('env.role.kelurahan') ? $request->id_kelurahan : null;
            $user->id_kecamatan = $request->id_role == config('env.role.kecamatan') ? $request->id_kecamatan : null;
            $user->id_psikolog_volunteer = $request->id_role == config('env.role.psikolog') ? $request->id_psikolog_volunteer : null;
            $user->save();

            DB::commit();
            $this->responseCode = 200;
            $this->responseData = $this->user->where('m_user.id', $id)->first();
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function resetPassword(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $id = intval($id);
            $user = User::find($id);
            if (empty($user)) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $user->password = Hash::make(config('env.default_password'));
            $user->save();

            DB::commit();
            $this->responseCode = 200;
            $this->responseData = $this->user->where('m_user.id', $id)->first();
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' on line ' . $e->getLine();

            DB::rollBack();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function switchStatus($id)
    {
        try {
            $id = intval($id);
            $user = User::find($id);
            if (!$user) {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak di temukan';
                return response()->json($this->getResponse(), $this->responseCode);
            }

            DB::beginTransaction();

            $user->update([
                'is_active' => !$user->is_active
            ]);

            $this->responseCode = 200;
            $this->responseMessage = boolval($user->is_active) ? 'User telah diaktifkan' : 'User telah dinonaktifkan';
            $this->responseData = $this->user->where('m_user.id', $id)->first();
            DB::commit();
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function login(Request $request)
    {
        try {
            $rules = [
                'username' => 'required|string',
                'password' => 'required|min:6',
                'recaptcha' => 'required|string',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            if ($request->filled('recaptcha')) {
                $client = new Client();
                $response = $client->post(
                    'https://www.google.com/recaptcha/api/siteverify',
                    [
                        'verify' => !(config('app.env') == 'local'),
                        'form_params' => [
                            'secret' => config('env.recaptcha_key.secret'),
                            'remoteip' => request()->getClientIp(),
                            'response' => $request->recaptcha,
                        ]
                    ]
                );
                $body = json_decode((string)$response->getBody());
                if (!$body->success) {
                    $this->responseCode = 422;
                    $this->responseMessage = 'Gagal verifikasi reCAPTCHA';
                    return response()->json($this->getResponse(), $this->responseCode);
                }
            }

            // Fasilitator Check

            $puspaga_rw = PuspagaRw::where('nik', $request->username)->first();
            if ($puspaga_rw) {
                $user = User::where('username', $request->username)->first();
                if (!$user) {
                    User::create([
                        'name' => $puspaga_rw->name,
                        'username' => $puspaga_rw->nik,
                        'id_role' => config('env.role.fasilitator'),
                        'password' => Hash::make($puspaga_rw->nik),
                        'id_fasilitator' => $puspaga_rw->id,
                        'id_kecamatan' => $puspaga_rw->id_kecamatan,
                        'id_kelurahan' => $puspaga_rw->id_kelurahan,
                    ]);
                }
            }

            // End of fasilitator Check
            $credentials = [
                'username' => $request->username,
                'password' => $request->password,
                'is_active' => true,
            ];

            $token = Auth::attempt($credentials);

            if (!empty($token)) {
                $user = $this->user->where('m_user.username', $request->username)->first();
                $user->last_login = date('Y-m-d H:i:s');
                $user->save();

                $this->responseCode = 200;
                $this->responseMessage = 'Login berhasil';
                $this->responseData = [
                    'user' => $user,
                    'token' => $this->respondWithToken($token)
                ];

                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 404;
            $this->responseMessage = 'User tidak ditemukan/password salah/tidak aktif';

            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();

            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function getProfile()
    {
        try {
            $user = $this->user->where('m_user.id', Auth::id())->first();

            $this->responseCode = 200;
            $this->responseData = $user;
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function logout()
    {
        try {
            Auth::logout(true);

            $this->responseCode = 200;
            $this->responseMessage = 'Logout berhasil';
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $user = Auth::user();
            DB::beginTransaction();

            $rules = [
                'current_password' => 'required|current_password',
                'password' => 'required|min:6|confirmed|different:current_password',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $user->password = Hash::make($request->password);
            $user->save();

            $this->responseCode = 200;

            DB::commit();
            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage() . ' on line ' . $e->getLine();

            DB::rollback();
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    public function externalLogin(Request $request)
    {
        try {
            $rules = [
                'username' => 'required|string',
                'password' => 'required|min:6',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = $validator->errors()->first();
                $this->responseData = $validator->errors();
                return response()->json($this->getResponse(), $this->responseCode);
            }

            $credentials = [
                'username' => $request->username,
                'password' => $request->password,
                'is_active' => true,
            ];

            $token = Auth::attempt($credentials);

            if (!empty($token)) {
                $user = $this->user->where('m_user.username', $request->username)->first();
                $user->last_login = date('Y-m-d H:i:s');
                $user->save();

                $this->responseCode = 200;
                $this->responseMessage = 'Login berhasil';
                $this->responseData = [
                    'user' => $user,
                    'token' => $this->respondWithToken($token)
                ];

                return response()->json($this->getResponse(), $this->responseCode);
            }

            $this->responseCode = 404;
            $this->responseMessage = 'User  tidak ditemukan/password salah/tidak aktif';

            return response()->json($this->getResponse(), $this->responseCode);
        } catch (\Exception $e) {
            $this->responseCode = 500;
            $this->responseMessage = $e->getMessage();

            return response()->json($this->getResponse(), $this->responseCode);
        }
    }

    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
        ];
    }
}
