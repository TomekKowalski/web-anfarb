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
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
        <script src = "js/jquery-1.11.0.min.js"> </script>
        <script src = "js/lightbox.min.js"> </script>
        <link href="css/lightbox.css" rel="stylesheet"/>
        <link href="css_wyglad_strony/style.css" rel="stylesheet" type="text/css">
        <link href="css_wyglad_strony/mobile_style.css" rel="stylesheet" type="text/css">
        <link rel="Stylesheet" media="print" type="text/css" href="dodruku.css" />
        <title>Zamówienia drukarnia</title>
      
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <link rel="stylesheet" href="/resources/demos/style.css">
  <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>
     
              
</head>

<body>
<?PHP  

print'<DIV class="do_tabeli">';

        require_once 'class.Polocz.php';
        $polocz = new Polocz();
        //$rok = array('2013' => '2013','2014' => '2014', '2015' => '2015', '2016' => '2016', '2017' => '2017', '2018' => '2018', '2019' => '2019', '2020' => '2020', '2021' => '2021');
                          

print"<TABLE  cellpadding = '0'  cellspacing = '0' border = '0' style='width: 100%; height: 100%;'>";
    print"<tr>";
        print"<td align=center>";
            require_once "zalogowany_banery.php";
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>";
            print"<TABLE cellpadding = '0'  cellspacing = '0' border = '0' style='width: 100%; height: 100%;'>";
                print"<tr>";
                    print"<td align=center>";
                        print"<DIV class='panel_1ogowanie'>";
                            
                                /////////przycisk i nazwa odbiorcy/////////////////////
                                print'<FORM ACTION="index.php" METHOD=POST>';
                                print'<INPUT TYPE="submit" VALUE="Strona startowa" CLASS="btn">';
                                print'</FORM>';

                                print "<br><B><font class='opis_paneli'>Cennik DAMAZ</font></B><br><br>";                                    

                                    /////////////wybieranie artykulu////////////////////////
                                print'<FORM ACTION="cennik_damaz.php" METHOD=POST>';
                                print '<INPUT TYPE="hidden" NAME="co" VALUE="wybor_artykulu">';
                            print'<div align=center>';
                                    ////////////textbox do wpisywania nr parti i przycisk /////////////////////////// 
                                print"<TABLE id=niedrukuj CELLPADDING=0 CELLSPACING=0 BORDER=0 style='width: 90%; height: 100%;'>";
                                    print"<TR>";
                                        print"<TD valign=bottom style='width: 45%;' align=left>";
                                            print'<B><font class="opis_texbox">NR ARTYKUŁU</font></B><br/>';    
                                            if($_POST['nr_artykulu'])
                                            {                      
                                                     $wybrany_nr_artykulu = $_POST['nr_artykulu'];
                                            }
                                            print ("<INPUT class='text_box' style='width: 95%;' TYPE='text' NAME='nr_artykulu' VALUE=".$wybrany_nr_artykulu.">");
                                        print"</TD>";                                 
                                        print"<TD valign=bottom style='width: 45%;' align=left>"; 
                                            print'<B><font class="opis_texbox">NAZWA ARTYKUŁU</font></B><br/>';
                                            if($_POST['nazwa_artykulu'])
                                            {                      
                                                     $wybrana_nazwa_artykulu = $_POST['nazwa_artykulu'];
                                            }
                                            print ("<INPUT class='text_box' style='width: 95%;' TYPE='text' NAME='nazwa_artykulu' VALUE=".$wybrana_nazwa_artykulu.">");
                                        print"</TD>";                                 
                                        print"<TD valign=bottom style='width: 10%;'>";

                                            print "";
                                            print'<INPUT TYPE="submit" VALUE="Wybierz" CLASS="btn" style="width: 100%;">';

                                        print"</TD>";
                                    print"</TR>";
                                print"</TABLE>";
                                print'</FORM>';
                            print'</div>';
                        print'</div>';
                    print"</td>";
                print"</tr>";           
            print"</TABLE>";
        print"</td>";
    print"</tr>";   
print"</TABLE>";

print"</div>";

