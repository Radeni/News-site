# News site

Internet sajt za vesti napravljen za predmet Projektovanje Informacionih Sistema i Baza Podataka

Ova internet aplikacija se većinski sastoji iz PHP i HTML koda. Za pokretanje aplikacije potrebni su nam:
- WAMP server (virtuelni server za web stranice)
- MySQLWorkbench
- PHP Composer ([link za download i uputstvo za instalaciju](https://getcomposer.org/download/))

## Kako pokrenuti aplikaciju:
1. Instalirati i pokrenuti WAMP Server.
2. Fajlove aplikacije ubaciti u `WWW` folder WAMP servera (npr. `D:\wamp64\www\News-site`).
3. Instaliramo PHP Composer prema uputstvu sa gore navedenog linka.
4. Kada smo instalirali Composer, potrebno je da preko njega instaliramo HTMLPurifier. U `News-site` folderu pokrecemo terminal (cmd, powershell...) i pokrecemo sledecu komandu (bez navodnika): `composer require ezyang/htmlpurifier`.
5. Zatim je potrebno da ucitamo model baze podataka, to radimo:
    - Instaliramo i otvorimo MySQLWorkbench
    - U workbenchu izaberemo opciju da se povezemo na lokalni server
    - Kada smo povezani na server, otvaramo SQL skriptu (`\News-site\baza\skripta.sql`)
    - Pokrecemo skriptu što bi trebalo da generiše našu bazu podataka ako je sve kako treba sa skriptom.
6. Kada je baza podataka generisana, aplikaciju možemo pregledati u browseru. To radimo tako što u polje za internet adresu ubacujemo `localhost/news-site` (bez navodnika). Odlaskom na ovu adresu prikazaće nam se naslovna strana web stranice i možemo dalje da je normalno koristimo.

### Podaci za login kao glavni urednik su:
- Username: admin
- Password: 123
