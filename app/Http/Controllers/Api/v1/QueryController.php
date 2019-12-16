<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\CommonResource;
use App\Repositories\BaseRepository;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;

class QueryController extends ApiController {
    use BaseRepository;
    protected $model;

    /**
     *=================================
     *======= COMMON FUNCTIONS ======
     *=================================
     */
    public function formInputDesignation(Request $request) {
        $mdInsert = [];
        $mdQuery = [
            "designation_id" => [
                "mergeArray"     => 'Associative', // Associative, Indexed, Merge, Object. Takes the Last from Array.
                "key"            => "designation_id",
                "table"          => "Designations",
                "tableWith"      => [
                    "employees",
                    "department" => [
                        "matchThese" => [ // Array Items used as AND. orThose used as Conjunction.
                            "active" => [
                                "type"       => "static", // static, request, /auth, relation
                                "columnName" => "active",
                                "operator"   => "=",
                                "value"      => 0 // request = 'active_id',
                            ]
                        ],
                        "orThose"    => [
                            "active" => [
                                "type"       => "static", // static, request, /auth, relation
                                "columnName" => "active",
                                "operator"   => "=",
                                "value"      => 1
                            ]
                        ],
                        "select"     => [
                            'id',
                            'department_no',
                            'name',
                        ],
                        "groupBy"    => "id",
                        "addSelect"  => [
                            "department_no as department_no_total",
                        ]
                    ]
                ],
                "withCount"      => [
                    "employees"
                ],
                "withCountWhere" => [ //
                    /*"department" => [
                        "relation"   => "department AS departments",
                        "selectRaw"  => "SUM(std_time) as std_time_total",
                        "matchThese" => [
                            "active" => [
                                "type"       => "static", // static, request, /auth, relation
                                "columnName" => "active",
                                "operator"   => "=",
                                "value"      => 1
                            ]
                        ],
                        "orThose"    => [
                            "active" => [
                                "type"       => "static", // static, request, /auth, relation
                                "columnName" => "active",
                                "operator"   => "=",
                                "value"      => 0
                            ]
                        ]
                    ]*/
                ],
                "whereHas"       => [
                    /*"department" => [
                        "relation"   => "department",
                        "selectRaw"  => null,
                        "matchThese" => [
                            "department_id" => [
                                "type"       => "request", // static, request, /auth, relation
                                "columnName" => "department_id",
                                "operator"   => "=",
                                "value"      => "department_id"
                            ],
                        ],
                        "orThose"    => null
                    ]*/
                ],
                "matchThese"     => [
                    /*"user_id" => [
                        "type"       => "request", // static, request, /auth, relation
                        "columnName" => "user_id",
                        "operator"   => "=",
                        "value"      => "user_id"
                    ],*/
                ],
                "orThose"        => [
                    /*"user_id" => [
                        "type"       => "request", // static, request, /auth, relation
                        "columnName" => "user_id",
                        "operator"   => "=",
                        "value"      => "user_id"
                    ],*/
                ],
                "where"          => [],
                "orWhere"        => [
                    /* [
                         "type"       => "static", // static, request, /auth, relation
                         "columnName" => "name",
                         "operator"   => "=",
                         "value"      => "Month"
                     ],
                     [
                         "type"       => "static",
                         "columnName" => "name",
                         "operator"   => "=",
                         "value"      => "Hour"
                     ]*/
                ],
                "search"         => [
                    "text"   => "",
                    "fields" => [
                    ]
                ],
                "select"         => [
                    "id"             => "id",
                    "department_id"  => "department_id",
                    "designation_no" => "designation_no",
                    "name"           => "name",
                    "description"    => "description",
                    "active"         => "active"
                ],
                "skip"           => 30,
                "take"           => 30,
//            "orderBy"    => "name",
//            "direction"  => "asc",
                "groupBy"        => "id",
                "addSelect"      => [
                    "SUM(pay_rate) as pay_rate_total",
                ],
                //
                "sortBy"         => [
                    "relation" => false,
                    "field"    => "id",
                    "desc"     => true
                ],
//            "value"  => "id",
                "pluck"          => [
                    "id" => "id",
                ],

            ],
            "designation_in" => [
                "mergeArray"     => 'Associative', // Associative, Indexed, Merge, Object. Takes the Last from Array.
                "key"            => "designation_in",
                "table"          => "Designations",
                "tableWith"      => [
//                    "department",
//                    "employees",
                    "department" => [
                        "matchThese" => [
                        ],
                        "orThose"    => [
                        ],
                        "select"     => [
                            'id',
                            'department_no',
                            'name',
                        ],
                        "groupBy"    => "id",
                        "addSelect"  => []
                    ]
                ],
                "withCount"      => [
                    "employees"
                ],
                "withCountWhere" => [
                    /*"department" => [
                        "relation"   => "department AS departments",
                        "selectRaw"  => "SUM(std_time) as std_time_total",
                        "matchThese" => [
                            "active" => [
                                "type"       => "static", // static, request, /auth, relation
                                "columnName" => "active",
                                "operator"   => "=",
                                "value"      => 1
                            ]
                        ],
                        "orThose"    => [
                            "active" => [
                                "type"       => "static", // static, request, /auth, relation
                                "columnName" => "active",
                                "operator"   => "=",
                                "value"      => 0
                            ]
                        ]
                    ]*/
                ],
                "whereHas"       => [
                    /*"department" => [
                        "relation"   => "department",
                        "selectRaw"  => null,
                        "matchThese" => [
                            "department_id" => [
                                "type"       => "request", // static, request, /auth, relation
                                "columnName" => "department_id",
                                "operator"   => "=",
                                "value"      => "department_id"
                            ],
                        ],
                        "orThose"    => null
                    ]*/
                ],
                "matchThese"     => [
                    /*"user_id" => [
                        "type"       => "request", // static, request, /auth, relation
                        "columnName" => "user_id",
                        "operator"   => "=",
                        "value"      => "user_id"
                    ],*/
                ],
                "orThose"        => [
                    /*"user_id" => [
                        "type"       => "request", // static, request, /auth, relation
                        "columnName" => "user_id",
                        "operator"   => "=",
                        "value"      => "user_id"
                    ],*/
                ],
                "where"          => [],
                "orWhere"        => [
                    /* [
                         "type"       => "static", // static, request, /auth, relation
                         "columnName" => "name",
                         "operator"   => "=",
                         "value"      => "Month"
                     ],
                     [
                         "type"       => "static",
                         "columnName" => "name",
                         "operator"   => "=",
                         "value"      => "Hour"
                     ]*/
                ],
                "search"         => [
                    "text"   => "",
                    "fields" => [
                    ]
                ],
                "select"         => [
                    "id"             => "id",
                    "department_id"  => "department_id",
                    "designation_no" => "designation_no",
                    "name"           => "name",
                    "description"    => "description",
                    "active"         => "active"
                ],
                "skip"           => 30,
                "take"           => 30,
//            "orderBy"    => "name",
//            "direction"  => "asc",
                "groupBy"        => "id",
                "addSelect"      => [
                    "SUM(pay_rate) as pay_rate_total",
                ],
                //
                "sortBy"         => [
                    "relation" => false,
                    "field"    => "id",
                    "desc"     => true
                ],
//            "value"  => "id",
                "pluck"          => [
                    "id" => "id",
                ],

            ]
        ];

        // Merge Flat or Associative  Array

        $request['dbQuery'] = $mdQuery;

        return $this->getFormInputs2($request);
    }
}
