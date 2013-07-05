<?php

class SourceHandler
{
    // propiedades
    const SOURCE_SABRE = 'sabre';
    const SOURCE_AMADEUS = 'amadeus';
    const SOURCE_BACKOFFICE = 'backoffice';

    const FILTER_COL_SABRE = 0;
    const FILTER_COL_AMADEUS = 'C';
    const FILTER_COL_BACKOFFICE = 'B';

    private $files_array = array();

    private $ready_array_sabre = array();
    private $ready_array_amadeus = array();
    private $ready_array_backoffice = array();

    // metodos

    function __construct($files)
    {
        $this->files_array = $this->orderFilesArray($files);
        $this->determineSource();
        $this->process();
    }

    private function orderFilesArray($file_array)
    {
        $ordered_files = array();
        $file_count = count($file_array['files']['name']);
        $file_keys = array_keys($file_array['files']);

        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $ordered_files[$i][$key] = $file_array['files'][$key][$i];
            }
        }

        return $ordered_files;
    }

    private function determineSource()
    {
        foreach ($this->files_array as $key => $file) {
            $name = $file['name'];
            $name = substr($name,0, strpos($name,'.')-1);
            $inputFileName = $file['tmp_name'];

            if ($name === 'sabre') {
                if (($handle = fopen($inputFileName, "r")) !== FALSE) {
                    $csvarray = array();
                    # Set the parent multidimensional array key to 0.
                    $nn = 0;
                    while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
                        # Count the total keys in the row.
                        $c = count($data);
                        # Populate the multidimensional array.
                        for ($x=0;$x<$c;$x++) {
                            # limito las columnas del array
                            if ($x < 15) {
                                $csvarray[$nn][$x] = $data[$x];
                            }
                        }
                        $nn++;
                    }
                    $this->ready_array_sabre = array_merge($this->ready_array_sabre, $csvarray);
                    # Close the File.
                    fclose($handle);
                }
            }

            if ($name === 'amadeus') {
                $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
                $this->ready_array_amadeus = array_merge($this->ready_array_amadeus,$objPHPExcel->getActiveSheet()->toArray(null,true,true,true));
            }

            if ($name === 'backoffice') {
                $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
                $this->ready_array_backoffice = array_merge($this->ready_array_backoffice,$objPHPExcel->getActiveSheet()->toArray(null,true,true,true));
            }        
        }
    }

    private function process()
    {
        $this->processSabre();
        $this->processAmadeus();
        $this->processBackoffice();
    }

    private function processSabre()
    {
        // quito las rows con las cabecereas
        $this->row_cleaner_source = SourceHandler::SOURCE_SABRE;
        $this->ready_array_sabre = array_filter($this->ready_array_sabre,array($this,'rowCleaner'));
        // quito los tickets en conjuncion
        $this->ready_array_sabre = array_map(array($this,'dismissCnjTkts'), $this->ready_array_sabre);
    }

    private function processAmadeus()
    {
        // quito las rows con las cabecereas
        $this->row_cleaner_source = SourceHandler::SOURCE_AMADEUS;
        $this->ready_array_amadeus = array_filter($this->ready_array_amadeus,array($this,'rowCleaner'));
    }

    private function processBackoffice()
    {
        // quito las rows con las cabecereas
        $this->row_cleaner_source = SourceHandler::SOURCE_BACKOFFICE;
        $this->ready_array_backoffice = array_filter($this->ready_array_backoffice,array($this,'rowCleaner'));
        $this->ready_array_backoffice = array_map(array($this,'rpad'), $this->ready_array_backoffice);
    }

    private function xlsToArray()
    {
        # code...
    }

    private function csvToArray()
    {
        # code...
    }

    private function rpad($elem)
    {
        $length = 10;
        $elem['E'] = substr($elem['E'], strlen($elem['E'])-$length,$length);
        return $elem;
    }

    private function dismissCnjTkts($elem)
    {
        $elem[2] = substr($elem[2], 0, 10);
        return $elem;
    }

    private function rowCleaner($elem)
    {
        if ($this->row_cleaner_source == SourceHandler::SOURCE_SABRE) {
            if ($elem[SourceHandler::FILTER_COL_SABRE] == 'FECHA') {
                return false;
            }else{
                return true;
            }
        }

        if ($this->row_cleaner_source == SourceHandler::SOURCE_AMADEUS) {
            if ($elem[SourceHandler::FILTER_COL_AMADEUS] == '' ||
                $elem[SourceHandler::FILTER_COL_AMADEUS] == 'DOC NUMBER' ||
                $elem['L'] == 'CANN') {
                return false;
            }else{
                return true;
            }
        }

        if ($this->row_cleaner_source == SourceHandler::SOURCE_BACKOFFICE) {
            if ($elem[SourceHandler::FILTER_COL_BACKOFFICE] == 'FECHA') {
                return false;
            }else{
                return true;
            }
        }
    }

    public function getSources()
    {
        return array(
                SourceHandler::SOURCE_SABRE => $this->ready_array_sabre,
                SourceHandler::SOURCE_AMADEUS => $this->ready_array_amadeus,
                SourceHandler::SOURCE_BACKOFFICE => $this->ready_array_backoffice,
            );
    }
}
