<?php

namespace App\Repositories;

use App\Http\Resources\CommonResource;
use App\Models\Deletes;
use App\Models\Edits;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;
use Intervention\Image\ImageManagerStatic as Image;
use Imagick;

trait BaseRepository {

    public function getData($input) {
        $data       = NULL;
        $sortBy     = NULL;
        $sortByDesc = false;
        $searchText = NULL;
        $where      = NULL;
        $orWhere    = NULL;

        if (isset($input['dbQuery']) && $input['dbQuery'] && !empty($input['dbQuery'])) {
            $this->model = app("App\Models\\".$input['dbQuery']['table']);

            $tableWith = isset($input['dbQuery']['tableWith']) && $input['dbQuery']['tableWith'] ? $input['dbQuery']['tableWith'] : NULL;

            $select = isset($input['dbQuery']['select']) && $input['dbQuery']['select'] ? $input['dbQuery']['select'] : NULL;

            $withCount = isset($input['dbQuery']['withCount']) && $input['dbQuery']['withCount'] ? $input['dbQuery']['withCount'] : NULL;

            $pluck = isset($input['dbQuery']['pluck']) && $input['dbQuery']['pluck'] ? $input['dbQuery']['pluck'] : NULL;

            $active = isset($input['dbQuery']['active']) && $input['dbQuery']['active'] ? $input['dbQuery']['active'] : NULL;

            $searchText = isset($input['dbQuery']['search']['text']) && $input['dbQuery']['search']['text'] ? $input['dbQuery']['search']['text'] : NULL;

            // where:
            if (isset($input['dbQuery']['where']) && $input['dbQuery']['where']) {
                $dbQueryWhere = $input['dbQuery']['where'];
                $where        = function ($q) use ($dbQueryWhere) {
                    foreach ($dbQueryWhere['where'] as $key => $whr) {
                        $q->where($whr['columnName'], $whr['operator'], $whr['value']);
                    }
                };
            }
            // orWhere:
            if (isset($input['dbQuery']['orWhere']) && $input['dbQuery']['orWhere']) {
                $dbQueryOrWhere = $input['dbQuery']['orWhere'];
                $orWhere        = function ($q) use ($dbQueryOrWhere) {
                    foreach ($dbQueryOrWhere as $key => $wOw) {
                        if ((int)$key > 0) {
                            $q->orWhere($wOw['columnName'], $wOw['operator'], $wOw['value']);
                        } else {
                            $q->where($wOw['columnName'], $wOw['operator'], $wOw['value']);
                        }
                    }
                };
            }

            if (isset($input['dbQuery']['sortBy']['relation']) && $input['dbQuery']['sortBy']['relation'] !== false && strlen($input['dbQuery']['sortBy']['relation']) > 0) {
                $sortByDesc = $input['dbQuery']['sortBy']['desc'];
                $relation   = $input['dbQuery']['sortBy']['relation'];
                $field      = $input['dbQuery']['sortBy']['field'];
                $sortBy     = function ($q) use ($relation, $field) {
                    return $q->$relation ? $q->$relation->$field : null;
                };
            } else if (isset($input['dbQuery']['sortBy']['relation']) && $input['dbQuery']['sortBy']['relation'] === false) {
                $sortByDesc = $input['dbQuery']['sortBy']['desc'];
                $sortBy     = $input['dbQuery']['sortBy']['field'];
            }

            $data = $this->model->when($tableWith, function ($query, $tableWith) {
                return $query->with($tableWith);
            })->where(function ($query) use ($input) {
                $query->where($input['dbQuery']['matchThese'])->orWhere($input['dbQuery']['orThose']);
            })->when($where, function ($query) use ($where) {
                $query->where($where);
            })->when($orWhere, function ($query) use ($orWhere) {
                $query->where($orWhere);
            })->when($searchText, function ($query) use ($input, $searchText) {
                return $query->where(function ($query) use ($input) {
                    foreach ($input['dbQuery']['search']['fields'] as $search) {
                        if (isset($search['field']) && strlen($search['field']) > 0 && isset($search['operator']) && strlen($search['operator']) > 0) {
                            if (isset($search['relation']) && $search['relation'] === false) {
                                $query->orWhere($search['field'], $search['operator'], '%'.$input['dbQuery']['search']['text'].'%');
                            } else if (isset($search['relation']) && $search['relation'] && strlen($search['relation']) > 0) {
                                $query->orWhereHas($search['relation'], function ($q) use ($search, $input) {
                                    $q->where($search['field'], $search['operator'], '%'.$input['dbQuery']['search']['text'].'%');
                                });
                            }
                        }
                    }
                });
            })->when($active, function ($query, $active) {
                return $query->where('active', $active);
            })->when($select, function ($query, $select) {
                return $query->select($select);
            })->when($withCount, function ($query, $withCount) {
                return $query->withCount($withCount);
            })//->orderBy($input['dbQuery']['orderBy'], $input['dbQuery']['direction'])
            ->when($select, function ($query, $select) {
                return $query->get($select);
            }, function ($query) {
                return $query->get();
            })->when($sortBy, function ($query, $sortBy) use ($sortByDesc) {
                return $query->sortBy($sortBy, SORT_REGULAR, $sortByDesc);
            });

            return CommonResource::collection($data);
        }

        return $data;
    }

