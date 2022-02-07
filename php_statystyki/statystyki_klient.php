<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl" xml:lang="pl">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="Content-Type" content="text/html; charset="iso-8859-2" />
        <meta charset="ISO-8859-1">
        <script src = "../js/jquery-1.11.0.min.js"> </script>
        <script src = "../js/lightbox.min.js"> </script>
        <script src="../js_web/script_miniatura_zdjecia.js" async></script>
        <link href="../css/lightbox.css" rel="stylesheet"/>     
	<link rel="Stylesheet" media="print" type="text/css" href="dodruku.css" />
        <link href="../css_wyglad_strony/style.css" rel="stylesheet" type="text/css">
        <link href="../css_wyglad_strony/mobile_style.css" rel="stylesheet" type="text/css">
        <title>Zamówienia drukarnia</title>
      
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
         <link rel="stylesheet" href="/resources/demos/style.css">
             	
</head>

<body>
    
<DIV class="do_tabeli" id="niedrukuj">

<TABLE  cellpadding = '0'  cellspacing = '0' border = '0' style='width: 100%; height: 100%;'> 
    <tr>
        <td align=center>
            <?PHP require_once "../zalogowany_banery.php"; ?>
        </td>
    </tr>
        <tr>
            <td align=center>
                <!--<DIV class="mniejszy_panel">-->
                <DIV id="panel_filtrowanie" class="wiekszy_panel">
                    
                            <FORM ACTION="../index.php" METHOD=POST>
                                <INPUT TYPE="submit" VALUE="Strona startowa" CLASS="btn">
                            </FORM>                                  
                    
                             <!--////////////koniec przycisk i nazwa odbiorcy////////////////-->
                            <br>
                            <!--/////////////przycisk data wybierz/////////////////////////-->
                            <B><font class='opis_paneli'>STATYSTYKI KLIENCI</font></B><br><br>

                            <FORM ACTION="statystyki_klient.php" METHOD=POST>
                                <INPUT TYPE="hidden" NAME="co" VALUE="opcja">

                                <div align=center>
                                    <TABLE class="pole_comboBox">
                                        <TR>
                                            <TD class='td_pole_spacja'><B><font class="opis_texbox">OD: </font></B></TD>
                                            <TD class='td_pole_daty_statystyki'>
                                                <?PHP
                                                if($_POST['data_od'] == "")
                                                {
                                                   $data_miesiac_p=date("m");
                                                   $data_dzien_p=date("d");
                                                   $data_rok_p=date("Y");
                                                   $data_od = $data_rok_p."-".$data_miesiac_p."-".$data_dzien_p;                                                  
                                                }else{
                                                  $data_od = $_POST['data_od'];
                                                }                                               
                                                print"<input class='text_box' type='date' name='data_od' value='".$data_od."'>";
                                                ?>
                                            </TD>   
                                            <TD class='td_pole_spacja'><B><font class="opis_texbox">DO: </font></B></TD>
                                            <TD class='td_pole_daty_statystyki'>
                                                <?PHP
                                                if($_POST['data_do'] == "")
                                                {
                                                   $data_miesiac_p=date("m");
                                                   $data_dzien_p=date("d");
                                                   $data_rok_p=date("Y");
                                                   $data_do = $data_rok_p."-".$data_miesiac_p."-".$data_dzien_p;                                                  
                                                }else{
                                                  $data_do = $_POST['data_do'];
                                                }                                               
                                                print"<input class='text_box' type='date' name='data_do' value='".$data_do."'>";
                                                ?>
                                            </TD>   
                                            <TD class='td_pole_spacja'></TD>
                                            <TD class='td_pole_przycisk'>
                                                <INPUT TYPE="submit" VALUE="Wybierz" CLASS="btn"> 
                                            </TD>
                                        </TR>
                                    </TABLE>
                                </div>
                            </FORM>
                               <!-- ////////////////////koniec dol kontener wklesly ////////////////////// -->
                        </div>
            </td>
    </tr> 
</TABLE>
</DIV>

<div align=center>   
            <?PHP print"<br/><B><font size=3 color=#00004d>Klienci od: $data_od do: $data_do</font></B><br/><br>"; ?>
             
            
            <TABLE cellpadding = '0'  cellspacing = '0' border = '0' style='width: 98%; height: 100%;'>               
                <tr>
                    <td align="center">
                        <DIV align="center">
                            <TABLE style="width: 80%">
                                <TR bgcolor = #6666ff><TD id='td_kolor' class='regaly_td_font' style='width: 5%;'><B>Lp.</B></TD><TD id='td_kolor' class='regaly_td_font' style='width: 60%;'><B>KLIENT</B></TD><TD id='td_kolor' class='regaly_td_font' style='width: 20%;'><B>METRY</B></TD><TD id='td_kolor' class='regaly_td_font' style='width: 15%;'><B> % </B></TD></TR>
                                    <?PHP
                                        require_once '../class.Polocz.php';
                                        $polocz = new Polocz();
                                        
                                        $polocz->open(); 
                                        mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");                                  
                                        $wynik_suma = mysql_query("SELECT sum(METRY_RAPORTY_ZMIANA) AS 'metry_suma' FROM view_wszystko_metry_raporty_sztuki WHERE Odbiorca_zamowienia != '' AND Data BETWEEN '$data_od' AND '$data_do';") or die ("zle pytanie zamowienia sumy");                                                                                              
                                        
                                        $polocz->close();
                                        
                                        while($rekord_suma = mysql_fetch_assoc($wynik_suma)){
                                            $suma_metrow = $rekord_suma['metry_suma'];
                                        }                                       
                                        
                                        $polocz->open(); 
                                        mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");                                  
                                        $wynik = mysql_query("SELECT Odbiorca_zamowienia AS 'Odbiorca', sum(METRY_RAPORTY_ZMIANA) AS 'Ilość_metrów' FROM view_wszystko_metry_raporty_sztuki WHERE Odbiorca_zamowienia != '' AND Data BETWEEN '$data_od' AND '$data_do' GROUP BY `Odbiorca_zamowienia` ORDER BY sum(`METRY_RAPORTY_ZMIANA`) DESC;") or die ("zle pytanie zamowienia");                                                                                              
                                       
                                        $polocz->close();
                                        
                                         
                                        $lp = 1;
                                        while($rekord = mysql_fetch_assoc($wynik)){
                                            
                                            $klient = $rekord['Odbiorca'];
                                            $metry = $rekord['Ilość_metrów'];
                                            
                                            $procent = (100 * $metry)/$suma_metrow;
                                            $procent = round($procent, 2);
                                            
                                            if($lp % 2)
                                            {
                                                $kolor = '#FFFFFF';
                                            }else{
                                                $kolor = '#F0FFFF';
                                            }                              
                                            
                                            print"<TR><TD id='td_kolor' align = 'center' bgcolor=$kolor>$lp</TD><TD id='td_kolor' bgcolor=$kolor>$klient</TD><TD id='td_kolor' align='right' bgcolor=$kolor>$metry</TD><TD id='td_kolor' align = 'center' bgcolor=$kolor>$procent %</TD></TR>\n";
                                            $lp ++;
                                            
                                        }
                                    
                                    
                                    ?>
                            </TABLE>
                        </DIV>           
                    </td>
                </tr>
            </TABLE>
            
                          
 
<DIV class="dolny_do_tabeli" id="niedrukuj"></DIV>

</body>
</html>
