# SurfBlackList
Globalny system banów stron w systemach AutoSurf i PTP.

Aby dołaczyć do systemu skontaktuj się z autorem (admin@xtrasurf.pl).
Po otrzymaniu dostępu użyj poniższych funkcji aby wdrożyć system.

# Opis funkcji (przykłady użycia w folderze /examples):

  - CheckBlackList($domain, $sid, $url); Sprawdza, czy dana strona jest na liście zbanowanych. Wymagane argumenty:
    - $domain: domena twojego surfa/ptp
    - $sid: Secret_id nadany twojej domenie,
    - $url: Adres URL strony, która ma być sprawdzona czy jest na liście.


  - SendToBlackList($domain, $sid, $url); Wysyła stronę do listy zbanowanych. Wymagane argumenty:
      - $domain: domena twojego surfa/ptp
      - $sid: Secret_id nadany twojej domenie,
      - $url: Adres URL strony, która ma być sprawdzona czy jest na liście.
      - $reason: Powód zbanowania (opcjonalne).    

  - ReportToBlackList($domain, $sid, $url); Wysyła stronę do listy zbanowanych. Wymagane argumenty:
      - $domain: domena twojego surfa/ptp
      - $sid: Secret_id nadany twojej domenie,
      - $url: Adres URL strony, która ma być sprawdzona czy jest na liście.
      - $reason: Powód zgłoszenia (opcjonalne).        
