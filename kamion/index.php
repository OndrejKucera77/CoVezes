<!DOCTYPE html>
<html lang='cs'>
  <head>
    <title>Co veze kamion?</title>
    <meta charset='utf-8'>
    <style>
        body {
            font-family: sans-serif;
            
            background-image: url("cesta.png");
            background-repeat: repeat-x;
            background-position: 0 507px;
            background-size: 36px;
        }
        main {
            width: 900px;
            margin: auto;
            padding-top: 60px;
        }
        h1 {
            margin-top: 0;
            margin-bottom: 40px;
            text-align: center;
        }
        #kamion {
            height: 370px;
            margin-bottom: 85px;
            position: relative;
            
            background-image: url("kamion.png");
            background-size: 100%;
            background-repeat: no-repeat;
        }
        #kody {
            width: 208px;
            
            background-color: orange;
            border: 6px solid black;
            
            position: absolute;
            top: 48px;
            left: 280px;
        }
        #kemler_kod {
            height: 78px;
            border: none;
            border-bottom: 6px solid black;
        }
        #un_kod {
            height: 78px;
        }                                  
        #kody input {
            border: none;
            background-color: transparent;
            
            width: 204px;
            height: 75px;
            
            font-size: 70px;
            text-align: center;
        }
        #kody input:hover {
            outline: 1px solid #eee;
        }
        #vypis {
            position: absolute;
            top: 55px;
            left: 511px;
            
            font-size: 16px;
        }
        #vypis p {
            height: 75px;
            margin-bottom: 10px;
            margin-top: 0;
            
            width: 364px; 
        }
        form {
            position: absolute;
            top: 142px;
            left: 511px;
        }
        form div {
            margin-bottom: 10px;
            font-size: 14px;
        }
        form input[type=text] {
            width: 240px;
        }
        #popis strong {
            display: block;
            margin-bottom: 8px;
        }
        #popis b {
            font-size: 14px;
        }
        #popis p {
            font-size: 13px;
        }
    </style>
  </head>
  <body>
    <main>
        <h1>Co veze kamion?</h1>
        <div id="kamion">
            <div id="kody">
                <div id="kemler_kod">
                    <input type="text" maxlength="4" onKeyUp="vypis(1, this.value)">                    
                </div>                                                             
                <div id="un_kod">
                    <input type="text" maxlength="4" onKeyUp="vypis(2, this.value); zkopiruj(this.value);">
                </div>                                                               
            </div>
            <div id="vypis">
                <p id="vystup1"></p>
                <p id="vystup2"></p>
            </div>
            <form id="UNform" method="POST">
                <div>
                Nenašli jsme žádnou látku odpovídající UN kódu <span id="cislo"></span>.
                <br>
                Pro tento kód však nyní můžete napsat název látky:
                </div>
                <input type="text" name="novynazev" required>
                <input type="hidden" id="hidden_input" name="hodnota" required>
                <input type="submit" value="Přidat">
            </form>
            <?php
            if (isset($_POST["novynazev"])&&!empty($_POST["novynazev"])&&isset($_POST["hodnota"])&&!empty($_POST["hodnota"])) {
                $nazvy=file_get_contents("pridane_nazvy.json");
                $json=json_decode($nazvy, true);
                                        
                $json[$_POST["hodnota"]]=$_POST["novynazev"];
                
                $nazvy=json_encode($json, JSON_UNESCAPED_UNICODE);
                
                $soubor=fopen("pridane_nazvy.json", "w");
                fwrite($soubor, $nazvy);
                fclose($soubor);                
            }
            ?>
        </div>
        <div id="popis">
            <strong>Z Wikipedie:</strong>
            <b>Kemlerův kód</b>
            <p>
            Kemlerův kód je kód značící nebezpečnost nebezpečné látky pro potřeby přepravy podle dohod ADR a RID. Umisťuje se na výstražnou tabulku o rozměru 300×400 mm na vozidlo přepravující předměty podle těchto dohod. Kemlerův kód slouží pro rychlé zjištění přibližných vlastností (chování) látky a je umístěn v horní polovině tabulky. Dolní polovina tabulky obsahuje podrobnější kód, určující přesně přepravovanou látku.
            </p>
            <p>
            2 – Plynná látka (uvolňování plynů pod tlakem); 3 – Hořlavá kapalina (hořlavost par kapalin a plynů); 4 – Hořlavá pevná látka; 5 – Látka podporující hoření (oxidační účinky); 6 – Jedovatá látka (toxicita); 7 – Radioaktivní látka; 8 – žíravá látka (leptavé účinky); 9 – Samovolná reakce (nebezpečí prudké, bouřlivé reakce); 0 – Bez významu
            </p>
            <b>UN kód</b>
            <p>
            UN kód je charakteristické čtyřčíslí, přiřazené dnes asi 3000 látkám a jejich směsím, které látku nebo směs jednoznačně identifikuje. Je umístěn v dolní polovině tabulky. Musí být společně s Kemlerovým kódem uveden na každém vozidle používaném při přepravě látek, které spadají do seznamu látek, jejichž přeprava se řídí dle ADR či RID. Látky identifikuje vždy čtyřmístný kód (v případě potřeby se doplňuje kód číslem 0).
            </p>
        </div>
        <script>
            window.onload = function () {
                document.getElementById("UNform").style.visibility = "hidden";
            };
             
            function vypis(verze, hodnota) {
                if (hodnota=="") {
                    document.getElementById("vystup"+verze).innerHTML = "";
                    document.getElementById("UNform").style.visibility = "hidden";                
                }
                else {
                    const xmlhttp = new XMLHttpRequest();
                    xmlhttp.onload = function() {
                        if (this.responseText == "") {
                            if (verze==1) {
                                document.getElementById("vystup1").innerHTML = "";
                            } 
                            else {
                                document.getElementById("vystup2").innerHTML = "";
                                document.getElementById("UNform").style.visibility = "visible";
                                document.getElementById("cislo").innerHTML = hodnota;
                            }
                        }
                        else {
                            if (verze==1) {
                                document.getElementById("vystup1").innerHTML = this.responseText;
                            }
                            else {
                                document.getElementById("UNform").style.visibility = "hidden";
                                document.getElementById("vystup2").innerHTML = this.responseText;
                            }
                        }                        
                    }
                    xmlhttp.open("GET", "kody.php?verze="+verze+"&&hodnota="+hodnota);
                    xmlhttp.send();                
                }                
            }
            
            function zkopiruj(hodnota) {
                document.getElementById("hidden_input").value = hodnota;
            }
        </script>
    </main>
  </body>
</html>