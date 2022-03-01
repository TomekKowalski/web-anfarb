<?php

session_start();
print"<TABLE cellpadding = '0'  cellspacing = '0' border = '0' width=100% height=100%>";
    print"<tr>";
        print"<td align=center>";
            print"<TABLE cellpadding = '0'  cellspacing = '0' border = '0' width=100% height=100%>";
                print"<tr>";
                    print"<td>";
                        print "<B><font class='opis_paneli'>ODBIORCA</font></B><br>";
                    print"</td>";
                print"</tr>";
            print"</TABLE>";
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td height=10px>";
        print"</td>";
    print"</tr>";
    print"<tr>";
        print"<td align=center>";           
                        print'<FORM ACTION="wybierz_odbiorce.php" METHOD=POST>';
                        print '<INPUT TYPE="hidden" NAME="opcja" VALUE="opcja">';
                        print'<TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 style="width: 100%; height: 100%">';
                            print"<TR>";
                                print'<TD style="width: 55%">';
                                    //print_r($_POST['wybrany_klient_nowe_zamowienie']);
                                    ///////////combobox 01/////////////////////
                                    print'<SELECT class="opis_select" NAME="opcja_odbiorca" style="width: 98%;">';
                                        if($_POST['wybrany_klient_nowe_zamowienie'] != "")
                                        {
                                            $odbiorca = $_POST['wybrany_klient_nowe_zamowienie'];
                                            $_SESSION['odbiorca_nowe_zamowienie'] = $odbiorca;
                                            print"<OPTION SELECTED VALUE='$odbiorca'>$odbiorca</OPTION>";
                                        }
                                        else{
                                           print'<OPTION SELECTED VALUE="">-&gt; wybierz, odbiorce:';  
                                        }
                                            foreach($odbiorcy as $klucz => $wartosc)
                                            {
                                                print("<OPTION VALUE=\"$klucz\">".$wartosc);
                                            }
                                        
                                    print'</SELECT>';
                                print"</TD>";
                                print'<TD style="width: 15%;">';
                                        ////////////combobox 02//////////////////
                                    print'<SELECT class="opis_select" NAME="rok" style="width: 98%;">';
                                        print'<OPTION SELECTED VALUE="">-&gt; 2022'; 
                                        foreach($rok as $klucz => $wartosc)
                                        {
                                            print("<OPTION VALUE=\"$klucz\">".$wartosc);
                                        }
                                    print'</SELECT>';
                                print"</TD>";
                                print'<TD style="width: 20%;">';  
                                        ////////////combobox 03//////////////////  
                                    print'<SELECT class="opis_select" NAME="status" style="width: 98%;">';
                                        print'<OPTION SELECTED VALUE="">-&gt; wybierz, status:'; 
                                        foreach($status as $klucz => $wartosc)
                                        {
                                            print("<OPTION VALUE=\"$klucz\">".$wartosc);
                                        }
                                    print'</SELECT>';
                                print"</TD>";
                                print'<TD style="width: 10%;">';
                                    print "";
                                    print'<INPUT TYPE="submit" VALUE="Szukaj" CLASS="btn" style="width: 100%;">';
                                print"</TD>"; 
                            print"</TR>";
                        print"</TABLE>";
                        print'</FORM>';
                        ///////////////////koniec kontener////////////////////////////////////////
        print"</td>";
    print"</tr>";   
print"</TABLE>";
 
 
 

?>
