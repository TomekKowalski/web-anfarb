<?php

session_start();

?>
<TABLE cellpadding = '0'  cellspacing = '0' border = '0' width=100% height=100%>
    <tr>
        <td align=center>
            <TABLE cellpadding = '0'  cellspacing = '0' border = '0' width=100% height=100%>
                <tr>
                    <td>
                       <B><font class='opis_paneli'>ODBIORCA</font></B><br>
                    </td>
                </tr>
            </TABLE>
        </td>
    </tr>
    <tr>
        <td height=10px>
        </td>
    </tr>
    <tr>
        <td align=center>           
                        
                        <TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 style="width: 100%; height: 100%">
                            <TR>
                                <TD>
                                    <FORM ACTION="wybierz_odbiorce.php" METHOD=POST>
                                        <?PHP
                                            print'<INPUT class="text_box_filtr" type ="text" name="filter_odbiorca" value="'.$filtr_odbiorcy.'">';
                                        ?>
                                        <!--<INPUT class="text_box_filtr" type ="text" name="filter_odbiorca" value="">-->
                                        
                                        <INPUT TYPE="submit" VALUE="Filtr odbiorca" CLASS="filtr_btn" style="width: 30%;">         
                                    </FORM>                   
                                </TD>
                                <TD></TD>
                                <TD></TD>
                                <TD></TD>
                            </TR>
                            <TR>
                                <FORM ACTION="wybierz_odbiorce.php" METHOD=POST>
                                <INPUT TYPE="hidden" NAME="opcja" VALUE="opcja">
                                <?PHP print'<INPUT TYPE="hidden" NAME="filter_szukaj_odbiorcy" VALUE="'.$filtr_odbiorcy.'">'; ?>
                                <TD style="width: 55%">                
                                    <SELECT class="opis_select" NAME="opcja_odbiorca" style="width: 98%;">
                                        <?PHP
                                            if($_POST['wybrany_klient_nowe_zamowienie'] != "")
                                            {
                                                $odbiorca = $_POST['wybrany_klient_nowe_zamowienie'];
                                                $_SESSION['odbiorca_nowe_zamowienie'] = $odbiorca;
                                                print"<OPTION SELECTED VALUE='$odbiorca'>$odbiorca</OPTION>";
                                            }
                                            else{
                                                if(!$filtr_odbiorcy)
                                                {
                                                    print'<OPTION SELECTED VALUE="">-&gt; wybierz, odbiorce:</OPTION>'; 
                                                }else{
                                                    $odbiorca_temp = $odbiorcy[""];
                                                    print"<OPTION SELECTED VALUE=''>$odbiorca_temp</OPTION>";             
                                                    
                                                }
                                            }
                                            
                                            
                                            foreach($odbiorcy as $klucz => $wartosc)
                                            {
                                                print("<OPTION VALUE=\"$klucz\">".$wartosc);
                                            }
                                            
                                        ?>
                                        
                                    </SELECT>
                                </TD>
                                <TD style="width: 15%;">
                                        <!--////////////combobox 02//////////////////-->
                                    <SELECT class="opis_select" NAME="rok" style="width: 98%;">
                                        <OPTION SELECTED VALUE="">-&gt; 2022</OPTION>
                                        <?PHP
                                            foreach($rok as $klucz => $wartosc)
                                            {
                                                print("<OPTION VALUE=\"$klucz\">".$wartosc."</OPTION>");
                                            }
                                        ?>
                                    </SELECT>
                                </TD>
                                <TD style="width: 20%;">  
                                        <!--////////////combobox 03//////////////////  -->
                                    <SELECT class="opis_select" NAME="status" style="width: 98%;">
                                        <OPTION SELECTED VALUE="">-&gt; wybierz, status:</OPTION>
                                        <?PHP
                                            foreach($status as $klucz => $wartosc)
                                            {
                                                print("<OPTION VALUE=\"$klucz\">".$wartosc."</OPTION>");
                                            }
                                        ?>
                                    </SELECT>
                                </TD>
                                <TD style="width: 10%;">
                                    
                                    <INPUT TYPE="submit" VALUE="Szukaj" CLASS="btn" style="width: 100%;">
                                </TD> 
                                </FORM>
                            </TR>
                        </TABLE>        
        </td>
    </tr>   
</TABLE>
