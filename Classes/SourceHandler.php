<?php

class SourceHandler
{
    // propiedades
    const CSV_DELIMITER = ';';

    const VOID_SABRE = "void_sabre";
    const VOID_AMADEUS = 'void_amadeus';

    const VOID_COL_SABRE = "DESCRIPCION";
    const VOID_COL_AMADEUS = 'L';
    const VOID_COL_BACKOFFICE = "";

    const VOID_FIELD_SABRE = "VOID";
    const VOID_FIELD_AMADEUS = 'CANX';
    const VOID_FIELD_BACKOFFICE = "";

    const SOURCE_SABRE = 'sabre';
    const SOURCE_AMADEUS = 'amadeus';
    const SOURCE_BACKOFFICE = 'backoffice';

    const FILTER_COL_SABRE = 'FECHA';
    const FILTER_COL_AMADEUS = 'C';
    const FILTER_COL_BACKOFFICE = 'B';

    const TICKET_COL_SABRE = 'TICKET';
    const TICKET_COL_BACKOFFICE = 'E';

    private $files_array = array();

    private $ready_array_sabre = array();
    private $ready_array_amadeus = array();
    private $ready_array_backoffice = array();

    private $ready_void_sabre = array();
    private $ready_void_amadeus = array();
    private $ready_void_backoffice = array();

    private $rpad_string_length = 10;

    private $ticket_col;
    private $col_cleaner_cols;
    private $cleaner_source;
    private $void_col;

