<?php

class click_counter
{
    protected $DB_HOST = "89.46.111.211";
    protected $DB_NAME = "Sql1450861_3";
    protected $DB_USER = "Sql1450861";
    protected $DB_PWD = "524818o2t0";
    protected $link = null;
    protected $stmt = null;

    function __construct (){
        $this->link = mysqli_connect($this->DB_HOST, $this->DB_USER, $this->DB_PWD, $this->DB_NAME);
    }

    function get_clicks (){
        $this->stmt = mysqli_query($this->link,
            'SELECT * FROM click_counter');
        return mysqli_fetch_all($this->stmt, MYSQLI_ASSOC);
    }
    
    function get_clicks_byID ($id){
        $this->stmt = mysqli_query($this->link,
            "SELECT * FROM click_counter WHERE id=$id");
        return mysqli_fetch_array($this->stmt, MYSQLI_ASSOC);
    }

    function update_clicks_byID ($id){
        mysqli_query($this->link,
            "UPDATE click_counter SET count=last_insert_id(count+1) WHERE id=$id");
    }
}

$clicks = new click_counter();

if(isset($_GET["id"])){
    $id= $_GET["id"];
    $clicks->update_clicks_byID($id);
    $redirect=$clicks->get_clicks_byID($id)["link"];
    header("location: $redirect");
}

?>


<head>
<title>Click Counter</title>
<link rel="stylesheet" href="https://www.plotterusati.it/themes/default/css/web-custom.css">
</head>

<body>

<h1 class="click_title"><b>Plotterusati.it</b> Contatore Click Banner</h1>

<table id="click_counter">
  <tr>
  	<th>Immagine</th>
    <th>Brand</th>
    <th>Link</th>
    <th>Numero di click</th>
  </tr>
  <?php 
  foreach ($clicks->get_clicks() as $click){
      if($click["id"]== 1){
        ?>
        <tr>
        <td colspan="4"><?php echo '<a href="'.$click["link"].'" target="_blank"><img class="top" src="https://www.plotterusati.it/banner/'.$click['name'].'.jpg"></a>' ?></td>
        </tr>
    	<tr>
        <td colspan="2" class="name"><?=$click["name"]?></td>
        <td><a href="<?=$click["link"]?>" target="_blank"><?=$click["link"]?></a></td>
        <td><?=$click["count"]?></td>
    	</tr>
    	<tr class="invisible"></tr>  
    	<?php
      }else{
        ?>
    	<tr>
    	<td><?php echo '<a href="'.$click["link"].'" target="_blank"><img src="https://www.plotterusati.it/banner/'.$click['name'].'.jpg"></a>' ?></td>
        <td class="name"><?=$click["name"]?></td>
        <td><a href="<?=$click["link"]?>" target="_blank"><?=$click["link"]?></a></td>
        <td><?=$click["count"]?></td>
    	</tr>  
    	<?php
      }
  }
  ?>
</table>

<a class="click_back" href="https://www.plotterusati.it">Torna al sito www.plotterusati.it</a>

</body>