print"<div align=center>";
       ////////////////wyszukiwanie artykulu /////////////////////////////

                            if(($_POST['co']=='wybor_artykulu'))
                            {
                                $wybrany_nr_artykulu =$_POST['nr_artykulu'];
                                $wybrana_nazwa_artykulu = $_POST['nazwa_artykulu'];
                                
                                $polocz->open(); 
                                mysql_select_db("DZIEWIARNIA_CENY") or die ("nie ma DZIEWIARNIA_CENY");
                                $wynik_EUR_druki = mysql_query("SELECT `kurs_euro_druki` FROM `KURS_EURO_DRUKI_TAB`;") or die ("zle pytanie wybor KURSU EUR");
                                $polocz->close();
                                
                                while($rekord_EUR = mysql_fetch_assoc($wynik_EUR_druki))
                                {
                                    $kurs_EUR_druki = $rekord_EUR['kurs_euro_druki'];
                                }
                                
                                

                                $polocz->open(); 
                                mysql_select_db("DZIEWIARNIA_CENY") or die ("nie ma DZIEWIARNIA_CENY");
                                $wynik = mysql_query("SELECT `ID_dane_artykulu`, `Nr_artykulu`, `Nazwa_artykulu`, `Nazwa_grupa_cenowa`, `Cena_netto_kg_zl`, `Cena_netto_mb_zl`, `Cena_EUR_za_kg`, `Data_ostatniej_zmiany`, `Uwagi_ceny`, `sklad_dzianiny`, `szerokosc`, `gramatura`, `wydajnosc`, `dlugosc_raportu`, `kurs_euro`, `dlugosc_sztuki_po_stabilizacji`, `Uwagi_grupa_cenowa` FROM `view_cennik_na_strone_i_dane_do_programu` WHERE `Nr_artykulu` LIKE '%$wybrany_nr_artykulu%' AND `Nazwa_artykulu` LIKE '%$wybrana_nazwa_artykulu%' AND `Nr_artykulu` NOT LIKE '%usuniete%' AND `Ukryj_artykul` = '0' ORDER BY `Nazwa_grupa_cenowa`, `Nr_artykulu`;") or die ("zle pytanie wybor cennika");
                                $polocz->close();
                                $ilosc_wierszy_cennik = 0;

                                print"<TABLE style='width: 98%; height: 100%;' height=100% border = '0'>";
                                    //print"<TR bgcolor = #6666ff><TD id='td_kolor' width=2%><B>Nr.</B></TD><TD id='td_kolor' width=10%><B>Nr artykułu </B></TD><TD id='td_kolor' width=10%><B>Nazwa artykułu</B></TD><TD id='td_kolor' width=10%><B>Grupa cenowa</B></TD><TD id='td_kolor' width=5%><B>Cena netto zł za kg</B></TD><TD id='td_kolor' width=5%><B>Cena netto zł za m\b</B></TD><TD id='td_kolor' width=5%><B>Cena EUR za kg</B></TD><TD id='td_kolor' width=5%><B>Cena EUR za m\b</B></TD><TD id='td_kolor' width=5%><B>Data modyfikacji</B></TD><TD id='td_kolor' width=10%><B>Uwagi</B></TD><TD id='td_kolor' width=5%><B>Skład dzianiny</B></TD><TD id='td_kolor' width=5%><B>Szerokość</B></TD><TD id='td_kolor' width=5%><B>Gramatura</B></TD><TD id='td_kolor' width=5%><B>Wydajność</B></TD><TD id='td_kolor' width=2%><B>Raport</B></TD><TD id='td_kolor' width=4%><B>Metry 1 szt +/- 5%</B></TD><TD id='td_kolor' width=4%><B>Metry 1 szt wg. stabilizacji</B></TD></TR>";
                                    
                                    print"<TR bgcolor = #6666ff><TD id='td_kolor' width=2%><B>Nr.</B></TD><TD id='td_kolor' width=10%><B>Nr artykułu </B></TD><TD id='td_kolor' width=10%><B>Nazwa artykułu</B></TD><TD id='td_kolor' width=10%><B>Grupa cenowa</B></TD><TD id='td_kolor' width=5%><B>Cena netto zł za kg</B></TD><TD id='td_kolor' width=5%><B>Cena netto zł za m\b</B></TD><TD id='td_kolor' width=5%><B>Cena EUR za kg</B></TD><TD id='td_kolor' width=5%><B>Cena EUR za m\b</B></TD><TD id='td_kolor' width=7%><B>Uwagi</B></TD><TD id='td_kolor' width=8%><B>Uwagi grupa cenowa</B></TD><TD id='td_kolor' width=5%><B>Skład dzianiny</B></TD><TD id='td_kolor' width=5%><B>Szerokość</B></TD><TD id='td_kolor' width=5%><B>Gramatura</B></TD><TD id='td_kolor' width=5%><B>Wydajność</B></TD><TD id='td_kolor' width=2%><B>Raport</B></TD><TD id='td_kolor' width=4%><B>Metry 1 szt +/- 5%</B></TD><TD id='td_kolor' width=4%><B>Metry 1 szt wg. stabilizacji</B></TD></TR>";

                                        while($rekord_3 = mysql_fetch_assoc($wynik))
                                        {
                                                $ilosc_wierszy_cennik ++;
                                                $nr_artykulu = $rekord_3['Nr_artykulu'];
                                                $nazwa_artykulu = $rekord_3['Nazwa_artykulu'];
                                                $grupa_cenowa = $rekord_3['Nazwa_grupa_cenowa'];

                                                $cena_netto_zl_za_kg_temp = $rekord_3['Cena_netto_kg_zl'];
                                                $cena_netto_zl_za_kg = number_format($cena_netto_zl_za_kg_temp, 2);
                                                $wydajnosc = $rekord_3['wydajnosc'];
                                                $wydajnosc_float = str_replace(",", ".", $wydajnosc);
                                                $cena_netto_zl_za_mb_temp = $rekord_3['Cena_netto_mb_zl'];
                                                $cena_netto_zl_za_mb = round($cena_netto_zl_za_mb_temp, 2);
                                                $cena_netto_zl_za_mb = number_format($cena_netto_zl_za_mb, 2);
                                                if($cena_netto_zl_za_kg != 0)
                                                {        
                                                    $cena_netto_zl_za_mb_temp = $cena_netto_zl_za_kg / $wydajnosc_float;
                                                    $cena_netto_zl_za_mb = round($cena_netto_zl_za_mb_temp, 2);
                                                    $cena_netto_zl_za_mb = number_format($cena_netto_zl_za_mb, 2);                                       
                                                }
                                                $int_sprawdz_druki = strpos($nr_artykulu, "/D");
                                                
                                                
                                                if($int_sprawdz_druki)
                                                {
                                                    $kurs_EUR = $kurs_EUR_druki;
                                                }
                                                else{
                                                    $kurs_EUR = $rekord_3['kurs_euro'];
                                                }
                                                
                                                
                                                $cena_EUR_za_kg_temp = $cena_netto_zl_za_kg / $kurs_EUR;
                                                $cena_EUR_za_kg = round($cena_EUR_za_kg_temp, 1);
                                                $cena_EUR_za_kg = number_format($cena_EUR_za_kg, 2);
                                                $cena_EUR_za_mb_temp = $cena_netto_zl_za_mb / $kurs_EUR;
                                                $cena_EUR_za_mb = round($cena_EUR_za_mb_temp, 1);
                                                $cena_EUR_za_mb = number_format($cena_EUR_za_mb, 2);
                                                $data_modyfikacji = $rekord_3['Data_ostatniej_zmiany'];
                                                $uwagi = $rekord_3['Uwagi_ceny'];
                                                $sklad_dzianiny = $rekord_3['sklad_dzianiny'];
                                                $szerokosc = $rekord_3['szerokosc'];
                                                $gramatura = $rekord_3['gramatura'];
                                                $raport = $rekord_3['dlugosc_raportu'];
                                                $Uwagi_grupa_cenowa = $rekord_3['Uwagi_grupa_cenowa'];
                                                /*
                                                $dlugosc_sztuki_po_stabilizacji_s = $rekord_3['dlugosc_sztuki_po_stabilizacji'];
                                                if($dlugosc_sztuki_po_stabilizacji_s == 0)
                                                {
                                                    $dlugosc_sztuki_po_stabilizacji_s = "";
                                                }
                                                 * 
                                                 */
                                                $int_pozycja_CZ_B = strpos($nr_artykulu, "/CZ");                                           
                                                if(strpos($nr_artykulu, "/CZ/") || strpos($nr_artykulu, "/B/") || strpos($nazwa_artykulu, "ELIEF"))
                                                {
                                                    $kg_1_sztuki = 17;
                                                }
                                                else
                                                {
                                                    $kg_1_sztuki = 18;
                                                }  
                                                
                                                $dlugosc_sztuki_z_wydajnosci = ((double)$kg_1_sztuki * (double)$wydajnosc_float);
                                                $do_odjecia = (double)$dlugosc_sztuki_z_wydajnosci * (double)0.12;
                                
                                                $dlugosc_sztuki_po_stabilizacji_s = floor($dlugosc_sztuki_z_wydajnosci - $do_odjecia);
                                                /*
                                                var_dump($dlugosc_sztuki_po_stabilizacji_s);                
                                                print"dlugosc rekord = ";
                                                var_dump($rekord_3['dlugosc_sztuki_po_stabilizacji']);                                               
                                                print"nr artykulu CZ = ";
                                                var_dump(strpos($nr_artykulu, "/CZ/"));
                                                print"nr artykulu B = ";
                                                var_dump(strpos($nr_artykulu, "/B/"));                         
                                                */
                                                $metry_1_sztuki = $kg_1_sztuki * $wydajnosc_float;
                                                $metry_1_sztuki = number_format($metry_1_sztuki, 0);
                                                $kolor = '#f2f2f2';
                                                if($k%2)
                                                {
                                                    $kolor = '#e6ffff';
                                                }
                                    //print"<TR bgcolor = $kolor><TD align='center' id='td_kolor'>$ilosc_wierszy_cennik</TD><TD align='left' id='td_kolor'>$nr_artykulu</TD><TD align='left' id='td_kolor'>$nazwa_artykulu</TD><TD align='left' id='td_kolor'>$grupa_cenowa</TD><TD align='center' id='td_kolor'>$cena_netto_zl_za_kg</TD><TD align='center' id='td_kolor'>$cena_netto_zl_za_mb</TD><TD align='center' id='td_kolor'>$cena_EUR_za_kg</TD><TD align='center' id='td_kolor'>$cena_EUR_za_mb</TD><TD align='center' id='td_kolor'>$data_modyfikacji</TD><TD align='left' id='td_kolor'>$uwagi</TD><TD align='left' id='td_kolor'>$sklad_dzianiny</TD><TD align='center' id='td_kolor'>$szerokosc</TD><TD align='center' id='td_kolor'>$gramatura</TD><TD align='center' id='td_kolor'>$wydajnosc</TD><TD align='center' id='td_kolor'>$raport</TD><TD align='center' id='td_kolor'>$metry_1_sztuki</TD><TD align='center' id='td_kolor'>$dlugosc_sztuki_po_stabilizacji_s</TD></TR>";
                                      
                                    print"<TR bgcolor = $kolor><TD align='center' id='td_kolor'>$ilosc_wierszy_cennik</TD><TD align='left' id='td_kolor'>$nr_artykulu</TD><TD align='left' id='td_kolor'>$nazwa_artykulu</TD><TD align='left' id='td_kolor'>$grupa_cenowa</TD><TD align='center' id='td_kolor'>$cena_netto_zl_za_kg</TD><TD align='center' id='td_kolor'>$cena_netto_zl_za_mb</TD><TD align='center' id='td_kolor'>$cena_EUR_za_kg</TD><TD align='center' id='td_kolor'>$cena_EUR_za_mb</TD><TD align='left' id='td_kolor'>$uwagi</TD><TD align='left' id='td_kolor'>$Uwagi_grupa_cenowa</TD><TD align='left' id='td_kolor'>$sklad_dzianiny</TD><TD align='center' id='td_kolor'>$szerokosc</TD><TD align='center' id='td_kolor'>$gramatura</TD><TD align='center' id='td_kolor'>$wydajnosc</TD><TD align='center' id='td_kolor'>$raport</TD><TD align='center' id='td_kolor'>$metry_1_sztuki</TD><TD align='center' id='td_kolor'>$dlugosc_sztuki_po_stabilizacji_s</TD></TR>";
                                    

                                                $k++;
                                        }
                                print"</TABLE>";
                            }
print"</div>";

if(($_POST['co']=='wybor_artykulu'))
{
    print"<DIV class='dolny_do_tabeli'>";
    print"</DIV>";
}


?>

</body>
</html>
