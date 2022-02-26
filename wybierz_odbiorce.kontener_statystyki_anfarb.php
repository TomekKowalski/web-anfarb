<?php

session_start();

?>

<TABLE cellpadding = '0'  cellspacing = '0' border = '0' width=100% height=100%>
    <tr>
        <td align=left>
            <TABLE cellpadding = '0'  cellspacing = '0' border = '0' width=50% height=100%>
               <tr>
                   <td height = 30>
                       <B><font class='opis_paneli'>STATYSTYKI AN-FARB</font></B><br>
                   </td>
               </tr>
            </TABLE>
        </td>
    </tr>
    <tr>
        <td height = 10px>
        </td>
    </tr>
    <tr>
        <td align=center>           
                        <TABLE>
                            <tr>
                                <td>
                                    <a href="php_statystyki/statystyki_klient_anfarb.php" class="button">Klient An-Farb</a>
                                </td>                              
                                <td>
                                    <a href="php_statystyki/statystyki_artykul_anfarb.php" class="button">Artykuły An-Farb</a>
                                </td> 
                                
                                <td>
                                    <a href="php_statystyki/wykres_miesiace_anfarb.php" class="button">An-Farb Miesiące</a>
                                </td> 
                                
                            </tr>
                            <tr>
                                <td>
                                    <!--<a href="php_statystyki/wykres_latami.php" class="button">Wykres rok</a>-->
                                </td>                              
                                <td>
                                    <a href="php_statystyki/wykres_latami_anfarb.php" class="button">An-Farb rok</a>
                                </td>  
                                
                                <td>
                                    <!--<a href="php_statystyki/wykres_dnia.php" class="button">Wykres dnia</a>-->
                                </td> 
                                
                            </tr>
                        </TABLE>                  
        </td>   
    </tr>
</TABLE>



