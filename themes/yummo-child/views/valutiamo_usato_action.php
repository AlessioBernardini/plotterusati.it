<?php
if(isset($_POST)) {
    $mailto = "info@plotterusati.it";
    $email = $_POST['Email'];
    $ragSoc = $_POST['RagioneSociale'];
    $nome = $_POST['Nome'];
    $cognome = $_POST['Cognome'];
    $categoria = $_POST['Categoria'];
    $condizione = $_POST['Condizione'];
    $marcaModello = $_POST['MarcaModello'];
    $formato = $_POST['Formato'];
    $annoCostruzione = $_POST['AnnoCostruzione'];
    $annoRevisione = $_POST['AnnoRevisione'];
    $garanzia = $_POST['Garanzia'];
    $assistenza = $_POST['Assistenza'];
    $descrizione = $_POST['Descrizione'];

    $subject = "Richiesta valutazione usato dal sito www.plotterusati.it";
    
    $message = ""
    . "<b>Dati anagrafici</b>" . "<br/>"
    . "Email: " . "<a href='mailto:".$email."'>".$email."</a>". "<br/>"
    . "Ragione Sociale: " . $ragSoc . "<br/>"
    . "Nome: " . $nome . "<br/>"
    . "Cognome: " . $cognome . "<br/><br/>"
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
    $headers .= "Content-Type: text/html; charset=iso-8859-1\n";
    
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
