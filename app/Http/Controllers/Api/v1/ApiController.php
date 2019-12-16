<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller as BaseController;

class ApiController extends Controller {
    /**
     * @var int
     */
    protected $statusCode = 200;

    /**
     * Function to return a Not Found response.
     *
     * @param string $message
     * @return mixed
     */
    public function respondNotFound($message = 'Not Found!') {
        return $this->setStatusCode(404)->respondWithError($message);
    }

    /**
     * Function to return an error response.
     *
     * @param $message
     * @return mixed
     */
    public function respondWithError($statusText, $type, $message, $exception) {
        return $this->respond([
            'status'     => $this->getStatusCode(),
            'statusText' => $statusText,
            'type'       => $type,
            'message'    => $message,
            'exception'  => $exception,
        ]);
    }

    /**
     * Function to return a generic response.
     *
     * @param       $data Data to be used in response.
     * @param array $headers Headers to b used in response.
     * @return mixed Return the response.
     */
    public function respond($data, $headers = []) {
        return response($data, $this->getStatusCode(), $headers);
    }

    /**
     * @return mixed
     */
    public function getStatusCode() {
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode) {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Function to return forbidden error response.
     * @param string $message
     * @return mixed
     */
    public function respondForbiddenError($message = 'Forbidden!') {
        return $this->setStatusCode(IlluminateResponse::HTTP_FORBIDDEN)->respondWithError($message);
    }

    /**
     * Function to return an internal error response.
     *
     * @param string $message
     * @return mixed
     */
    public function respondInternalError($message = 'Internal Error!') {
        return $this->setStatusCode(IlluminateResponse::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
    }

    /**
     * Function to return an unauthorized response.
     *
     * @param string $message
     * @return mixed
     */
    public function respondUnauthorizedError($message = 'Unauthorized!') {
        return $this->setStatusCode(IlluminateResponse::HTTP_UNAUTHORIZED)->respondWithError($message);
    }

    /**
     * Function to return a service unavailable response.
     *
     * @param string $message
     * @return mixed
     */
    public function respondServiceUnavailable($message = "Service Unavailable!") {
        return $this->setStatusCode(IlluminateResponse::HTTP_SERVICE_UNAVAILABLE)->respondWithError($message);
    }

    /**
     * Function to return an Successful response.
     *
     * @param $message
     * @return mixed
     */
    public function respondWithSuccess($statusText, $type, $message, $data) {
        return $this->respond([
            'status'     => $this->getStatusCode(),
            'statusText' => $statusText,
            'type'       => $type,
            'message'    => $message,
            'data'       => $data,
        ]);
    }

    /**
     * @param Paginator $paginator
     * @param           $data
     * @return \Response
     */
    public function respondWithPagination(Paginator $paginator, $data) {
        $data = array_merge($data, [
            'pagination' => [
                'total_count'  => $paginator->total(),
                'total_pages'  => ceil($paginator->total() / $paginator->perPage()),
                'current_page' => $paginator->currentPage(),
                'limit'        => $paginator->perPage(),
            ]
        ]);

        return $this->respond($data);
    }

    /**
     * @param $message
     * @return mixed
     */
    protected function respondUnprocessableEntity($message) {
        return $this->setStatusCode(IlluminateResponse::HTTP_UNPROCESSABLE_ENTITY)->respond([
            'error'  => [
                'message' => $message
            ],
            'status' => $this->getStatusCode()
        ]);
    }
}
