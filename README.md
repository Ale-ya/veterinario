# Veterinario — Monitoraggio clinico per cani con enteropatia cronica

![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?logo=php&logoColor=white)
![MariaDB](https://img.shields.io/badge/MariaDB-11.8-003545?logo=mariadb&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?logo=bootstrap&logoColor=white)
![Chart.js](https://img.shields.io/badge/Chart.js-4.x-FF6384?logo=chartdotjs&logoColor=white)
![Status](https://img.shields.io/badge/status-in%20approvazione-yellow)

Applicazione web per la **digitalizzazione del monitoraggio giornaliero** di cani affetti da enteropatia cronica (IBD canina). Sostituisce il diario cartaceo consegnato ai proprietari, raccogliendo i parametri dell'indice clinico **CIBDAI** in forma strutturata e consultabile dal veterinario tramite grafici interattivi.

---

## Contesto clinico

L'**enteropatia cronica canina** (Chronic Enteropathy) è una patologia gastrointestinale infiammatoria che richiede un follow-up continuativo nel tempo. Il monitoraggio avviene tramite l'indice **CIBDAI** (Canine Inflammatory Bowel Disease Activity Index), che quantifica la gravità dei sintomi attraverso parametri osservabili dal proprietario a domicilio.

### Il problema
In precedenza il veterinario consegnava al proprietario un **diario cartaceo** da compilare giornalmente per 30 giorni (atteggiamento, appetito, vomito, feci, ecc.). I dati venivano poi analizzati manualmente a visita successiva.

### La soluzione
Questa applicazione permette al proprietario di **inserire i dati da smartphone o PC** e al veterinario di **consultare lo storico in tempo reale** tramite grafici, con possibilità di filtrare per intervallo di date.

### Collaborazione
Progetto sviluppato in collaborazione tra:
- **ITIS Giancardi Galilei Aicardi** — sviluppo applicativo (Alessio Paccino)
- **Università di Parma (UNIPR)** — supervisione

---

## Funzionalità

### Ruolo: Veterinario

| Azione | Descrizione |
|--------|-------------|
| Registrazione | Crea account veterinario |
| Registra paziente | Inserisce scheda T0: nome animale, razza, peso, sesso, dieta, terapie, sospetta diagnosi |
| Associa proprietario | Il proprietario si registra indicando il veterinario di riferimento |
| Dashboard | Visualizza tutti i pazienti assegnati |
| Info generali | Consulta scheda completa T0 del paziente |
| Storico | Grafici a linee per ogni parametro CIBDAI, filtrabili per intervallo di date |

### Ruolo: Proprietario

| Azione | Descrizione |
|--------|-------------|
| Registrazione | Crea account associandosi al proprio veterinario |
| Inserimento log | Compila il monitoraggio giornaliero (T1+) con i parametri clinici |
| Gestione animali | Inserisce la scheda dei propri animali |

---

## Parametri monitorati (CIBDAI)

| Parametro | Scala dei valori |
|-----------|-----------------|
| **Atteggiamento** | Normale → Poco abbattuto → Mediamente abbattuto → Gravemente abbattuto |
| **Appetito** | Normale → Poco diminuito → Mediamente diminuito → Gravemente diminuito |
| **Vomito** | No → Sì → Blando (1/sett.) → Moderato (2-3/sett.) → Grave (>3/sett.) |
| **Dimagrimento** | Assente → Blando (<5%) → Moderato (5-10%) → Grave (>10%) |
| **Frequenza feci** | Normale → 2-3/giorno → 4-5/giorno → 5+ al giorno |
| **Sangue nelle feci** | Assente / Presente |
| **Muco nelle feci** | Assente / Presente |
| **Flatulenza** | Assente / Presente |
| **Lambimento** | Assente / Presente |

Ogni valore ha un **peso numerico** che permette la visualizzazione in scala nei grafici e il futuro calcolo automatico dello score CIBDAI.

---

## Screenshot

### Dashboard veterinario
![Dashboard veterinario](https://github.com/Ale-ya/veterinario/assets/208044545/a3d8bbe0-272f-4bf3-a9f8-3b848a09da9b)

### Inserimento log giornaliero
![Inserimento log](https://github.com/Ale-ya/veterinario/assets/208044545/073c5878-ce96-411d-bca4-7445f1964626)

### Storico con grafici
![Storico grafici](https://github.com/Ale-ya/veterinario/assets/208044545/3bfa9d00-9cca-45fd-871f-5a187c0713ba)

---

## Stack tecnologico

| Layer | Tecnologia |
|-------|-----------|
| Backend | PHP 8.4 |
| Database | MariaDB 11.8 (MySQL-compatibile) |
| Frontend | Bootstrap 5.3 + Bootstrap Icons 1.11 |
| Grafici | Chart.js |
| Autenticazione | Session PHP + bcrypt (`password_hash`) |

---

## Struttura del progetto

```
veterinario/
├── index.php              # Landing page — login o registrati
├── login.php              # Form login (vet e proprietario)
├── logout.php             # Distruzione sessione
├── choose_signin_type.php # Scelta tipo account (vet / proprietario)
├── signin_vet.php         # Registrazione veterinario
├── signin_customer.php    # Registrazione proprietario
├── dashboard_vet.php      # Dashboard veterinario — lista pazienti
├── dashboard_owner.php    # Dashboard proprietario — form log + animali
├── insert_animale.php     # Inserimento nuovo animale
├── insert_log.php         # Inserimento log giornaliero (proprietario)
├── storico.php            # Storico sintomi con grafici Chart.js
├── info_animale.php       # Scheda info generali animale (vet)
└── connection/
    ├── connection.php     # Helper connessione DB  ← escluso da git
    ├── check_owner.php    # Guard sessione — solo proprietari
    ├── check_vet.php      # Guard sessione — solo veterinari
    └── veterinario.sql    # Dump DB con schema e dati di esempio
```

---

## Installazione

### Requisiti
- PHP >= 8.0
- MariaDB / MySQL
- Web server con supporto PHP (Apache, Nginx, XAMPP, MAMP...)

### Setup

**1. Clona il repository**
```bash
git clone https://github.com/Ale-ya/veterinario.git
cd veterinario
```

**2. Importa il database**
```bash
mysql -u root -p < connection/veterinario.sql
```

**3. Configura la connessione**

Crea il file `connection/connection.php` (non tracciato da git):
```php
<?php
function get_conn() {
    $host = "localhost";
    $user = "tuo_utente";
    $password = "tua_password";
    $db = "veterinario";
    $conn = new mysqli($host, $user, $password, $db);
    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }
    return $conn;
}
```

**4. Punta il web server** sulla cartella del progetto

Con XAMPP: copia in `htdocs/veterinario/`  
Con server Linux: configura virtualhost su `/var/www/html/veterinario/`

**5. Apri nel browser**
```
http://localhost/veterinario/
```

---

## Credenziali di esempio (dal dump SQL)

| Tipo | Username | Password |
|------|----------|----------|
| Veterinario | `dr_rossi` | `monolitico` |
| Proprietario | `luca85` | `monolitico` |

> Dati di esempio per scopo dimostrativo. Da non usare in produzione.

---

## Schema del database

### Tabelle principali

| Tabella | Contenuto |
|---------|-----------|
| `veterinari` | Account veterinari (username, password bcrypt, nome, cognome, email) |
| `proprietari` | Account proprietari, FK → `veterinari` (veterinario di riferimento) |
| `pazienti` | Anagrafica animali + dati T0 (dieta, terapie, diagnosi sospetta), FK → `proprietari` |
| `pazienti_veterinari` | Relazione N:M paziente ↔ veterinario |
| `log` | Rilevazione giornaliera, FK → 9 tabelle lookup + `pazienti` |

### Tabelle lookup (parametri CIBDAI)

Ogni tabella lookup ha struttura `(id, description, peso)`. Il campo `peso` è il valore numerico usato nei grafici:

`vomito` · `appetito` · `atteggiamento` · `dimagrimento` · `frequenza_feci` · `sangue` · `muco` · `flatulenza` · `lambimento`

---

## Roadmap

| Stato | Feature |
|-------|---------|
| ✅ Implementato | Autenticazione dual-role (vet / proprietario) |
| ✅ Implementato | Log giornaliero con tutti i parametri CIBDAI |
| ✅ Implementato | Storico con grafici Chart.js e filtro date |
| ✅ Implementato | Scheda paziente T0 (dieta, terapie, diagnosi) |
| 🔄 In corso | UI mobile-first ottimizzata (layout responsive su smartphone) |
| 📋 Pianificato | Punteggio CIBDAI calcolato automaticamente e visualizzato nel log |
| 📋 Pianificato | Consistenza feci (presente nel diario cartaceo, da aggiungere al DB) |
| 📋 Pianificato | Glasgow Composite Measure Pain Scale — sezione D integrata nel log |
| 📋 Pianificato | Export report PDF per follow-up veterinario |
| 📋 Pianificato | Single Sign-On (SSO) |
| 💡 Future | Monitoraggio variabili correlate a recidive (meteo, chirurgia, alimentazione) |
| 💡 Future | Notifiche e reminder giornalieri per il proprietario |
| 💡 Future | BCS (Body Condition Score) nella scheda paziente |
| 💡 Future | Grafico score CIBDAI aggregato nel tempo |

---

## Autore

**Alessio Paccino** — [@Ale-ya](https://github.com/Ale-ya)

Progetto in collaborazione con **Università di Parma (UNIPR)** — A.A. 2025/2026  
