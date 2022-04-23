<?php
class Klant {
    //properties
    private $naam;
    private $email;
    private $wachtwoord;
    private $telefoonnummer;
    private $straat;
    private $huisnummer;
    private $postcode;
    private $plaats;

    //constructor
    function __construct($naam, $email, $wachtwoord, $telefoonnummer, $straat, $huisnummer, $postcode, $plaats)
    {
        $this->naam = $naam;
        $this->email = $email;
        $this->wachtwoord = $wachtwoord;
        $this->telefoonnummer = $telefoonnummer;
        $this->straat = $straat;
        $this->huisnummer = $huisnummer;
        $this->postcode = $postcode;
        $this->plaats = $plaats;
    }

    public function insertKlant($conn) {
        $this->wachtwoord = password_hash($this->wachtwoord, PASSWORD_DEFAULT);
        $querry = "INSERT INTO gebruikers (email, wachtwoord, rechten) VALUES ('{$this->email}', '{$this->wachtwoord}', 0)";
        $result = $conn->query($querry);
        if ($result) {
            $last_id = mysqli_insert_id($conn);
            $querry = "INSERT INTO klanten (gebruikerID, naam, telefoonnummer, straat, huisnummer, postcode, plaats) 
            VALUES ({$last_id}, '{$this->naam}',  {$this->telefoonnummer}, '{$this->straat}', '{$this->huisnummer}', '{$this->postcode}', '{$this->plaats}')";
            $result2 = $conn->query($querry);
            if ($result2) {
                return true;  
            }else {
                return false;
            }
        }else {
            return false;
        }
    }  
}