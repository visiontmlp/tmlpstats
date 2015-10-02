<?php
namespace TmlpStats\Import\Xlsx\DataImporter;

use TmlpStats\Import\Xlsx\ImportDocument\ImportDocument;
use TmlpStats\TmlpGame;
use TmlpStats\TmlpGameData;

class TmlpGameInfoImporter extends DataImporterAbstract
{
    protected $sheetId = ImportDocument::TAB_COURSES;

    protected $blockT1X = array();
    protected $blockT2X = array();

    protected function populateSheetRanges()
    {
        $this->blockT1X[] = $this->excelRange('A', 'K');
        $this->blockT1X[] = $this->excelRange(30, 31);

        $this->blockT2X[] = $this->excelRange('A', 'K');
        $this->blockT2X[] = $this->excelRange(38, 39);
    }

    protected function load()
    {
        $this->reader = $this->getReader($this->sheet);

        $this->loadBlock($this->blockT1X, 'T1X');
        $this->loadBlock($this->blockT2X, 'T2X');
    }

    protected function loadEntry($row, $type)
    {
        if ($this->reader->isEmptyCell($row, 'B')) return;

        $this->data[] = array(
            'offset'                 => $row,
            'type'                   => $this->reader->getType($row),
            'quarterStartRegistered' => $this->reader->getQuarterStartRegistered($row),
            'quarterStartApproved'   => $this->reader->getQuarterStartApproved($row),
        );
    }

    public function postProcess()
    {
        foreach ($this->data as $gameInput) {
            $gameData = TmlpGameData::firstOrNew(array(
                'type'            => $gameInput['type'],
                'stats_report_id' => $this->statsReport->id,
            ));

            unset($gameInput['type']);
            unset($gameInput['offset']);

            $this->setValues($gameData, $gameInput);

            $gameData->save();
        }
    }
}
