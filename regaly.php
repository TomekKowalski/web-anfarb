<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
        $zalogowany = $_SESSION['imie_nazwisko'];
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl" xml:lang="pl">
<head>
	<!--<meta http-equiv="Refresh" content="5" />-->
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
            <script src = "js/jquery-1.11.0.min.js"> </script>
            <script src = "js/lightbox.min.js"> </script>
            <link href="css/lightbox.css" rel="stylesheet"/>
            <link rel="Stylesheet" media="print" type="text/css" href="dodruku.css" />
            <link href="css_wyglad_strony/style.css" rel="stylesheet" type="text/css"> 
            <link href="css_wyglad_strony/mobile_style.css" rel="stylesheet" type="text/css">
    <title>Zamówienia drukarnia</title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <link rel="stylesheet" href="/resources/demos/style.css">	  
</head>
<body>
<?PHP

print"<DIV class='panel_glowny'>";
       
        require_once 'class.Polocz.php';
        $polocz = new Polocz();
        
        $polocz->open();
        mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");
        $lista_nazwa_regalu = mysql_query("SELECT Nazwa_regalu FROM REGALY_NAZWY_TAB ORDER BY Nazwa_regalu") or die ("zle pytanie NAZWA REGALU");
        $polocz->close();
        while($rekord_regalu = mysql_fetch_assoc($lista_nazwa_regalu))
        {
            $nazwa_regalu[$i] = $rekord_regalu['Nazwa_regalu'];
            $i++;   
        }
       // var_dump($nazwa_regalu);
        
         
        if(isset($_POST['przycisk_szukaj']))///wcisniety przycisk szukaj
        {
            $odbiorca_wybrany = htmlspecialchars($_POST['filtr_klient_tex']);
            $filtr_nr_parti_wybrany = htmlspecialchars($_POST['filtr_nr_parti']);
            $filtr_artykul_wybrany = htmlspecialchars($_POST['filtr_artykul']);
            $filtr_nazwa_regalu_klucz = htmlspecialchars($_POST['filtr_nazwa_regalu']);
           
            foreach($nazwa_regalu as $klucz => $wartosc)
            {
                //print"wchodzi_klucz.$klucz.=.$wartosc.<br>";
                if($klucz == $filtr_nazwa_regalu_klucz)
                {
                    $nazwa_regalu_wybrany = htmlspecialchars($wartosc);
                    //print"wchodzi";
                }
            }
             //print"filtr nazwa regalu : ";
             //var_dump($nazwa_regalu_wybrany); //filtr_nazwa_regalu
            /*
            print"filtr KLIENT :";
            print_r($odbiorca_wybrany);
            print"<BR>filtr NR PARTI :";
            print_r($filtr_nr_parti_wybrany);
            print"<BR>filtr ARTYKUŁ :";
            print_r($filtr_artykul_wybrany);
             * 
             */
            
        }      
        
        
