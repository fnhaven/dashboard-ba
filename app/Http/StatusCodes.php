<?php

namespace App\Http;

class StatusCodes {

    /**
     * The request was fulfilled
     */
    const OK = 200;

    /**
     * Following a POST command, this indicates success,
     * but the textual part of the response line indicates
     * the URI by which the newly created document should be known.
     */
    const CREATED = 201;

    /**
     * The server cannot or will not process the request
     * due to an apparent client error (e.g., malformed request syntax,
     * size too large, invalid request message framing, or deceptive request routing)
     */
    const BAD_REQUEST = 400;

    /**
     * The parameter to this message gives a specification
     * of authorization schemes which are acceptable.
     * The client should retry the request with a suitable Authorization header.
     */
    const UNAUTHORIZED = 401;

    /**
     * Response should be used afterwards, when the user is authenticated
     * but isn’t authorized to perform the requested operation on the given resource.
     */
    const FORBIDDEN = 403;

    /**
     * The server has not found anything matching the URI given.
     */
    const NOT_FOUND = 404;

    /**
     * Request method not supported by that resource.
     */
    const METHOD_NOT_ALLOWED = 405;

    /**
     * Request unable to be followed due to semantic errors.
     */
    const UNPROCESSABLE_ENTITY = 422;

    /**
     * User has sent too many requests in a given amount of time.
     */
    const TOO_MANY_REQUEST = 429;

    /**
     * The server encountered an unexpected condition which prevented it from fulfilling the request.
     */
    const INTERNAL_SERVER_ERROR = 500;

    /**
     * This is equivalent to Internal Error 500,
     * but in the case of a server which is in turn accessing some other service,
     * this indicates that the response from the other service
     * did not return within a time that the gateway was prepared to wait.
     * As from the point of view of the client and the HTTP transaction
     * the other service is hidden within the server,
     * this maybe treated identically to Internal error 500, but has more diagnostic value.
     */
    const SERVICE_UNAVAILABLE = 503;

}