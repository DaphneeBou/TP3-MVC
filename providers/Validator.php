<?php
namespace App\Providers;

class Validator {

    private $errors = array();
    private string $key;
    private string $value;
    private string $name;

    public function field(string $key, string $value, $name = null){
        $this->key = $key;
        $this->value = $value;
        if($name == null){
            $this->name = ucfirst($key);
        }else{
            $this->name = ucfirst($name);
        }
        return $this;
    }

    //regles
    public function required(){
        if(empty($this->value)){
            $this->errors[$this->key]="$this->name est obligatoire";
        }
        return $this;
    }

    public function min(int $length){
        if(strlen($this->value) < $length){
            $this->errors[$this->key]="$this->name doit contenir au moins $length caracteres";
        }
        return $this;
    }

    public function max(int $length){
        if(strlen($this->value) > $length){
            $this->errors[$this->key]="$this->name doit contenir au plus $length caracteres";
        }
        return $this;
    }

    public function int(){
        if(!empty($this->value) && !filter_var($this->value, FILTER_VALIDATE_INT)){
             $this->errors[$this->key]="$this->name doit etre un nombre entier";
        }
    }

    public function email(){
        if(!empty($this->value) && !filter_var($this->value, FILTER_VALIDATE_EMAIL)){
             $this->errors[$this->key]="Format de $this->name invalide";
        }
    }

    //-- regles fin
    public function isSuccess(){
        if(empty($this->errors)) return true;
    }

    public function getErrors(){
        if(!$this->isSuccess()) return $this->errors;
    }
}

?>