print"<TABLE cellpadding = '0'  cellspacing = '0' border = '0' style='width: 100%; height: 100%;'>";
    print"<tr>";
        print"<td align=center>";
            require_once "zalogowany_banery.php";
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>";  
            print"<DIV class='wiekszy_panel'>";
            print'<FORM ACTION="index.php" METHOD=POST>';
            print'<INPUT TYPE="submit" VALUE="Strona startowa" CLASS="btn">';
            print'</FORM>';       
        
            print "<br><B><font class='opis_paneli'>REGAŁY</font></B><br><br>";
  
                print'<FORM METHOD=POST>';
                
                    print"<div align=center>";
                    print"<TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 style='width: 90%; height: 100%;'>";
                        print"<TR>";                                                  
                            print"<TD valign=bottom style='width: 25%; text-align: left;'>";
                                print'<B><font class="opis_texbox">KLIENT</font></B><br/>'; 
                                print '<INPUT class="text_box" style="width: 95%;" TYPE="text" NAME="filtr_klient_tex" VALUE="'.$odbiorca_wybrany.'">';              
                            print"</TD>";                            
                            print"<TD valign=bottom style='width: 25%; text-align: left;'>"; 
                                print'<B><font class="opis_texbox">NR PARTI</font></B><br/>';
                                print '<INPUT class="text_box" style="width: 95%;" TYPE="text" NAME="filtr_nr_parti" VALUE="'.$filtr_nr_parti_wybrany.'">';
                            print"</TD>";  
                            print"<TD valign=bottom style='width: 25%; text-align: left;'>"; 
                                print'<B><font class="opis_texbox">ARTYKUŁ</font></B><br/>';
                                print '<INPUT class="text_box" style="width: 95%;" TYPE="text" NAME="filtr_artykul" VALUE="'.$filtr_artykul_wybrany.'">';
                            print"</TD>";
                            
                            print"<TD valign=bottom style='width: 15%; text-align: left;'>"; 
                                print'<B><font class="opis_texbox">REGAŁ</font></B><br/>';
                                print'<SELECT class="opis_select" NAME="filtr_nazwa_regalu" style="width: 95%;">';  
                                    
                                    foreach($nazwa_regalu as $klucz => $wartosc)
                                    {
                                        print("<OPTION VALUE=\"$klucz\">".$wartosc); 
                                    }
                                    
                                    if(isset($_POST['przycisk_szukaj']))///wcisniety przycisk szukaj
                                    {
                                        print("<OPTION SELECTED VALUE=\"$filtr_nazwa_regalu_klucz\">$nazwa_regalu_wybrany</OPTION>");   
                                    }
                                    
                                     
                                print'</SELECT>';
                                
                                //print '<INPUT class="text_box" style="width: 95%;" TYPE="text" NAME="filtr_artykul" VALUE="'.$filtr_artykul_wybrany.'">';
                            print"</TD>";
                                          
                            print"<TD valign=bottom style='width: 5%; text-align: center;'>";
                                print "";
                                print'<INPUT TYPE="submit" NAME="przycisk_szukaj" VALUE="Szukaj" CLASS="btn" style="width: 100%;">';  
                            print"</TD>";
                        print"</tr>";
                    print"</TABLE>";
                    print"</div>";
                print"</div>";
                print"</FORM>";                   
                         	
                                ////////////koniec textbox filtrowanie  ///////////////////////////       
        print"</td>";       
    print"</tr>";
    print"<tr>";
        print"<td height=20>";
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>";           
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td height=20>";
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>";
            print"<TABLE border = '0' style='width: 95%; height: 100%;'>";
                print"<TR><TD id='td_kolor' class='regaly_td_font' width=15% bgcolor = #6666ff><B>KLIENT</B></TD><TD id='td_kolor' class='regaly_td_font' width=15% bgcolor = #6666ff><B>NR PARTI</B></TD><TD id='td_kolor' class='regaly_td_font' width=20% bgcolor = #6666ff><B>ARTYKUŁ</B></TD><TD id='td_kolor' class='regaly_td_font' width=10% bgcolor = #6666ff><B>ILOŚĆ</B></TD><TD id='td_kolor' class='regaly_td_font' width=20% bgcolor = #6666ff><B>UWAGI</B></TD><TD id='td_kolor' class='regaly_td_font' width=20% bgcolor = #6666ff><B>REGAŁ</B></TD></TR>";
                if($odbiorca_wybrany != "" || $filtr_nr_parti_wybrany != "" || $filtr_artykul_wybrany != "" || $nazwa_regalu_wybrany != "")
                {
                    $polocz->open();
                    mysql_select_db("ZAMOWIENIA_DRUKARNIA") or die ("nie ma zamowienia_drukarnia");                      
                    $wynik = mysql_query("SELECT `ID_regaly`, `Klient`, `Nr_zlecenia`, `Artykul`, `Ilosc`, `Uwagi`, `Ktory_regal` FROM `REGALY_TAB` WHERE `Klient` LIKE '$odbiorca_wybrany%' AND `Nr_zlecenia` LIKE '$filtr_nr_parti_wybrany%' AND `Artykul` LIKE '$filtr_artykul_wybrany%' AND `Ktory_regal` LIKE '$nazwa_regalu_wybrany%'") or die ("zle pytanie regaly");
                    $polocz->close();

                    while($rekord = mysql_fetch_assoc($wynik))
                    {

                        $klient = $rekord['Klient'];                     
                        $nr_zlecenia = $rekord['Nr_zlecenia'];
                        $artykul = $rekord['Artykul'];
                        $ktory_regal = $rekord['Ktory_regal'];
                        $ilosc = $rekord['Ilosc'];
                        $uwagi = $rekord['Uwagi'];


                        $kolor = '#FFFFFF';
                        print"<TR><TD id='td_kolor' class='regaly_td_font' bgcolor=$kolor>$klient</TD><TD id='td_kolor' class='regaly_td_font' align = 'left' bgcolor=$kolor>$nr_zlecenia</TD><TD id='td_kolor' class='regaly_td_font' align = 'left' bgcolor=$kolor>$artykul</TD><TD id='td_kolor' class='regaly_td_font' bgcolor=$kolor>$ilosc</TD><TD id='td_kolor' class='regaly_td_font' bgcolor=$kolor>$uwagi</TD><TD id='td_kolor' class='regaly_td_font' bgcolor=$kolor>$ktory_regal</TD>";
                            /*
                            print"<TD id='td_kolor' align=center bgcolor=$kolor>";
                                    print'<FORM ACTION="wzory_od_klienta.php" METHOD=POST>'; 
                                    //print "<INPUT TYPE=hidden NAME=wybrany_klient VALUE='$odbiorca'>";
                                    //print '<INPUT TYPE="hidden" NAME="usuwaj" VALUE="'.$nr_wiersza.'">';
                                    if($projektantka_baza == $zalogowany) ////////PRZYCISK USUN
                                    {    
                                        if($data == $data_dzisiaj)
                                        {
                                            print '<INPUT TYPE="hidden" NAME="usuwaj" VALUE="'.$nr_wiersza.'">';
                                                 //print '<INPUT TYPE="hidden" NAME="usun_wiersz" VALUE="usun">';

                                            print'<INPUT TYPE="submit" NAME="przycisk_usuwaj" VALUE="X Usuń" CLASS="btn">';              
                                        }
                                    }
                                    print '</FORM>';                          
                            print"</TD>";
                             * 
                             */

                    }
                    print"</TR>";
                }
            print"</TABLE>";   
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td height=30>";
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>";
            /*
            print"<TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 style='width: 100%; height: 100%;'>";
                print"<tr>";
                    print"<td align=center>";
                        print'<a id="dopisywanie_wzoru">';
                            print"<B><font size='1' color='blue'>DOPISZ WZÓR</font></B><br>";
                        print'</a>'; 
                    print"</td>";
                print"</tr>";
                print"<tr>";
                    print"<td>";
                        ////////////text box dopisywanie wzorow /////////////////////////// 
                            print'<FORM METHOD=POST>';
                            print"<DIV class='wiekszy_panel'>";
                                print"<div align=center>";
                                print"<TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 style='width: 90%; height: 100%;'>";
                                    print"<TR>";
                                        print"<TD valign=bottom style='width: 24%;'>";
                                            print'<B><font class="opis_texbox">KLIENT</font></B><br/>';                              
                                            print'<SELECT class="opis_select" NAME="dodaj_klient_tex" style="width: 95%;">';  

                                                foreach($odbiorcy as $klucz => $wartosc)
                                                {
                                                    print("<OPTION VALUE=\"$klucz\">".$wartosc); 
                                                }
                                                if(isset($_POST['przycisk_zapisz']))///wcisniety przycisk szukaj
                                                {
                                                    print("<OPTION SELECTED VALUE=\"$filtr_klient_klucz\">$odbiorca_wybrany_do_zapisania</OPTION>");   
                                                }
                                            print'</SELECT>';

                                        print"</TD>";           
                                        print"<TD style='width: 24%;'>";
                                            print'<B><font class="opis_texbox">WZÓR KONWERTOWANY</font></B><br/>';
                                            print '<INPUT class="text_box" style="width: 95%;" TYPE="text" NAME="dodaj_wzor_konwertowany_tex" VALUE="">';                
                                        print"</TD>";                                       
                                        print"<TD valign=bottom style='width: 24%;'>";
                                            print'<B><font class="opis_texbox">WZÓR POPRAWIANY</font></B><br/>';
                                            print '<INPUT class="text_box" style="width: 95%;" TYPE="text" NAME="dodaj_wzor_poprawiany_tex" VALUE="">';                
                                        print"</TD>";                                       
                                        print"<TD valign=bottom style='width: 24%;'>";
                                            print'<B><font class="opis_texbox">UWAGI</font></B><br/>';
                                            print '<INPUT class="text_box" style="width: 95%;" TYPE="text" NAME="dodaj_uwagi_tex" VALUE="">';                
                                        print"</TD>";                                       
                                        print"<TD valign=bottom style='width: 4%;'>";
                                            print "";
                                            print'<INPUT style="width: 100%;" TYPE="submit" NAME="przycisk_zapisz" VALUE="Zapisz" CLASS="btn">';  
                                        print"</TD>";
                                    print"</TR>";
                                print"</TABLE>";
                                print"</FORM>";
                                print"</div>";
                            print"</div>";    
                    print"</td>";
                print"</tr>";
            print"</TABLE>";
             * 
             */
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td height=30>";
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>";
            /*
            print"<TABLE>";
                print"<tr>";
                    print"<td align=left>";
                        print'<a id="statystyki">';
                            print"<B><font size='1' color='blue'>STATYSTYKI</font></B><br>";
                        print'</a>'; 
                    print"</td>";
                print"</tr>";
                print"<tr>";
                    print"<td>";
                        //print"<TABLE border = '0' width=20% height=100%>";
                        print"<TABLE>";
                            print"<TR><TD id='td_kolor' width=10% bgcolor = #5F9F9F><B>NAZWA</B></TD><TD id='td_kolor' width=5% bgcolor = #5F9F9F><B>ILOŚC SZT.</B></TD></TR>";
                            $kolor = '#FFFFFF';
                            print"<TR><TD id='td_kolor' bgcolor=$kolor>Wzory razem</TD><TD id='td_kolor' align=center bgcolor=$kolor>$ilosc_wzorow</TD></TR>";
                            print"<TR><TD id='td_kolor' bgcolor=$kolor>Wzory konwertowane</TD><TD id='td_kolor' align=center bgcolor=$kolor>$ilosc_wzorow_konwertowanych</TD></TR>";
                            print"<TR><TD id='td_kolor' bgcolor=$kolor>Wzory poprawiane</TD><TD id='td_kolor' align=center bgcolor=$kolor>$ilosc_wzorow_poprawianych</TD></TR>";
                            //print"<TR><TD id='td_kolor' bgcolor=$kolor>Marcela</TD><TD id='td_kolor' align=center bgcolor=$kolor>$ilosc_wzorow_Marcela</TD></TR>";
                            print"<TR><TD id='td_kolor' bgcolor=$kolor>Marta</TD><TD id='td_kolor' align=center bgcolor=$kolor>$ilosc_wzorow_Marta</TD></TR>";
                            print"<TR><TD id='td_kolor' bgcolor=$kolor>Ola</TD><TD id='td_kolor' align=center bgcolor=$kolor>$ilosc_wzorow_Ola</TD></TR>";
                            print"<TR><TD id='td_kolor' bgcolor=$kolor>Aleksandra</TD><TD id='td_kolor' align=center bgcolor=$kolor>$ilosc_wzorow_Aleksandra</TD></TR>";           
                        print"</TABLE>";
                    print"</td>";
                print"</tr>";
            print"</TABLE>";
             * 
             */
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td height=30>";
        print"</td>";
    print"</tr>";
print"</TABLE>";
        
print"</DIV>";
?>        
        
</body>




