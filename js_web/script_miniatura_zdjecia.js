var yScrollAxis02 = 0;

window.onload = function()
{  
    
    try{
    
        var tdNazwyWzorow = [];

        var n = 0;
        while(document.getElementById("td_wzor"+n+""))
        {
            tdNazwyWzorow.push(document.getElementById("td_wzor"+n+""));  ///pobranie kolejnych okienek tabliczki
            n++;
        }
        for(var i=0; i<tdNazwyWzorow.length; i++)
        {
            tdNazwyWzorow[i].addEventListener("mouseout", zmienKolor);
            tdNazwyWzorow[i].addEventListener("mouseover", wrocKolor);  
            tdNazwyWzorow[i].addEventListener("mousemove", wyswietl_miniature_wzoru);

        }
        var panel_filtr_ilosc_do_druku = document.getElementById("panel_filtr_ilosc_do_druku"); //do_druku.php
        var panel_wybierz_odbiorce_fix = document.getElementById("panel_wybierz_odbiorce_fix");
        var panel_filtrowanie = document.getElementById("panel_filtrowanie");   //zamowienia_oganes.php
        
         
        window.onscroll = function()
        {       
            yScrollAxis02 = window.pageYOffset; 
            if(panel_filtr_ilosc_do_druku)
            {
                if(yScrollAxis02 > 300)
                 {
                     panel_filtr_ilosc_do_druku.setAttribute("class", "wiekszy_panel_fixed");
                 }            
                 else
                 {
                     panel_filtr_ilosc_do_druku.setAttribute("class", "mniejszy_panel");                  
                 }
            }
            if(panel_wybierz_odbiorce_fix)
            {
                if(yScrollAxis02 > 300)
                {
                    panel_wybierz_odbiorce_fix.setAttribute("class", "wiekszy_panel_fixed");
                }            
                else
                {
                    panel_wybierz_odbiorce_fix.setAttribute("class", "panel_1ogowanie");
                }
            }
            if(panel_filtrowanie)
            {
                if(yScrollAxis > 300)
                {
                    panel_filtrowanie.setAttribute("class", "wiekszy_panel_fixed");
                }            
                else
                {
                    panel_filtrowanie.setAttribute("class", "wiekszy_panel");
                }
            }
        };
    }catch(e){}
    
};
function zmienKolor()
{
    this.className = "";    
    var miniatura_zdjecia = document.getElementById("miniatura_zdjecia");
    
    miniatura_zdjecia.style.display = "none";
}

function wrocKolor()
{       
    this.className = "divNowyColor";      
}

function wyswietl_miniature_wzoru(event)
{
    var e = event || window.event;
    this.className = "divNowyColor";
    //var pozycjaScroll = e.pageYOffset;
    
      
    var miniatura_zdjecia = document.getElementById("miniatura_zdjecia");
    
    miniatura_zdjecia.style.display = "block";
    miniatura_zdjecia.style.left = e.clientX + 5 + "px";
    miniatura_zdjecia.style.top = e.clientY + 5 + yScrollAxis02 + "px";
    miniatura_zdjecia.innerHTML = "<img src='../WZORY_JPG_WSZYSTKIE/" + this.innerHTML + ".jpg' alt='Loading...' class='wielkosc_miniatura'/>\n\
                                <br /><figcaption>"+this.innerHTML+"</figcaption>";
    
    
    
    
}