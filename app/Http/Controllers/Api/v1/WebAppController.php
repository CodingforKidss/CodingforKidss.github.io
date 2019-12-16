<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\CommonResource;
use App\Models\Attendance;
use App\Models\CategoryItem;
use App\Models\CourseEnrolment;
use App\Models\Courses;
use App\Models\Employees;
use App\Models\LoginLog;
use App\Models\Notifications;
use App\Models\PasswordResetCode;
use App\Models\SessionLogs;
use App\Models\Settings;
use App\Models\Shifts;
use App\Models\User;
use App\Models\WorkCalendar;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Imagick;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;

class WebAppController extends ApiController {
    use BaseRepository;
    protected $model;

    /**
     *=================================
     *======= SUPER FUNCTIONS ======
     *=================================
     */
    public function get(Request $request) {

        return $this->getNew($request);
    }

    public function store(Request $request) {

        return $this->storeNew($request);
    }

    public function remove(Request $request) {

        return $this->destroyNew($request);
    }

    public function removes(Request $request) {

        return $this->destroysNew($request);
    }

    public function formInputs(Request $request) {

        return $this->getFormInputs($request);
    }

    /**
     *=================================
     *======= COMMON FUNCTIONS ======
     *=================================
     */
    public function login(Request $request) {
        try {
            $input       = $request->all();
            $data        = NULL;
            $this->model = app("App\Models\\".$input['dbInsert']['table']);
            $validator   = Validator::make($input['data'], $input['dbInsert']['validations']);
            if ($validator->fails()) {
                return $this->setStatusCode(422)->respondWithError('Unprocessable Entity', 'Validation', $validator->errors(), $input['data']);
            } else {
                $exits = $this->model::where('username', $input['data']['username'])->exists();
                if (!$exits) {
                    return $this->setStatusCode(422)->respondWithError('Unprocessable Entity', 'exists', ['User Does not exits'], '');
                } else {
                    $account_status = $this->model::where('username', $input['data']['username'])->value('active');
                    if ($account_status == 1) {
                        if (Auth::attempt([
                            'username' => $input['data']['username'],
                            'password' => $input['data']['password']
                        ])) {
                            $auth = Auth::user();

                            $this->model->where('id', $auth->id)->update([
                                'api_ver'       => isset($input['data']['api_ver']) &&
                                                   $input['data']['api_ver'] ? $input['data']['api_ver'] : NULL,
                                'app_ver'       => isset($input['data']['app_ver']) &&
                                                   $input['data']['app_ver'] ? $input['data']['app_ver'] : NULL,
                                'app_build_ver' => isset($input['data']['app_build_ver']) &&
                                                   $input['data']['app_build_ver'] ? $input['data']['app_build_ver'] : NULL,
                                'u_agent'       => $request->header('User-Agent') ? $request->header('User-Agent') : NULL,
                                'device_log'    => isset($input['data']['device_log']) &&
                                                   $input['data']['device_log'] ? $input['data']['device_log'] : NULL,
                                'ipAddress'     => $request->ip() ? $request->ip() : NULL,
                            ]);

                            // Get User Data for VueX
                            $tableWith = isset($input['dbQuery']['tableWith']) &&
                                         $input['dbQuery']['tableWith'] ? $input['dbQuery']['tableWith'] : NULL;
                            $select    = isset($input['dbQuery']['select']) &&
                                         $input['dbQuery']['select'] ? $input['dbQuery']['select'] : NULL;
                            $pluck     = isset($input['dbQuery']['pluck']) &&
                                         $input['dbQuery']['pluck'] ? $input['dbQuery']['pluck'] : NULL;
                            $active    = isset($input['dbQuery']['active']) &&
                                         $input['dbQuery']['active'] ? $input['dbQuery']['active'] : NULL;
                            $user      = $this->model->where('id', $auth->id)->when($tableWith,
                                function ($query, $tableWith) {
                                    return $query->with($tableWith);
                                })
                                ->where($input['dbQuery']['matchThese'])
                                ->orWhere($input['dbQuery']['orThose'])
                                ->when($select, function ($query, $select) {
                                    return $query->select($select);
                                })
                                ->orderBy($input['dbQuery']['orderBy'],
                                    $input['dbQuery']['direction'])
                                ->get();

                            $data['data']          = $user[0];
                            $data['data']['token'] = $auth->createToken('eTeacher')->accessToken;

                            // Create Login Session Record.
                            $sessionLog = SessionLogs::create([
                                'user_id'       => $data['data']['id'],
                                'role_id'       => $data['data']['role_id'],
                                'token_id'      => $data['data']['token'],
                                'time_login'    => date('Y-m-d H:i:s'),
                                'description'   => 'login',
                                'api_ver'       => $input['data']['api_ver'],
                                'app_ver'       => $input['data']['app_ver'],
                                'app_build_ver' => $input['data']['app_build_ver'],
                                'u_agent'       => $request->header('User-Agent') ? $request->header('User-Agent') : NULL,
                                'device_log'    => NULL,
                                'ipAddress'     => $request->ip() ? $request->ip() : NULL,
                            ]);

                            $message        = 'Login Successful.';
                            $data['notify'] = [
                                'group' => 'saved',
                                'type'  => 'success',
                                'title' => 'Login',
                                'text'  => $message
                            ];

                            return $this->setStatusCode(200)->respondWithSuccess('OK', 'signin', $message, $data);
                        } else {
                            return $this->setStatusCode(422)
                                ->respondWithError('Unprocessable Entity', 'password', ['Password Wrong!'], '');
                        }
                    } else {
                        return $this->setStatusCode(422)->respondWithError('Unprocessable Entity', 'active',
                            ['User is not Active'], '');

                    }
                }
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Query Exception', ['QueryException'],
                    $e->getMessage());
        } catch (\PDOException $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Query Exception', ['PDOException'],
                    $e->getMessage());
        } catch (\BadMethodCallException $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Bad Method Call Exception',
                    ['BadMethodCallException'], $e->getMessage());
        } catch (\ErrorException $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Error Exception', ['ErrorException'],
                    $e->getMessage());
        } catch (\Exception $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Exception', ['Exception'], $e->getMessage());
        } catch (\Error $e) {
            return $this->setStatusCode(500)->respondWithError('Internal Server Error', 'Error', ['Error'],
                $e->getMessage());
        }
    }

    public function register(Request $request) {
        try {
            $input       = $request->all();
            $data        = NULL;
            $this->model = app("App\Models\\".$input['dbInsert']['table']);
            $validator   = Validator::make($input['data'], [$input['dbInsert']['validations']]);
            if ($validator->fails()) {
                return $this->setStatusCode(422)->respondWithError('Unprocessable Entity', 'Validation',
                    $validator->errors(), $input['data']);
            } else {
                if (isset($input['data']['password']) && $input['data']['password'] &&
                    strlen($input['data']['password']) > 0) {
                    $input['data']['password'] = Hash::make($input['data']['password']);
                }
                $create = User::create([
                    'name'          => $input['data']['name'],
                    'username'      => $input['data']['username'],
                    'email'         => $input['data']['email'],
                    'password'      => $input['data']['password'],
                    'address'       => $input['data']['address'],
                    'phone'         => $input['data']['phone'],
//                    'department_id' => $input['data']['department_id'],
                    'role_id'       => $input['data']['role_id'],
                    'active'        => 0,
                    'api_ver'       => $input['data']['api_ver'],
                    'app_ver'       => $input['data']['app_ver'],
                    'app_build_ver' => $input['data']['app_build_ver'],
                ]);
                $this->model->where('id', $create->id)->update([
                    'active'        => 0, // 1 = Allow login after registraiton
                    'api_ver'       => isset($input['data']['api_ver']) &&
                                       $input['data']['api_ver'] ? $input['data']['api_ver'] : NULL,
                    'app_ver'       => isset($input['data']['app_ver']) &&
                                       $input['data']['app_ver'] ? $input['data']['app_ver'] : NULL,
                    'app_build_ver' => isset($input['data']['app_build_ver']) &&
                                       $input['data']['app_build_ver'] ? $input['data']['app_build_ver'] : NULL,
                    'u_agent'       => $request->header('User-Agent') ? $request->header('User-Agent') : NULL,
                    'device_log'    => isset($input['data']['device_log']) &&
                                       $input['data']['device_log'] ? $input['data']['device_log'] : NULL,
                    'ipAddress'     => $request->ip() ? $request->ip() : NULL,
                ]);

                $message        = 'Registration Successful.';
                $data['notify'] = [
                    'group' => 'saved',
                    'type'  => 'success',
                    'title' => 'Registration',
                    'text'  => $message
                ];

                return $this->setStatusCode(200)->respondWithSuccess('OK', 'register', $message, $data);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Query Exception', ['QueryException'],
                    $e->getMessage());
        } catch (\PDOException $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Query Exception', ['PDOException'],
                    $e->getMessage());
        } catch (\BadMethodCallException $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Bad Method Call Exception',
                    ['BadMethodCallException'], $e->getMessage());
        } catch (\ErrorException $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Error Exception', ['ErrorException'],
                    $e->getMessage());
        } catch (\Exception $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Exception', ['Exception'], $e->getMessage());
        } catch (\Error $e) {
            return $this->setStatusCode(500)->respondWithError('Internal Server Error', 'Error', ['Error'],
                $e->getMessage());
        }
    }

    public function passwordForgot(Request $request) {
        try {
            $input       = $request->all();
            $data        = NULL;
            $this->model = app("App\Models\\".$input['dbInsert']['table']);
            if (isset($input['dbInsert']) && isset($input['dbInsert']['validations']) &&
                isset($input['dbInsert']['unique']) && $input['dbInsert']['validations'] &&
                $input['dbInsert']['unique']) {
                foreach ($input['dbInsert']['unique'] as $i => $unique) {
                    $input['dbInsert']['validations'][$i] = $input['dbInsert']['validations'][$i].
                                                            $input['dbInsert']['unique'][$i].$input['data']['id'];
                }
            }
            $validator = Validator::make($input['data'], $input['dbInsert']['validations']);
            if ($validator->fails()) {
                return $this->setStatusCode(422)
                    ->respondWithError('Unprocessable Entity', 'Validation', $validator->errors(),
                        $input['data']);
            } else {
                $user_exits = User::where('email', $input['data']['email'])->exists();
                if (!$user_exits) {
                    return $this->setStatusCode(422)
                        ->respondWithError('Unprocessable Entity', 'email',
                            ['current_password' => ['User Does not exits']], '');
                } else {
                    $user_code = PasswordResetCode::where('email', $input['data']['email'])->first();
                    if ($user_exits && isset($user_code['code']) && $user_code['code'] &&
                        strlen($user_code['code']) > 0) {
                        if (isset($user_code['created_at']) && $user_code['created_at'] &&
                            strlen($user_code['created_at']) > 0 &&
                            Carbon::now()->subDay(3) < $user_code['created_at']) {
                            $message        = 'Password recovery code already sent to:<br/>'.
                                              $input['data']['email'].
                                              '<br/>Please check your email.';
                            $data['notify'] = [
                                'group' => 'edited',
                                'type'  => 'warn',
                                'title' => 'Data Edited!',
                                'text'  => $message
                            ];

                            return $this->setStatusCode(200)->respondWithSuccess('OK', 'data', $message, $data);
                        } else {
                            $code           = random_str(6);
                            $data           = PasswordResetCode::where('email', $input['data']['email'])->update([
                                'code'       => $code,
                                'created_at' => date('Y-m-d H:i:s')
                            ]);
                            $message        = 'Password recovery code sent to:<br/>'.$input['data']['email'].
                                              '<br/>Please check your email.';
                            $data['notify'] = [
                                'group' => 'edited',
                                'type'  => 'warn',
                                'title' => 'Data Edited!',
                                'text'  => $message
                            ];
                            return $this->setStatusCode(200)->respondWithSuccess('OK', 'data', $message, $data);
                        }
                    } else {
                        $input['data']['code']       = random_str(6);
                        $input['data']['created_at'] = date('Y-m-d H:i:s');
                        $data                        = PasswordResetCode::create($input['data']);
                        $message                     = 'Password recovery code sent to:<br/>'.
                                                       $input['data']['email'].
                                                       '<br/>Please check your email.';
                        $data['notify']              = [
                            'group' => 'edited',
                            'type'  => 'warn',
                            'title' => 'Data Edited!',
                            'text'  => $message
                        ];
                        return $this->setStatusCode(200)->respondWithSuccess('OK', 'data', $message, $data);
                    }
                }
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Query Exception', ['QueryException'],
                    $e->getMessage());
        } catch (\PDOException $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Query Exception', ['PDOException'],
                    $e->getMessage());
        } catch (\BadMethodCallException $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Bad Method Call Exception',
                    ['BadMethodCallException'], $e->getMessage());
        } catch (\ErrorException $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Error Exception', ['ErrorException'],
                    $e->getMessage());
        } catch (\Exception $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Exception', ['Exception'], $e->getMessage());
        } catch (\Error $e) {
            return $this->setStatusCode(500)->respondWithError('Internal Server Error', 'Error', ['Error'],
                $e->getMessage());
        }
    }

    public function passwordReset(Request $request) {
        try {
            $input       = $request->all();
            $data        = NULL;
            $this->model = app("App\Models\\".$input['dbInsert']['table']);
            if (isset($input['dbInsert']) && isset($input['dbInsert']['validations']) &&
                isset($input['dbInsert']['unique']) && $input['dbInsert']['validations'] &&
                $input['dbInsert']['unique']) {
                foreach ($input['dbInsert']['unique'] as $i => $unique) {
                    $input['dbInsert']['validations'][$i] = $input['dbInsert']['validations'][$i].
                                                            $input['dbInsert']['unique'][$i].$input['data']['id'];
                }
            }
            $validator = Validator::make($input['data'], $input['dbInsert']['validations']);
            if ($validator->fails()) {
                return $this->setStatusCode(422)
                    ->respondWithError('Unprocessable Entity', 'Validation', $validator->errors(),
                        $input['data']);
            } else {
                $user_exits = User::where('email', $input['data']['email'])->exists();
                $user_code  = PasswordResetCode::where('email', $input['data']['email'])
                    ->where('code', $input['data']['code'])
                    ->first();
                if ($user_exits && isset($user_code['code']) && $user_code['code'] && strlen($user_code['code']) > 0) {
                    if (isset($user_code['created_at']) && $user_code['created_at'] &&
                        strlen($user_code['created_at']) > 0 && Carbon::now()->subDay(3) < $user_code['created_at']) {
                        $user           = User::where('email', $input['data']['email'])->first();
                        $user->password = Hash::make($input['data']['new_password']);
                        $user->save();
                        $delete         = PasswordResetCode::where('email', $input['data']['email'])
                            ->where('code', $input['data']['code'])
                            ->delete();
                        $message        = 'New Password Set Successfully.';
                        $data['notify'] = [
                            'group' => 'edited',
                            'type'  => 'warn',
                            'title' => 'Data Edited!',
                            'text'  => $message
                        ];
                        return $this->setStatusCode(200)->respondWithSuccess('OK', 'data', $message, $data);
                    } else {
                        return $this->setStatusCode(422)
                            ->respondWithError('Unprocessable Entity', 'code',
                                ['code' => 'Recovery Code Expired, Please Request a New Code!'], '');
                    }
                } else {
                    return $this->setStatusCode(422)
                        ->respondWithError('Unprocessable Entity', 'code',
                            ['code' => ['Recovery Code is Not Valid!']], '');
                }
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Query Exception', ['QueryException'],
                    $e->getMessage());
        } catch (\PDOException $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Query Exception', ['PDOException'],
                    $e->getMessage());
        } catch (\BadMethodCallException $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Bad Method Call Exception',
                    ['BadMethodCallException'], $e->getMessage());
        } catch (\ErrorException $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Error Exception', ['ErrorException'],
                    $e->getMessage());
        } catch (\Exception $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Exception', ['Exception'], $e->getMessage());
        } catch (\Error $e) {
            return $this->setStatusCode(500)->respondWithError('Internal Server Error', 'Error', ['Error'],
                $e->getMessage());
        }
    }

    public function changePassword(Request $request) {
        try {
            $user        = Auth::check() && Auth::user() ? Auth::user() : NULL;
            $input       = $request->all();
            $data        = NULL;
            $this->model = app("App\Models\\".$input['dbInsert']['table']);
            if (isset($input['dbInsert']) && isset($input['dbInsert']['validations']) &&
                isset($input['dbInsert']['unique']) && $input['dbInsert']['validations'] &&
                $input['dbInsert']['unique']) {
                foreach ($input['dbInsert']['unique'] as $i => $unique) {
                    $input['dbInsert']['validations'][$i] = $input['dbInsert']['validations'][$i].
                                                            $input['dbInsert']['unique'][$i].$input['data']['id'];
                }
            }
            $validator = Validator::make($input['data'], $input['dbInsert']['validations']);
            if ($validator->fails()) {
                return $this->setStatusCode(422)
                    ->respondWithError('Unprocessable Entity', 'Validation', $validator->errors(),
                        $input['data']);
            } else if (isset($input['dbInsert']['role']['active']) && (($input['dbInsert']['role']['active'] === TRUE && isset($input['dbInsert']['role']['roles']) && in_array($user['role']['name'], $input['dbInsert']['role']['roles'])) OR ($input['dbInsert']['role']['active'] === FALSE && isset($input['dbInsert']['role']['roles']) && in_array('ALL', $input['dbInsert']['role']['roles'])))) {
                $current_password = $user->password;
                if (Hash::check($input['data']['current_password'], $current_password)) {
                    $user->password = Hash::make($input['data']['new_password']);
                    $user->save();
                    $message        = 'Password Changed Successfully.';
                    $data['notify'] = [
                        'group' => 'edited',
                        'type'  => 'warn',
                        'title' => 'Data Edited!',
                        'text'  => $message
                    ];

                    return $this->setStatusCode(200)->respondWithSuccess('OK', 'data', 'Password Changed Successfully.',
                        $data);
                } else {
                    return $this->setStatusCode(422)
                        ->respondWithError('Unprocessable Entity', 'validation',
                            ['current_password' => ['Incorrect Password']], '');
                }
            } else {
                $message = isset($input['dbInsert']['role']['message']) && $input['dbInsert']['role']['message'] && strlen($input['dbInsert']['role']['message']) > 0 ? $input['dbInsert']['role']['message'] : 'You do not have permission to perform this action.';
                return $this->setStatusCode(422)->respondWithError('Unprocessable Entity', 'role', [$message], '');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Query Exception', ['QueryException'],
                    $e->getMessage());
        } catch (\PDOException $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Query Exception', ['PDOException'],
                    $e->getMessage());
        } catch (\BadMethodCallException $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Bad Method Call Exception',
                    ['BadMethodCallException'], $e->getMessage());
        } catch (\ErrorException $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Error Exception', ['ErrorException'],
                    $e->getMessage());
        } catch (\Exception $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Exception', ['Exception'], $e->getMessage());
        } catch (\Error $e) {
            return $this->setStatusCode(500)->respondWithError('Internal Server Error', 'Error', ['Error'],
                $e->getMessage());
        }
    }

    public function logout(Request $request) {
        try {
            $input = $request->all();
            $data  = [];
            //$token = $request->user()->token();            /*;
            //$token->revoke();
            $message        = 'You have been logged out!';
            $data['notify'] = [
                'group' => 'saved',
                'type'  => 'success',
                'title' => 'Logout',
                'text'  => $message
            ];

            // Keep Login Session Updated with Logout Time
            $sessionLog = SessionLogs::where('user_id', $input['id'])
                ->where('token_id', $input['token'])
                ->update([
                    'time_logout' => date('Y-m-d H:i:s'),
                    'description' => 'logout',
                ]);

            return $this->setStatusCode(200)->respondWithSuccess('OK', 'logout', $message, $data);

        } catch (\Illuminate\Database\QueryException $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Query Exception', ['QueryException'],
                    $e->getMessage());
        } catch (\PDOException $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Query Exception', ['PDOException'],
                    $e->getMessage());
        } catch (\BadMethodCallException $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Bad Method Call Exception',
                    ['BadMethodCallException'], $e->getMessage());
        } catch (\ErrorException $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Error Exception', ['ErrorException'],
                    $e->getMessage());
        } catch (\Exception $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Exception', ['Exception'], $e->getMessage());
        } catch (\Error $e) {
            return $this->setStatusCode(500)->respondWithError('Internal Server Error', 'Error', ['Error'],
                $e->getMessage());
        }

    }

    /**
     *=================================
     *======= DASHBOARD ======
     *=================================
     */
    public function getDashboard(Request $request) {
        try {
            $today      = Carbon::now()->format('Y-m-d');
            $from       = Carbon::now()->format('Y-m-d');
            $until      = Carbon::now()->format('Y-m-d');
            $this_month = Carbon::now()->format('m');
            $input      = $request->all();
            $data       = [];
            $user       = Auth::check() && Auth::user() ? Auth::user() : NULL;
            $settings   = Settings::where('active', 1)->orderBy('id', 'desc')->first();

            if (isset($user['role']['name']) && $user['role']['name'] && ($user['role']['name'] === 'Admin' || $user['role']['name'] === 'Parent')) {
                $data['user_count']              = User::where('role_id', 3)->where('active', 1)->count();
                $data['donor_count']             = User::where('role_id', 4)->where('active', 1)->count();
                $data['food_count']              = Courses::where('active', 1)->count();
                $data['enrolment_count']         = CourseEnrolment::where('active', 1)->count();
                $data['student']                 = User::with('login_sessions')->where('parent_id', $user['id'])->first();
                $data['student_enrolment_count'] = CourseEnrolment::where('user_id', $data['student']['id'])->where('active', 1)->count();
//                $data['donation_today'] = User::where('role_id', 4)->where('active', 1)->count();
            }

            return $this->setStatusCode(200)->respondWithSuccess('OK', 'data', 'Query Successful. ', $data);

        } catch (\Illuminate\Database\QueryException $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Query Exception', ['QueryException'],
                    $e->getMessage());
        } catch (\PDOException $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Query Exception', ['PDOException'],
                    $e->getMessage());
        } catch (\BadMethodCallException $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Bad Method Call Exception',
                    ['BadMethodCallException'], $e->getMessage());
        } catch (\ErrorException $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Error Exception', ['ErrorException'],
                    $e->getMessage());
        } catch (\Exception $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Exception', ['Exception'], $e->getMessage());
        } catch (\Error $e) {
            return $this->setStatusCode(404)->respondWithError('Internal Server Error', 'Error', ['Error'],
                $e->getMessage());
        }
    }

    /**
     *=================================
     *======= REPORT ======
     *=================================
     */
}
