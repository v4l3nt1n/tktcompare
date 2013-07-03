<?php

class Formatter 
{
    // propiedades
    const SOURCE_SABRE = 'sabre';
    const SOURCE_AMADEUS = 'amadeus';
    const SOURCE_BACKOFFICE = 'backoffice';

    const TICKET_KEY_SABRE = 'boleto';
    const TICKET_KEY_AMADEUS = 'ticket';
    const TICKET_KEY_BACKOFFICE = 'tkt';

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
        $this->source_sabre = $tickets[Formatter::SOURCE_SABRE];
        $this->source_amadeus = $tickets[Formatter::SOURCE_AMADEUS];
        $this->source_backoffice = $tickets[Formatter::SOURCE_BACKOFFICE];
        
        // me quedo con la columna de tickets del backoffice
        $this->cleaner_key = Formatter::TICKET_KEY_BACKOFFICE;
        $this->backoffice_clean_data = array_map(array($this,'cleaner'), $this->source_backoffice);
        
        // quita de 0 de izquierda fuente backoffice
        $this->backoffice_clean_data = array_map(array($this,'rpad'), $this->backoffice_clean_data);
    }

    private function cleaner($elem)
    {
        return $elem[$this->cleaner_key];
    }

    private function filter($elem)
    {      
        return !in_array($elem[$this->filter_key], $this->backoffice_clean_data);
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

    public function getMissing()
    {
        $this->filter_key = Formatter::TICKET_KEY_SABRE;
        $this->missing_sabre = array_filter($this->source_sabre,array($this,'filter'));
        $this->filter_key = Formatter::TICKET_KEY_AMADEUS;
        $this->missing_amadeus = array_filter($this->source_amadeus,array($this,'filter'));
        return array(
                'missing_sabre'=>$this->missing_sabre,
                'missing_amadeus'=>$this->missing_amadeus,
            );
    }


}