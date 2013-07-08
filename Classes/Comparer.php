<?php

class Comparer 
{
    // propiedades
    const SOURCE_SABRE = 'sabre';
    const SOURCE_AMADEUS = 'amadeus';
    const SOURCE_BACKOFFICE = 'backoffice';

    const VOID_SABRE = "void_sabre";
    const VOID_AMADEUS = 'void_amadeus';

    const TICKET_KEY_SABRE = 'TICKET';
    const TICKET_KEY_AMADEUS = 'TICKET';
    const TICKET_KEY_BACKOFFICE = 'E';

    const VOID_COL_SABRE = "DESCRIPCION";
    const VOID_COL_AMADEUS = 'TRNC';
    const VOID_COL_BACKOFFICE = "";

    const VOID_FIELD_SABRE = "VOID";
    const VOID_FIELD_AMADEUS = "CANX";
    const VOID_FIELD_BACKOFFICE = "";

    private $source_sabre = array();
    private $source_amadeus = array();
    private $source_backoffice = array();

    private $backoffice_clean_data = array();

    private $missing_sabre = array();
    private $missing_amadeus = array();

    private $ready_void_sabre = array();
    private $ready_void_amadeus = array();

    private $filter_key;
    private $cleaner_key;
    private $void_col;

    // metodos
    public function __construct($tickets)
    {
        // se asignan las propiedades de cada fuente
        $this->source_sabre = $tickets[Comparer::SOURCE_SABRE];
        $this->source_amadeus = $tickets[Comparer::SOURCE_AMADEUS];
        $this->source_backoffice = $tickets[Comparer::SOURCE_BACKOFFICE];
        
        // me quedo con la columna de tickets del backoffice
        $this->cleaner_key = Comparer::TICKET_KEY_BACKOFFICE;
        $this->backoffice_clean_data = array_map(array($this,'cleaner'), $this->source_backoffice);
        
        // proceso
        $this->process();
    }

    private function cleaner($elem)
    {
        return $elem[$this->cleaner_key];
    }

    private function filter($elem)
    {      
        return !in_array($elem[$this->filter_key], $this->backoffice_clean_data);
    }

    private function sourceCleaner()
    {       
        if ($this->cleaner_source == Comparer::SOURCE_SABRE) {
            foreach ($this->source_sabre as $key => $ticket) {
                if ($ticket[$this->void_col] == Comparer::VOID_FIELD_SABRE) {
                    $this->ready_void_sabre[] = $ticket;
                } else {
                    $this->missing_sabre[] = $ticket;
                }
            }
        }
        if ($this->cleaner_source == Comparer::SOURCE_AMADEUS) {
            foreach ($this->source_amadeus as $key => $ticket) {
                if ($ticket[$this->void_col] == Comparer::VOID_FIELD_AMADEUS) {
                    $this->ready_void_amadeus[] = $ticket;
                } else {
                    $this->missing_amadeus[] = $ticket;
                }
            }
        }
    }

    private function processMissing()
    {
        $this->filter_key = Comparer::TICKET_KEY_SABRE;
        $this->missing_sabre = array_filter($this->missing_sabre,array($this,'filter'));
        $this->filter_key = Comparer::TICKET_KEY_AMADEUS;
        $this->missing_amadeus = array_filter($this->missing_amadeus,array($this,'filter'));
    }

    private function process()
    {
        $this->void_col = Comparer::VOID_COL_SABRE;
        $this->cleaner_source = Comparer::SOURCE_SABRE;        
        $this->sourceCleaner();

        $this->void_col = Comparer::VOID_COL_AMADEUS;
        $this->cleaner_source = Comparer::SOURCE_AMADEUS;        
        $this->sourceCleaner();

        $this->processMissing();
    }

    public function getMissing()
    {
        return array(
                'missing_sabre'=>$this->missing_sabre,
                'missing_amadeus'=>$this->missing_amadeus,
            );
    }
    
    public function getVoids()
    {
        return array(
                Comparer::VOID_SABRE => $this->ready_void_sabre,
                Comparer::VOID_AMADEUS => $this->ready_void_amadeus,
            );
    }
}