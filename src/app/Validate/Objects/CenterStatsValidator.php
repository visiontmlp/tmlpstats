<?php
namespace TmlpStats\Validate\Objects;

use TmlpStats\Import\Xlsx\ImportDocument\ImportDocument;
use Respect\Validation\Validator as v;

class CenterStatsValidator extends ObjectsValidatorAbstract
{
    protected $sheetId = ImportDocument::TAB_WEEKLY_STATS;

    protected function populateValidators($data)
    {
        $intNotNullValidator    = v::when(v::nullValue(), v::alwaysInvalid(), v::int());
        $percentValidator       = v::numeric()->between(0, 100, true);
        $percentOrNullValidator = v::when(v::nullValue(), v::alwaysValid(), $percentValidator);

        $types = ['promise', 'actual'];

        $this->dataValidators['reportingDate'] = v::date('Y-m-d');
        $this->dataValidators['type']          = v::in($types);
        $this->dataValidators['tdo']           = $percentOrNullValidator;
        $this->dataValidators['cap']           = $intNotNullValidator;
        $this->dataValidators['cpc']           = $intNotNullValidator;
        $this->dataValidators['t1x']           = $intNotNullValidator;
        $this->dataValidators['t2x']           = $intNotNullValidator;
        $this->dataValidators['gitw']          = $percentValidator;
        $this->dataValidators['lf']            = $intNotNullValidator;
    }

    protected function validate($data)
    {
        return $this->isValid;
    }
}
