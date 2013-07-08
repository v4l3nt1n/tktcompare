<?php

class Comparer 
{
    // propiedades
    const SOURCE_SABRE = 'sabre';
    const SOURCE_AMADEUS = 'amadeus';
    const SOURCE_BACKOFFICE = 'backoffice';

    const TICKET_KEY_SABRE = 'TICKET';
    const TICKET_KEY_AMADEUS = 'C';
    const TICKET_KEY_BACKOFFICE = 'E';

    private $source_sabre;
    private $source_amadeus;
    private $source_backoffice;

    private $backoffice_clean_data;

    private $missing_sabre;
    private $missing_amadeus;

    private $filter_key;
    private $cleaner_key;

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
    }

    private function cleaner($elem)
    {
        return $elem[$this->cleaner_key];
    }

    private function filter($elem)
    {      
        return !in_array($elem[$this->filter_key], $this->backoffice_clean_data);
    }

    public function getMissing()
    {
        $this->filter_key = Comparer::TICKET_KEY_SABRE;
        $this->missing_sabre = array_filter($this->source_sabre,array($this,'filter'));
        $this->filter_key = Comparer::TICKET_KEY_AMADEUS;
        $this->missing_amadeus = array_filter($this->source_amadeus,array($this,'filter'));
        return array(
                'missing_sabre'=>$this->missing_sabre,
                'missing_amadeus'=>$this->missing_amadeus,
            );
    }
}