<?php
if(isset($_POST)) {
    $mailto = "info@plotterusati.it";
    
    // Funzione helper per sanificare gli header da newline
    function sanitize_header_value($value) {
        return str_replace(array("\r", "\n", "%0a", "%0d"), '', trim($value));
    }

    $email = filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL);
    if (!$email) {
        echo "Indirizzo email non valido.";
        exit;
    }
    
    $email = sanitize_header_value($email);
    $nome = sanitize_header_value($_POST['Nome']);
    $cognome = sanitize_header_value($_POST['Cognome']);

    // Sanitizzazione HTML generale
    $ragSoc = htmlspecialchars($_POST['RagioneSociale'] ?? '', ENT_QUOTES, 'UTF-8');
    $categoria = htmlspecialchars($_POST['Categoria'] ?? '', ENT_QUOTES, 'UTF-8');
    $condizione = htmlspecialchars($_POST['Condizione'] ?? '', ENT_QUOTES, 'UTF-8');
    $marcaModello = htmlspecialchars($_POST['MarcaModello'] ?? '', ENT_QUOTES, 'UTF-8');
    $formato = htmlspecialchars($_POST['Formato'] ?? '', ENT_QUOTES, 'UTF-8');
    $annoCostruzione = htmlspecialchars($_POST['AnnoCostruzione'] ?? '', ENT_QUOTES, 'UTF-8');
    $annoRevisione = htmlspecialchars($_POST['AnnoRevisione'] ?? '', ENT_QUOTES, 'UTF-8');
    $garanzia = htmlspecialchars($_POST['Garanzia'] ?? '', ENT_QUOTES, 'UTF-8');
    $assistenza = htmlspecialchars($_POST['Assistenza'] ?? '', ENT_QUOTES, 'UTF-8');
    $descrizione = htmlspecialchars($_POST['Descrizione'] ?? '', ENT_QUOTES, 'UTF-8');

    $subject = "Richiesta valutazione usato dal sito www.plotterusati.it";
    
    $message = ""
    . "<b>Dati anagrafici</b>" . "<br/>"
    . "Email: " . "<a href='mailto:".$email."'>".$email."</a>". "<br/>"
    . "Ragione Sociale: " . $ragSoc . "<br/>"
    . "Nome: " . htmlspecialchars($nome, ENT_QUOTES, 'UTF-8') . "<br/>"
    . "Cognome: " . htmlspecialchars($cognome, ENT_QUOTES, 'UTF-8') . "<br/><br/>"
    . "<b>Dati attrezzatura</b>" . "<br/>"
    . "Categoria: " . $categoria . "<br/>"
    . "Condizione: " . $condizione . "<br/>"
    . "Marca e Modello: " . $marcaModello . "<br/>"
    . "Formato: " . $formato . "<br/>"
    . "Anno di Costruzione: " . $annoCostruzione . "<br/>"
    . "Anno di Revisione: " . $annoRevisione . "<br/>"
    . "Garanzia: " . $garanzia . "<br/>"
    . "Contratto di Assistenza: " . $assistenza . "<br/>"
    . "Descrizione: " . $descrizione;
    
    $headers = "From: " . $email;
    $headers  = "From: ".$nome." ".$cognome."<".$email.">\n";
    //$headers .= "Cc: ADV <adv@trendsrl.net>\n"; //TEMP
    $headers .= "X-Sender: Plotterusati <info@plotterusati.it>\n";
    $headers .= 'X-Mailer: PHP/' . phpversion();
    $headers .= "X-Priority: 1\n"; // Urgent message!
    $headers .= "Return-Path: noreply@plotterusati.it\n"; // Return path for errors
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\n";
    
    $result = mail($mailto, $subject, $message, $headers);

    if ($result) {
        $messaggio = "Messaggio inviato correttamente! Grazie.";
    } else {
        $messaggio = "Errore nell'invio del messaggio. Riprova.";
    }

    ?>
    <div style="text-align: center; margin-top: 30px; font-family: arial,helvetica,sans-serif;">
        <h3><?=$messaggio?></h3>
        <p>Stai per essere reindirizzato alla homepage...</p>
    </div>
    <?php
    header( "refresh:3;url=https://www.plotterusati.it" ); //redirect dopo 3 secondi
    
}else{
    echo "Form non valida";
}
?>