    private $keys_array_sabre = array(
            'FECHA',
            'AEROLINEA',
            'TICKET',
            'DK',
            'PNR',
            'NOMBRE',
            'APELLIDO',
            'RUTA',
            'CLASE',
            'TOURCODE',
            'MONEDA',
            'FACIAL',
            'IMPUESTOS',
            'COMISION',
            'TOTAL_TKT',
            'MONTO_CASH',
            'MONTO_TARIFA',
            'FOP',
            'GARANTIA',
            'FOP_DETALLADA',
            'CUOTAS',
            'ENDOSO',
            '1ERVUELO',
            'ULTIMOVUELO',
            'BASE',
            'SIGN',
            'HORA',
            'DESCRIPCION',
            'CORTETRF1',
            'CORTETRF2',
    );
    private $keys_choose_sabre = array(
            'FECHA',
            'AEROLINEA',
            'TICKET',
            'PNR',
            'NOMBRE',
            'APELLIDO',
            'RUTA',
            'CLASE',
            'TOURCODE',
            'FACIAL',
            'IMPUESTOS',
            'COMISION',
            'TOTAL_TKT',
            'MONTO_CASH',
            'MONTO_TARIFA',
            'FOP',
            'FOP_DETALLADA',
            'BASE',
            'SIGN',
            'HORA',
            'DESCRIPCION',
    );
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
                $this->csvToArray($inputFileName);
            }

            if ($name === 'amadeus') {
                $this->xlsToArray($inputFileName, $name);
            }

            if ($name === 'backoffice') {
                $this->xlsToArray($inputFileName, $name);
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
        // asigno keys para luego elegirlas
        foreach ($this->ready_array_sabre as $key => $row) {
            $this->ready_array_sabre[$key] = array_combine($this->keys_array_sabre, $row);
        }        
        // quito las rows con las cabecereas
        $this->cleaner_source = SourceHandler::SOURCE_SABRE;
        $this->ready_array_sabre = array_filter($this->ready_array_sabre,array($this,'rowCleaner'));
        // quito los tickets en conjuncion
        $this->ticket_col = SourceHandler::TICKET_COL_SABRE;
        $this->ready_array_sabre = array_map(array($this,'dismissCnjTkts'), $this->ready_array_sabre);
        // me quedo con las columnas indicadas en key_choose_sabre
        $this->col_cleaner_cols = $this->keys_choose_sabre;
        $this->ready_array_sabre = array_map(array($this,'colCleaner'),$this->ready_array_sabre);
    }

    private function processAmadeus()
    {
        // quito las rows con las cabecereas
        $this->cleaner_source = SourceHandler::SOURCE_AMADEUS;
        $this->ready_array_amadeus = array_filter($this->ready_array_amadeus,array($this,'rowCleaner'));
    }

    private function processBackoffice()
    {
        // quito las rows con las cabecereas
        $this->cleaner_source = SourceHandler::SOURCE_BACKOFFICE;
        $this->ready_array_backoffice = array_filter($this->ready_array_backoffice,array($this,'rowCleaner'));
        // quito el 0 a la izquierda del vstour
        $this->ticket_col = SourceHandler::TICKET_COL_BACKOFFICE;
        $this->ready_array_backoffice = array_map(array($this,'rpad'), $this->ready_array_backoffice);
    }

    private function processVoids()
    {
        $this->void_col = SourceHandler::VOID_COL_SABRE;
        $this->cleaner_source = SourceHandler::SOURCE_SABRE;
        $this->ready_void_sabre = array_filter($this->ready_array_sabre,array($this,'voidCleaner'));
        $this->void_col = SourceHandler::VOID_COL_AMADEUS;
        $this->cleaner_source = SourceHandler::SOURCE_AMADEUS;
        $this->ready_void_amadeus = array_filter($this->ready_array_amadeus,array($this,'voidCleaner'));
    }

    private function xlsToArray($inputFileName,$source)
    {
        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
        if ($source == SourceHandler::SOURCE_AMADEUS) {
            $this->ready_array_amadeus = array_merge($this->ready_array_amadeus,$objPHPExcel->getActiveSheet()->toArray(null,true,true,true));
        }
        if ($source = SourceHandler::SOURCE_BACKOFFICE) {
            $this->ready_array_backoffice = array_merge($this->ready_array_backoffice,$objPHPExcel->getActiveSheet()->toArray(null,true,true,true));
        }
    }

    private function csvToArray($inputFileName)
    {
        if (($handle = fopen($inputFileName, "r")) !== FALSE) {
            $csvarray = array();
            # Set the parent multidimensional array key to 0.
            $nn = 0;
            while (($data = fgetcsv($handle, 0, SourceHandler::CSV_DELIMITER)) !== FALSE) {
                # Count the total keys in the row.
                $c = count($data);
                # Populate the multidimensional array.
                for ($x=0;$x<$c;$x++) {
                    $csvarray[$nn][$x] = $data[$x];
                }
                $nn++;
            }
            $this->ready_array_sabre = array_merge($this->ready_array_sabre, $csvarray);
            # Close the File.
            fclose($handle);
        }
    }

    private function rpad($elem)
    {
        $length = $this->rpad_string_length;
        $elem[$this->ticket_col] = substr($elem[$this->ticket_col], strlen($elem[$this->ticket_col])-$length,$length);
        return $elem;
    }

    private function dismissCnjTkts($elem)
    {
        $elem[$this->ticket_col] = substr($elem[$this->ticket_col], 0, 10);
        return $elem;
    }

    private function voidCleaner($elem)
    {
        if ($this->cleaner_source == SourceHandler::SOURCE_SABRE) {
            if ($elem[$this->void_col] != SourceHandler::VOID_FIELD_SABRE) {
                return false;
            } else {
                return true;
            }
        }

        if ($this->cleaner_source == SourceHandler::SOURCE_AMADEUS) {
            if ($elem[$this->void_col] != SourceHandler::VOID_FIELD_AMADEUS) {
                return false;
            } else {
                return true;
            }
        }        
    }

    private function rowCleaner($elem)
    {
        if ($this->cleaner_source == SourceHandler::SOURCE_SABRE) {
            if ($elem[SourceHandler::FILTER_COL_SABRE] == 'FECHA' ||
                $elem[SourceHandler::VOID_COL_SABRE] == SourceHandler::VOID_FIELD_SABRE
                ) {
                return false;
            }else{
                return true;
            }
        }

        if ($this->cleaner_source == SourceHandler::SOURCE_AMADEUS) {
            if ($elem[SourceHandler::FILTER_COL_AMADEUS] == '' ||
                $elem[SourceHandler::FILTER_COL_AMADEUS] == 'DOC NUMBER' ||
                $elem[SourceHandler::VOID_COL_AMADEUS] == 'CANN' ||
                $elem[SourceHandler::VOID_COL_AMADEUS] == SourceHandler::VOID_FIELD_AMADEUS
                )
            {
                return false;
            }else{
                return true;
            }
        }

        if ($this->cleaner_source == SourceHandler::SOURCE_BACKOFFICE) {
            if ($elem[SourceHandler::FILTER_COL_BACKOFFICE] == 'FECHA') {
                return false;
            }else{
                return true;
            }
        }
    }

    private function colCleaner($elem)
    {
        foreach ($elem as $key => $value) {
            if (!in_array($key, $this->col_cleaner_cols)) {
                unset($elem[$key]);
            }
        }
        return $elem;
    }

    public function getSources()
    {
        return array(
                SourceHandler::SOURCE_SABRE => $this->ready_array_sabre,
                SourceHandler::SOURCE_AMADEUS => $this->ready_array_amadeus,
                SourceHandler::SOURCE_BACKOFFICE => $this->ready_array_backoffice,
            );
    }
    public function getVoids()
    {
        $this->processVoids();
        /*
        return array(
                SourceHandler::VOID_SABRE => $this->ready_void_sabre,
                SourceHandler::VOID_AMADEUS => $this->ready_void_amadeus,                
            );
        */
        $voids = array(
                SourceHandler::VOID_SABRE => $this->ready_void_sabre,
                SourceHandler::VOID_AMADEUS => $this->ready_void_amadeus,                
            );
        echo "<pre>";
        print_r($voids);
        echo "</pre>";
    }
}