    public function getFormInputs2($request) {
        try {
            $input = $request->all();

            $data           = [];
            $tableWith      = NULL;
            $select         = NULL;
            $withCount      = NULL;
            $withCountWhere = NULL;
            $whereHas       = NULL;
            $matchThese     = [];
            $orThose        = [];
            $where          = NULL;
            $orWhere        = NULL;
            $groupBy        = NULL;
            $addSelect      = NULL;
            $pluck          = NULL;
            $sortBy         = NULL;
            $sortByDesc     = false;
            $searchText     = NULL;
            $mergeArray     = NULL;

            // SET dbQuery local variable:
            $dbQuery = $input['dbQuery'];

            foreach ($dbQuery as $key => $value) {

                $this->model = app("App\Models\\".$value['table']);

                // tableWith:
                if (isset($value['tableWith']) && $value['tableWith']) {
                    foreach ($value['tableWith'] as $n => $tw) {
                        if (isset($tw) && $tw && gettype($tw) === 'array') {
                            $twMatchThese = [];
                            $twOrThose    = [];
                            $twAddSelect  = [];
                            if (isset($tw['matchThese']) && $tw['matchThese']) { // TO get all the related field. Doesn't stop loading.
                                foreach ($tw['matchThese'] as $k => $mt) {
                                    switch ($mt['type']) {
                                        case 'static':
                                            $twMatchThese[] = [
                                                $mt['columnName'],
                                                $mt['operator'],
                                                $mt['value']
                                            ];
                                            break;
                                        case 'request':
                                            if (isset($request['data'][$mt['value']]) && $request['data'][$mt['value']]) {
                                                $twMatchThese[] = [
                                                    $mt['columnName'],
                                                    $mt['operator'],
                                                    $request['data'][$mt['value']]
                                                ];
                                            }
                                            break;
                                        case 'auth':
                                            $twMatchThese[] = [
                                                $mt['columnName'],
                                                $mt['operator'],
                                                Auth::user()[$mt['value']]
                                            ];
                                            break;
                                        case 'relation':
                                            break;
                                        default:
                                            break;
                                    }
                                }
                            }
                            if (isset($tw['orThose']) && $tw['orThose']) {
                                foreach ($tw['orThose'] as $k => $mt) {
                                    switch ($mt['type']) {
                                        case 'static':
                                            $twOrThose[] = [
                                                $mt['columnName'],
                                                $mt['operator'],
                                                $mt['value']
                                            ];
                                            break;
                                        case 'request':
                                            if (isset($request['data'][$mt['value']]) && $request['data'][$mt['value']]) {
                                                $twOrThose[] = [
                                                    $mt['columnName'],
                                                    $mt['operator'],
                                                    $request['data'][$mt['value']]
                                                ];
                                            }
                                            break;
                                        case 'auth':
                                            $twOrThose[] = [
                                                $mt['columnName'],
                                                $mt['operator'],
                                                Auth::user()[$mt['value']]
                                            ];
                                            break;
                                        case 'relation':
                                            break;
                                        default:
                                            break;
                                    }
                                }
                            }
                            if (isset($tw['addSelect']) && $tw['addSelect']) {
                                $twAddSelQuery = NULL;
                                foreach ($tw['addSelect'] as $i => $addSel) {
                                    $twAddSelQuery[] = DB::raw($addSel);
                                }
                                $twAddSelect = $twAddSelQuery;
                            }

                            $tableWith[$n] = function ($q) use ($tw, $twMatchThese, $twOrThose, $twAddSelect) {
                                $q->select($tw['select'])
                                    ->where($twMatchThese)
                                    ->orWhere($twOrThose)
                                    ->when($twAddSelect, function ($q) use ($tw, $twAddSelect) {
                                        return $q->groupBy($tw['groupBy'])->addSelect($twAddSelect);
                                    });
                            };
                        } else if (isset($tw) && $tw && gettype($tw) === 'string') {
                            $tableWith[$n] = $tw;
                        }
                    }
                }

                $select = isset($value['select']) && $value['select'] ? $value['select'] : NULL;

                $withCount = isset($value['withCount']) && $value['withCount'] ? $value['withCount'] : NULL;

                $pluck = isset($value['pluck']) && $value['pluck'] ? $value['pluck'] : NULL;

                $active = isset($value['active']) && $value['active'] ? $value['active'] : NULL;

                $groupBy = isset($value['groupBy']) && $value['groupBy'] ? $value['groupBy'] : NULL;

                $searchText = isset($value['search']['text']) && $value['search']['text'] ? $value['search']['text'] : NULL;

                $mergeArray = isset($value['mergeArray']) && $value['mergeArray'] ? $value['mergeArray'] : NULL;

                // where:
                $where = NULL;
                if (isset($value['where']) && $value['where']) {
                    $where = function ($q) use ($value) {
                        foreach ($value['where'] as $key => $whr) {
                            $q->where($whr['columnName'], $whr['operator'], $whr['value']);
                        }
                    };
                }

                // orWhere:
                $orWhere = NULL;
                if (isset($value['orWhere']) && $value['orWhere']) {
                    $orWhere = function ($q) use ($value) {
                        foreach ($value['orWhere'] as $key => $wOw) {
                            if ((int)$key > 0) {
                                $q->orWhere($wOw['columnName'], $wOw['operator'], $wOw['value']);
                            } else {
                                $q->where($wOw['columnName'], $wOw['operator'], $wOw['value']);
                            }
                        }
                    };
                }

                // sortBy:
                if (isset($value['sortBy']['relation']) && $value['sortBy']['relation'] !== false && strlen($value['sortBy']['relation']) > 0) {
                    $sortByDesc = $value['sortBy']['desc'];
                    $relation   = $value['sortBy']['relation'];
                    $field      = $value['sortBy']['field'];
                    $sortBy     = function ($q) use ($relation, $field) {
                        return $q->$relation ? $q->$relation->$field : null;
                    };
                } else if (isset($value['sortBy']['relation']) && $value['sortBy']['relation'] === false) {
                    $sortByDesc = $value['sortBy']['desc'];
                    $sortBy     = $value['sortBy']['field'];
                }

                // Main Query:
                $data[$value['key']] = CommonResource::collection($this->model
                    ->when($tableWith, function ($query, $tableWith) {
                        return $query->with($tableWith);
                    })
                    ->when($select, function ($query, $select) {
                        return $query->select($select);
                    })
                    ->when($withCount, function ($query, $withCount) {
                        return $query->withCount($withCount);
                    })
                    ->when($withCountWhere, function ($query, $withCountWhere) {
                        return $query->withCount($withCountWhere);
                    })
                    ->where(function ($query) use ($value) {
                        $query->where($value['matchThese'])->orWhere($value['orThose']);
                    })
                    ->when($where, function ($query) use ($where) {
                        $query->where($where);
                    })
                    ->when($orWhere, function ($query) use ($orWhere) {
                        $query->where($orWhere);
                    })
                    ->when($searchText, function ($query) use ($value, $searchText) {
                        return $query->where(function ($query) use ($value) {
                            foreach ($value['search']['fields'] as $search) {
                                if (isset($search['field']) && strlen($search['field']) > 0 && isset($search['operator']) && strlen($search['operator']) > 0) {
                                    if (isset($search['relation']) && $search['relation'] === false) {
                                        $query->orWhere($search['field'], $search['operator'], '%'.$value['search']['text'].'%');
                                    } else if (isset($search['relation']) && $search['relation'] && strlen($search['relation']) > 0) {
                                        $query->orWhereHas($search['relation'], function ($q) use ($search, $value) {
                                            $q->where($search['field'], $search['operator'], '%'.$value['search']['text'].'%');
                                        });
                                    }
                                }
                            }
                        });
                    })
                    /*->when($active, function ($query, $active) {
                        return $query->where('active', $active);
                    })*/
                    //->orderBy($value['orderBy'], $value['direction'])
                    ->when($groupBy, function ($query, $groupBy) {
                        return $query->groupBy($groupBy);
                    })
                    ->when($addSelect, function ($query, $addSelect) {
                        return $query->addSelect($addSelect);
                    })
                    ->when($select, function ($query, $select) {
                        return $query->get($select);
                    }, function ($query) {
                        return $query->get();
                    })
                    ->when($sortBy, function ($query, $sortBy) use ($sortByDesc) {
                        return $query->sortBy($sortBy, SORT_REGULAR, $sortByDesc);
                    }));
            }

            switch ($mergeArray) {
                case 'Merge':
                    $merge = $data;
                    $data  = [];
                    foreach ($merge as $key => $dA) {
                        array_merge_recursive($data, $dA);
                    }
                    break;
                default:
                    break;
            }

            return $this->setStatusCode(200)->respondWithSuccess('OK', 'data', 'Data Loaded Successfully', $data);

        } catch (QueryException $e) {
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
            return $this->setStatusCode(500)->respondWithError('Internal Server Error', 'Error Exception', ['ErrorException'], $e->getTrace());
        } catch (\Exception $e) {
            return $this->setStatusCode(500)
                ->respondWithError('Internal Server Error', 'Exception', ['Exception'], $e->getMessage());
        } catch (\Error $e) {
            return $this->setStatusCode(500)->respondWithError('Internal Server Error', 'Error', ['Error'],
                $e->getMessage());
        }
    }

