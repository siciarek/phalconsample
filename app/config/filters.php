<?php

$di->setShared('filter', function () {
    $filter = new \Phalcon\Filter();
    // Remove quotation marks (single and double):
    $filter->add('removeq', function ($value) {
        if (preg_match("/[^']'$/", $value) and !preg_match("/^'[^']/", $value)) {
            return $value;
        }
        return preg_replace("/^[\"']+|[\"']+$/u", '', $value);
    });
    // Saxon genitive replacement:
    $filter->add('saxgen', function ($value) {
        return preg_replace("/'+/u", '’', $value);
    });

    // Empty value null replacement:
    $filter->add('null', function ($value) {
        return strlen($value) === 0 ? null : $value;
    });

    // Title case modifier:
    $filter->add('title', function ($value) {
        return mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
    });

    return $filter;
});
