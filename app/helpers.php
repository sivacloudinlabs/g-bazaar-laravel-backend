<?php

use App\Models\ErrorLog;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

if (!function_exists('internalServerError500')) {
    function internalServerError500($exception = null, $className = null, $functionName = null)
    {

        logError(SERVER_ERROR_OCCURRED, getLocation($className, $functionName), $exception);

        ErrorLog::create([
            'error' => SERVER_ERROR_OCCURRED,
            'location' => getLocation($className, $functionName),
            'message' => $exception?->getMessage() ?? SERVER_ERROR_OCCURRED
        ]);

        $response = [
            RESPONSE_MESSAGE => SERVER_ERROR_OCCURRED,
            RESPONSE_ERRORS => [
                RESPONSE_MESSAGE => $exception?->getMessage(),
                'location' => getLocation($className, $functionName),
            ],
        ];

        return $response;
    }
}


if (!function_exists('getLocation')) {
    function getLocation($className, $functionName)
    {
        $className = str_replace("\\", "/", $className);
        return "{$className}@{$functionName}";
    }
}

if (!function_exists('logError')) {
    function logError($message, $location, $errorObject = null, $reference = []): void
    {
        $data = [
            'location' => $location,
        ];

        if ($errorObject) {
            $data['message'] = $errorObject->getMessage();
            $data['trace'] = $errorObject->getTraceAsString();
        }

        if ($reference) {
            $data['reference'] = $reference;
        }

        Log::error([$message => $data]);
    }
}

if (!function_exists('getInputData')) {
    function getInputData($request)
    {
        return (gettype($request->input) == 'array') ? (object) $request->input : $request->input;
    }
}


if (!function_exists('validationError422')) {
    function validationError422($validatedData)
    {
        if (!$validatedData->fails()) {
            return false;
        }

        $response = [
            RESPONSE_STATUS => true,
            RESPONSE_ERRORS => [
                Str::lower(RESPONSE_MESSAGE) => $validatedData->errors()->first()
            ],
            RESPONSE_CODE => Response::HTTP_UNPROCESSABLE_ENTITY
        ];

        return $response;
    }
}


if (!function_exists('shortCodeGenerator')) {
    function shortCodeGenerator($string)
    {
        $strA = explode(' ', $string);
        $shortCodeString = "";

        if (sizeof($strA) == 1) {
            $string = $strA[0];
            $stringChunkSplit = chunk_split($string, 4, ".");
            $strArray = explode('.', $stringChunkSplit);
            $resultString = $string[0];

            foreach ($strArray as $string) {
                if ($string !== "") {
                    $resultString = $resultString . $string[2];

                }
            }

            return Str::upper($resultString);
        }

        foreach ($strA as $words) {
            $shortCodeString = $shortCodeString . $words[0];
        }

        return Str::upper($shortCodeString);
    }
}