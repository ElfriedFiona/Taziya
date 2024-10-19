<?php

class PHP_Email_Form {
    // Définition des méthodes et propriétés de la classe ici
    private $to;
    private $subject;
    private $fields;
    
    public function __construct($to, $subject) {
        $this->to = $to;
        $this->subject = $subject;
    }
    public function setTo($to) {
        $this->to = $to;
    }

    public function getTo() {
        return $this->to;
    }
    public function setsubject($subject) {
        $this->subject = $subject;
    }

    public function getsubject() {
        return $this->subject;
    }

    public function addField($name, $label, $required = false) {
        $this->fields[$name] = array('label' => $label, 'required' => $required);
    }
    public function processForm() {
        $errors = array();
        $data = array();
    
        // Vérifier les champs requis
        foreach ($this->fields as $name => $field) {
            if ($field['required'] && empty($_POST[$name])) {
                $errors[] = $field['label'] . ' est requis.';
            } else {
                $data[$name] = $_POST[$name];
            }
        }
    
        // Vérifier s'il y a des erreurs
        if (!empty($errors)) {
            // Gérer les erreurs ici, par exemple les afficher à l'utilisateur
            return $errors;
        } else {
            // Pas d'erreurs, envoyer l'email
            $message = "Nouveau message depuis le formulaire :\n\n";
            foreach ($data as $name => $value) {
                $message .= "$name: $value\n";
            }        $headers = 'From: ' . $data['email'];

            mail($this->to, $this->subject, $message, $headers);
    
            return true; // Email envoyé avec succès
        }
    }
}

?>