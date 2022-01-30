var yScrollAxis02 = 0;

window.onload = function()
{  
    
    
    
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
    //miniatura_zdjecia.style.top = e.clientY + 5 + "px"; 
    //miniatura_zdjecia.innerHTML = this.innerHTML;
    //miniatura_zdjecia.innerHTML = yScrollAxis02 + " : " + e.clientY;
    miniatura_zdjecia.style.top = e.clientY + 5 + yScrollAxis02 + "px";
    miniatura_zdjecia.innerHTML = "<img src='../WZORY_JPG_WSZYSTKIE/" + this.innerHTML + ".jpg' alt='Loading...' class='wielkosc_miniatura'/>\n\
                                <br /><figcaption>"+this.innerHTML+"</figcaption>";
    
    //alert(this.innerHTML);
    window.onscroll = function()
    {       
        yScrollAxis02 = window.pageYOffset;         
    };
    
    
}