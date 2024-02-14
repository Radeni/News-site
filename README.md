# News site
 Internet sajt za vesti napravljen za predmet Projektovanje Informacionih Sistema i Baza Podataka

Ova internet aplikacija se vecinski sastoji iz PHP i HTML koda.
Za pokretanje aplikacije potrebni su nam:
-WAMP server (virtuelni server za web stranice)
-MySQLWorkbench
-PHP Composer (https://getcomposer.org/download/ <- link za download i uputstvo za instalaciju)

Kako pokrenuti aplikaciju:
-Instalirati i pokrenuti WAMP Server.
-Fajlove aplikacije ubaciti u WWW folder WAMP servera (npr. 'D:\wamp64\www\News-site')
-Instaliramo PHP Composer prema uputstvu sa gore navedenog linka.
-Kada smo instalirali Composer, potrebno je da preko njega instaliramo HTMLPurifier. U 'News-site' folderu pokrecemo terminal (cmd, powershell...) i pokrecemo sledecu komandu (bez navodnika): 'composer require ezyang/htmlpurifier'
-Zatim je potrebno da ucitamo model baze podataka, to radimo:
    -Instaliramo i otvorimo MySQLWorkbench
    -U workbenchu izaberemo opciju da se povezemo na lokalni server
    -Kada smo povezani na server, otvaramo SQL skriptu (\News-site\baza\skripta.sql)
    -Pokrecemo skriptu sto bi trebalo da generise nasu bazu podataka ako je sve kako treba sa skriptom.
-Kada je baza podataka generisana, aplikaciju mozemo pregledamo u browseru. To radimo tako sto u polje za internet adresu ubacujemo 'localhost/news-site' (bez navodnika). Odlaskom na ovu adresu prikazace nam se naslovna strana web stranice i mozemo dalje da je    normalno koristimo.

-Podaci za login kao glavni urednik su:
  -Username: admin
  -password: 123