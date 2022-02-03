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
                            <B><font class='opis_paneli'>STATYSTYKI ARTYKUŁ</font></B><br><br>

                            <FORM ACTION="statystyki_artykul.php" METHOD=POST>
                                <INPUT TYPE="hidden" NAME="co" VALUE="opcja">

                                <div align=center>
                                    <TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 style='width: 35%;'>
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
            <?PHP print"<br/><B><font size=3 color=#00004d>Artykuły od: $data_od do: $data_do</font></B><br/><br>"; ?>
             
            
            <TABLE cellpadding = '0'  cellspacing = '0' border = '0' style='width: 98%; height: 100%;'>               
                <tr>
                    <td align="center">
                        <DIV class="centrowanie">
                            <TABLE width=80%>
                                <TR bgcolor = #6666ff><TD id='td_kolor' class='regaly_td_font' style='width: 60%;'><B>ARTYKUŁ</B></TD><TD id='td_kolor' class='regaly_td_font' style='width: 25%;'><B>METRY</B></TD><TD id='td_kolor' class='regaly_td_font' style='width: 15%;'><B> % </B></TD></TR>
                                    <?PHP
                                        require_once '../class.Polocz.php';
                                        $polocz = new Polocz();
                                        
                                        $polocz->open(); 
                                        mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");                                  
                                        $wynik_suma = mysql_query("SELECT sum(METRY_RAPORTY_ZMIANA) AS 'metry_suma' FROM view_wszystko_metry_raporty_sztuki WHERE Artykul_zamowienia != '' AND Artykul_zamowienia != 'Zamówienie nr..' AND Artykul_zamowienia != 'ZZZZ' AND Artykul_zamowienia != 'test 2020' AND Artykul_zamowienia != 'wwwww' AND Artykul_zamowienia != 'DZIANINA PES/T' AND Artykul_zamowienia NOT LIKE 'TKANINA%' AND Artykul_zamowienia != '200 BAWEŁNA' AND Artykul_zamowienia NOT LIKE '%VISKOZA' AND Data BETWEEN '$data_od' AND '$data_do';") or die ("zle pytanie zamowienia sumy");                                                                                              
                                        $polocz->close();
                                        
                                        while($rekord_suma = mysql_fetch_assoc($wynik_suma)){
                                            $suma_metrow = $rekord_suma['metry_suma'];
                                        }
                                        
                                        $polocz->open(); 
                                        mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");                                  
                                        $wynik = mysql_query("SELECT Artykul_zamowienia AS 'Artykuł', sum(METRY_RAPORTY_ZMIANA) AS 'Ilość_metrów' FROM view_wszystko_metry_raporty_sztuki WHERE Artykul_zamowienia != '' AND Artykul_zamowienia != 'Zamówienie nr..' AND Artykul_zamowienia != 'ZZZZ' AND Artykul_zamowienia != 'test 2020' AND Artykul_zamowienia != 'wwwww' AND Artykul_zamowienia != 'DZIANINA PES/T' AND Artykul_zamowienia NOT LIKE 'TKANINA%' AND Artykul_zamowienia != '200 BAWEŁNA' AND Artykul_zamowienia NOT LIKE '%VISKOZA' AND Data BETWEEN '$data_od' AND '$data_do' GROUP BY Artykul_zamowienia ORDER BY sum(METRY_RAPORTY_ZMIANA) DESC;") or die ("zle pytanie zamowienia");                                                                                              
                                        $polocz->close();
                                        
                                        while($rekord = mysql_fetch_assoc($wynik)){
                                            
                                            $artykul = $rekord['Artykuł'];
                                            $metry = $rekord['Ilość_metrów'];
                                            
                                            $procent = (100 * $metry)/$suma_metrow;
                                            $procent = round($procent, 2);
                                            
                                            $kolor = '#FFFFFF';
                                            
                                            print"<TR><TD id='td_kolor' bgcolor=$kolor>$artykul</TD><TD id='td_kolor' align='right' bgcolor=$kolor>$metry</TD><TD id='td_kolor' align = 'center' bgcolor=$kolor>$procent %</TD></TR>\n";
                                        
                                            
                                        }
                                    
                                    
                                    ?>
                            </TABLE>
                        </DIV>
            
                    <?PHP
                         /*
                        ///////////////////koniec przycisk data wybierz///////////////////
                            require_once '../class.Polocz.php';
                            $polocz = new Polocz();

                                /////////wyswietlanie po wybraniu/////////////

                            if($_POST['co']=='opcja')
                            {

                                    ////////////////wyszukiwanie z danego dnia /////////////////////////////
                                    $data_razem=$_POST['data_data'];

                                                                  
                                     
                                    $polocz->open(); 
                                    mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
                                    
                                    $wynik = mysql_query("SELECT Z.Odbiorca_zamowienia, Z.Artykul_zamowienia, Z.Ilosc_szt_metrow, Z.Status_metrow, Z.Data, Z.Kto_wpisal FROM ZAMOWIENIA_TAB Z WHERE Z.Data LIKE '$data_razem' AND Z.Nr_parti NOT LIKE '%usuniete%' AND Z.Artykul_zamowienia NOT LIKE '%BT2424%' ORDER BY Z.Kto_wpisal, Z.Odbiorca_zamowienia;") or die ("zle pytanie zamowienia");                        
                                  
                                        
                                    $polocz->close();
                                print"<DIV ALIGN=center>";

                                    print"<TABLE width=80%>";
                                        print"<TR bgcolor = #6666ff><TD id='td_kolor' style='width: 60%;'><B>ARTYKUŁ</B></TD><TD id='td_kolor' style='width: 25%;'><B>ILOŚĆ</B></TD><TD id='td_kolor' style='width: 15%;'><B> M./SZT. </B></TD></TR>";

                                            $temp_zamowienie = 0;
                                            $temp_odbiorca = "";
                                            $ilosc_sztuk = 0;
                                            $ilosc_metrow = 0;
                                            $opis_sztuki = "";
                                            
                                            $licz_rekordy = 0;
                                            
                                            $temp_uzytkownik = "";
                                            $temp_ilosc_sztuk_uzytkownik = 0;
                                            $temp_ilosc_metrow_uzytkownik = 0;

                                            while($rekord = mysql_fetch_assoc($wynik)){



                                              $odbiorca_zamowienia = $rekord['Odbiorca_zamowienia'];
                                              
                                              $artykul_zamowienia = $rekord['Artykul_zamowienia'];
                                              $ilosc = $rekord['Ilosc_szt_metrow'];
                                              $status_metrow = $rekord['Status_metrow'];
                                              
                                                if($data_razem < "2021-10-31")
                                                {
                                                    $uzytkownik = $rekord['uzytkownik'];
                                                }
                                                else 
                                                {
                                                    $uzytkownik = $rekord['Kto_wpisal'];
                                                }
                                              
                                              $data = $rekord['Data'];
                                              
                                              if($uzytkownik == "OGANES_HMAJAK")
                                              {
                                                  $uzytkownik = "Mariusz";
                                              }
                                              
                                               

                                              
                                              //////////////zliczanie sztuk / metrow ////////////////////////////
                                              if($odbiorca_zamowienia != "PAKAITA" && $odbiorca_zamowienia != "ROKIET" && $odbiorca_zamowienia != "PRÓBY DRUKU" && $odbiorca_zamowienia != "CANORRA" && $odbiorca_zamowienia != "MADRES" && $odbiorca_zamowienia != "ZZZ" && $odbiorca_zamowienia != "PRZYGOTOWANIE PRODUKCJI" && $uzytkownik != "TOMEK-DRUKARNIA" && $uzytkownik != "ASIA-DRUKARNIA" && $uzytkownik != "DRUK-Kasia" && $uzytkownik != "" && $artykul_zamowienia != 'DZIANINA PES/T')
                                              {

                                                
                                                
                                                

                                                $kolor = '#FFFFFF';                                                                

                                                if($temp_uzytkownik != $uzytkownik)
                                                {
                                                    if($licz_rekordy != 0)
                                                    {
                                                        $temp_ilosc_metrow_uzytkownik = $temp_ilosc_metrow_uzytkownik/45;
                                                        $temp_ilosc_sztuk_uzytkownik += $temp_ilosc_metrow_uzytkownik;
                                                        
                                                        if($temp_ilosc_sztuk_uzytkownik > 0)
                                                        {
                                                            $opis_sztuki = "sztuka";
                                                        }
                                                        if($temp_ilosc_sztuk_uzytkownik >= 2 && $temp_ilosc_sztuk_uzytkownik < 5)
                                                        {
                                                            $opis_sztuki = "sztuki";
                                                        }
                                                        if($temp_ilosc_sztuk_uzytkownik > 5)
                                                        {
                                                            $opis_sztuki = "sztuk";
                                                        }
                                                        
                                                        
                                                        
                                                        //print_r($temp_ilosc_sztuk_uzytkownik); print"<br>";
                                                        $kolor = '#F3E5F5';
                                                        print"<TR><TD id='td_kolor' bgcolor=$kolor align=right></TD><TD id='td_kolor' bgcolor=$kolor align=center><B><font size='4' color='black'>Razem:  "; echo (int)"$temp_ilosc_sztuk_uzytkownik"; print"  $opis_sztuki</font></B></TD><TD id='td_kolor' bgcolor=$kolor></TD></TR>\n";
                                                        
                                                        $temp_ilosc_metrow_uzytkownik = 0;
                                                        $temp_ilosc_sztuk_uzytkownik = 0;
                                                    }
                                                    if($uzytkownik == "Jacek Kęska")
                                                    {
                                                        $uzytkownik_do_wyswietlenia = "Jacek";
                                                    }
                                                    else{
                                                        $uzytkownik_do_wyswietlenia = $uzytkownik;
                                                    }
                                                     $kolor = '#99CCCC';
                                                    //print"<TR><TD id='td_kolor' bgcolor=$kolor><B><font size='4' color='blue'>$uzytkownik</font></B></TD><TD id='td_kolor' bgcolor=$kolor>$uzytkownik</TD><TD id='td_kolor' bgcolor=$kolor></TD></TR>\n";
                                                    print"<TR><TD id='td_kolor' style='background-color:$kolor; text-align: right;'><B><font style= 'font-size:22px; color:#003366;'>$uzytkownik_do_wyswietlenia</font></B></TD><TD id='td_kolor' style='background-color:$kolor;'></TD><TD id='td_kolor' style='background-color:$kolor;'></TD></TR>\n";
                                                    
                                                    $temp_uzytkownik = $uzytkownik;
                                                }
                                                
                                                if($status_metrow == "sztuk")
                                                {
                                                  $ilosc_sztuk += $ilosc; 
                                                  $temp_ilosc_sztuk_uzytkownik += $ilosc;
                                                   }
                                                if(($status_metrow == "raport(y)") || ($status_metrow == "metr(y)"))
                                                {
                                                  $ilosc_metrow += $ilosc;
                                                  $temp_ilosc_metrow_uzytkownik += $ilosc;
                                                }
                                                
                                                $licz_rekordy++;
                                                
                                                $kolor = '#FFFFFF';
                                                if($temp_odbiorca != $odbiorca_zamowienia)
                                                {
                                                      $kolor = '#33FF66';
                                                      //print"<TR><TD id='td_kolor' bgcolor=$kolor><B><font style= 'size:4; color:blue;'>$odbiorca_zamowienia</font></B></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD></TR>\n";
                                                      print"<TR><TD id='td_kolor' bgcolor=$kolor><B><font style= 'font-size:18px; color:red;'>$odbiorca_zamowienia</font></B></TD><TD id='td_kolor' bgcolor=$kolor></TD><TD id='td_kolor' bgcolor=$kolor></TD></TR>\n";
                                                      
                                                      $temp_odbiorca = $odbiorca_zamowienia;

                                                }
                                                
                                                $kolor = '#FFFFFF';



                                              print"<TR><TD id='td_kolor' bgcolor=$kolor>$artykul_zamowienia</TD><TD id='td_kolor' align='right' bgcolor=$kolor>$ilosc</TD><TD id='td_kolor' align = 'center' bgcolor=$kolor>$status_metrow</TD></TR>\n";
                                            }                                             
                                        }
                                        if($ilosc != 0 && $temp_ilosc_sztuk_uzytkownik == 0 && $status_metrow == "sztuk")
                                        {
                                            $temp_ilosc_sztuk_uzytkownik = $ilosc;
                                        }
                                        else
                                        {
                                            $temp_ilosc_metrow_uzytkownik = $temp_ilosc_metrow_uzytkownik/45;
                                            $temp_ilosc_sztuk_uzytkownik += $temp_ilosc_metrow_uzytkownik;
                                        }
                                        
                                                        if($temp_ilosc_sztuk_uzytkownik > 0 &&  $temp_ilosc_sztuk_uzytkownik < 1)
                                                        {
                                                            $opis_sztuki = "sztuk";                                                           
                                                        }
                                                        if($temp_ilosc_sztuk_uzytkownik >= 1)
                                                        {
                                                            $opis_sztuki = "sztuka";                                                           
                                                        }
                                                        if($temp_ilosc_sztuk_uzytkownik >= 2 && $temp_ilosc_sztuk_uzytkownik < 5)
                                                        {
                                                            $opis_sztuki = "sztuki";                              
                                                        }
                                                        if($temp_ilosc_sztuk_uzytkownik > 5)
                                                        {
                                                            $opis_sztuki = "sztuk";
                                                        }
                                                        if($status_metrow != "sztuk" && $ilosc != 0 && $temp_ilosc_sztuk_uzytkownik == 0)
                                                        {
                                                            $opis_sztuki = $status_metrow;
                                                        }
                                                $kolor = '#F3E5F5';
                                                //print"<TR><TD id='td_kolor' bgcolor=$kolor align=right><B><font size='4' color='black'>Razem:</font></B></TD><TD id='td_kolor' bgcolor=$kolor align=center><B><font size='4' color='black'>"; echo (int)"$temp_ilosc_sztuk_uzytkownik"; print"</font></B></TD><TD id='td_kolor' bgcolor=$kolor>sztuk</TD></TR>\n";
                                                print"<TR><TD id='td_kolor' bgcolor=$kolor align=right></TD><TD id='td_kolor' bgcolor=$kolor align=center><B><font size='4' color='black'>Razem:  "; echo (int)"$temp_ilosc_sztuk_uzytkownik"; print"  $opis_sztuki</font></B></TD><TD id='td_kolor' bgcolor=$kolor></TD></TR>\n";
                                                               

                                    print"</TABLE>";
                                print"</DIV>";
                            }
                            else{
                                    ////////////////////////////////////////////////// 
  
                            }
                            print'<br>';
                          */  
                          //print"przykładowy tekst";
                          ?>
            
                    </td>
                </tr>
            </TABLE>
            
                          
 
<DIV class="dolny_do_tabeli" id="niedrukuj"></DIV>

</body>
</html>
