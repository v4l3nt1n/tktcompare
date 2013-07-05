<?php

/**
* 
*/
class SourceHandler
{
    // propiedades
    const SOURCE_SABRE = 'sabre';
    const SOURCE_AMADEUS = 'amadeus';
    const SOURCE_BACKOFFICE = 'backoffice';

    const TICKET_KEY_SABRE = 'boleto';
    const TICKET_KEY_AMADEUS = 'ticket';
    const TICKET_KEY_BACKOFFICE = 'tkt';

    private $files_array = array();

    private $ready_array_sabre = array();
    private $ready_array_amadeus = array();
    private $ready_array_backoffice = array();

    // metodos

    function __construct($files)
    {
        //$this->files_array = $this->orderFilesArray($files);
        $this->orderFilesArray($files);
        //$this->determineSource();

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
        foreach ($this->file_array as $key => $file) {
            
        }
    }

    private function processSabre()
    {
        # code...
    }

    private function processAmadeus()
    {
        # code...
    }

    private function processBackoffice()
    {
        # code...
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
        return substr($elem, strlen($elem)-$length,$length);
    }

    private function dismissCnjTkts($elem)
    {
        return true;
    }


}