    public function getFormInputs($request) {
        try {
            $input   = $request->all();
            $data    = [];
            $where   = NULL;
            $orWhere = NULL;

            foreach ($input['dbQueryForInputs'] as $key => $value) {
                $tableWith   = isset($value['tableWith']) && $value['tableWith'] ? $value['tableWith'] : NULL;
                $select      = isset($value['select']) && $value['select'] ? $value['select'] : NULL;
                $pluck       = isset($value['pluck']) && $value['pluck'] ? $value['pluck'] : NULL;
                $this->model = app("App\Models\\".$value['table']);
                // where:
                $where = NULL;
                if (isset($value['where']) && $value['where']) {
                    $where = function ($q) use ($value) {
                        foreach ($value['where'] as $key => $whr) {
                            $q->where($whr['columnName'], $whr['operator'], $whr['value']);
                        }
                    };
                }
                // orWhere:
                $orWhere = NULL;
                if (isset($value['orWhere']) && $value['orWhere']) {
                    $orWhere = function ($q) use ($value) {
                        foreach ($value['orWhere'] as $key => $wOw) {
                            if ((int)$key > 0) {
                                $q->orWhere($wOw['columnName'], $wOw['operator'], $wOw['value']);
                            } else {
                                $q->where($wOw['columnName'], $wOw['operator'], $wOw['value']);
                            }
                        }
                    };
                }
                $data[$value['key']] = CommonResource::collection($this->model
                    ->when($tableWith, function ($query, $tableWith) {
                        return $query->with($tableWith);
                    })
                    ->where($value['matchThese'])
                    ->orWhere($value['orThose'])
                    ->when($where, function ($query) use ($where) {
                        $query->where($where);
                    })
                    ->when($orWhere, function ($query) use ($orWhere) {
                        $query->where($orWhere);
                    })
                    ->when($select, function ($query, $select) {
                        return $query->select($select);
                    })
                    ->orderBy($value['orderBy'], $value['direction'])
                    ->when($select, function ($query, $select) {
                        return $query->get($select);
                    }, function ($query) {
                        return $query->get();
                    }));
            }

            return $this->setStatusCode(200)->respondWithSuccess('OK', 'data', 'Data Loaded Successfully', $data);
        } catch (QueryException $e) {
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

    public function callSuperQuery($request) {
        $data        = NULL;
        $report_type = $request['data']['report_id'];
        //
        $dbQuery        = NULL;
        $select         = NULL;
        $tableWith      = NULL;
        $matchThese     = [];
        $orThose        = [];
        $where          = NULL;
        $orWhere        = NULL;
        $whereHas       = NULL;
        $withCount      = NULL;
        $withCountWhere = NULL;
        $addSelect      = NULL;
        $pluck          = NULL;

        $sortBy     = NULL;
        $sortByDesc = false;
        $searchText = NULL;

        // SET dbQuery local variable:
        $dbQuery = $request['dbQuery'];
        // SET select:
        $select = isset($dbQuery['select']) && $dbQuery['select'] ? $dbQuery['select'] : NULL;
        // SET withCount:
        $withCount = isset($dbQuery['withCount']) && $dbQuery['withCount'] ? $dbQuery['withCount'] : NULL;
        // SET pluck:
        $pluck = isset($dbQuery['pluck']) && $dbQuery['pluck'] ? $dbQuery['pluck'] : NULL;
        // Search Text: FIX IT.
        $searchText = isset($dbQuery['search']['text']) && $dbQuery['search']['text'] ? $dbQuery['search']['text'] : NULL;

        // SET TABLE:
        $this->model = app("App\Models\\".$dbQuery['table']);
        // matchThese:
        if (isset($dbQuery['matchThese']) && $dbQuery['matchThese']) {
            foreach ($dbQuery['matchThese'] as $key => $mt) {
                switch ($mt['type']) {
                    case 'static':
                        $matchThese[] = [
                            $mt['columnName'],
                            $mt['operator'],
                            $mt['value']
                        ];
                        break;
                    case 'request':
                        if (isset($request['data'][$mt['value']]) && $request['data'][$mt['value']]) {
                            $matchThese[] = [
                                $mt['columnName'],
                                $mt['operator'],
                                $request['data'][$mt['value']]
                            ];
                        }
                        break;
                    case 'auth':
                        $matchThese[] = [
                            $mt['columnName'],
                            $mt['operator'],
                            Auth::user()[$mt['value']]
                        ];
                        break;
                    case 'relation':
                        break;
                    default:
                        break;
                }
            }
        }
        // orThose:
        if (isset($dbQuery['orThose']) && $dbQuery['orThose']) {
            foreach ($dbQuery['orThose'] as $key => $mt) {
                switch ($mt['type']) {
                    case 'static':
                        $orThose[] = [
                            $mt['columnName'],
                            $mt['operator'],
                            $mt['value']
                        ];
                        break;
                    case 'request':
                        if (isset($request['data'][$mt['value']]) && $request['data'][$mt['value']]) {
                            $orThose[] = [
                                $mt['columnName'],
                                $mt['operator'],
                                $request['data'][$mt['value']]
                            ];
                        }
                        break;
                    case 'auth':
                        $orThose[] = [
                            $mt['columnName'],
                            $mt['operator'],
                            Auth::user()[$mt['value']]
                        ];
                        break;
                    case 'relation':
                        break;
                    default:
                        break;
                }
            }
        }
        /*// where:
        if (isset($dbQuery['where']) && $dbQuery['where']) {
            $dbQueryWhere = $dbQuery['where'];
            $where        = function ($q) use ($dbQueryWhere) {
                foreach ($dbQueryWhere['where'] as $key => $whr) {
                    $q->where($whr['columnName'], $whr['operator'], $whr['value']);
                }
            };
        }
        // orWhere:
        if (isset($input['dbQuery']['orWhere']) && $input['dbQuery']['orWhere']) {
            $dbQueryOrWhere = $input['dbQuery']['orWhere'];
            $orWhere        = function ($q) use ($dbQueryOrWhere) {
                foreach ($dbQueryOrWhere as $key => $wOw) {
                    if ((int)$key > 0) {
                        $q->orWhere($wOw['columnName'], $wOw['operator'], $wOw['value']);
                    } else {
                        $q->where($wOw['columnName'], $wOw['operator'], $wOw['value']);
                    }
                }
            };
        }
        // where:
        if (isset($dbQuery['where']) && $dbQuery['where']) {
            foreach ($dbQuery['where'] as $key => $mt) {
                switch ($mt['type']) {
                    case 'static':
                        $orThose[] = [
                            $mt['columnName'],
                            $mt['operator'],
                            $mt['value']
                        ];
                        break;
                    case 'request':
                        if (isset($request['data'][$mt['value']]) && $request['data'][$mt['value']]) {
                            $orThose[] = [
                                $mt['columnName'],
                                $mt['operator'],
                                $request['data'][$mt['value']]
                            ];
                        }
                        break;
                    case 'auth':
                        $orThose[] = [
                            $mt['columnName'],
                            $mt['operator'],
                            Auth::user()[$mt['value']]
                        ];
                        break;
                    case 'relation':
                        break;
                    default:
                        break;
                }
                $whereOrWhere[$key] = function ($q) use ($orThose) {
                    $q->where($orThose)->orWhere($orThose);
                };
            }
        }*/ //TODO:
        // tableWith:
        if (isset($dbQuery['tableWith']) && $dbQuery['tableWith']) {
            foreach ($dbQuery['tableWith'] as $key => $tw) {
                $twMatchThese = [];
                $twOrThose    = [];
                $twAddSelect  = [];
                if (isset($tw['matchThese']) && $tw['matchThese']) { // TO get all the related field. Doesn't stop loading.
                    foreach ($tw['matchThese'] as $k => $mt) {
                        switch ($mt['type']) {
                            case 'static':
                                $twMatchThese[] = [
                                    $mt['columnName'],
                                    $mt['operator'],
                                    $mt['value']
                                ];
                                break;
                            case 'request':
                                if (isset($request['data'][$mt['value']]) && $request['data'][$mt['value']]) {
                                    $twMatchThese[] = [
                                        $mt['columnName'],
                                        $mt['operator'],
                                        $request['data'][$mt['value']]
                                    ];
                                }
                                break;
                            case 'auth':
                                $twMatchThese[] = [
                                    $mt['columnName'],
                                    $mt['operator'],
                                    Auth::user()[$mt['value']]
                                ];
                                break;
                            case 'relation':
                                break;
                            default:
                                break;
                        }
                    }
                }
                if (isset($tw['orThose']) && $tw['orThose']) {
                    foreach ($tw['orThose'] as $k => $mt) {
                        switch ($mt['type']) {
                            case 'static':
                                $twOrThose[] = [
                                    $mt['columnName'],
                                    $mt['operator'],
                                    $mt['value']
                                ];
                                break;
                            case 'request':
                                if (isset($request['data'][$mt['value']]) && $request['data'][$mt['value']]) {
                                    $twOrThose[] = [
                                        $mt['columnName'],
                                        $mt['operator'],
                                        $request['data'][$mt['value']]
                                    ];
                                }
                                break;
                            case 'auth':
                                $twOrThose[] = [
                                    $mt['columnName'],
                                    $mt['operator'],
                                    Auth::user()[$mt['value']]
                                ];
                                break;
                            case 'relation':
                                break;
                            default:
                                break;
                        }
                    }
                }
                if (isset($tw['addSelect']) && $tw['addSelect']) {
                    $twAddSelQuery = NULL;
                    foreach ($tw['addSelect'] as $i => $addSel) {
                        $twAddSelQuery[] = DB::raw($addSel);
                    }
                    $twAddSelect = $twAddSelQuery;
                }
                $tableWith[$key] = function ($q) use ($tw, $twMatchThese, $twOrThose, $twAddSelect) {
                    $q->select($tw['select'])
                        ->where($twMatchThese)
                        ->orWhere($twOrThose)
                        ->when($twAddSelect, function ($q) use ($tw, $twAddSelect) {
                            return $q->groupBy($tw['groupBy'])->addSelect($twAddSelect);
                        });
                };
            }
        }
        // whereHas:
        if (isset($dbQuery['whereHas']) && $dbQuery['whereHas']) { // TO get only the has models.
            foreach ($dbQuery['whereHas'] as $key => $wHas) {
                $whMatchThese = [];
                $whOrThose    = [];
                if (isset($wHas['matchThese']) && $wHas['matchThese']) {
                    foreach ($wHas['matchThese'] as $k => $mt) {
                        switch ($mt['type']) {
                            case 'static':
                                $whMatchThese[] = [
                                    $mt['columnName'],
                                    $mt['operator'],
                                    $mt['value']
                                ];
                                break;
                            case 'request':
                                if (isset($request['data'][$mt['value']]) && $request['data'][$mt['value']]) {
                                    $whMatchThese[] = [
                                        $mt['columnName'],
                                        $mt['operator'],
                                        $request['data'][$mt['value']]
                                    ];
                                }
                                break;
                            case 'auth':
                                $whMatchThese[] = [
                                    $mt['columnName'],
                                    $mt['operator'],
                                    Auth::user()[$mt['value']]
                                ];
                                break;
                            case 'relation':
                                break;
                            default:
                                break;
                        }
                    }
                }
                if (isset($wHas['orThose']) && $wHas['orThose']) {
                    foreach ($wHas['orThose'] as $k => $mt) {
                        switch ($mt['type']) {
                            case 'static':
                                $whOrThose[] = [
                                    $mt['columnName'],
                                    $mt['operator'],
                                    $mt['value']
                                ];
                                break;
                            case 'request':
                                if (isset($request['data'][$mt['value']]) && $request['data'][$mt['value']]) {
                                    $whOrThose[] = [
                                        $mt['columnName'],
                                        $mt['operator'],
                                        $request['data'][$mt['value']]
                                    ];
                                }
                                break;
                            case 'auth':
                                $whOrThose[] = [
                                    $mt['columnName'],
                                    $mt['operator'],
                                    Auth::user()[$mt['value']]
                                ];
                                break;
                            case 'relation':
                                break;
                            default:
                                break;
                        }
                    }
                }
                $whereHas[] = [
                    'relation'   => $wHas['relation'],
                    'matchThese' => $whMatchThese,
                    'orThose'    => $whOrThose,
                ];
            }
        }
        // withCountWhere:
        if (isset($dbQuery['withCountWhere']) && $dbQuery['withCountWhere']) {
            foreach ($dbQuery['withCountWhere'] as $key => $wch) {
                $wchMatchThese = [];
                $wchOrThose    = [];
                if (isset($wch['matchThese']) && $wch['matchThese']) {
                    foreach ($wch['matchThese'] as $k => $mt) {
                        switch ($mt['type']) {
                            case 'static':
                                $wchMatchThese[] = [
                                    $mt['columnName'],
                                    $mt['operator'],
                                    $mt['value']
                                ];
                                break;
                            case 'request':
                                if (isset($request['data'][$mt['value']]) && $request['data'][$mt['value']]) {
                                    $wchMatchThese[] = [
                                        $mt['columnName'],
                                        $mt['operator'],
                                        $request['data'][$mt['value']]
                                    ];
                                }
                                break;
                            case 'auth':
                                $wchMatchThese[] = [
                                    $mt['columnName'],
                                    $mt['operator'],
                                    Auth::user()[$mt['value']]
                                ];
                                break;
                            case 'relation':
                                break;
                            default:
                                break;
                        }
                    }
                }
                if (isset($wch['orThose']) && $wch['orThose']) {
                    foreach ($wch['orThose'] as $k => $mt) {
                        switch ($mt['type']) {
                            case 'static':
                                $wchOrThose[] = [
                                    $mt['columnName'],
                                    $mt['operator'],
                                    $mt['value']
                                ];
                                break;
                            case 'request':
                                if (isset($request['data'][$mt['value']]) && $request['data'][$mt['value']]) {
                                    $wchOrThose[] = [
                                        $mt['columnName'],
                                        $mt['operator'],
                                        $request['data'][$mt['value']]
                                    ];
                                }
                                break;
                            case 'auth':
                                $wchOrThose[] = [
                                    $mt['columnName'],
                                    $mt['operator'],
                                    Auth::user()[$mt['value']]
                                ];
                                break;
                            case 'relation':
                                break;
                            default:
                                break;
                        }
                    }
                }
                if (isset($wch['selectRaw']) && $wch['selectRaw']) {
                    $withCountWhere[$wch['relation']] = function ($q) use ($wch, $wchMatchThese, $wchOrThose) {
                        $q->select(DB::raw($wch['selectRaw']))->where($wchMatchThese)->orWhere($wchOrThose);
                    };
                } else {
                    $withCountWhere[$wch['relation']] = function ($q) use ($wch, $wchMatchThese, $wchOrThose) {
                        $q->where($wchMatchThese)->orWhere($wchOrThose);
                    };
                }
            }
        }
        // addSelect:
        if (isset($dbQuery['addSelect']) && $dbQuery['addSelect']) {
            $addSelQuery = NULL;
            foreach ($dbQuery['addSelect'] as $i => $addSel) {
                $addSelQuery[] = DB::raw($addSel);
            }
            $addSelect = $addSelQuery;
        }
        // sortBy
        if (isset($dbQuery['sortBy']['relation']) && $dbQuery['sortBy']['relation'] !== false && strlen($dbQuery['sortBy']['relation']) > 0) {
            $sortByDesc = $dbQuery['sortBy']['desc'];
            $relation   = $dbQuery['sortBy']['relation'];
            $field      = $dbQuery['sortBy']['field'];
            $sortBy     = function ($q) use ($relation, $field) {
                return $q->$relation ? $q->$relation->$field : null;
            };
        } else if (isset($dbQuery['sortBy']['relation']) && $dbQuery['sortBy']['relation'] === false) {
            $sortByDesc = $dbQuery['sortBy']['desc'];
            $sortBy     = $dbQuery['sortBy']['field'];
        }

        // CALLING THE QUERY:
        $data = $this->model::when($select, function ($query, $select) {
            return $query->select($select);
        })->when($tableWith, function ($query, $tableWith) {
            return $query->with($tableWith);
        })->where($matchThese)->orWhere($orThose)
            /*->when($searchText, function ($query) use ($dbQuery, $searchText) {
                return $query->where(function ($query) use ($dbQuery) {
                    foreach ($dbQuery['search']['fields'] as $search) {
                        if (isset($search['field']) && strlen($search['field']) > 0 && isset($search['operator']) && strlen($search['operator']) > 0) {
                            if (isset($search['relation']) && $search['relation'] === false) {
                                $query->orWhere($search['field'], $search['operator'], '%' . $dbQuery['search']['text'] . '%');
                            } else if (isset($search['relation']) && $search['relation'] && strlen($search['relation']) > 0) {
                                $query->orWhereHas($search['relation'], function ($q) use ($search, $input) {
                                    $q->where($search['field'], $search['operator'], '%' . $dbQuery['search']['text'] . '%');
                                });
                            }
                        }
                    }
                });
            })*/
            ->when($whereHas[0], function ($query, $wHas) {
                return $query->whereHas($wHas['relation'], function ($q) use ($wHas) {
                    $q->where($wHas['matchThese'])->orWhere($wHas['orThose']);
                });
            })
            ->when($withCount, function ($query, $withCount) {
                return $query->withCount($withCount);
            })
            ->when($withCountWhere, function ($query, $withCountWhere) {
                return $query->withCount($withCountWhere);
            })
            ->when($dbQuery['groupBy'], function ($query, $groupBy) {
                return $query->groupBy($groupBy);
            })
            ->when($addSelect, function ($query, $addSelect) {
                return $query->addSelect($addSelect);
            });

        return ['data' => $data, 'select' => $select, 'sortBy' => $sortBy, 'sortByDesc' => $sortByDesc];
    }

    public function getNew($request) {
        try {
            $input = $request->all();
            $data  = $this->getData($input);

            return $this->setStatusCode(200)->respondWithSuccess('OK', 'data', 'Data Loaded Successfully', $data);
        } catch (QueryException $e) {
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

    public function storeNew($request) {
        try {
            $user  = Auth::check() && Auth::user() ? Auth::user() : NULL;
            $input = $request->all();
            if (0 === strpos($request->headers->get('Content-Type'), 'multipart/form-data')) {
                $input['data']     = json_decode($input['data'], TRUE);
                $input['dbInsert'] = json_decode($input['dbInsert'], TRUE);
                $input['dbQuery']  = json_decode($input['dbQuery'], TRUE);
            }
            $this->model = app("App\Models\\".$input['dbInsert']['table']);
            if (isset($input['dbInsert']) && isset($input['dbInsert']['validations']) &&
                isset($input['dbInsert']['unique']) && $input['dbInsert']['validations'] &&
                $input['dbInsert']['unique']) {
                foreach ($input['dbInsert']['unique'] as $i => $unique) {
                    $input['dbInsert']['validations'][$i] = $input['dbInsert']['validations'][$i].$input['dbInsert']['unique'][$i].$input['data']['id'];
                }
            }
            $validator = Validator::make($input['data'], $input['dbInsert']['validations']);
            if ($validator->fails()) {
                return $this->setStatusCode(422)->respondWithError('Unprocessable Entity', 'Validation', $validator->errors(), $input['data']);
                //} else if (Auth::check() && Auth::user() && Auth::user()->role_id === $input['dbInsert']['allowedRoles']) {
            }
            if (isset($input['dbInsert']['exists']['active']) && $input['dbInsert']['exists']['active'] === true) {


                $exits = app("App\Models\\".$input['dbInsert']['exists']['table'])::where('user_id', 2)->exists();
                if ($exits) {
                    $message = isset($input['dbInsert']['exists']['message']) && $input['dbInsert']['exists']['message'] &&
                               strlen($input['dbInsert']['exists']['message']) >
                               0 ? $input['dbInsert']['exists']['message'] : 'You do not have permission to perform this action.';

                    return $this->setStatusCode(422)->respondWithError('Unprocessable Entity', 'role', [$message], '');
                }
            }
            if (isset($input['dbInsert']['role']['active']) AND isset($input['dbInsert']['role']['roles']) AND (($input['dbInsert']['role']['active'] === TRUE && (in_array($user['role']['name'], $input['dbInsert']['role']['roles']) OR in_array('ALL', $input['dbInsert']['role']['roles']))) OR ($input['dbInsert']['role']['active'] === FALSE))) {
                $message = '';
                $data    = [];
                if (isset($input['data']['id']) && $input['data']['id'] && (int)$input['data']['id'] > 0) {
                    $prev_data = $this->model->findOrFail($input['data']['id']);
                    $edit      = $this->model->findOrFail($input['data']['id']);
                    $edit->fill($input['data']);
                    if ($edit->isDirty()) {
                        $changed_data = $edit->getDirty();
                        if (isset($changed_data['password']) && $changed_data['password'] && strlen($changed_data['password']) > 0) {
                            $input['data']['password'] = Hash::make($input['data']['password']);
                            $changed_data['password']  = '******';
                        } else if (!isset($changed_data['password'])) {
                            $input['data']['password'] = $prev_data['password'];
                        }
                        /*if (isset($input['data']['photo']) && $input['data']['photo'] && strlen($input['data']['photo']) > 0) {
                            $input['data']['photo'] = null;
                        }*/
                        $data = $this->save($edit, $input['data']);
                        $this->model->where('id', $data->id)->update([
                            'entryby_id'    => Auth::check() &&
                                               Auth::user() &&
                                               Auth::user()->id ? Auth::user()->id : NULL,
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
                        if (isset($input['dbInsert']['storeInEdits']) && $input['dbInsert']['storeInEdits'] &&
                            $input['dbInsert']['storeInEdits'] === TRUE) {
                            $edits = Edits::create([
                                'table'         => $this->model->getTable(),
                                'model'         => $input['dbInsert']['table'],
                                'form_data'     => $input['data'],
                                'dbInsert'      => $input['dbInsert'],
                                'data_id'       => $data->id,
                                'prev_data'     => $prev_data,
                                'new_data'      => $data,
                                'changed_data'  => $changed_data,
                                'action_type'   => $input['dbInsert']['actionType'],
                                'entryby_id'    => Auth::check() && Auth::user() &&
                                                   Auth::user()->id ? Auth::user()->id : NULL,
                                'comment'       => NULL,
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
                        }
                        $data['file_uploaded'] = $this->uploadFiles($request, $input, $data->id);
                        $data['notify']        = [
                            'group' => 'edited',
                            'type'  => 'warn',
                            'title' => 'Data Edited!',
                            'text'  => '<b><u>'.$data->id.'</u></b> Edited Successfully!'
                        ];
                        $message               = '<b><u>'.$data->id.'</u></b> Edited Successfully!';
                    } else {
                        $data['notify'] = [
                            'group' => 'edited',
                            'type'  => 'warn',
                            'title' => 'Data Untouched!',
                            'text'  => '<b><u>No Changes</u></b> were made to update.'
                        ];
                        $message        = '<b><u>No Changes</u></b> were made to update.';
                    }
                } else {
                    if (isset($input['data']['password']) && $input['data']['password'] &&
                        strlen($input['data']['password']) > 0) {
                        $input['data']['password'] = Hash::make($input['data']['password']);
                    }
                    /*if (isset($input['data']['photo']) && $input['data']['photo'] && strlen($input['data']['photo']) > 0) {
                        $input['data']['photo'] = null;
                    }*/
                    $data = $this->save($this->model, $input['data']);
                    if (isset($input['dbInsert']['autoEntry'])) {
                        foreach ($input['dbInsert']['autoEntry'] as $i => $autoEntry) {
                            if ($autoEntry['type'] === 'update') {
                                if ($autoEntry['data']['surfix'] === 'id') {
                                    $auto_entry_field_date = $autoEntry['data']['prefix'].
                                                             str_pad($data->id, 3, '0', STR_PAD_LEFT);
                                    $this->model->where('id', $data->id)->update([
                                        $autoEntry['field'] => $auto_entry_field_date,
                                    ]);
                                }
                            }
                        }
                    }
                    $this->model->where('id', $data->id)->update([
                        'entryby_id'    => Auth::check() && Auth::user() &&
                                           Auth::user()->id ? Auth::user()->id : NULL,
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
                    //$billing = new CustomerDebitNoteItems();
                    //$billing->fill($input['data']['listItems']);
                    /*$items = collect($input['data']['listItems'])->transform(function ($items) {
                        return new CustomerDebitNoteItems($items);
                    });*/
                    if (isset($input['dbInsert']['createMany']) && $input['dbInsert']['createMany'] == TRUE) {
                        foreach ($input['data'][$input['dbInsert']['createManyField']] as $i => $create) {
                            $this->model                                     = app("App\Models\\".$input['dbInsert']['createManyTable']);
                            $create[$input['dbInsert']['createManyTableId']] = $data->id;
                            $this->model->fill($create);
                            $this->save($this->model, $create);
                        }
                        //$data->items()->createMany($input['data']['listItems']);
                    }
                    $data['file_uploaded'] = $this->uploadFiles($request, $input, $data->id);
                    $data['notify']        = [
                        'group' => 'saved',
                        'type'  => 'success',
                        'title' => 'Data Saved!',
                        'text'  => '<b><u>'.$data->id.'</u></b> Inserted Successfully!'
                    ];
                    $message               = '<b><u>'.$data->id.'</u></b> Inserted Successfully!';
                }
                if (isset($input['dbQuery']) && $input['dbQuery'] && !empty($input['dbQuery'])) {
                    $data['dataAll'] = $this->getData($input);
                }

                return $this->setStatusCode(200)->respondWithSuccess('OK', 'data', $message, $data);
            } else {
                $message = isset($input['dbInsert']['role']['message']) && $input['dbInsert']['role']['message'] &&
                           strlen($input['dbInsert']['role']['message']) >
                           0 ? $input['dbInsert']['role']['message'] : 'You do not have permission to perform this action.';

                return $this->setStatusCode(422)->respondWithError('Unprocessable Entity', 'role', [$message], '');
            }
        } catch (QueryException $e) {
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

    public function destroyNew($request) {
        try {
            $user        = Auth::check() && Auth::user() ? Auth::user() : NULL;
            $input       = $request->all();
            $this->model = app("App\Models\\".$input['dbDestroy']['table']);
            $validator   = Validator::make($input['data'], $input['dbDestroy']['validations']);
            if ($validator->fails()) {
                return $this->setStatusCode(422)->respondWithError('Unprocessable Entity', 'Validation', $validator->errors(), $input['data']);
            } else if (isset($input['dbDestroy']['role']['active']) && (($input['dbDestroy']['role']['active'] === TRUE && isset($input['dbDestroy']['role']['roles']) && in_array($user['role']['name'], $input['dbDestroy']['role']['roles'])) OR ($input['dbDestroy']['role']['active'] === FALSE && isset($input['dbDestroy']['role']['roles']) && in_array('ALL', $input['dbDestroy']['role']['roles'])))) {
                $message = '';
                $data    = [];
                $delete  = $this->model->findOrFail($input['data']['id']);
                if ($this->model->where('id', $input['data']['id'])->delete()) {
                    if (isset($input['dbDestroy']['storeInDeletes']) && $input['dbDestroy']['storeInDeletes'] &&
                        $input['dbDestroy']['storeInDeletes'] === TRUE) {
                        $deletes = Deletes::create([
                            'table'         => $this->model->getTable(),
                            'model'         => $input['dbDestroy']['table'],
                            'dbDestroy'     => $input['dbDestroy'],
                            'data_id'       => $delete->id,
                            'data'          => $delete,
                            'action_type'   => $input['dbDestroy']['actionType'],
                            'entryby_id'    => Auth::check() && Auth::user() &&
                                               Auth::user()->id ? Auth::user()->id : NULL,
                            'comment'       => NULL,
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
                    }
                    $data['notify'] = [
                        'group' => 'deleted',
                        'type'  => 'error',
                        'title' => 'Data Deleted!',
                        'text'  => 'Item Id: <b><u>'.$input['data']['id'].'</u></b> Deleted Successfully!'
                    ];
                    $message        = 'Item Id: <b><u>'.$input['data']['id'].'</u></b> Deleted Successfully!';
                } else {
                    $data['notify'] = [
                        'group' => 'not_deleted',
                        'type'  => 'error',
                        'title' => 'Data Not Found!',
                        'text'  => 'Unable to Delete data Id: '.'<b><u>'.$input['data']['id'].'</u></b>!'
                    ];
                    $message        = 'Unable to Delete data Id: '.'<b><u>'.$input['data']['id'].'</u></b>!';
                }
                if (isset($input['dbQuery']) && $input['dbQuery'] && !empty($input['dbQuery'])) {
                    $data['dataAll'] = $this->getData($input);
                }

                return $this->setStatusCode(200)->respondWithSuccess('OK', 'data', $message, $data);
            } else {
                $message =
                    isset($input['dbDestroy']['role']['message']) && $input['dbDestroy']['role']['message'] &&
                    strlen($input['dbDestroy']['role']['message']) >
                    0 ? $input['dbDestroy']['role']['message'] : 'You do not have permission to perform this action.';

                return $this->setStatusCode(422)->respondWithError('Unprocessable Entity', 'role', [$message], '');
            }
        } catch (QueryException $e) {
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

    public function destroysNew($request) {
        try {
            $input       = $request->all();
            $this->model = app("App\Models\\".$input['dbDestroy']['table']);
            $validator   = Validator::make($input['data'], $input['dbDestroy']['validations']);
            if ($validator->fails()) {
                return $this->setStatusCode(422)->respondWithError('Unprocessable Entity', 'Validation', $validator->errors(), $input['data']);
            } else {
                $message     = '';
                $data        = [];
                $deleteCount = 0;
                foreach ($input['data'] as $i => $d) {
                    if (isset($d['selected']) && $d['selected'] && $d['selected'] == TRUE) {
                        $data[$deleteCount] = $this->model->where('id', $d['id'])->delete();
                        $deleteCount++;
                    }
                }
                if ($data && $deleteCount > 0) {
                    $data['notify'] = [
                        'group' => 'deleted',
                        'type'  => 'error',
                        'title' => 'Data Deleted!',
                        'text'  => 'Total <b><u>'.$deleteCount.' Item(s)</u></b> Deleted Successfully!'
                    ];
                    $message        = 'Total <b><u>'.$deleteCount.' Item(s)</u></b> Deleted Successfully!';
                } else {
                    $data['notify'] = [
                        'group' => 'deleted',
                        'type'  => 'error',
                        'title' => 'Data Not Found!',
                        'text'  => 'Unable to Delete selected Items!'
                    ];
                    $message        = 'Unable to Delete selected Items!';
                }
                if (isset($input['dbQuery']) && $input['dbQuery'] && !empty($input['dbQuery'])) {
                    $data['dataAll'] = $this->getData($input);
                }

                return $this->setStatusCode(200)->respondWithSuccess('OK', 'data', $message, $data);
            }
        } catch (QueryException $e) {
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

    public function uploadFiles($request, $input, $data_id) {
        if (isset($input['dbInsert']) && isset($input['dbInsert']['fileUploads']) && isset($input['dbInsert']['fileUploads']['active']) && $input['dbInsert']['fileUploads']['active'] === TRUE && isset($input['dbInsert']['fileUploads']['files']) && $input['dbInsert']['fileUploads']['files']) {
            foreach ($input['dbInsert']['fileUploads']['files'] as $key => $fileObj) {
                $files        = $request->file($fileObj['field']);
                $store_path   = $fileObj['storePath'];
                $db_file_name = NULL;
                if (!empty($files)) {
                    $file_count   = count($files);
                    $upload_count = 0;
                    foreach ($files as $i => $file) {
                        $rules     = $fileObj['validations'];
                        $validator = Validator::make(['file' => $file], $rules);
                        if ($validator->passes()) {
                            $file_size         = NULL;
                            $file_name         = NULL;
                            $file_path         = NULL;
                            $isImage           = FALSE;
                            $random_string     = uniqid($data_id.'_', TRUE);
                            $file_orginal_name = $file->getClientOriginalName();
                            $mime_type         = $file->getClientMimeType();
                            $file_ext          = strtolower($file->getClientOriginalExtension());
                            $file_name         = $random_string.'.'.$file_ext;
                            $file_path         = public_path($store_path.$file_name);
                            $isImage           = explode("/", $mime_type)[0] === "image";
                            $db_file_name      = $db_file_name.($upload_count > 0 ? ',' : '').$file_name;
                            if ($isImage === TRUE) {
                                list($width, $height, $type, $attribute) = getimagesize($file);
                                $file_size = (filesize($file->getRealPath()) / 1024);
                                if ($width > $fileObj['maxWidth'] || $height > $fileObj['maxHeight'] || $file_size > $fileObj['maxSize']) {
                                    if ($width > $fileObj['width'] || $height > $fileObj['height']) {
                                        Image::configure(array('driver' => 'imagick')); //Supported: "gd", "imagick"
                                        $image_resize = Image::make($file->getRealPath());
                                        if ($width > $height) {
                                            $image_resize->resize($fileObj['width'], NULL, function ($constraint) {
                                                $constraint->aspectRatio();
                                                $constraint->upsize();
                                            });
                                        } else {
                                            $image_resize->resize(NULL, $fileObj['height'], function ($constraint) {
                                                $constraint->aspectRatio();
                                                $constraint->upsize();
                                            });
                                        }
                                        //$image_resize->width();
                                        //$image_resize->height();
                                        //$image_resize->encode('jpg', 75);
                                        //$image_resize->filesize();
                                        //$image_resize->mime();
                                        $image_resize->save($file_path);
                                        $image_resize->destroy();
                                        $this->compressImage($file_path, $file_path, $this->fileTypeFromType($type));
                                    } else {
                                        $file->move($store_path, $file_name);
                                    }
                                    $upload_count++;
                                } else {
                                    $file->move($store_path, $file_name);
                                    $upload_count++;
                                }
                            } else {
                                $file->move($store_path, $file_name);
                                $upload_count++;
                            }
                        } else {
                            return $this->setStatusCode(422)->respondWithError('Unprocessable Entity', 'validation', $validator->errors(), '');
                        }
                    }
                    if ($upload_count === $file_count) {
                        if (isset($fileObj['storePath']) && $fileObj['storeType'] === 'update') {
                            $this->model = app("App\Models\\".$fileObj['table']);
                            $this->model->where('id', $data_id)->update([
                                $fileObj['field'] => $db_file_name,
                            ]);
                        } else if (isset($fileObj['storePath']) && $fileObj['storeType'] === 'create') {

                        }

                        return TRUE;
                    } else {
                        return FALSE;
                    }
                }
            }
        }
    }


    /**
     * Save the input's data.
     *
     * @param  $model
     * @param  $input
     * @return User
     */
    public function save($model, $input) {
        $model->fill($input);
        $model->save();

        return $model;
    }

    /**
     * Get number of the records
     *
     * @param int $number
     * @param string $sort
     * @param string $sortColumn
     * @return Paginate
     */
    public function page($number = 10, $sort = 'desc', $sortColumn = 'created_at') {
        return CommonResource::collection($this->model->orderBy($sortColumn, $sort)->paginate($number));
    }

    public function compressImage($source, $destination, $type) {
        switch ($type) {
            case 'GIF':
                /*  $image = imagecreatefromgif($source);
                  imagegif($image, $destination);
                  imagedestroy($image);*/ break;
            case 'JPEG':
                $imagick = new Imagick($source);
                //$imagick->readImage($source);
                $imagick->setImageCompression(Imagick::COMPRESSION_JPEG);
                $imagick->setImageCompressionQuality(70);
                $imagick->setImageFormat('jpg');
                $imagick->writeImages($destination, TRUE);
                break;
            case 'PNG':
                $image = imagecreatefrompng($source);
                imagealphablending($image, TRUE);
                imagesavealpha($image, TRUE);
                imagepng($image, $destination, 7);
                /*$fileSize2 = (filesize($destination) / 1024);

                return $fileSize2;
                if ($fileSize1 > $fileSize2) {
                    imagepng($image, $destination, 7);
                }*/
                imagedestroy($image);
                break;
            case 'BMP':
                /*$image = imagecreatefrombmp($source);
                imagebmp($image, $destination, TRUE);
                imagedestroy($image);
                $imagick = new Imagick($source);
                $imagick->setImageCompressionQuality(70);
                $imagick->setImageFormat('bmp');
                $imagick->writeImages($destination, TRUE);
                $imagick->destroy();*/ break;
            case 'COUNT':
                $imagick = new Imagick($source);
                $imagick->setImageCompressionQuality(50);
                //                $imagick->setOption('webp:lossless', 'true');
                $imagick->setImageFormat('webp');
                //                $imagick->setOption('webp:method', '6');
                $imagick->writeImages($destination, TRUE);
                break;
            default:
                break;
        }
    }

    public function compressImage2($source, $destination, $type) {
        switch ($type) {
            case 'GIF':
                $image = imagecreatefromgif($source);
                imagegif($image, $destination);
                break;
            case 'JPEG':
                $image = imagecreatefromjpeg($source);
                imagejpeg($image, $destination, 85);
                break;
            case 'PNG':
                $image = imagecreatefrompng($source);
                imagealphablending($image, TRUE);
                imagesavealpha($image, TRUE);
                imagepng($image, $destination, 7);
                break;
            case 'BMP':
                $image = imagecreatefromwbmp($source);
                imagewbmp($image, $destination);
                break;
            case 'WBMP':
                break;
            default:
                break;
        }
        imagedestroy($image);
        /*$image = imagecreatetruecolor(1000, 1000);
        imagecolortransparent($image, imagecolorallocate($image, 0, 0, 0));
        imagealphablending( $image, false );
        imagesavealpha( $image, true );
        imagecopyresampled($image, $srcImage, 0, 0, 0, 0, 128, 128, $uploadWidth, $uploadHeight);
        imagepng($image, 'filename.png', 9);*/
    }

    public function fileTypeFromType($type) {
        $imageTypeArray = array(
            0  => 'UNKNOWN',
            1  => 'GIF',
            2  => 'JPEG',
            3  => 'PNG',
            4  => 'SWF',
            5  => 'PSD',
            6  => 'BMP',
            7  => 'TIFF_II',
            8  => 'TIFF_MM',
            9  => 'JPC',
            10 => 'JP2',
            11 => 'JPX',
            12 => 'JB2',
            13 => 'SWC',
            14 => 'IFF',
            15 => 'WBMP',
            16 => 'XBM',
            17 => 'ICO',
            18 => 'COUNT'
        );

        return $imageTypeArray[$type];
    }
}
